<?php 
 /*
 * Implementa a classe view MET_CAD_Maquinas
 * @author Cleverton Hoffmann
 * @since 13/07/2021
 */
 
class ViewMET_CAD_Maquinas extends View {
 
    public function __construct() {
        parent::__construct();
       }
 
    public function criaConsulta() { 
        parent::criaConsulta();
 
        $this->setUsaAcaoVisualizar(true);
        $this->getTela()->setITipoGrid(2);

        $ofil_des = new CampoConsulta('Empresa', 'DELX_FIL_Empresa.fil_fantasia', CampoConsulta::TIPO_TEXTO);
        $ofil_des->setILargura(30);
        $ocodigoMaq = new CampoConsulta('Cód', 'codigoMaq', CampoConsulta::TIPO_TEXTO); //Código da máquina física
        $ocod = new CampoConsulta('Nr', 'cod', CampoConsulta::TIPO_TEXTO);
        $omaquina = new CampoConsulta('Máquina', 'maquina', CampoConsulta::TIPO_TEXTO);
    //    $obitola = new CampoConsulta('Bitola', 'bitola', CampoConsulta::TIPO_TEXTO);
    //    $oseq = new CampoConsulta('Seq', 'seq', CampoConsulta::TIPO_TEXTO);
        $omaqtip = new CampoConsulta('Categoria', 'maqtip', CampoConsulta::TIPO_TEXTO);
    //    $ocat = new CampoConsulta('Cat', 'cat', CampoConsulta::TIPO_TEXTO);
    //    $onomeclatura = new CampoConsulta('Nomeclatura', 'nomeclatura', CampoConsulta::TIPO_TEXTO);
    //    $ofabricante = new CampoConsulta('Fabricante', 'fabricante', CampoConsulta::TIPO_TEXTO);
        $omodelo = new CampoConsulta('Modelo', 'modelo', CampoConsulta::TIPO_TEXTO);
        $oanofab = new CampoConsulta('Ano Fab.', 'anofab', CampoConsulta::TIPO_TEXTO);
        $ocapacidade = new CampoConsulta('Capacidade', 'capacidade', CampoConsulta::TIPO_TEXTO);
        $oprodutividade = new CampoConsulta('Produtividade', 'produtividade', CampoConsulta::TIPO_TEXTO);
        $otempoOpera = new CampoConsulta('Tempo Operação', 'tempoopera', CampoConsulta::TIPO_TIME);
    //    $ooperadores = new CampoConsulta('Operadores', 'operadores', CampoConsulta::TIPO_TEXTO);
        $oadequadoNr12 = new CampoConsulta('Adequado Nr12', 'adequadonr12', CampoConsulta::TIPO_TEXTO);
        $ocodsetor = new CampoConsulta('Cod. Setor', 'codsetor', CampoConsulta::TIPO_TEXTO);
//        $ofornecedor = new CampoConsulta('fornecedor', 'fornecedor', CampoConsulta::TIPO_DECIMAL);
//        $oserie = new CampoConsulta('serie', 'serie', CampoConsulta::TIPO_TEXTO);
//        $opatrimonio = new CampoConsulta('patrimonio', 'patrimonio', CampoConsulta::TIPO_TEXTO);
//        $opeso02 = new CampoConsulta('peso02', 'peso02', CampoConsulta::TIPO_TEXTO);
//        $oalimentacao = new CampoConsulta('alimentacao', 'alimentacao', CampoConsulta::TIPO_TEXTO);
//        $oprotFixa = new CampoConsulta('protFixa', 'protFixa', CampoConsulta::TIPO_TEXTO);
//        $ometalica = new CampoConsulta('metalica', 'metalica', CampoConsulta::TIPO_TEXTO);
//        $omadeira = new CampoConsulta('madeira', 'madeira', CampoConsulta::TIPO_TEXTO);
//        $otela = new CampoConsulta('tela', 'tela', CampoConsulta::TIPO_TEXTO);
//        $oacrilico = new CampoConsulta('acrilico', 'acrilico', CampoConsulta::TIPO_TEXTO);
//        $opoli = new CampoConsulta('poli', 'poli', CampoConsulta::TIPO_TEXTO);
//        $oprotMovel = new CampoConsulta('protMovel', 'protMovel', CampoConsulta::TIPO_TEXTO);
//        $ometalicaMov = new CampoConsulta('metalicaMov', 'metalicaMov', CampoConsulta::TIPO_TEXTO);
//        $omadeiraMov = new CampoConsulta('madeiraMov', 'madeiraMov', CampoConsulta::TIPO_TEXTO);
//        $otelaMov = new CampoConsulta('telaMov', 'telaMov', CampoConsulta::TIPO_TEXTO);
//        $oacrilicoMov = new CampoConsulta('acrilicoMov', 'acrilicoMov', CampoConsulta::TIPO_TEXTO);
//        $opoliMov = new CampoConsulta('poliMov', 'poliMov', CampoConsulta::TIPO_TEXTO);
//        $osisSeg = new CampoConsulta('sisSeg', 'sisSeg', CampoConsulta::TIPO_TEXTO);
//        $ocortLuz = new CampoConsulta('cortLuz', 'cortLuz', CampoConsulta::TIPO_TEXTO);
//        $olaser = new CampoConsulta('laser', 'laser', CampoConsulta::TIPO_TEXTO);
//        $ooptica = new CampoConsulta('optica', 'optica', CampoConsulta::TIPO_TEXTO);
//        $obatente = new CampoConsulta('batente', 'batente', CampoConsulta::TIPO_TEXTO);
//        $oscanner = new CampoConsulta('scanner', 'scanner', CampoConsulta::TIPO_TEXTO);
//        $otapete = new CampoConsulta('tapete', 'tapete', CampoConsulta::TIPO_TEXTO);
//        $ochaveseg = new CampoConsulta('chaveseg', 'chaveseg', CampoConsulta::TIPO_TEXTO);
//        $omagnetica = new CampoConsulta('magnetica', 'magnetica', CampoConsulta::TIPO_TEXTO);
//        $oeletromec = new CampoConsulta('eletromec', 'eletromec', CampoConsulta::TIPO_TEXTO);
//        $ointseg = new CampoConsulta('intseg', 'intseg', CampoConsulta::TIPO_TEXTO);
//        $orelesSeg = new CampoConsulta('relesSeg', 'relesSeg', CampoConsulta::TIPO_TEXTO);
//        $oclp = new CampoConsulta('clp', 'clp', CampoConsulta::TIPO_TEXTO);
        $ositmaq = new CampoConsulta('Situação', 'sitmaq', CampoConsulta::TIPO_TEXTO);
//        $ozonaProtFixa = new CampoConsulta('zonaProtFixa', 'zonaProtFixa', CampoConsulta::TIPO_TEXTO);
//        $ozonaProtMovel = new CampoConsulta('zonaProtMovel', 'zonaProtMovel', CampoConsulta::TIPO_TEXTO);
//        $ozonaProtSeg = new CampoConsulta('zonaProtSeg', 'zonaProtSeg', CampoConsulta::TIPO_TEXTO);
//        $opartida = new CampoConsulta('partida', 'partida', CampoConsulta::TIPO_TEXTO);
//        $opartidaBaixaTensao = new CampoConsulta('partidaBaixaTensao', 'partidaBaixaTensao', CampoConsulta::TIPO_TEXTO);
//        $opartidaIsolacao = new CampoConsulta('partidaIsolacao', 'partidaIsolacao', CampoConsulta::TIPO_TEXTO);
//        $oparada = new CampoConsulta('parada', 'parada', CampoConsulta::TIPO_TEXTO);
//        $oparadaBaixaTensao = new CampoConsulta('paradaBaixaTensao', 'paradaBaixaTensao', CampoConsulta::TIPO_TEXTO);
//        $oparadaIsolacao = new CampoConsulta('paradaIsolacao', 'paradaIsolacao', CampoConsulta::TIPO_TEXTO);
//        $oemergencia = new CampoConsulta('emergencia', 'emergencia', CampoConsulta::TIPO_TEXTO);
//        $oemergenciaBaixaTensao = new CampoConsulta('emergenciaBaixaTensao', 'emergenciaBaixaTensao', CampoConsulta::TIPO_TEXTO);
//        $oemerIso = new CampoConsulta('emerIso', 'emerIso', CampoConsulta::TIPO_TEXTO);
//        $oemerCabo = new CampoConsulta('emerCabo', 'emerCabo', CampoConsulta::TIPO_TEXTO);
//        $oemercaboBaixaTensao = new CampoConsulta('emercaboBaixaTensao', 'emercaboBaixaTensao', CampoConsulta::TIPO_TEXTO);
//        $oemercaboIso = new CampoConsulta('emercaboIso', 'emercaboIso', CampoConsulta::TIPO_TEXTO);
//        $orearme = new CampoConsulta('rearme', 'rearme', CampoConsulta::TIPO_TEXTO);
//        $oresetBaixaTensao = new CampoConsulta('resetBaixaTensao', 'resetBaixaTensao', CampoConsulta::TIPO_TEXTO);
//        $oresetIso = new CampoConsulta('resetIso', 'resetIso', CampoConsulta::TIPO_TEXTO);
//        $osPortugues = new CampoConsulta('sPortugues', 'sPortugues', CampoConsulta::TIPO_TEXTO);
//        $ochoque = new CampoConsulta('choque', 'choque', CampoConsulta::TIPO_TEXTO);
//        $orelpatrimonio = new CampoConsulta('relpatrimonio', 'relpatrimonio', CampoConsulta::TIPO_TEXTO);
//        $oempcnpj = new CampoConsulta('empcnpj', 'empcnpj', CampoConsulta::TIPO_TEXTO);
//        $otipmanut = new CampoConsulta('tipmanut', 'tipmanut', CampoConsulta::TIPO_TEXTO);
 
        $oBtnCadastraFotos = new CampoConsulta('Cad.Fotos', '', CampoConsulta::TIPO_MVC, CampoConsulta::ICONE_ADICIONAR);
        $oBtnCadastraFotos->addDadosConsultaMVC('MET_CAD_MaquinasImagens', 'TelaCadastraFotos', 'Cadastra imagens da máquina!');
                
        $oDesEmp = new Filtro($ofil_des, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);
        $oCodigoMaqfiltro = new Filtro($ocod, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12);
        $oDescricaoMaqfiltro = new Filtro($omaquina, Filtro::CAMPO_TEXTO, 3, 3, 12, 12);
        $oCodigoSetorfiltro = new Filtro($ocodsetor, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12);
        $oDesSitfiltro = new Filtro($ositmaq, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oDesSitfiltro->setSLabel('');
        $oDesSitfiltro->addItemSelect('', 'TODAS SITUAÇÕES');
        $oDesSitfiltro->addItemSelect('ATIVA', 'ATIVA');
        $oDesSitfiltro->addItemSelect('REFORMA', 'REFORMA');
        $oDesSitfiltro->addItemSelect('MANUTENÇÃO', 'MANUTENÇÃO');
        $oDesSitfiltro->addItemSelect('INATIVA', 'INATIVA');
        $oDesSitfiltro->addItemSelect('ATIVA FERRAMENTAS MANUAIS', 'ATIVA FERRAMENTAS MANUAIS');
        $oDesSitfiltro->addItemSelect('ATIVA AUTOMOTRIZ', 'ATIVA AUTOMOTRIZ');
        
        $this->addFiltro($oDesEmp,$oCodigoMaqfiltro, $oDescricaoMaqfiltro, $oCodigoSetorfiltro, $oDesSitfiltro);
        
        $this->addCampos($ocod, $ofil_des, $oBtnCadastraFotos, $ocodigoMaq, $omaquina, $omaqtip, $omodelo, $oanofab, $ocapacidade, $oprodutividade, $otempoOpera, $oadequadoNr12, $ocodsetor, $ositmaq);
            
        
    }
 
    public function criaTela() { 
        parent::criaTela();
 
        $oTab = new TabPanel();
        $oAbaCadastro = new AbaTabPanel('CADASTRO');
        $oAbaCadastro->setBActive(true);

        $oAbaNr = new AbaTabPanel('NR12');

        $oAbaSistemaSeg = new AbaTabPanel('SISTEMA DE SEGURANÇA');
        
        $oAbaPartParad = new AbaTabPanel('SISTEMA DE PARTIDA E PARADA');
        
        $oAbaFotos = new AbaTabPanel('FOTOS');
        
        $this->addLayoutPadrao('Aba');
        
        $ofil_codigo = new campo('Cód. Empresa', 'fil_codigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $ofil_codigo->setSValor('8993358000174');

        $ofil_Des = new Campo('Descrição', 'DELX_FIL_Empresa.fil_fantasia', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $ofil_Des->setSIdPk($ofil_codigo->getId());
        $ofil_Des->setSValor('STEELTRATER');
        $ofil_Des->setClasseBusca('DELX_FIL_empresa');
        $ofil_Des->addCampoBusca('fil_codigo', '', '');
        $ofil_Des->addCampoBusca('fil_fantasia', '', '');
        $ofil_Des->setSIdTela($this->getTela()->getid());
        $ofil_Des->addValidacao(false, Validacao::TIPO_STRING);
        $ofil_Des->setBCampoBloqueado(true);

        $ofil_codigo->setClasseBusca('DELX_FIL_empresa');
        $ofil_codigo->setSCampoRetorno('fil_codigo', $this->getTela()->getId());
        $ofil_codigo->addCampoBusca('fil_fantasia', $ofil_Des->getId(), $this->getTela()->getId());
        
        $ocodigoMaq = new Campo('Código', 'codigoMaq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $ocodigoMaq->setId('codigoMaqMetCad');
        $ocodigoMaq->addValidacao(false, Validacao::TIPO_INTEIRO);
        $ocodigoMaq->setBFocus(true);
        
        $ocod = new Campo('Nr', 'cod', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $ocod->setBCampoBloqueado(true);
        $omaquina = new Campo('Des. Máquina', 'maquina', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $omaquina->addValidacao(false, Validacao::TIPO_STRING);
        
        //Consulta se já existe esse código para essa máquina não deixando inserir o mesmo.
        $sConsCodMaqRep = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_CAD_Maquinas","consultaCodMaqRep");';
        $ocodigoMaq->addEvento(Campo::EVENTO_CHANGE, $sConsCodMaqRep);
        
        //$obitola = new Campo('Bitola', 'bitola', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        
        $oObs = new Campo('Observação', 'obs', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObs->addValidacao(true, Validacao::TIPO_STRING, 'Campo obrigatório', '1', '1000');
        
        $oseq = new Campo('Célula', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        
        $omaqtip = new Campo('Categoria', 'maqtip', Campo::CAMPO_SELECTSIMPLE, 1, 1, 12, 12);
        $omaqtip->addItemSelect('PO', 'PO');
        $omaqtip->addItemSelect('PF', 'PF');
        $omaqtip->addItemSelect('CNC', 'CNC');
        $omaqtip->addItemSelect('MQ', 'MQ');
        $omaqtip->addItemSelect('ROSQ', 'ROSQ');
        $omaqtip->addItemSelect('DIVER', 'DIVER');
        
        $ositmaq = new Campo('Situação', 'sitmaq', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $ositmaq->addItemSelect('ATIVA', 'ATIVA');
        $ositmaq->addItemSelect('REFORMA', 'REFORMA');
        $ositmaq->addItemSelect('MANUTENÇÃO', 'MANUTENÇÃO');
        $ositmaq->addItemSelect('INATIVA', 'INATIVA');
        $ositmaq->addItemSelect('ATIVA FERRAMENTAS MANUAIS', 'ATIVA FERRAMENTAS MANUAIS');
        $ositmaq->addItemSelect('ATIVA AUTOMOTRIZ', 'ATIVA AUTOMOTRIZ');
        
       // $ocat = new Campo('Cat', 'cat', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        
        $onomeclatura = new Campo('Tipo', 'nomeclatura', Campo::TIPO_TEXTO, 1, 1, 12, 12);
                
        $omodelo = new Campo('Modelo', 'modelo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oanofab = new Campo('Ano Fabricação', 'anofab', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $ocapacidade = new Campo('Capacidade', 'capacidade', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oprodutividade = new Campo('Produtividade', 'produtividade', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $otempoOpera = new Campo('Tempo Operação', 'tempoOpera', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $otempoOpera->setBTime(true);
        //$otempoOpera->setSValor(date('H:i'));
        $ooperadores = new Campo('Operadores Envolvidos', 'operadores', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oadequadoNr12 = new Campo('Adequado Nr12', 'adequadonr12', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oadequadoNr12->addItemSelect('SIM', 'SIM');
        $oadequadoNr12->addItemSelect('NÃO', 'NAO');
        $oadequadoNr12->addItemSelect('PARCIAL', 'PARCIAL');
        
        $ocodsetor = new campo('Setor', 'codsetor', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);

        $oSetorDes = new Campo('Descrição', 'MET_CAD_setores.descsetor', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oSetorDes->setSIdPk($ocodsetor->getId());
        $oSetorDes->setClasseBusca('MET_CAD_setores');
        $oSetorDes->addCampoBusca('codsetor', '', '');
        $oSetorDes->addCampoBusca('descsetor', '', '');
        $oSetorDes->setSIdTela($this->getTela()->getId());
        $oSetorDes->addValidacao(false, Validacao::TIPO_STRING);
        $oSetorDes->setBCampoBloqueado(true);

        $ocodsetor->setClasseBusca('MET_CAD_setores');
        $ocodsetor->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $ocodsetor->addCampoBusca('descsetor', $oSetorDes->getId(), $this->getTela()->getId());

        $ofabricante = new campo('Fabricante', 'fabricante', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);

        $ofabricante_Des = new Campo('Descrição', 'DELX_CAD_Pessoa.emp_razaosocial', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $ofabricante_Des->setSIdPk($ofabricante->getId());
        $ofabricante_Des->setClasseBusca('DELX_CAD_Pessoa');
        $ofabricante_Des->addCampoBusca('emp_codigo', '', '');
        $ofabricante_Des->addCampoBusca('emp_razaosocial', '', '');
        $ofabricante_Des->setSIdTela($this->getTela()->getId());
        $ofabricante_Des->addValidacao(false, Validacao::TIPO_STRING);
        $ofabricante_Des->setBCampoBloqueado(true);

        $ofabricante->setClasseBusca('DELX_CAD_Pessoa');
        $ofabricante->setSCampoRetorno('emp_codigo', $this->getTela()->getId());
        $ofabricante->addCampoBusca('emp_razaosocial', $ofabricante_Des->getId(), $this->getTela()->getId());
        
        $ofornecedor = new campo('Fornecedor', 'fornecedor', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);

        $ofornecedor_Des = new Campo('Descrição', 'DELX_CAD_Pessoa2.emp_razaosocial', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $ofornecedor_Des->setSIdPk($ofornecedor->getId());
        $ofornecedor_Des->setClasseBusca('DELX_CAD_Pessoa');
        $ofornecedor_Des->addCampoBusca('emp_codigo', '', '');
        $ofornecedor_Des->addCampoBusca('emp_razaosocial', '', '');
        $ofornecedor_Des->setSIdTela($this->getTela()->getid());
        $ofornecedor_Des->addValidacao(false, Validacao::TIPO_STRING);
        $ofornecedor_Des->setBCampoBloqueado(true);

        $ofornecedor->setClasseBusca('DELX_CAD_Pessoa');
        $ofornecedor->setSCampoRetorno('emp_codigo', $this->getTela()->getId());
        $ofornecedor->addCampoBusca('emp_razaosocial', $ofornecedor_Des->getId(), $this->getTela()->getId());
       
        $oserie = new Campo('Número de Série', 'serie', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $opatrimonio = new Campo('Patrimônio', 'patrimonio', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $opeso02 = new Campo('Peso da Máquina', 'peso02', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        
        $oalimentacao = new Campo('Alimentação', 'alimentacao', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oalimentacao->addItemSelect('MANUAL', 'MANUAL');
        $oalimentacao->addItemSelect('SEMI-AUTOMÁTICA', 'SEMI-AUTOMÁTICA');
        $oalimentacao->addItemSelect('AUTOMÁTICA', 'AUTOMÁTICA');
        
        //------------------------INICIO ABA SISTEMAS DE SEGURANÇA--------------------------//------------------------------------------------------
        
        ///-----------------------Inicio Tipo de Proteção----------------------///
        
        $oDivisor = new Campo('TIPOS DE PROTEÇÃO', 'ptfix', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor->setApenasTela(true);
        
        //---------Inicio Proteções Fixas------------//
        $oprotFixa = new Campo('Proteções Fixas', 'protfixa', Campo::TIPO_RADIO, 5, 5, 12, 12);
        $oprotFixa->addItenRadio('INTEGRAL', 'Integral');
        $oprotFixa->addItenRadio('PARCIAL', 'Parcial');
        $oprotFixa->addItenRadio('NÃO', 'Não');
        $oprotFixa->addItenRadio('NÃO SE APLICA', 'Não se aplica');
                
        $ometalica = new Campo('Metálica', 'metalica', Campo::TIPO_CHECK_STRING, 1, 1, 12, 12);
        $ometalica->setSValorCheck('Sim');
        $omadeira = new Campo('Madeiras', 'madeira', Campo::TIPO_CHECK_STRING, 1, 1, 12, 12);
        $omadeira->setSValorCheck('Sim');
        $otela = new Campo('Tela', 'tela', Campo::TIPO_CHECK_STRING, 1, 1, 12, 12);
        $otela->setSValorCheck('Sim');
        $oacrilico = new Campo('Acrílico', 'acrilico', Campo::TIPO_CHECK_STRING, 1, 1, 12, 12);
        $oacrilico->setSValorCheck('Sim');
        $opoli = new Campo('Policarbonato', 'poli', Campo::TIPO_CHECK_STRING, 1, 1, 12, 12);
        $opoli->setSValorCheck('Sim');
        $ozonaProtFixa = new Campo('Zona protegida', 'zonaprotfixa', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        //---------Fim Proteções Fixas------------//
        
        //---------Inicio Proteções Móveis------------//
        $oprotMovel = new Campo('Proteções Móveis', 'protmovel', Campo::TIPO_RADIO, 5, 5, 12, 12);
        $oprotMovel->addItenRadio('INTEGRAL', 'Integral');
        $oprotMovel->addItenRadio('PARCIAL', 'Parcial');
        $oprotMovel->addItenRadio('NÃO', 'Não');
        $oprotMovel->addItenRadio('NÃO SE APLICA', 'Não se aplica');
        
        $ometalicaMov = new Campo('Metálica', 'metalicamov', Campo::TIPO_CHECK_STRING, 1, 1, 12, 12);
        $ometalicaMov->setSValorCheck('Sim');
        $omadeiraMov = new Campo('Madeiras', 'madeiramov', Campo::TIPO_CHECK_STRING, 1, 1, 12, 12);
        $omadeiraMov->setSValorCheck('Sim');
        $otelaMov = new Campo('Tela', 'telamov', Campo::TIPO_CHECK_STRING, 1, 1, 12, 12);
        $otelaMov->setSValorCheck('Sim');
        $oacrilicoMov = new Campo('Acrílico', 'acrilicomov', Campo::TIPO_CHECK_STRING, 1, 1, 12, 12);
        $oacrilicoMov->setSValorCheck('Sim');
        $opoliMov = new Campo('Policarbonato', 'polimov', Campo::TIPO_CHECK_STRING, 1, 1, 12, 12);
        $opoliMov->setSValorCheck('Sim');
        $ozonaProtMovel = new Campo('Zona protegida', 'zonaprotmovel', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $ozonaProtMovel->addValidacao(true, Validacao::TIPO_STRING, 'Campo obrigatório', '1', '1000');
        //---------Fim Proteções Móveis------------//
        
        $oDivisor1 = new Campo('', 'ptfix1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);
     
        ///-----------------------Fim Tipo de Proteção----------------------///
        
        ///-----------------------Inicio Dispositivos de Segurança----------------------///
        
        $oDivisor2 = new Campo('DISPOSITIVOS DE SEGURANÇA', 'dpseg2', Campo::DIVISOR_INFO, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);
        
        //---------Inicio Chaves de Segurança------------//
        $ochaveseg = new Campo('Chaves de Segurança', 'chaveseg', Campo::TIPO_RADIO, 5, 5, 12, 12);
        $ochaveseg->addItenRadio('INTEGRAL', 'Integral');
        $ochaveseg->addItenRadio('PARCIAL', 'Parcial');
        $ochaveseg->addItenRadio('NÃO', 'Não');
        $ochaveseg->addItenRadio('NÃO SE APLICA', 'Não se aplica');
        
        $omagnetica = new Campo('Magnetica', 'magnetica', Campo::TIPO_CHECK_STRING, 2, 2, 12, 12);
        $omagnetica->setSValorCheck('Sim');
        $oeletromec = new Campo('Eletromecânica', 'eletromec', Campo::TIPO_CHECK_STRING, 2, 2, 12, 12);
        $oeletromec->setSValorCheck('Sim');
        //---------Fim Chaves de Segurança------------//
        
        //---------Inicio Interface de segurança------------//
        $ointseg = new Campo('Interface de Segurança', 'intseg', Campo::TIPO_RADIO, 5, 5, 12, 12);
        $ointseg->addItenRadio('INTEGRAL', 'Integral');
        $ointseg->addItenRadio('PARCIAL', 'Parcial');
        $ointseg->addItenRadio('NÃO', 'Não');
        $ointseg->addItenRadio('NÃO SE APLICA', 'Não se aplica');
        
        $orelesSeg = new Campo('Relé de segurança', 'relesseg', Campo::TIPO_CHECK_STRING, 2, 2, 12, 12);
        $orelesSeg->setSValorCheck('Sim');
        $oclp = new Campo('CLP de segurança', 'clp', Campo::TIPO_CHECK_STRING, 2, 2, 12, 12);
        $oclp->setSValorCheck('Sim');
        //---------Fim Interface de segurança------------//
        
        //---------Inicio Sensores de Segurança------------//
        $osisSeg = new Campo('Sensores de Segurança', 'sisseg', Campo::TIPO_RADIO, 5, 5, 12, 12);
        $osisSeg->addItenRadio('INTEGRAL', 'Integral');
        $osisSeg->addItenRadio('PARCIAL', 'Parcial');
        $osisSeg->addItenRadio('NÃO', 'Não');
        $osisSeg->addItenRadio('NÃO SE APLICA', 'Não se aplica');
        
        $ocortLuz = new Campo('Cortina de Luz', 'cortluz', Campo::TIPO_CHECK_STRING, 2, 2, 12, 12);
        $ocortLuz->setSValorCheck('Sim');
        $olaser = new Campo('Laser m. feixes', 'laser', Campo::TIPO_CHECK_STRING, 2, 2, 12, 12);
        $olaser->setSValorCheck('Sim');
        $ooptica = new Campo('Barreira Óptica', 'optica', Campo::TIPO_CHECK_STRING, 2, 2, 12, 12);
        $ooptica->setSValorCheck('Sim');
        $oscanner = new Campo('Scanner', 'scanner', Campo::TIPO_CHECK_STRING, 2, 2, 12, 12);
        $oscanner->setSValorCheck('Sim');
        $otapete = new Campo('Tapete', 'tapete', Campo::TIPO_CHECK_STRING, 2, 2, 12, 12);
        $otapete->setSValorCheck('Sim');
        $obatente = new Campo('Batente (borda sensitiva)', 'batente', Campo::TIPO_CHECK_STRING, 3, 3, 12, 12);
        $obatente->setSValorCheck('Sim');
        
        $ozonaProtSeg = new Campo('Zona protegida', 'zonaprotseg', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $ozonaProtSeg->addValidacao(true, Validacao::TIPO_STRING, 'Campo obrigatório', '1', '1000');
        //---------Fim Sensores de Segurança------------//
        ///-----------------------Fim Dispositivos de Segurança----------------------///
        
        $oDivisor3 = new Campo('', 'dpSeg3', Campo::DIVISOR_INFO, 12, 12, 12, 12);
        $oDivisor3->setApenasTela(true);
        
        //------------------------FIM ABA SISTEMAS DE SEGURANÇA--------------------------//-----------------------------------------------------   

        //------------------------INICIO ABA SISTEMA DE PARTIDA E PARADA--------------------------//-----------------------------------------------------   
        $opartida = new Campo('Partida', 'partida', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $opartida->addItenRadio('Sim', 'Sim');
        $opartida->addItenRadio('Não', 'Não');
        
        $opartidaBaixaTensao = new Campo('Extra Baixa Tensão', 'partidabaixatensao', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $opartidaBaixaTensao->addItenRadio('Sim', 'Sim');
        $opartidaBaixaTensao->addItenRadio('Não', 'Não');
        
        $opartidaIsolacao = new Campo('Dupla Isolação', 'partidaisolacao', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $opartidaIsolacao->addItenRadio('Sim', 'Sim');
        $opartidaIsolacao->addItenRadio('Não', 'Não');
        
        $oparada = new Campo('Parada', 'parada', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $oparada->addItenRadio('Sim', 'Sim');
        $oparada->addItenRadio('Não', 'Não');
        
        $oparadaBaixaTensao = new Campo('Extra Baixa Tensão', 'paradabaixatensao', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $oparadaBaixaTensao->addItenRadio('Sim', 'Sim');
        $oparadaBaixaTensao->addItenRadio('Não', 'Não');
        
        $oparadaIsolacao = new Campo('Dupla Isolação', 'paradaisolacao', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $oparadaIsolacao->addItenRadio('Sim', 'Sim');
        $oparadaIsolacao->addItenRadio('Não', 'Não');
        
        $oemergencia = new Campo('Emergência', 'emergencia', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $oemergencia->addItenRadio('Sim', 'Sim');
        $oemergencia->addItenRadio('Não', 'Não');
        
        $oemergenciaBaixaTensao = new Campo('Extra Baixa Tensão', 'emergenciabaixatensao', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $oemergenciaBaixaTensao->addItenRadio('Sim', 'Sim');
        $oemergenciaBaixaTensao->addItenRadio('Não', 'Não');
        
        $oemerIso = new Campo('Dupla Isolação', 'emeriso', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $oemerIso->addItenRadio('Sim', 'Sim');
        $oemerIso->addItenRadio('Não', 'Não');
                
        $orearme = new Campo('Rearme (Reset)', 'rearme', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $orearme->addItenRadio('Sim', 'Sim');
        $orearme->addItenRadio('Não', 'Não');
        
        $oresetBaixaTensao = new Campo('Extra Baixa Tensão', 'resetbaixatensao', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $oresetBaixaTensao->addItenRadio('Sim', 'Sim');
        $oresetBaixaTensao->addItenRadio('Não', 'Não');
        
        $oresetIso = new Campo('Dupla Isolação', 'resetiso', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $oresetIso->addItenRadio('Sim', 'Sim');
        $oresetIso->addItenRadio('Não', 'Não');
        
        $osPortugues = new Campo('Sinalização em língua portuguêsa', 'sportugues', Campo::TIPO_RADIO, 12, 12, 12, 12);
        $osPortugues->addItenRadio('Sim', 'Sim');
        $osPortugues->addItenRadio('Não', 'Não');
        
        $ochoque = new Campo('Outras medidas de proteção contra choque elétrico', 'choque', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $ochoque->addValidacao(true, Validacao::TIPO_STRING, 'Campo obrigatório', 1, 1000);
        
        //------------------------FIM ABA SISTEMA DE PARTIDA E PARADA--------------------------//-----------------------------------------------------   
        
        
    //    $oemerCabo = new Campo('emerCabo', 'emerCabo', Campo::TIPO_TEXTO, 1, 1, 12, 12);        
    //    $oemercaboBaixaTensao = new Campo('emercaboBaixaTensao', 'emercaboBaixaTensao', Campo::TIPO_TEXTO, 1, 1, 12, 12); 
    //    $oemercaboIso = new Campo('emercaboIso', 'emercaboIso', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        
//        $orelpatrimonio = new Campo('relpatrimonio', 'relpatrimonio', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oempcnpj = new Campo('empcnpj', 'empcnpj', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $otipmanut = new Campo('tipmanut', 'tipmanut', Campo::TIPO_TEXTO, 1, 1, 12, 12);
 
        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);
        $oLinha2 = new campo('', 'linha2', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLinha2->setApenasTela(true);
        
        //Divisor sistema partida
        $oDivisor11 = new Campo('PARTIDA', 'divparpar1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor11->setApenasTela(true);
        
        //Divisor sistema parada
        $oDivisor12 = new Campo('PARADA', 'divparpar2', Campo::DIVISOR_INFO, 12, 12, 12, 12);
        $oDivisor12->setApenasTela(true);
        
        //Divisore sistema 
        $oDivisor13 = new Campo('EMERGÊNCIA', 'divparpar3', Campo::DIVISOR_SUCCESS, 12, 12, 12, 12);
        $oDivisor13->setApenasTela(true);
        
        //Divisore sistema 
        $oDivisor14 = new Campo('REARME(RESET)', 'divparpar4', Campo::DIVISOR_WARNING, 12, 12, 12, 12);
        $oDivisor14->setApenasTela(true);
                
        $oAbaCadastro->addCampos(array($ofil_codigo, $ofil_Des), $oLinha1, array($ocod, $ocodigoMaq, $omaquina), $oLinha1, array($oseq, $omaqtip), $oLinha1, $oObs);

        $oAbaNr->addCampos($onomeclatura, $omodelo, array($ofabricante, $ofabricante_Des), $oLinha1, array($ofornecedor, $ofornecedor_Des), $oLinha1, array($oserie, $opatrimonio), $opeso02, array($oanofab, $oprodutividade, $ooperadores), array($ocapacidade , $otempoOpera, $oadequadoNr12), array($ocodsetor, $oSetorDes), array($oalimentacao, $ositmaq));
                
        $oAbaSistemaSeg->addCampos($oDivisor, $oLinha1, array($oprotFixa, $ometalica, $omadeira, $otela, $oacrilico, $opoli), $oLinha1, $ozonaProtFixa ,$oLinha1,$oLinha2, array($oprotMovel, $ometalicaMov, $omadeiraMov, $otelaMov, $oacrilicoMov, $opoliMov), $oLinha1, $ozonaProtMovel, $oDivisor1, $oDivisor2, $oLinha1, array($ochaveseg, $omagnetica, $oeletromec), $oLinha1, $oLinha2, array($ointseg, $orelesSeg, $oclp), $oLinha1, $oLinha2, array($osisSeg, $ocortLuz, $olaser, $ooptica, $oscanner, $otapete, $obatente), $oLinha1, $ozonaProtSeg, $oDivisor3);
        
        $oAbaPartParad->addCampos($oLinha1,$oDivisor11, $oLinha1, array($opartida, $opartidaBaixaTensao, $opartidaIsolacao), $oLinha1,$oDivisor12, $oLinha1, array($oparada, $oparadaBaixaTensao, $oparadaIsolacao), $oLinha1, $oDivisor13, $oLinha1, array($oemergencia, $oemergenciaBaixaTensao, $oemerIso), $oLinha1, $oDivisor14, $oLinha1, array($orearme, $oresetBaixaTensao, $oresetIso), $oLinha1, $oLinha2, $osPortugues,$oLinha1, $ochoque);
        
       // $oAbaFotos->addCampos($ocat, $orelpatrimonio, $oempcnpj, $otipmanut);
        
        $oTab->addItems($oAbaCadastro, $oAbaNr, $oAbaSistemaSeg, $oAbaPartParad/*, $oAbaFotos*/);
        
        $this->addCampos($oTab);
    } 
    
    public function relCadMaqSteel() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de cadastro de máquinas');
        $this->setBTela(true);

        $oOrdData1 = new Campo('Ordenação', 'orddata1', Campo::TIPO_RADIO, 6);
        $oOrdData1->addItenRadio('desc', 'Ordena por código decrescente');
        $oOrdData1->addItenRadio('asc', 'Ordena por código crescente');

        $this->addCampos($oOrdData1);
    }
}