<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 03/10/2018
 */

class ViewSTEEL_PCP_Certificado extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oNr = new CampoConsulta('Nr.', 'nrcert');
        $oOp = new CampoConsulta('Op', 'op');
        $oNotaSteel = new CampoConsulta('Nota STEEL', 'notasteel');
        //$oNotaClient = new CampoConsulta('Nota Cliente', 'notacliente');
        $oOpcliente = new CampoConsulta('OP Cliente.', 'opcliente');
        //$oEmpCod = new CampoConsulta('Empresa', 'empcod');
        $oEmpDes = new CampoConsulta('Descrição', 'empdes');
        $oProduto = new CampoConsulta('Produto', 'prodes');
        $oDataEnsaio = new CampoConsulta('Data Ensaio', 'dataensaio', CampoConsulta::TIPO_DATA);
        $oPeso = new CampoConsulta('Peso', 'peso');
        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO, 5);
        

        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oOpFiltro);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir',Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'STEEL_PCP_Certificado', 'acaoMostraRelCertificado', '', false, 'CertificadoOpSteel',false,'',false,'',true);
        
        $this->addDropdown($oDrop1);
        
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->addCampos($oNr,$oOp,$oNotaSteel,$oOpcliente,$oEmpDes,$oProduto,$oDataEnsaio,$oPeso);
    }

    public function criaTela() {
        parent::criaTela();
        
        $oDadosOp = $this->getAParametrosExtras();
        
        date_default_timezone_set('America/Sao_Paulo');
       
        $oNr = new Campo('Nr.', 'nrcert', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);
        
        $oOp = new Campo('Op','op',Campo::TIPO_BUSCADOBANCOPK,1,2,12,12);
        $oOp->setClasseBusca('STEEL_PCP_OrdensFab');
        $oOp->setSCampoRetorno('op',$this->getTela()->getId());
        $oOp->setBFocus(true);
        $oOp->setSCorFundo(Campo::FUNDO_AMARELO);
        $oOp->addValidacao(false, Validacao::TIPO_INTEIRO);
        if(method_exists($oDadosOp, 'getOp')) 
         {$oOp->setSValor($oDadosOp->getOp());
         $oOp->setBCampoBloqueado(TRUE);
         }
                
        $oNotaSteel = new Campo('Nota retorno', 'notasteel', Campo::TIPO_TEXTO, 1, 2, 12, 12);
        $oNotaSteel->addValidacao(false, Validacao::TIPO_INTEIRO);
        $oNotaClient = new Campo('Nota rec.', 'notacliente', Campo::TIPO_TEXTO, 1, 2, 12, 12);
        $oNotaClient->addValidacao(false, Validacao::TIPO_INTEIRO);
        if(method_exists($oDadosOp, 'getDocumento')) 
         {$oNotaClient->setSValor($oDadosOp->getDocumento());
         $oNotaClient->setBCampoBloqueado(TRUE);
         }
        $oOpcliente = new Campo('OP Cliente.', 'opcliente', Campo::TIPO_TEXTO, 1, 2, 12, 12);
        $oOpcliente->addValidacao(false, Validacao::TIPO_INTEIRO);
        if(method_exists($oDadosOp, 'getOpcliente')) 
         {$oOpcliente->setSValor($oDadosOp->getOpcliente());
         $oOpcliente->setBCampoBloqueado(TRUE);
         }
       
        //cliente
        $oEmp_codigo = new Campo('Empresa','empcod',Campo::TIPO_BUSCADOBANCOPK,2);
        $oEmp_codigo->addValidacao(false, Validacao::TIPO_INTEIRO);
        if(method_exists($oDadosOp, 'getEmp_codigo')) 
         {$oEmp_codigo->setSValor($oDadosOp->getEmp_codigo());
         $oEmp_codigo->setBCampoBloqueado(TRUE);
         }
        
        
        //campo descrição do cliente adicionando o campo de busca
        $oEmp_des = new Campo('Descricao','empdes',Campo::TIPO_BUSCADOBANCO, 4);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '','');
        $oEmp_des->addCampoBusca('emp_razaosocial', '','');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        $oEmp_des->addValidacao(false, Validacao::TIPO_STRING);
        if(method_exists($oDadosOp, 'getEmp_razaosocial')) 
         {$oEmp_des->setSValor($oDadosOp->getEmp_razaosocial());
         $oEmp_des->setBCampoBloqueado(TRUE);
         }
        
        //declarar o campo descrição
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo',$this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial',$oEmp_des->getId(),  $this->getTela()->getId());
        
        $oCodProd = new Campo('Produto', 'procod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCodProd->setSCorFundo(Campo::FUNDO_MONEY);
        $oCodProd->addValidacao(false, Validacao::TIPO_INTEIRO);
       // $oCodProd->setBCampoBloqueado(TRUE);
        if(method_exists($oDadosOp, 'getProd')) 
         {$oCodProd->setSValor($oDadosOp->getProd());
         $oCodProd->setBCampoBloqueado(TRUE);
         }
        
        $oProduto = new Campo('Descrição', 'prodes', Campo::TIPO_TEXTO, 4, 3, 12, 12);
        $oProduto->setSCorFundo(Campo::FUNDO_MONEY);
        $oProduto->addValidacao(false, Validacao::TIPO_STRING);
        if(method_exists($oDadosOp, 'getProdes')) 
         {$oProduto->setSValor($oDadosOp->getProdes());
         $oProduto->setBCampoBloqueado(TRUE);
         }
        
        $oDataEnsaio = new Campo('Data Ensaio', 'dataensaio', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataEnsaio->setSValor(date('d/m/Y'));
        $oDataEnsaio->addValidacao(false, Validacao::TIPO_STRING);
        $oQuant = new Campo('Qt.', 'quant', Campo::TIPO_DECIMAL, 1, 2, 12, 12);
        $oQuant->addValidacao(false, Validacao::TIPO_DECIMAL);
        if(method_exists($oDadosOp, 'getquant')) 
         {$oQuant->setSValor(number_format($oDadosOp->getQuant(), 2, ',', '.'));
         $oQuant->setBCampoBloqueado(TRUE);
         }
        
        $oPeso = new Campo('Peso', 'peso', Campo::TIPO_DECIMAL, 1, 2, 12, 12);
        $oPeso->setSValor(number_format($oPeso, 2, ',', '.'));
        $oPeso->addValidacao(false, Validacao::TIPO_DECIMAL);
        if(method_exists($oDadosOp, 'getPeso')) 
         {$oPeso->setSValor(number_format($oDadosOp->getPeso(), 2, ',', '.'));
         $oPeso->setBCampoBloqueado(TRUE);
         }
        
        $oDataEmi=new Campo('Emissão','dataemissao', Campo::TIPO_TEXTO,1);
        $oDataEmi->setSValor(date('d/m/Y'));
        $oDataEmi->setBCampoBloqueado(true);
        
        $oHora = new Campo('Hora','hora', Campo::TIPO_TEXTO,1,2,12,12);
        $oHora->setBCampoBloqueado(true);
        $oHora->setBTime(true);
        $oHora->setSValor (date('H:i'));
        
        $oUser = new Campo('Usuário','usuario', Campo::TIPO_TEXTO,2,2,12,12);
        $oUser->setBCampoBloqueado(true);
        $oUser->setSValor($_SESSION['nome']);
        
        //linha
        $oLinha1 = new Campo('','linha', Campo::TIPO_LINHA,12);
        $oLinha1->setApenasTela(true);
        
         //ativa o fechamento da tela ao inserir
        $this->getTela()->setBFecharTelaIncluir(true);
        
        if($oDadosOp==null){
         //adiciona os eventos ao sair do campo op e do botao pesquisar
         $sEventoOp = 'var OpSteel =  $("#'.$oOp->getId().'").val();if(OpSteel !==""){requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_Certificado","consultaOpDados",'
                 . '"'.$oEmp_codigo->getId().','.$oEmp_des->getId().','.$oCodProd->getId().','.$oProduto->getId()
                 .','.$oOpcliente->getId().','.$oPeso->getId().','.$oNotaClient->getId().','.$oQuant->getId().'");}'
                 . 'else{$("#'.$oEmp_codigo->getId().'").val(""); $("#'.$oEmp_des->getId().'").val(""); '
                 . '$("#'.$oCodProd->getId().'").val(""); $("#'.$oProduto->getId().'").val(""); '
                 . '$("#'.$oOpcliente->getId().'").val(""); $("#'.$oPeso->getId().'").val("");  '
                 . '$("#'.$oNotaClient->getId().'").val(""); $("#'.$oQuant->getId().'").val("");};';
         $oOp->addEvento(Campo::EVENTO_SAIR,$sEventoOp);
        }
        
        $this->addCampos(array($oNr,$oOp,$oNotaSteel),array($oEmp_codigo,$oEmp_des),array($oOpcliente,$oNotaClient,$oCodProd, $oProduto),
                array($oQuant,$oPeso,$oDataEnsaio),$oLinha1,array($oDataEmi,$oHora,$oUser));
    }

}
