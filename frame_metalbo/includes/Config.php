<?php

/**
 * Classe que contêm constantes com as configurações do sistema
 *
 * @author Fernando Salla
 * @since 10/12/2015
 */
class Config {

    //configurações da empresa
    const NOME_EMPRESA = '';
    const SLOGAN_EMPRESA = '';

    /*
     * configuração de diretórios
     */
    const PROJ_FOLDER = 'frame_avanei';
    const APP_FOLDER = 'app'; //sistemas
    const LIB_FOLDER = 'biblioteca'; //componentes
//    const EXTJS_FOLDER = '/ext-4.2.1.883'; //pasta da biblioteca extjs
    //const JASPER_FOLDER = '/PHPJasperXML'; //pasta da biblioteca de relatório JasperXML
    const MAIL_FOLDER = '/PHPMailer'; //pasta da biblioteca de envio de emails
    const REPORT_FOLDER = '/relatorio'; //pasta onde se encontram os modelos XML dos relatórios
    const ARQ_FOLDER = 'resources'; //arquivos do sistema
    const ARQ_FOLDER_CSS = '/css'; //estilos do sistema
    const ARQ_FOLDER_IMG = '/img'; //imagens do sistema
    const ARQ_FOLDER_JS = '/js'; //funções do sistema        
    const ARQ_FOLDER_TEMP = 'temp'; //arquivos temporários de upload
    const JASPER_FOLDER = '/PHPJasperXMLmet';

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
    const BD_MYSQL = 1;
    const BD_POSTGRESQL = 2;
    const BD_SQLITE = 3;
    const BD_FIREBIRD = 4;
    const BD_ORACLE = 5;
    const BD_SQLSERVER = 6;
    
    
    
    const TIPO_BD = self::BD_SQLSERVER;
    const PORTA_BD = 1433;
    const USER_BD = 'sa';
    const NOME_BD = 'rex_maquinas';
    const HOST_BD = 'Metalbobase';
    const PASS_BD = 'Met@lbo@4321';




    /*
      const TIPO_BD = self::BD_SQLSERVER;
      const PORTA_BD = 1433;
      const USER_BD = 'sa';
      const NOME_BD = 'rex_maquinas';
      const HOST_BD = 'rexdatabase';
      const PASS_BD = 'M@quinas@321';
     * 
     */



    /*
     * Configurações de nomes de elementos do sistema
     */
    const SISTEMA = 'containerSistema';
    const TOPOSISTEMA = 'containerTopo';
    const TABPANEL = 'containerTelas';
    const REGION_MENU = 'containerMenu';

}

?>