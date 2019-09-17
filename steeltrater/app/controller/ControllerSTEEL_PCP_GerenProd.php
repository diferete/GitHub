<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_PCP_GerenProd extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_GerenProd');
    }
    
    /**
     * Método para carregar a gestão da produção
     */
    public function carregaDadosGerenProd($sDados){
        //tratamentos dos dados da tela
        $aDados = explode(',', $sDados);
        $aCamposChave = array();
        parse_str($_REQUEST['campos'], $aCamposChave);
        
        //################################################################################################
        //producao diário peso
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getDataAtual();
        $aDadosParam['datafin'] = Util::getDataAtual();
         
        $aDadosPesoGeral = $this->Persistencia->geraGerenProd($aDadosParam);
       //separa por tipo de op tempera
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getDataAtual();
        $aDadosParam['datafin'] = Util::getDataAtual();
        $aDadosParam['tipoOp'] = 'P';
        $aDadosPesoTempera = $this->Persistencia->geraGerenProd($aDadosParam);
        //separa por tipo de op fio maquina
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getDataAtual();
        $aDadosParam['datafin'] = Util::getDataAtual();
        $aDadosParam['tipoOp'] = 'F';
        $aDadosPesoFio = $this->Persistencia->geraGerenProd($aDadosParam);
        
        echo '$("#'.$aDados[0].' > tbody >").remove();'; 
        //html visualizacao
        $sHtmlDiario ='             <tr><td>Produção total</td><td> '.number_format($aDadosPesoGeral['pesoTotal'], 2, ',', '.').' Kg</td></tr> '   
                      .'             <tr><td>Fornos contínuos</td><td> '.number_format($aDadosPesoTempera['pesoTotal'], 2, ',', '.').' Kg</td></tr> '   
                      .'             <tr><td>Fio Máquina Industrialização</td><td>'.number_format($aDadosPesoFio['pesoTotal'], 2, ',', '.').' Kg</td></tr> '; 
        echo '$("#'.$aDados[0].' > tbody").append(\''.$sHtmlDiario.'\');';
        
 //#############################################################################################################
        
         //producao mensal peso
        $aDadosParam = array();
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = $aCamposChave['dataini'];
        $aDadosParam['datafin'] = $aCamposChave['datafin'];
        $aDadosPesoGeralMensal = $this->Persistencia->geraGerenProd($aDadosParam);
        //separa por tipo de op tempera
        $aDadosParam['busca'] ='ProdTotal';
         $aDadosParam['dataini'] = $aCamposChave['dataini'];
        $aDadosParam['datafin'] = $aCamposChave['datafin'];
        $aDadosParam['tipoOp'] = 'P';
        $aDadosPesoTemperaMensal = $this->Persistencia->geraGerenProd($aDadosParam);
        //separa por tipo de op fio maquina
        $aDadosParam['busca'] ='ProdTotal';
         $aDadosParam['dataini'] = $aCamposChave['dataini'];
        $aDadosParam['datafin'] = $aCamposChave['datafin'];
        $aDadosParam['tipoOp'] = 'F';
        $aDadosPesoFioMensal = $this->Persistencia->geraGerenProd($aDadosParam);
        
        echo '$("#'.$aDados[1].' > tbody >").remove();'; 
        //html visualizacao
        $sHtmlDiario ='             <tr><td>Produção total</td><td> '.number_format($aDadosPesoGeralMensal['pesoTotal'], 2, ',', '.').' Kg</td></tr> '   
                      .'             <tr><td>Fornos contínuos</td><td> '.number_format($aDadosPesoTemperaMensal['pesoTotal'], 2, ',', '.').' Kg</td></tr> '   
                      .'             <tr><td>Fio Máquina Industrialização</td><td>'.number_format($aDadosPesoFioMensal['pesoTotal'], 2, ',', '.').' Kg</td></tr> '; 
        echo '$("#'.$aDados[1].' > tbody").append(\''.$sHtmlDiario.'\');';
   //################################################################################################
        //producao diário por forno
        $aDadosParam = array();
        $aDadosParam['busca'] ='ProdForno';
        $aDadosParam['dataini'] = Util::getDataAtual();
        $aDadosParam['datafin'] = Util::getDataAtual();
        
        $aDadosProdFornoDiario = $this->Persistencia->geraGerenProd($aDadosParam);
        $sHtmlDiario ='';
        foreach ($aDadosProdFornoDiario as $key => $value) {
           $sHtmlDiario .='             <tr><td>'.$key.' </td><td> '.number_format($value, 2, ',', '.').' Kg</td></tr> '   ; 
        }
        echo '$("#'.$aDados[2].' > tbody >").remove();'; 
        echo '$("#'.$aDados[2].' > tbody").append(\''.$sHtmlDiario.'\');';
        
    //###############################################################################################
        //producao por forno mensal
        
        $aDadosParam = array();
        $aDadosParam['busca'] ='ProdForno';
         $aDadosParam['dataini'] = $aCamposChave['dataini'];
        $aDadosParam['datafin'] = $aCamposChave['datafin'];
        
        $aDadosProdFornoMensal = $this->Persistencia->geraGerenProd($aDadosParam);
        
        $sHtmlDiario ='';
        foreach ($aDadosProdFornoMensal as $key => $value) {
           $sHtmlDiario .='             <tr><td>'.$key.' </td><td> '.number_format($value, 2, ',', '.').' Kg</td></tr> '   ; 
        }
        echo '$("#'.$aDados[3].' > tbody >").remove();'; 
        echo '$("#'.$aDados[3].' > tbody").append(\''.$sHtmlDiario.'\');';
    }
    
    /**
     * Mostra tela para gerenciar e-mails
     */
     public function acaoMostraTelaGerenEmail($sDados) {
        $this->View->setSRotina(View::ACAO_INCLUIR);

        $aDados = explode(',', $sDados);

        $this->View->setSIdAbaSelecionada($aDados[0]);

        $this->antesDeMostrarTela($sDados);

        //cria a tela
        $this->View->criaTelaEmailProd();
        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[0] . 'control');

        $this->View->getTela()->setAbaSel($aDados[0]);

        //busca campo autoincremento para passar como parametro
        $sCampoIncremento = $this->retornaAutoInc();

        //função autoincremento
        $this->funcoesAutoIncremento();
        //funcao antes de renderizar a tela
        $this->afterCriaTela();

        $this->View->addBotaoPadraoTela($sCampoIncremento);


        //renderiza a tela
        $this->View->getTela()->getRender();
    }
    
    /**
     * Public function envia e-mail administrativo 
     */
    public function enviaEmailProdAdm($sDados){
         //tratamentos dos dados da tela
        $aDados = explode(',', $sDados);
        $aCamposChave = array();
        parse_str($_REQUEST['campos'], $aCamposChave);
       
        //################ GERA OS DADOS DO DIA ANTERIOS ########################
         //################################################################################################
        //producao diário peso
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getDataOtem();
        $aDadosParam['datafin'] = Util::getDataOtem();
        $aDadosPesoGeral = $this->Persistencia->geraGerenProd($aDadosParam);
       //separa por tipo de op tempera
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getDataOtem();
        $aDadosParam['datafin'] = Util::getDataOtem();
        $aDadosParam['tipoOp'] = 'P';
        $aDadosPesoTempera = $this->Persistencia->geraGerenProd($aDadosParam);
        //separa por tipo de op fio maquina
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getDataOtem();
        $aDadosParam['datafin'] = Util::getDataOtem();
        $aDadosParam['tipoOp'] = 'F';
        $aDadosPesoFio = $this->Persistencia->geraGerenProd($aDadosParam);
        
        if($aDados[0]=='naoEnv'){
            echo '$("#'.$aDados[1].' > tbody >").remove();'; 
            //html visualizacao
            $sHtmlDiario ='             <tr><td>Produção total</td><td> '.number_format($aDadosPesoGeral['pesoTotal'], 2, ',', '.').' Kg</td></tr> '   
                          .'             <tr><td>Fornos contínuos</td><td> '.number_format($aDadosPesoTempera['pesoTotal'], 2, ',', '.').' Kg</td></tr> '   
                          .'             <tr><td>Fio Máquina Industrialização</td><td>'.number_format($aDadosPesoFio['pesoTotal'], 2, ',', '.').' Kg</td></tr> '; 
            echo '$("#'.$aDados[1].' > tbody").append(\''.$sHtmlDiario.'\');';
        }
       //#############################################################################################################
        
         //producao mensal peso
        $aDadosParam = array();
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getPrimeiroDiaMes();
        $aDadosParam['datafin'] = Util::getDataOtem();
        $aDadosPesoGeralMensal = $this->Persistencia->geraGerenProd($aDadosParam);
        //separa por tipo de op tempera
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getPrimeiroDiaMes();
        $aDadosParam['datafin'] = Util::getDataOtem();
        $aDadosParam['tipoOp'] = 'P';
        $aDadosPesoTemperaMensal = $this->Persistencia->geraGerenProd($aDadosParam);
        //separa por tipo de op fio maquina
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getPrimeiroDiaMes();
        $aDadosParam['datafin'] = Util::getDataOtem();
        $aDadosParam['tipoOp'] = 'F';
        $aDadosPesoFioMensal = $this->Persistencia->geraGerenProd($aDadosParam);
        
        if($aDados[0]=='naoEnv'){
            echo '$("#'.$aDados[2].' > tbody >").remove();'; 
            //html visualizacao
            $sHtmlDiario ='             <tr><td>Produção total</td><td> '.number_format($aDadosPesoGeralMensal['pesoTotal'], 2, ',', '.').' Kg</td></tr> '   
                          .'             <tr><td>Fornos contínuos</td><td> '.number_format($aDadosPesoTemperaMensal['pesoTotal'], 2, ',', '.').' Kg</td></tr> '   
                          .'             <tr><td>Fio Máquina Industrialização</td><td>'.number_format($aDadosPesoFioMensal['pesoTotal'], 2, ',', '.').' Kg</td></tr> '; 
            echo '$("#'.$aDados[2].' > tbody").append(\''.$sHtmlDiario.'\');'; 
        }
        
        if($aDados[0]=='EnvEmail'){
           //monta array referente a produção do dia anterior
           $aDadosEmail = array();
           $aDadosEmail['ProdDiaria']['PesoTotal']=$aDadosPesoGeral;
           $aDadosEmail['ProdDiaria']['PesoTempera']=$aDadosPesoTempera;
           $aDadosEmail['ProdDiaria']['PesoFio']=$aDadosPesoFio;
           
           $aDadosEmail['ProdMensal']['PesoTotal']=$aDadosPesoGeralMensal;
           $aDadosEmail['ProdMensal']['PesoTempera']=$aDadosPesoTemperaMensal;
           $aDadosEmail['ProdMensal']['PesoFio']=$aDadosPesoFioMensal;
           
           $this->enviaEmailProducaoSteel($aDadosEmail);
        }
        
        
    }
    /**
     * Rotina de envio de e-mails
     */
    
    public function enviaEmailProducaoSteel($aDadosEmail){
        
        $sTextoEmail = '<h3>PRODUÇÃO STEELTRATER REFERENTE AO DIA '.Util::getDataOtem().'.</h3><hr><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="50%"> '
                        . '<tr><td><b>Produção total do dia '.Util::getDataOtem().'</b></td><td><b>' .number_format( $aDadosEmail['ProdDiaria']['PesoTotal']['pesoTotal'],2, ',', '.') . ' kg</b></td></tr>'
                        . '<tr><td><b>Fornos contínuos</b></td><td><b>' .number_format($aDadosEmail['ProdDiaria']['PesoTempera']['pesoTotal'],2, ',', '.') . ' kg</b></td></tr>'
                        . '<tr><td><b>Fio máquina industrialização</td><td><b>' . number_format($aDadosEmail['ProdDiaria']['PesoFio']['pesoTotal'],2, ',', '.') . ' kg</b></td></tr>'
                        . '</table><br/><br/><br/>';
        $sTextoEmail .='<h3>PRODUÇÃO MENSAL '.Util::getPrimeiroDiaMes().' ATÉ '.Util::getDataOtem().'.</h3><hr><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="50%"> '
                        . '<tr><td><b>Produção mensal </td><td><b>' .number_format( $aDadosEmail['ProdMensal']['PesoTotal']['pesoTotal'],2, ',', '.') . ' kg</b></td></tr>'
                        . '<tr><td><b>Fornos contínuos</b></td><td><b>' .number_format($aDadosEmail['ProdMensal']['PesoTempera']['pesoTotal'],2, ',', '.') . ' kg</b></td></tr>'
                        . '<tr><td><b>Fio máquina industrialização</td><td><b>' . number_format($aDadosEmail['ProdMensal']['PesoFio']['pesoTotal'],2, ',', '.') . ' kg</b></td></tr>'
                        . '</table><br/><br/>'
                        . '<br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>';
        
        //monta envio do email
        $oEmail = new Email();
        $oEmail->setMailer();

        $oEmail->setEnvioSMTP();
        
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('Metalbo@@50');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('PRODUÇÃO STEELTRATER'));
        
        $oEmail->setAssunto(utf8_decode('PRODUÇÃO STEELTRATER DO DIA ' . Util::getDataOtem() . ''));
        $oEmail->setMensagem(utf8_decode($sTextoEmail));
        
         $oEmail->limpaDestinatariosAll();

        // Para
         $aEmails = array();
         $aEmails[]='avanei@metalbo.com.br';
         $aEmails[]='avaneim@gmail.com';
         $aEmails[]='cristian@steeltrater.com.br';
         $aEmails[]='clovis@steeltrater.com.br';
         $aEmails[]='john@metalbo.com.br';
         
          foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
         }
         
         $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, tente novamente no botão de E-mails, caso o problema persista, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
        
    }
    
}