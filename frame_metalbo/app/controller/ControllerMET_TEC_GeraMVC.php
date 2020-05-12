<?php

/*
 * Implementa a classe controler do gerador de classes
 * @author Cleverton Hoffmann
 * @since 07/05/2020
 */

class ControllerMET_TEC_GeraMVC extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_GeraMVC');
    }

    /**
     * Método que realiza as verificações dos campos
     */
    public function verificaCampos() {
        $sDados = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sDados, $aCamposChave);
        $sNomeMVC = $aCamposChave['nomemvc'];
        $sNomeTabela = $aCamposChave['nometabela'];

        //Verifica se a tabela possui uma extenção específica tipo widl.emp01 e remove widl
        if (stristr($sNomeTabela, ".") != '') {
            $sNomeTabela = explode(".", $sNomeTabela)[1];
        }

        //Verifica se os campos em tela estão preenchidos
        if ($sNomeMVC != '' && $sNomeTabela != '') {

            //Verifica se nome da classe deve ser gerada sem nomenclatura conforme definido pelo usuário
            if (!$aCamposChave['nomclat']) {

                $aMVC = explode('_', $sNomeMVC);

                //Verifica se existe uma sigla já definida pelo usuário no nome da MVC
                if ($aMVC[0] == "MET" || $aMVC[0] == "STEEL" || $aMVC[0] == "DELX") {
                    
                } else {
                    //Acrescenta a empresa no nome das classes
                    if ($aCamposChave['frame'] == 'frame_metalbo') {
                        $aCamposChave['nomemvc'] = "MET_" . $aCamposChave['nomemvc'];
                        $sNomeMVC = $aCamposChave['nomemvc'];
                    } else {
                        $aCamposChave['nomemvc'] = "STEEL_" . $aCamposChave['nomemvc'];
                        $sNomeMVC = $aCamposChave['nomemvc'];
                    }
                }
            }

            //Verifica se a classe existe
            if ($this->Persistencia->verificaSeClasseExiste($sNomeMVC, $aCamposChave)) {
                $oModal = new Modal('Atenção', 'Classe já existe, favor verificar nos diretórios!', Modal::TIPO_ERRO);
                echo $oModal->getRender();
                exit();
            }

            //Verifica se a tabela existe
            if ($this->Persistencia->verificaTabelaExiste($sNomeTabela)) {

                //Busca o nome das colunas da tabela
                $aCampos = $this->Persistencia->buscaCampos($sNomeTabela);
                //Chama método que inicia a geração das classes
                $this->geraClasses($aCampos, $aCamposChave);
            } else {
                $oModal = new Modal('Atenção', 'Tabela inexistente no banco, crie primeiro a tabela!', Modal::TIPO_ERRO);
                echo $oModal->getRender();
                exit();
            }
        } else {
            $oModal = new Modal('Atenção', 'O nome da MVC e da Tabela devem estar preenchidos!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
    }

    /**
     * Método que gerencia a geração das classes
     * @param type $aCampos
     * @param type $aCamposChave
     */
    public function geraClasses($aCampos, $aCamposChave) {

        //Chama os métodos da parte que cria a estrutura texto das classes
        $sController = $this->estruturaCriaController($aCamposChave['nomemvc']);
        $sPersistencia = $this->estruturaCriaPersistencia($aCamposChave['nomemvc'], $aCamposChave['nometabela'], $aCampos);
        $sModel = $this->estruturaCriaModel($aCamposChave['nomemvc'], $aCampos);
        $sView = $this->estruturaCriaView($aCamposChave, $aCampos);

        //Chama os métodos na persistencia que cria as classes em arquivos 
        $bBol1 = $this->Persistencia->CriaArquivoController($sController, $aCamposChave);
        $bBol2 = $this->Persistencia->CriaArquivoModel($sModel, $aCamposChave);
        $bBol3 = $this->Persistencia->CriaArquivoPersistencia($sPersistencia, $aCamposChave);
        $bBol4 = $this->Persistencia->CriaArquivoView($sView, $aCamposChave);

        //Gera mensagem se houve algum erro na criação das classes
        if ($bBol1 & $bBol2 & $bBol3 & $bBol4) {
            $oModal = new Modal('Sucesso', 'Classes geradas com sucesso!', Modal::TIPO_SUCESSO);
            echo $oModal->getRender();
            exit();
        } else {
            $oModal = new Modal('Atenção', 'Algum erro de geração encontrado!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
    }

    /**
     * Cria a estrutura texto da controller
     * @param type $sNome
     * @return string
     */
    public function estruturaCriaController($sNome) {

        $sTexto = "<?php "
                . "\r\n /*"
                . "\n * Implementa a classe controler " . $sNome
                . "\n * @author " . $_SESSION['nome'] . ""
                . "\n * @since " . date('d/m/Y') . ""
                . "\n */"
                . "\r \nclass Controller" . $sNome . " extends Controller {"
                . "\r \n    public function __construct() {"
                . "\n        \$this->carregaClassesMvc('" . $sNome . "');"
                . "\n    } \r \n}";

        return $sTexto;
    }

    /**
     * Cria a estrutura texto da model
     * @param type $sNome
     * @param type $aCampos
     * @return string
     */
    public function estruturaCriaModel($sNome, $aCampos) {

        $sTexto = "<?php "
                . "\r\n /*"
                . "\n * Implementa a classe model " . $sNome
                . "\n * @author " . $_SESSION['nome'] . ""
                . "\n * @since " . date('d/m/Y') . ""
                . "\n */"
                . "\r \nclass Model" . $sNome . " {\r";

        foreach ($aCampos as $skey) {
            $sTexto .= "\r\n    private $" . strtolower($skey[0]) . ";";
        }
        $sTexto .= "\r\n";
        foreach ($aCampos as $skey) {
            $sTexto .= "\n    function get" . ucfirst(strtolower($skey[0])) . "(){";
            $sTexto .= "\n       return \$this->" . strtolower($skey[0]) . ";";
            $sTexto .= "\n    }";

            $sTexto .= "\n    function set" . ucfirst(strtolower($skey[0])) . "($" . strtolower($skey[0]) . "){";
            $sTexto .= "\n       \$this->" . strtolower($skey[0]) . " = $" . strtolower($skey[0]) . ";";
            $sTexto .= "\n    }";
        }

        $sTexto .= "\r\n}";

        return $sTexto;
    }

    /**
     * Cria a estrutura texto da persistencia
     * @param type $sNome
     * @param type $sTabela
     * @param type $aCampos
     * @return string
     */
    public function estruturaCriaPersistencia($sNome, $sTabela, $aCampos) {

        $sTexto = "<?php "
                . "\r\n /*"
                . "\n * Implementa a classe persistencia " . $sNome
                . "\n * @author " . $_SESSION['nome'] . ""
                . "\n * @since " . date('d/m/Y') . ""
                . "\n */"
                . "\r \nclass Persistencia" . $sNome . " extends Persistencia {"
                . "\r \n    public function __construct() {"
                . "\n        parent::__construct();"
                . "\r \n        \$this->setTabela('" . $sTabela . "');";

        foreach ($aCampos as $skey) {
            if ($skey == $aCampos[0]) {
                $sTexto .= "\n        \$this->adicionaRelacionamento('" . strtolower($skey[0]) . "','" . strtolower($skey[0]) . "', true, true);";
            } else {
                $sTexto .= "\n        \$this->adicionaRelacionamento('" . strtolower($skey[0]) . "','" . strtolower($skey[0]) . "');";
            }
        }

        $sTexto .= "\r\n    } \n}";

        return $sTexto;
    }

    /**
     * Cria a estrutura texto da view
     * @param type $aCamposChave
     * @param type $aCampos
     * @return string
     */
    public function estruturaCriaView($aCamposChave, $aCampos) {

        $sNome = $aCamposChave['nomemvc'];
        //Verifica se não deve ter campos na view
        if ($aCamposChave['viewcamp']) {

            $sTexto = "<?php "
                    . "\r\n /*"
                    . "\n * Implementa a classe view " . $sNome
                    . "\n * @author " . $_SESSION['nome'] . ""
                    . "\n * @since " . date('d/m/Y') . ""
                    . "\n */"
                    . "\r \nclass View" . $sNome . " extends View {"
                    . "\r \n    public function __construct() {"
                    . "\n        parent::__construct();"
                    . "\n    }"
                    . "\r \n    public function criaConsulta() {"
                    . " \n        parent::criaConsulta();"
                    . "\r \n        \$this->setUsaAcaoVisualizar(true);"
                    . "\r \n    }"
                    . "\r \n    public function criaTela() {"
                    . " \n        parent::criaTela();"
                    . "\r \n"
                    . "\r\n    } \n}";
        } else {

            $sTexto = "<?php "
                    . "\r\n /*"
                    . "\n * Implementa a classe view " . $sNome
                    . "\n * @author " . $_SESSION['nome'] . ""
                    . "\n * @since " . date('d/m/Y') . ""
                    . "\n */"
                    . "\r \nclass View" . $sNome . " extends View {"
                    . "\r \n    public function __construct() {"
                    . "\n        parent::__construct();"
                    . "\n       }"
                    . "\r \n    public function criaConsulta() {"
                    . " \n        parent::criaConsulta();";
            $sTexto .= "\r \n        \$this->setUsaAcaoVisualizar(true);";
            $sTexto .= "\r \n";

            foreach ($aCampos as $skey) {
                if ($skey[1] == 'money') {
                    $sTexto .= "\n        \$o" . $skey[0] . " = new CampoConsulta('" . $skey[0] . "', '" . $skey[0] . "', CampoConsulta::TIPO_MONEY);";
                } else {
                    if ($skey[1] == 'date') {
                        $sTexto .= "\n        \$o" . $skey[0] . " = new CampoConsulta('" . $skey[0] . "', '" . $skey[0] . "', CampoConsulta::TIPO_DATA);";
                    } else {
                        if ($skey[1] == 'decimal') {
                            $sTexto .= "\n        \$o" . $skey[0] . " = new CampoConsulta('" . $skey[0] . "', '" . $skey[0] . "', CampoConsulta::TIPO_DECIMAL);";
                        } else {
                            $sTexto .= "\n        \$o" . $skey[0] . " = new CampoConsulta('" . $skey[0] . "', '" . $skey[0] . "', CampoConsulta::TIPO_TEXTO);";
                        }
                    }
                }
            }

            $sTexto .= "\r \n        \$this->addCampos(";
            foreach ($aCampos as $skey) {
                if ($skey == $aCampos[0]) {
                    $sTexto .= "\$o" . $skey[0];
                } else {
                    $sTexto .= ", \$o" . $skey[0];
                }
            }

            $sTexto .= ");\r\n    }";

            $sTexto .= "\r \n    public function criaTela() {"
                    . " \n        parent::criaTela();";
            $sTexto .= "\r \n";

            foreach ($aCampos as $skey) {
                if ($skey[1] == 'money') {
                    $sTexto .= "\n        \$o" . $skey[0] . " = new Campo('" . $skey[0] . "', '" . $skey[0] . "', Campo::TIPO_MONEY, 1, 1, 12, 12);";
                } else {
                    if ($skey[1] == 'date') {
                        $sTexto .= "\n        \$o" . $skey[0] . " = new Campo('" . $skey[0] . "', '" . $skey[0] . "', Campo::TIPO_DATA, 1, 1, 12, 12);";
                    } else {
                        if ($skey[1] == 'decimal') {
                            $sTexto .= "\n        \$o" . $skey[0] . " = new Campo('" . $skey[0] . "', '" . $skey[0] . "', Campo::TIPO_DECIMAL, 1, 1, 12, 12);";
                        } else {
                            $sTexto .= "\n        \$o" . $skey[0] . " = new Campo('" . $skey[0] . "', '" . $skey[0] . "', Campo::TIPO_TEXTO, 1, 1, 12, 12);";
                        }
                    }
                }
            }

            $sTexto .= "\r \n        \$this->addCampos(";
            foreach ($aCampos as $skey) {
                if ($skey == $aCampos[0]) {
                    $sTexto .= "\$o" . $skey[0];
                } else {
                    $sTexto .= ", \$o" . $skey[0];
                }
            }

            $sTexto .= ");";

            $sTexto .= "\r\n    } \n}";
        }

        return $sTexto;
    }

}
