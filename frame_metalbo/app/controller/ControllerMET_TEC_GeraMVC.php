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

        $bVerifClasseExiste = $this->verificaSeClasseExiste($sNomeMVC, $aCamposChave);
        if ($bVerifClasseExiste) {
            $oModal = new Modal('Atenção', 'Classe já existe, favor verificar nos diretórios!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }

        //Verifica se a tabela possui uma extenção específica tipo widl.emp01 e remove widl
        if (stristr($sNomeTabela, ".") != '') {
            $sNomeTabela = explode(".", $sNomeTabela)[1];
        }

        //Verifica se os campos em tela estão preenchidos
        if ($sNomeMVC != '' && $sNomeTabela != '') {

            $aMVC = explode('_', $sNomeMVC);

            if ($aMVC[0] == "MET" || $aMVC[0] == "STEEL") {
                
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

    public function verificaSeClasseExiste($sNomeMVC, $aCamposChave) {
        $sDir = 'C:\\wamp64/www/github/' . $aCamposChave['frame'] . '/app/controller/Controller' . $sNomeMVC . '.php';
        if (!file_exists($sDir)) {
            return false;
        } else {
            return true;
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
        $sView = $this->estruturaCriaView($aCamposChave['nomemvc'], $aCampos);

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

            $sTexto .= "\n    function set" . ucfirst(strtolower($skey[0])) . "($" .  strtolower($skey[0]) . "){";
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
     * @param type $sNome
     * @param type $aCampos
     * @return string
     */
    public function estruturaCriaView($sNome, $aCampos) {

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
                . " \n        parent::criaConsulta();"
                . "\r \n        \$this->setUsaAcaoVisualizar(true);"
                . "\r \n}"
                . "\r \n    public function criaTela() {"
                . " \n        parent::criaTela();"
                . "\r \n"
                . "\r\n    } \n}";

        return $sTexto;
    }

}
