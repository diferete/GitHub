<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_TEC_Mobile extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_Mobile');
    }

    /**
     * 
     * @return type
     */
    function getCamposMobile() {
        $data = file_get_contents("php://input");
        $oMobileCampos = json_decode($data);

        return $oMobileCampos;
    }

    /**
     * 
     * @param type $str
     * @return type
     */
    public function limpaString($str) {
        $Str1 = stripslashes($str);
        $sRetorno = trim($Str1);

        return $sRetorno;
    }

    public function autenticaToken($UsuCodigo, $UsuToken) {
        $oControllerLogin = Fabrica::FabricarController('MET_TEC_Login');
        $token = $oControllerLogin->validaToken($UsuCodigo, $UsuToken);

        if ($token['VALIDO']) {
            $aRetorno['VALIDO'] = true;
            $aRetorno['DADOS'] = $oControllerLogin->atualizaToken($UsuCodigo);
        } else {
            $aRetorno['VALIDO'] = FALSE;
        }

        return $aRetorno;
    }

    public function validaToken($UsuCodigo, $UsuToken) {
        $oControllerLogin = Fabrica::FabricarController('MET_TEC_Login');
        $token = $oControllerLogin->validaToken($UsuCodigo, $UsuToken);

        if ($token['VALIDO']) {
            $aRetorno['VALIDO'] = true;
        } else {
            $aRetorno['VALIDO'] = FALSE;
        }

        return $aRetorno;
    }

    /**
     * Método para testar
     */
    public function testeHttp() {
        $aCampos = $this->getCamposMobile();

        echo json_encode($aCampos);
    }

    /**
     * A Mágica ocorre aqui!
     */
    public function getRequisicao() {
        $aCampos = $this->getCamposMobile();

        $CampoUsuToken = $aCampos->usutoken;
        $CampoUsuCod = $aCampos->usucodigo;


        $Classe = $aCampos->classe;
        $Metodo = $aCampos->metodo;
        $Dados = $aCampos->dados;

        //verifica se o foi informado o código do usuário e um token
        if (empty($CampoUsuCod) || empty($CampoUsuToken)) {
            //se for login deixa entar na condição abaixo, mesmo que token e codigo do usuario estejam em branco
            if ($Classe == 'MET_TEC_Login' && $Metodo == 'validaMobLogin') {

                //pega login e senha digitado pelo usuário
                $CampoLogin = $Dados->usuario;
                $CampoSenha = $Dados->senha;



                //$CampoLogin = 'carlos@metalbo.com.br';
                //$CampoSenha = 'dsl2640t';

                $oClasseLogin = Fabrica::FabricarController('MET_TEC_Login');
                $aRetornoLogin = $oClasseLogin->validaMobLogin($CampoLogin, $CampoSenha);

                //verifica se login é válido
                if ($aRetornoLogin['LOGIN']) {
                    $aToken = $oClasseLogin->atualizaToken($aRetornoLogin['DADOS']->usucodigo);

                    //verifica se foi possível gerar um novo token
                    if ($aToken['SUCESSO']) {
                        // $ControllerMobUsuModulos = Fabrica::FabricarController('MobUsuModulos');
                        //  $aModulos = $ControllerMobUsuModulos->getModulos($aRetornoLogin['DADOS']->usucodigo);

                        $aRetorno['SUCESSO'] = TRUE;
                        $aRetorno['bTOKEN'] = TRUE;
                        $aRetorno['TOKEN'] = $aToken['TOKEN'];
                        $aRetorno['DADOS'] = $aRetornoLogin['DADOS'];
                        // $aRetorno['MODULOS'] = $aModulos;
                        //erro ao gerar token    
                    } else {
                        //limpa array de retorna apenas como preucação
                        $aRetorno = NULL;
                        //login true, porém o token não foi atualizado e deve-se tentar fazer login novamente
                        $aRetorno['bTOKEN'] = FALSE;
                        //devido ao erro ao gerar token retorna false
                        $aRetorno['SUCESSO'] = FALSE;
                        $aRetorno['ERRO'] = 'Falha ao gerar um novo token';
                    }
                    //login inválido    
                } else {
                    //retorna como false pois o login foi invalidado
                    $aRetorno['bTOKEN'] = FALSE;
                    //retorna como false pois o login foi invalidado
                    $aRetorno['SUCESSO'] = FALSE;
                    $aRetorno['ERRO'] = 'Acesso Negado: Usuário e Senha não compatíveis!';
                }
                //se não for o método de login da classe Login não, entra na condição abaixo, pois não foi informado um token ou o código de usuário     
            } else {
                /*   if($Classe == 'User' && ($Metodo == 'recuperaSenha' || $Metodo == 'verficaCodigoRedefinicaoSenha' || $Metodo == 'alteraSenhaUsuarioIdRecuperacaoSenha')){
                  $oClasseUsuario = Fabrica::FabricarController('User');
                  $aRetorno['DADOS'] = $oClasseUsuario->$Metodo($Dados);
                  $aRetorno['SUCESSO'] = true;
                  }else{
                  //limpa array de retorna apenas como preucação
                  $aRetorno = NULL;
                  $aRetorno['SUCESSO'] = true;
                  $aRetorno['bTOKEN'] = FALSE;
                  $aRetorno['ERRO'] = 'Acesso Negado: Token desconhecido!';
                  } */
            }
            //se o token ou o código do usuário forem informado      
        } else {
            //fabrica classe login, para verificação de token antes da requisição dos dados
            $oControllerLogin = Fabrica::FabricarController('MET_TEC_Login');

            if ($Classe == 'MET_TEC_Mobile' && ($Metodo == 'validaToken' || $Metodo == 'autenticaToken')) {
                if ($Metodo == 'validaToken') {
                    $UsuCodigo = $Dados->usucodigo;
                    $UsuToken = $Dados->usutoken;
                    $aToken = $this->validaToken($UsuCodigo, $UsuToken);

                    if ($aToken['VALIDO']) {
                        $aDados = $aToken['DADOS'];
                        $aRetorno['SUCESSO'] = true;
//                        $aRetorno['TOKEN'] =    $aDados['TOKEN'];
                        $aRetorno['bTOKEN'] = true;
                    } else {
                        $aRetorno['SUCESSO'] = false;
                        $aRetorno['bTOKEN'] = false;
                        $aRetorno['ERRO'] = 'Token Inválido';
                    }
                }

                if ($Metodo == 'autenticaToken') {

                    //                $aRetorno = array('SUCESSO' => TRUE, 'MSG' => 'CHEGOU NESSA PORRA CARAI');
                    $UsuCodigo = $Dados->usucodigo;
                    $UsuToken = $Dados->usutoken;
                    $aToken = $this->autenticaToken($UsuCodigo, $UsuToken);

                    if ($aToken['VALIDO']) {
                        $aDados = $aToken['DADOS'];
                        $aRetorno['SUCESSO'] = true;
                        $aRetorno['TOKEN'] = $aDados['TOKEN'];
                        $aRetorno['bTOKEN'] = true;
                    } else {
                        $aRetorno['SUCESSO'] = false;
                        $aRetorno['bTOKEN'] = false;
                        $aRetorno['ERRO'] = 'TOKEN INVÁLIDO';
                    }
                }
            } else {
                //valida token com código do usuário e token
                $aToken = $oControllerLogin->validaToken($CampoUsuCod, $CampoUsuToken);
                if ($aToken['VALIDO']) {

                    //se a classe ou método, para serem executadas, não terem sido passados retorna erro
                    if (empty($Classe) || empty($Metodo)) {

                        $aRetorno['SUCESSO'] = FALSE;
                        $aRetorno['bTOKEN'] = TRUE;
                        $aRetorno['ERRO'] = 'É necessário ter uma classe e um método';

                        //caso foi informado uma classe entra abaixo    
                    } else {

                        if ($Classe == 'MET_TEC_Mobile') {
                            $oClasse = $this;
                        } else {
                            //fabrica classe passada através da aplicação
                            $oClasse = Fabrica::FabricarController($Classe);
                        }


                        //verifica se o método passado pela aplicação é existente na classe também passada pela aplicação
                        if (method_exists($oClasse, $Metodo)) {
                            //carrega código do usuário na sessão
                            $_SESSION['codUser'] = $CampoUsuCod;
                            //logo, se o método existir na classe, é executado e retorna seus respectivos dads dentro do indice "DADOS" o array $aRetorno
                            $aRetorno['DADOS'] = $oClasse->$Metodo($Dados);
                            //retorna esta classe para identificar que não ocorreu algum erro durante o percurso de dados
                            $aRetorno['SUCESSO'] = TRUE;
                            //retorna que o token passado é válido
                            $aRetorno['bTOKEN'] = TRUE;
                            //retorna indice "ERRO" null, pois obviamente, se chegou aqui é por que não ocorreu algum erro
                            $aRetorno['ERRO'] = NULL;
                        } else {
                            //retorna o indice "SUCESSO" como false, pois o método não existe dentro da classe invocada através da aplicação
                            $aRetorno['SUCESSO'] = FALSE;
                            //retorna o "bTOKEN" como true, pois o token é valido, porém ocorreu algum outro problema que fez a aplicação não retornar os dados
                            $aRetorno['bTOKEN'] = TRUE;
                            //apenas retorna uma breve descrição dos erros da aplicação
                            $aRetorno['ERRO'] = 'Método não encontrado!';
                        }
                    }
                } else {
                    //retorna false pois o token não é valido
                    $aRetorno['bTOKEN'] = FALSE;
                    //retona false pois o token passado não é valido, e por isto a aplicação não deve prosseguir, e também deve ser apagados os dados do localStorage do aparelho
                    $aRetorno['SUCESSO'] = FALSE;
                    //retorna breve string apenas á caráter de log
                    $aRetorno['ERRO'] = 'Acesso Negado: Token inválido!';
                }
            }
        }

        echo json_encode($aRetorno); //tudo deve retornar através disso :)
    }

    /**
     * Retorna o Menu de um aplicativo
     */
    public function getMenu($Dados) {
        $aRetorno = array();
        $aRetDados = array();
        $oMod = Fabrica::FabricarController('MET_TEC_ModUsuario');
        $aModulo = $oMod->modSistemaApp();

        $oMenu = Fabrica::FabricarController('MET_TEC_Menu');
        $aMenu = $oMenu->getMenuApp($aModulo[1]);

        $oItemMenu = Fabrica::FabricarController('MET_TEC_ItemMenu');
        foreach ($aMenu as $key => $aMenuSup) {
            $aSub = $oItemMenu->getItemMenuApp($aModulo[1], $aMenuSup[1]);
            foreach ($aSub as $key => $aValue) {
                $aRetorno[$aMenuSup[0]][$key]['title'] = $aValue['itedescricao'];
                $aRetorno[$aMenuSup[0]][$key]['url'] = $aValue['url'];
                $aRetorno[$aMenuSup[0]][$key]['ionicIcon'] = $aValue['iconApp'];
            }
        }
        return $aRetorno;
    }

}
