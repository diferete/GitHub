<?php

/* 
 * @author Avanei Martendal
 * @Since 06/09/2019
 */

class ControllerSTEEL_PCP_ordensFabApontEtapas extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_ordensFabApontEtapas');
    }
    
    public function atualizaApontEnt($sDados){
        $aDados = explode(',', $sDados);
        
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        //verifica se foi informado uma op válida
        if($aCamposChave['op']==''){
            $oMensagem = new Mensagem('Op não informada!', 'Informe uma ordem de produção.', Mensagem::TIPO_WARNING, 5000);
            echo $oMensagem->getRender();
            echo '$("#'.$aDados[0].' > tbody >").remove();'; 
            exit();
        }
       //busca o apontamento da ordem de producao
        $oDadosEnt = Fabrica::FabricarController('STEEL_PCP_ordensFabApontEnt');
        $oDadosEnt->Persistencia->adicionaFiltro('op',$aCamposChave['op']);
        $oDadosOp = $oDadosEnt->Persistencia->consultarWhere();
        
         //verifica se há op apontada
        if($oDadosOp->getOp()==null){
             $oMensagem = new Mensagem('Ordem de produção não encontrada!', 'Informe uma nova ordem de produção.', Mensagem::TIPO_ERROR, 5000);
            echo $oMensagem->getRender();
            echo '$("#'.$aDados[0].' > tbody >").remove();'; 
            exit();
        }
        
        //carrega os dados no grid
         echo '$("#'.$aDados[0].' > tbody >").remove();'; 
         //verifica a cor verde para finalizado e azul para processo
         $sCorFundo ='';
         if($oDadosOp->getSituacao()=='Processo'){
             $sCorFundo = 'azul';
         }else{
             $sCorFundo = 'verde';
         }
        //html visualizacao
        $sRenderOp ='<tr class="tr-'.$sCorFundo.'" >'
                .'<td><button type="button" id="'.$aDados[0].'-btn" title="Excluir apontamento!" class="btn btn-outline btn-danger btn-xs"><i class="icon wb-trash" aria-hidden="true"></i></button></td>'
                . '<td>'.$oDadosOp->getOp().'</td>'
                . '<td>'.$oDadosOp->getProdes().'</td>'
                . '<td>'.$oDadosOp->getFornodes().'</td>'
                . '<td>'.$oDadosOp->getTurnoSteel().'</td>'
                . '<td>'.date('d/m/Y',strtotime($oDadosOp->getDataent_forno())).'</td>'
                . '<td>'.substr($oDadosOp->getHoraent_forno(), 0, -8).'</td>'
                . '<td class="tr-bk-'.$sCorFundo.'">'.$oDadosOp->getSituacao().'</td>'
                . '<td>'.$oDadosOp->getUsernome().'</td>'
                . '</tr> <script>$("#' . $aDados[0]. '-btn").click(function(){ '
                . 'requestAjax("","STEEL_PCP_ordensFabApontEtapas","atualizaApontEnt","' .$aDados[0]. '","consultaApontGrid");'
                . ' }); </script>';  
                    
        echo '$("#'.$aDados[0].' > tbody").append(\''.$sRenderOp.'\');';
        
        
        
        
    }
    
    
}

