<?php

/**
 * Classe estática que implementa funções comuns entre as classes
 * da biblioteca visual
 *
 * @author Avanei Martendal
 * @since 01/12/2015
 */
class Base{
/**
 * Formatações de data
 *
 * Valores possíveis
 * d = dia (2 caracteres)
 * m = mês (2 caracteres)
 * Y = ano (4 caracteres)
 * y = ano (2 caracteres)
 * H = hora (24 horas)
 * h = hora (AM/PM)
 * i = minuto (2 caracteres)
 * s = segundo (2 caracteres)
 * u = milisegundo (3 caracteres)
 */
const DD_MM_AAAA = 'd/m/Y';
const DD_MM_AA = 'd/m/y';
const AAAA_MM_DD = 'Y/m/d';
const AAAA = 'Y';
const AA = 'Y';
const DD_MM = 'd/m';
const DD = 'd';
const MM_AA = 'm/a';
const MM = 'm';
const H_M_S_ML = 'H:i:s.u';
const H_M_S = 'H:i:s';
const H_M = 'H:i';
const H = 'H';
const FORMATO_DATA_BD = 'Y-m-d';

//constantes para ícones

const ICON_CONFIRMAR = 'icon wb-check';
const ICON_FECHAR = 'icon wb-close';
const ICON_IMPRESSORA = 'icon wb-print';
const ICON_PESQUISAR = 'icon wb-search';
const ICON_DELETAR = 'icon wb-trash';

const ICON_EDITAR = 'icon wb-edit';
const ICON_LAPIS = 'icon wb-pencil';
const ICON_BORRACHA = 'icon wb-rubber';
const ICON_DOWNLOAD = 'icon wb-download';
const ICON_UPLOAD = 'icon wb-upload';
const ICON_IMAGEM = 'icon wb-image';
const ICON_VIDEO = 'icon wb-video';
const ICON_GALERIA = 'icon wb-gallery';
const ICON_CAMERA = 'icon wb-camera';

const ICON_AVISO = 'icon wb-warning';
const ICON_ALERTA = 'icon wb-alert';
const ICON_AJUDA = 'icon wb-help';
const ICON_INFO = 'icon wb-info';

const ICON_BLOQUEADO = 'icon wb-lock';
const ICON_DESBLOQUEADO = 'icon wb-unlock';
const ICON_RECARREGAR = 'icon wb-reload';
const ICON_CONFIG = 'icon wb-settings';
const ICON_RELOGIO = 'icon wb-time';
const ICON_CALENDARIO = 'icon wb-calendar';

const ICON_ADD_ARQUIVO = 'icon wb-file-add';
const ICON_FILE = 'icon wb-file';
const ICON_PASTA = 'icon wb-folder';
const ICON_COPIAR = 'icon wb-copy';

const ICON_MARTELO = 'icon wb-hammer';
const ICON_CHAVE = 'icon wb-wrench';
const ICON_TESOURA = 'icon wb-scissor';
const ICON_LOOP = 'icon wb-loop';
const ICON_EMAIL = 'icon wb-envelope';
const ICON_EXCEL = 'icon fa-file-excel-o';

const ICON_BOX = 'icon wb-grid-4';
const ICON_CART ='icon wb-shopping-cart';
const ICON_QUAL ='icon wb-book';

const ICON_ARROW_UP = 'icon wb-arrow-up';
const ICON_ARROW_DOWN = 'icon wb-arrow-down';


/**
 * Gera um hash único baseado na hora atual que servirá de
 * identificador para os objetos
 * 
 * @return string
 * 
 * @author Fernando Salla
 * @since 09/05/2012     
 */
public static function getId(){
return "style".uniqid(rand());
}

/**
 * Gera a string do objeto para ser renderizado a partir do
 * vetor recebido com suas propriedades e valores
 * 
 * @param type $aRender
 * @return string 
 */
public static function getRender($aRender){

}

/**
 * Gera a função para limpar os campos de um form
 * 
 */
public function limpaFormDetail($sId){
$sLimpa = "$('#".$sId."').each (function(){ this.reset();});";
return $sLimpa;
}
/**
 * Gera a função para limpar os campos de um form
 * 
 */
public function limpaForm($sId){
$sLimpa = "$('#".$sId."-form').each (function(){ this.reset();});";
return $sLimpa;
}
/**
 * Gera a função para fechar um form
 * 
 */
public function fechaForm($sId){
$sFecha = '$("#'.$sId.'").remove();';
return $sFecha;
}
/**
 * retorna grid
 * 
 */
public function openGrid($sGrid){
$sGrid = '$("#'.$sGrid.'").toggle();';
return $sGrid;
}
/**
 * função para mudar etapa
 */
public function nextEtapa($sEtapa, $sProcesso){

$sEtapa = '$( "#'.$sEtapa.' > #'.$sProcesso.'" ).addClass( "current" );';
return $sEtapa;
}
/**
 * função para retornar etapa
 */
public function backupEtapa($sEtapa, $sProcesso){
$sEtapa = '$( "#'.$sEtapa.' > #'.$sProcesso.'" ).removeClass( "current" );';
return $sEtapa;
}
/**
 * função que da um hide no form
 */
public function formhide($sIdForm){
$sForm = '$("#'.$sIdForm.'").toggle();';
return $sForm;
}
/**
 * 
 */
public function focus($sIdCampo){
$sFocus = '$("#'.$sIdCampo.'").focus();';
return $sFocus;
}
/**
 * 
 */
public function sendFiltro($sId, $sController){
$sFiltro = 'sendFiltros("#'.$sId.'-filtros","'.$sController.'","'.$sId.'");';
return $sFiltro;
}

/**
 * Método que retornará true, caso a string passada como parâmetro é do tipo da extensão desejada
 * 
 * @param string $Arquivo
 * @param string $Extensão
 */
public function isType($Arquivo){
$aArquivo = explode('.', $Arquivo); //Explode arquivo, após o ponto obrigatoriamente será a extensao
$Extensao = $aArquivo[1];


switch ($Extensao){
case 'png':


break;

case 'jpg':

break;
}

}
/**
 * Método que será responsponsável em gerar tokens aleatórios para aplicação mobile
 * 
 * @param int $tamanho Informatar tamanho do token a ser gerado
 * @return string Retorno do Token
 */
public function geraToken($tamanho = 25){
//String com valor possíveis do resultado, os caracteres pode ser adicionado ou retirados conforme sua necessidade
$basic = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

$return = "";

for($count = 0;
$tamanho > $count;
$count++){
//Gera um caracter aleatorio
$return .= $basic[rand(0, strlen($basic) - 1)];
}

return $return;
}

/**
 * Método que será responsponsável em gerar tokens númericos aleatórios para aplicação mobile
 * 
 * @param int $tamanho Informatar tamanho do token a ser gerado
 * @return string Retorno do Token
 */
public function geraTokenNumerico($tamanho = 25){
//String com valor possíveis do resultado, os caracteres pode ser adicionado ou retirados conforme sua necessidade
$basic = '0123456789';

$return = "";

for($count = 0;
$tamanho > $count;
$count++){
//Gera um caracter aleatorio
$return .= $basic[rand(0, strlen($basic) - 1)];
}

return $return;
}

}


