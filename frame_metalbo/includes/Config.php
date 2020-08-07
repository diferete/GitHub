<?php

/**
 * Classe que contêm constantes com as configurações do sistema
 *
 * @author Fernando Salla
 * @since 10/12/2015
 */
class Config {
    //configurações da empresa
    const NOME_EMPRESA = 'Matos Construtora';
    const SLOGAN_EMPRESA = 'Construindo para o futuro!';
    
    /*
     * configuração de diretórios
     */
        
    const PROJ_FOLDER = 'frame_avanei';
    const APP_FOLDER = 'app'; //sistemas
    const LIB_FOLDER = 'biblioteca'; //componentes
    const EXTJS_FOLDER = '/ext-4.2.1.883'; //pasta da biblioteca extjs
    //const JASPER_FOLDER = '/PHPJasperXML'; //pasta da biblioteca de relatório JasperXML
    const MAIL_FOLDER = '/PHPMailer'; //pasta da biblioteca de envio de emails
    const REPORT_FOLDER = '/relatorio'; //pasta onde se encontram os modelos XML dos relatórios
    const ARQ_FOLDER = 'resources'; //arquivos do sistema
    const ARQ_FOLDER_CSS = '/css'; //estilos do sistema
    const ARQ_FOLDER_IMG = '/img'; //imagens do sistema
    const ARQ_FOLDER_JS = '/js'; //funções do sistema        
    const ARQ_FOLDER_TEMP = 'temp'; //arquivos temporários de upload
    const JASPER_FOLDER = '/PHPJasperXMLmet';
    const EMAIL_SENDER = 'metalboweb@gmail.com';
    const PASWRD_EMAIL_SENDER = '3BS0deAgtLu4';
    const SERVER_SMTP = 'smtp.gmail.com';
    const PORT_SMTP = 465;
    const PROTOCOLO_SMTP = 'ssl';
	
    /*
     * Configurações da conexão com o banco de dados
     */

    /*
     * Tipo de banco de dados
     * 1 ==> Mysql
     * 2 ==> PostgreSQL
     * 3 ==> SQLite
     * 4 ==> Firebird
     * 5 ==> Oracle
     * 6 ==> SQL Server
     */
    const BD_MYSQL      = 1;
    const BD_POSTGRESQL = 2;
    const BD_SQLITE     = 3;
    const BD_FIREBIRD   = 4;
    const BD_ORACLE     = 5;
    const BD_SQLSERVER  = 6;
    
   

    
//    
//    const TIPO_BD = self::BD_MYSQL;
//
//    const PORTA_BD = 3306;
//    const USER_BD  = 'root';
//    const NOME_BD  = 'frame_metalbo';
//    const HOST_BD  = 'localhost';
//    const PASS_BD  = 'M@quinas@4321';
//    
    
    
    
    const TIPO_BD = self::BD_SQLSERVER;

  /*  const PORTA_BD = 1433;
    const USER_BD  = 'sa';
    const NOME_BD  = 'rex_maquinas';
    const HOST_BD  = 'metalboweb';
    const PASS_BD  = 'M@quinas@321';*/
   
 /*   const PORTA_BD = 1433;
    const USER_BD  = 'sa';
    const NOME_BD  = 'rex_maquinas';
    const HOST_BD  = 'localhost';
    const PASS_BD  = 'P@lmeiras'; */
////    
//    const PORTA_BD = 1433;
//    const USER_BD  = 'sa';
//    const NOME_BD  = 'rex_maquinas';
//    const HOST_BD  = 'metalbobase';
//    const PASS_BD  = 'Met@lbo@4321'; 
//	
    const PORTA_BD = 1433;
    const USER_BD = 'sa';
    const NOME_BD = 'rex_maquinas';
    const HOST_BD = 'MetalboServer';
    const PASS_BD = 'M@quinas@321';
 
  /*  const PORTA_BD = 1433;
    const USER_BD  = 'sa';
    const NOME_BD  = 'rex_metalbo';
    const HOST_BD  = '192.168.0.1';
    const PASS_BD  = 'M@quinas';*/
   
 /*   const TIPO_BD = self::BD_MYSQL;
    const PORTA_BD = 3306;
    const USER_BD  = 'root';
    const NOME_BD  = 'frame_metalbo';
    const HOST_BD  = 'localhost';
    const PASS_BD  = 'M@quinas@4321';
     
    
  /*  const TIPO_BD = self::BD_MYSQL;

    const PORTA_BD = 3306;
    const USER_BD  = 'root';
    const NOME_BD  = 'painel_controle';
    const HOST_BD  = 'localhost';
    const PASS_BD  = 'M@quinas';*/
    
    
    
    /*
     * Configurações de nomes de elementos do sistema
     */
    const SISTEMA       = 'containerSistema';
    const TOPOSISTEMA   = 'containerTopo';
    const TABPANEL      = 'containerTelas';
    const REGION_MENU   = 'containerMenu';
}
?>