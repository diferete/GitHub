<?php
/**
 * Implementação do padrão de projeto Singleton para realizar 
 * a conexão com o banco de dados utilizado
 * 
 * @author Fernando Augusto Salla
 * @since 11/03/2012
 */
class Conexao {
    private static $instance;
    private static $instanceEspecifico;
    
    private static $INSTANCIAS = array();

    private function __construct(){}
    /* 
     * Se a conexão existir apenas retorna a sua instância, 
     * caso contrário cria a instância do objeto de conexão e
     * retorna o mesmo
     */ 
    public static function getConexao() {
        if (!isset(self::$instance)) {
            try{
                switch (Config::TIPO_BD){
                    case 1:
                        //mysql
                        self::$instance = new PDO("mysql:host=".Config::HOST_BD."; port=".Config::PORTA_BD."; dbname=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD,
							array(
								PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
								PDO::ATTR_PERSISTENT => false,
								PDO::ATTR_EMULATE_PREPARES => false,
								PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
							)
						);    
                        $statement = self::$instance->prepare("SET sql_mode = ANSI_QUOTES;");
                        $statement->execute();
						
                    break;
                    case 2:
                        //postgre
                        self::$instance = new PDO("pgsql:dbname=".Config::NOME_BD."; user=".Config::USER_BD."; password=".Config::PASS_BD."; host=".Config::HOST_BD."; port=".Config::PORTA_BD);    
                    break;
                    case 3:
                        //sqlite
                        self::$instance = new PDO("sqlite:host=".Config::HOST_BD);    
                    break;
                    case 4:
                        //firebird
                        self::$instance = new PDO("firebird:dbname=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);    
                    break;
                    case 5:
                        //oracle
                        self::$instance = new PDO("oci:dbname=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);    
                    break;
                    case 6:
                        //sql server
                        self::$instance = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
                       
                    break;
                }
                self::$instance->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
                
            } catch (PDOException $e) {
                print $e->getMessage();
            }
        }
        return self::$instance;
    }
    /**
     * Checa se existe config específico
     *  - se não retornar a própria instancia
     *  - se sim faz nova conexão e retorna
     * 
     * Utilizando quando existe a necessidade de conectar em base de dados
     * diferentes ou remotas
     * 
     * @param $iSeq integer Sequência do arquivo de conexão caso exista mais de 1 específico para o mesmo cliente
     */
    public static function getConexaoEspecifica($iSeq = null) {
        $sEmpresa = str_pad($_SESSION['empresa'],5,'0',STR_PAD_LEFT);
        $sSistema = str_pad($_SESSION['sistema'],3,'0',STR_PAD_LEFT);
        
        $sNomeArqConfig = 'Config_'.$sEmpresa.'_'.$sSistema;
        if($iSeq != null){
            $sNomeArqConfig .= "_".str_pad($iSeq,2,'0',STR_PAD_LEFT);
        }
        
        $oConfig = Fabrica::FabricarConfig($sNomeArqConfig);
        if($oConfig){
            $bExiste = false;
            $aInstancias = self::$INSTANCIAS;
            foreach($aInstancias as $instancia) {
                if($instancia['tipoBD'] === $oConfig::TIPO_BD && $instancia['host'] === $oConfig::HOST_BD &&
                   $instancia['porta'] === $oConfig::PORTA_BD && $instancia['db'] === $oConfig::NOME_BD &&
                   $instancia['user'] === $oConfig::USER_BD && $instancia['senha'] === $oConfig::PASS_BD){
                   $bExiste = true;
                   self::$instanceEspecifico = $instancia['instancia'];
                }
            }
            
            if (!$bExiste){
                try{
                    switch ($oConfig::TIPO_BD){
                        case 1:
                            //mysql
                            self::$instanceEspecifico = new PDO("mysql:host=".$oConfig::HOST_BD."; port=".$oConfig::PORTA_BD."; dbname=".$oConfig::NOME_BD, $oConfig::USER_BD, $oConfig::PASS_BD);    
                            $statement = self::$instanceEspecifico->prepare("SET sql_mode = ANSI_QUOTES;");
                            $statement->execute();
                        break;
                        case 2:
                            //postgre
                            self::$instanceEspecifico = new PDO("pgsql:dbname=".$oConfig::NOME_BD."; user=".$oConfig::USER_BD."; password=".$oConfig::PASS_BD."; host=".$oConfig::HOST_BD."; port=".$oConfig::PORTA_BD);    
                        break;
                        case 3:
                            //sqlite
                            self::$instanceEspecifico = new PDO("sqlite:host=".$oConfig::HOST_BD);    
                        break;
                        case 4:
                            //firebird
                            self::$instanceEspecifico = new PDO("firebird:dbname=".$oConfig::NOME_BD, $oConfig::USER_BD, $oConfig::PASS_BD);    
                        break;
                        case 5:
                            //oracle
                            self::$instanceEspecifico = new PDO("oci:dbname=".$oConfig::NOME_BD, $oConfig::USER_BD, $oConfig::PASS_BD);    
                        break;
                        case 6:
                            //sql server
                            self::$instanceEspecifico = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
                        break;
                    alert($instanceEspecifico);
                    }
                    self::$instanceEspecifico->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
                } catch (PDOException $e) {
                    print $e->getMessage();
                }
                self::$INSTANCIAS[] = array('tipoBD'    => $oConfig::TIPO_BD,
                                            'host'      => $oConfig::HOST_BD,
                                            'porta'     => $oConfig::PORTA_BD,
                                            'db'        => $oConfig::NOME_BD,
                                            'user'      => $oConfig::USER_BD,
                                            'senha'     => $oConfig::PASS_BD,
                                            'instancia' => self::$instanceEspecifico);                
            }
            return self::$instanceEspecifico;
        } else {
            return self::$instance;        
        }
    }
}
?>