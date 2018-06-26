<?php
/**
 * Classe responsável por criar instâncias de objetos 
 * conforme parâmetros passados
 * 
 * @author Everton Porath 
 * @since 01/07/2011
 */

 class Fabrica{

     /**
      * Método que realiza a fabricação de instâncias de objetos conforme os
      * parâmetros passados
      * 
      * @param string $sDiretorio
      * @param string $sClasse
      * @return object Instância de objeto da classe desejada
      */
     public static function Fabricar($sDiretorio,$sClasse){
        $bReturn = self::getRequireFile($sDiretorio,$sClasse);
        
        if($bReturn){
            $oInstancia = new $sClasse(); 		 
            return $oInstancia;
        }
        return $bReturn;
    }
    
    /**
     * Método base que centraliza a inclusão das classes na framework
     * 
     * @param string $sDiretorio Subdiretório que contêm a classe
     * @param string $sClasse Nome da classe
     */
    private static function getRequireFile($sDiretorio,$sClasse){
        $sPath = str_replace("\\","/",dirname(__FILE__));
        
        $sEndArquivo = $sPath.'/../'.$sDiretorio.'/'.$sClasse.'.php';
        
        $bReturn = true;
        if(file_exists($sEndArquivo)){
            require_once($sEndArquivo);
        } else{
            $bReturn = false;
        }
        
        return $bReturn;
    }
    
    /**
     * Método que realiza a inclusão das classes da biblioteca de objetos 
     * de interface da framework
     * 
     * @param string $sClasse Classe a ser requisitada
     */
    public static function requireBibliotecaVisual($sClasse){
        self::getRequireFile(Config::LIB_FOLDER.'/visual',$sClasse);
    }
    
    /**
     * Método que realiza a inclusão das classes da biblioteca de relatórios
     * 
     * @param string $sClasse Classe a ser requisitada
     */
    public static function requireBibliotecaReport($sClasse){
        self::getRequireFile(Config::LIB_FOLDER.Config::JASPER_FOLDER.'/class',$sClasse);
    }
    
    /**
     * Método que realiza a inclusão das classes da biblioteca de emails
     * 
     * @param string $sClasse Classe a ser requisitada
     */
    public static function requireBibliotecaEmail($sClasse){
        self::getRequireFile(Config::LIB_FOLDER.Config::MAIL_FOLDER,$sClasse);
    }
    
    /**
     * Método que realiza a inclusão das classes da biblioteca de objetos
     * de persistência da framework
     * 
     * @param string $sClasse Classe a ser requisitada
     */    
    public static function requireBibliotecaPersistencia($sClasse){
        self::getRequireFile(Config::LIB_FOLDER.'/persistencia',$sClasse);
    } 
    
    /**
     * Método que realiza a inclusão e criação das classes controladoras 
     * de sistemas/módulos
     * 
     * Retorna o objetos requisitado
     * 
     * @param string $sClasse Nome da classe de controle
     * @return object
     */
    public static function FabricarController($sClasse){
        return self::Fabricar(Config::APP_FOLDER.'/controller','Controller'.$sClasse);
    }

    /**
     * Método que realiza a inclusão e criação das classes de modelo 
     * de sistemas/módulos
     * 
     * Retorna o objetos requisitado
     * 
     * @param string $sClasse Nome da classe de modelo
     * @return object
     */    
    public static function FabricarModel($sClasse){
         return self::Fabricar(Config::APP_FOLDER.'/model','Model'.$sClasse);
    }

    /**
     * Método que realiza a inclusão e criação do config específico por cliente
     * de sistemas/módulos
     * 
     * Retorna o objetos requisitado
     * 
     * @param string $sClasse Nome da classe de modelo
     * @return object
     */    
    public static function FabricarConfig($sClasse){
         return self::Fabricar('includes',$sClasse);
    }
    
    /**
     * Método que realiza a inclusão e criação das classes de interface 
     * de sistemas/módulos
     * 
     * Retorna o objetos requisitado
     * 
     * @param string $sClasse Nome da classe de interface
     * @return object
     */   
    public static function FabricarView($sClasse){
         return self::Fabricar(Config::APP_FOLDER.'/view','View'.$sClasse);
    }

    /**
     * Método que realiza a inclusão e criação das classes de persistência 
     * de sistemas/módulos
     * 
     * Retorna o objetos requisitado
     * 
     * @param string $sClasse Nome da classe de persistência
     * @return object
     */       
    public static function FabricarPersistencia($sClasse){
         return self::Fabricar(Config::APP_FOLDER.'/persistencia','Persistencia'.$sClasse);
    }
    
    public static function FabricarPersistenciaEstatica($sClasse){
         $sDiretorio = Config::APP_FOLDER.'/persistencia';
         $sClasse = 'Persistencia'.$sClasse;
         $bReturn = self::getRequireFile($sDiretorio,$sClasse);        
         return $sClasse;
    }
    
    /**
     * Monta a string para que seja possível executar o método setter 
     * do atributo passado
     * 
     * @param string $sCampoModel
     * @return string String contendo o nome do método a ser chamado
     */
    public static function montaSetter($sCampoModel){
        return 'set'.self::montaStringGetterSetter($sCampoModel);
    }

    /**
     * Monta a string para que seja possível executar o método getter 
     * do atributo passado
     * 
     * @param string $sCampoModel
     * @return string String contendo o nome do método a ser chamado
     */    
    public static function montaGetter($sCampoModel){
        return 'get'.self::montaStringGetterSetter($sCampoModel);
    }
    
    /**
     * Converte a primeira letra referente ao nome do model para maiúscula
     * para que fique de acordo com a nomeclatura dos métodos e possa ser
     * realizada a chamada de maneira adequada
     * 
     * @param string $sCampoModel
     * @return string String convertida contendo a primeira letra em maiúsculo 
     */
    private static function montaStringGetterSetter($sCampoModel){
        return ucwords($sCampoModel);
    }
}
?>