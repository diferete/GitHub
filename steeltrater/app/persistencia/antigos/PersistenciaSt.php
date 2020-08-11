<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSt extends Persistencia{
    public function __construct() {
        parent::__construct();
    }
    
    /*
     * Retorna se cliente precisa pagar st
     */
    public function contSt($sCnpj){
        $sSql = " select count(*) as cont,estcod,empsimples from widl.EMP01 left outer join 
        widl.CID01 on widl.EMP01.cidcep = widl.CID01.cidcep 
        where empcod =".$sCnpj."
        and atvcod in  (select atvcod from widl.ATV001 
              where atvdes like 'ST%') group by estcod,empsimples";
        
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        $aRetorno[0]=$row->cont;
        if ($row->empsimples=='S'){
            $sSimples = 'S';
        }else{
            $sSimples='N';   
        };
        $aRetorno[1]=$sSimples;
        $aRetorno[2]=$row->estcod;
        
        return $aRetorno;
        
    }
    
    /**
     * monta base para cálculo
     */
    public function ponticms($aItens,$sSimples,$sNr,$sEstcod){
        //monsta uma nova conexao para manter id para as tabelas temporárias
        $PDOnew = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
        
        $aRet1 = $PDOnew->exec('drop table #ponticms ');
        
        $sTab = ' create table #ponticms( '
                .'id integer identity ,' 
                .'nrped integer ,'
                .'procod integer,'
                .'seq integer , '
                .'icmsaliq float , ' 
                .'icmssubtri float , ' 
                .'vltotal float, ' 
                .'mva float, ' 
                .'pont float primary key (id) )';
        
        $aRet2 = $PDOnew->exec($sTab);
        
        foreach ($aItens as $key => $avalue) {
           $procod = $avalue[0];
           $vltotal = $avalue[1];
           $id = $avalue[2];   
           //captura o mva
           $mva = $this->retMva($procod,$sEstcod,$sSimples);
          
           
           $sSql ="select icmsseq,icmsgrucod,icmssubcod,icmsaliq,icmssubtri,icmsestcod from widl.ICMS "
                                          ."where icmsestcod ='".$sEstcod."'";
            $result = $this->getObjetoSql($sSql);
            while($oRowBD = $result->fetch(PDO::FETCH_OBJ)){
                 $seqticms = $oRowBD->icmsseq;
                 $grucod = $oRowBD->icmsgrucod;
                 $subcod = $oRowBD->icmssubcod;
                 $icmsaliq = $oRowBD->icmsaliq;
                 $icmssubtri =$oRowBD->icmssubtri;
                 $uf =$oRowBD->icmsestcod;
                 //vamos montar a pontuaçao comencando pelo filcgc, para cara pontuaçao vamos ter um método para facilitar manutenção
                 $ipontuacao = 0;
                 $ipontuacao = $ipontuacao + $this->pontFilcgc($seqticms);
                 $ipontuacao = $ipontuacao + $this->pontGrupo($procod,$grucod,$seqticms);
                 $ipontuacao = $ipontuacao + $this->pontSubGrupo($procod,$grucod,$seqticms,$subcod,$uf);
                 $ipontuacao = $ipontuacao + $this->pontEst($seqticms,$uf);
                 $ipontuacao = $ipontuacao + $this->pontPes($seqticms,$uf);
                 $ipontuacao = $ipontuacao + $this->pontAtv($seqticms,$uf);
                 $ipontuacao = $ipontuacao + $this->pontNat($seqticms,$uf);
                 $ipontuacao = $ipontuacao + $this->pontMov($seqticms,$uf);
                 
                 //insere os 
                 $sInsert = "insert into #ponticms (nrped,procod,seq,icmsaliq,icmssubtri,vltotal,mva,pont) "
                                          ."values (".$id.",'".$procod."',".$seqticms.",".$icmsaliq.",".$icmssubtri.",".$vltotal.",".$mva.",".$ipontuacao.")";
                 
                 $aRet3 =$PDOnew->exec($sInsert);
                
            }
           
        }
        
            //fim dos whiles vamos criar a pontcms2 para buscar maior pontuacao
           $aRet4 = $PDOnew->exec("drop table #ponticms2 ");
           
           $sTab2 = ' create table #ponticms2( '
                                                  .' id integer  ,' 
                                                  .'nrped integer ,'
                                                  .'procod integer,'
                                                  .'seq integer , '
                                                  .'icmsaliq float , ' 
                                                  .'icmssubtri float , ' 
                                                  .'vltotal float, ' 
                                                  .'mva float, ' 
                                                  .'pont float )';
           $aRet5 = $PDOnew->exec($sTab2);
           
           //da um select na primeira tabela e vamos percorrer ela
           $result = $PDOnew->query("select procod from #ponticms ORDER BY id");
           while($oRow = $result->fetchObject()){
               $codpont = $oRow->procod;
               $sInsert2 = 'insert into #ponticms2 '
                                      .'select * from #ponticms   '
                                      .'where procod = '.$codpont.' and pont = (select Max(pont)from #ponticms where procod = '.$codpont.' ) '
                                      .'and seq = (select MIN(seq)from #ponticms ' 
                                      .'where procod = '.$codpont.' '
                                      .'and seq in( select seq from #ponticms where procod = '.$codpont.' ' 
                                      .'and pont = (select Max(pont)from #ponticms where procod = '.$codpont.' ))) ';
               $aRet6 = $PDOnew->exec($sInsert2);
           }
           
          //vamos inserir ba tabela icmscal1 
           $aRet7 = $PDOnew->exec("drop table #icmscal1 ");
           $sTab3 = 'select procod,mva  as marckup,seq,nrped, '
                                          .'vltotal as valor,icmsaliq/100 as icms,icmssubtri/100 as icmsprod,0.1 as ipi  '
                                          .'into #icmscal1 from #ponticms2 ' 
                                          .'group by procod, pont,mva,vltotal,icmsaliq,icmssubtri,seq,nrped ';
           $aRet8 = $PDOnew->exec($sTab3);
           
           $aRet9 = $PDOnew->exec("drop table #icmscal2"); 
           $sTab4 = 'select sum( (ipi*valor)+valor)* marckup/100 + valor + (ipi*valor)' 
                                              .'as  baseicms,icms,icmsprod ,(valor * icms)as icmsprod2,valor,ipi,procod ' 
                                              .'into #icmscal2 from #icmscal1 ' 
                                              .'group by icms,icmsprod,marckup,valor,ipi,procod ';
           $aRet10 = $PDOnew->exec($sTab4);
           
           $aRet11 = $PDOnew->exec("drop table #calculoicms ");
           
           $sTab5 = 'select SUM (baseicms * icmsprod ) - icmsprod2 as st ' 
                                                        .'into #calculoicms from #icmscal2  ' 
                                                        .'group by icmsprod2 ';
           $aRet12 = $PDOnew->exec($sTab5);
           
           $resultFinal = $PDOnew->query("SELECT sum (st) as st FROM #calculoicms ");
           $row = $resultFinal->fetchObject();
           $st = $row->st;
           
           return number_format($st, 2, ',', '.');
        
    }
    
    /*
     *retorna o mva
     */
    
    public function retMva($procod,$estcod,$sSimples){
        $mva = 0;
        $sSql = "select  STMarckup,STsMarckup from widl.PROD062(nolock) "
                                 ." where procod ='".$procod."' and STEstcod ='".$estcod."' ";
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
            if($sSimples=='S'){
                $mva = $row->stsmarckup;
            }else{
               $mva = $row->stmarckup; 
            }
            
        return $mva;
      
    }
    
      
       /**
        * Verifica os pesos da regra e insere na tabela
        */
        
       
       
       /**
        * Retorna a pontuaçao do filcgc
        */
       
       public function pontFilcgc($seqticms){
           $iretpont = 0;
           $sSql = "select  icmspesfil from widl.ICMS(nolock)  "
                   ."where icmsseq =".$seqticms;
           $result =$this->getObjetoSql($sSql);
           $row = $result->fetch(PDO::FETCH_OBJ);
           $iretpont = $row->icmspesfil;
           return $iretpont;
       }
       
       /**
        * Retorna a pontuacao por grupo
        */
       
       public function pontGrupo($procod,$grucod,$seqticms){
           $iretpont = 0;
           
           $sSql = "select count(*) as cont from widl.prod01(nolock) "
                                          ."where procod =".$procod." and grucod =".$grucod." group by procod"; 
           $result =$this->getObjetoSql($sSql);
           $row = $result->fetch(PDO::FETCH_OBJ);
           if($row->cont > 0){
             $sSql = "select  icmspesgru from widl.ICMS(nolock)  "
                                            ."where   icmsseq =".$seqticms." and  icmsgrucod =".$grucod; 
             $result =$this->getObjetoSql($sSql);
             $row = $result->fetch(PDO::FETCH_OBJ);
             $iretpont = $row->icmspesgru;
           
           }
         
           
           return $iretpont;
           
       }
       
       /**
        * Pesquisa o subgrupo
        */
       public function pontSubGrupo($procod,$grucod,$seqticms,$subcod,$uf){
              $iretpont = 0;
               $sSql = "select count(*) as cont  from widl.prod01(nolock) "
                                            ."where procod =".$procod." and grucod =".$grucod." and subcod =".$subcod." group by procod";
               $result =$this->getObjetoSql($sSql);
               $row = $result->fetch(PDO::FETCH_OBJ);
              if($row->cont > 0){
              
               $sSql = "select icmspessub from widl.ICMS(nolock) "
                                                      ." where icmsestcod ='".$uf."' and icmsseq =".$seqticms." and icmsgrucod =".$grucod." "
                                                      ."and icmssubcod =".$subcod." ";
               $result =$this->getObjetoSql($sSql);
               $row = $result->fetch(PDO::FETCH_OBJ);
               $iretpont = $row->icmspessub;
              }
          
           return $iretpont;
           
           /**
            *  with Sql_IcmsPont do
                                          begin
                                              Active := False;
                                            sql.text :='select procod from widl.prod01(nolock) ' +
                                            'where procod =:procod and grucod =:grucod and subcod =:subcod   ';
                                            Parameters.ParamByName('procod').Value :=  procod;
                                            Parameters.ParamByName('grucod').Value :=   grucod;
				                                    Parameters.ParamByName('subcod').Value :=   subcod;
                                               Active := True;
                                               if RecordCount > 0 then
                                               begin
                                                 Active := False;
                                                    sql.text := 'select icmspessub from widl.ICMS(nolock)' +
                                                      ' where icmsestcod =:uf and icmsseq =:seqticms and icmsgrucod =:grucod ' +
                                                       'and icmssubcod =:subcod ';
                                                       Parameters.ParamByName('uf').Value := uf;
                                                      Parameters.ParamByName('seqticms').Value := seqticms;
                                                       Parameters.ParamByName('grucod').Value :=   grucod;
                                                      Parameters.ParamByName('subcod').Value := subcod;
                                                     Active := True;

                                                       pontuacao := pontuacao + FieldByName('icmspessub').Value;
                                                        showmessage('icmspessub '+FloatToStr(pontuacao));
                                               end;
                                              end;
            */
       }

       
      /**
       * pesquisa o peso do estado
       */
       
      public function pontEst($seqticms,$uf){
          $iretpont = 0;
          $sSql = "select  icmspesest from widl.ICMS(nolock)  "
                                          ."where icmsseq =".$seqticms." and icmsestcod ='".$uf."'";
          $result =$this->getObjetoSql($sSql);
          $row = $result->fetch(PDO::FETCH_OBJ);
          $iretpont = $row->icmspesest;
          return $iretpont;
      }
      /**
       * Pesquisa o peso do cnpj
       * @param type $seqticms
       * @param type $uf
       * @return type
       */
      public function pontPes($seqticms,$uf){
         $iretpont = 0;
         $sSql = "select  icmspespes from widl.ICMS(nolock)  "
                                          ."where icmsseq =".$seqticms." and icmsestcod ='".$uf."' ";
         $result =$this->getObjetoSql($sSql);
         $row = $result->fetch(PDO::FETCH_OBJ);
         $iretpont = $row->icmspespes;
         return $iretpont;
         
      }
      /**
       * Pesquisa o peso da atividade
       */
      
      public function pontAtv($seqticms,$uf){
         $iretpont = 0;
         $sSql = "select  icmspesatv from widl.ICMS(nolock)   "
                                          ."where icmsseq =".$seqticms." and icmsestcod ='".$uf."' and icmsconpes = 'S' ";
         $result =$this->getObjetoSql($sSql);
         $row = $result->fetch(PDO::FETCH_OBJ);
         $iretpont = $row->icmspesatv;
         return $iretpont; 
      }
      
      /**
       * natureza operação
       */
      public function pontNat($seqticms,$uf){
          $iretpont = 0;
          $sSql = "select  icmspesnat from widl.ICMS(nolock)   "
                                         . "where icmsseq =".$seqticms." and icmsestcod ='".$uf."'"; 
          $result = $this->getObjetoSql($sSql);
          $row = $result->fetch(PDO::FETCH_OBJ);
          $iretpont = $row->icmspesnat;
          return $iretpont;
      }
      /**
       * tipo de movimento
       */
      
      public function pontMov($seqticms,$uf){
          $iretpont = 0;
          $sSql = "select  icmspesmov  from widl.ICMS(nolock) "
                                          ."where icmsseq =".$seqticms." and icmsestcod ='".$uf."'";
          $result = $this->getObjetoSql($sSql);
          $row = $result->fetch(PDO::FETCH_OBJ);
          $iretpont = $row->icmspesmov;                                 
      }



}