<?php

/**
 * Classe que implementa a estrutura para envio de emails
 *
 * @author Fernando Salla
 * @since 30/05/2014
 */
Fabrica::requireBibliotecaEmail("class.phpmailer");

class Email {

    private $oPHPMailer;

    const CODIFICACAO_BASE64 = 'base64';
    const CODIFICACAO_7BIT = '7bit';
    const CODIFICACAO_8BIT = '8bit';
    const CODIFICACAO_BINARY = 'binary';
    const CODIFICACAO_QUOTED = 'quoted-printable';
    
    const PROTOCOLO_SSL = 'ssl';
    const PROTOCOLO_TLS = 'tls';

    /**
     * Construtor da classe 
     */
    function __construct() {
        $this->oPHPMailer = new PHPMailer();
        $this->oPHPMailer->setLanguage("br");
        
        $this->setServidor();
        $this->setPorta();
    }

    /**
     * Retorna o conteúdo do atributo oPHPMailer
     * 
     * @return object
     */
    public function getPHPMailer() {
        return $this->oPHPMailer;
    }
    /**
     * 
     */
    
    public function setMailer(){
        $this->getPHPMailer()->Mailer = 'smtp';
        return $this;
    }

    /**
     * Refere-se ao endereço do servidor que fará o envio do email, por
     * padrão usa localhost
     * 
     * @param string $sServidor 
     */
    public function setServidor($sServidor = 'localhost') {
        $this->getPHPMailer()->Host = $sServidor;
        return $this;
    }

    /**
     * Porta que será utilizada no servidor para o envio do email, por
     * padrão utiliza a porta 25
     * 
     * @param integer $iPorta 
     */
    public function setPorta($iPorta = 25) {
        $this->getPHPMailer()->Port = $iPorta;
        return $this;
    }

    /**
     * Indica se o envio será via protocolo SMTP
     */
    public function setEnvioSMTP() {
        $this->getPHPMailer()->isSMTP();
        return $this;
    }
    
    /**
     * Indica o tipo de envio quando for SMTP, podendo ser SSL ou TLS
     * @param string $sSMTPSecure
     */
    public function setProtocoloSMTP($sSMTPSecure) {
        $this->getPHPMailer()->SMTPSecure = $sSMTPSecure;        
        return $this;
    }
    
    /**
     * Indica se o envio será autenticado (com usuário e senha)
     * @param boolean $bAuthenticate
     */
    public function setAutentica($bAuthenticate) {
        $this->getPHPMailer()->SMTPAuth = $bAuthenticate;
        return $this;
    }
    
    /**
     * Indica o usuário do email para autenticação
     * @param string $sUsuario
     */
    public function setUsuario($sUsuario) {
        $this->getPHPMailer()->Username = $sUsuario;
        return $this;
    }
    
    /**
     * Indica o usuário do email para autenticação
     * @param string $sSenha
     */
    public function setSenha($sSenha) {
        $this->getPHPMailer()->Password = $sSenha;
        return $this;
    }
    
    /**
     * Indica o asunto do email
     * 
     * @param string $sAssunto 
     */
    public function setAssunto($sAssunto) {
        $this->getPHPMailer()->Subject = $sAssunto;
        return $this;
    }

    /**
     * Indica o conteúdo (corpo) do email
     * 
     * @param string $sMensagem 
     */
    public function setMensagem($sMensagem) {
        $this->getPHPMailer()->MsgHTML($sMensagem);
        return $this;
    }

    /**
     * Define o valor do atributo sNomeRemetente
     * Indica o nome do remetente do email
     * 
     * @param string $sNomeRemetente 
     */
    public function setRemetente($sEmail, $sNome = "", $sResponder = "") {
        $this->getPHPMailer()->setFrom($sEmail, $sNome);
        if ($sResponder != "") {
            $this->getPHPMailer()->addReplyTo($sResponder, '');
        } else {
            $this->getPHPMailer()->addReplyTo($sEmail, $sNome);
        }
        return $this;
    }
    /**
     * Se preenchido solicita confirmação do recebimento do email
     * @param type $sEmail Email do remetente
     */
    public function setConfirmacao($sEmail) {
        $this->getPHPMailer()->ConfirmReadingTo = $sEmail;
    }

    /**
     * Adiciona destinatários a lista de emails
     * 
     * @param string $sEmail 
     * @param string $sNome 
     */
    public function addDestinatario($sEmail, $sNome = "") {
        $this->getPHPMailer()->addAddress($sEmail, $sNome);
        return $this;
    }

    /**
     * Adiciona destinatários que receberão o email como cópia
     * 
     * @param string $sEmail 
     * @param string $sNome 
     */
    public function addDestinatarioCopia($sEmail, $sNome = "") {
        $this->getPHPMailer()->addCC($sEmail, $sNome);
        return $this;
    }

    /**
     * Adiciona destinatários que receberão o email como cópia oculta
     * 
     * @param string $sEmail 
     * @param string $sNome 
     */
    public function addDestinatarioCopiaOculta($sEmail, $sNome = "") {
        $this->getPHPMailer()->addBCC($sEmail, $sNome);
        return $this;
    }

    /**
     * Adiciona anexos ao email
     * 
     * @param string $sCaminhoArquivo Caminho do arquivo a ser anexado
     * @param string $sNome Nome a ser exibido
     */
    public function addAnexo($sCaminhoArquivo, $sNome = "") {
        $this->getPHPMailer()->AddAttachment($sCaminhoArquivo, $sNome);
    }

    /**
     * Adiciona anexos de URL externa ao email
     * 
     * @param string $sBinarioArquivo String contendo o arquivo em binário
     * @param string $sNome Nome a ser exibido
     * @param string $sCodificacao Codificação da string do arquivo
     * @param string $sTipo Mime-type do arquivo
     */
    public function addAnexoExterno($sBinarioArquivo, $sNome = "", $sCodificacao = self::CODIFICACAO_BASE64, $sTipo = "") {
        $this->getPHPMailer()->AddStringAttachment($sBinarioArquivo, $sNome, $sCodificacao, $sTipo);
    }

    /**
     * Adiciona imagens ao corpo do email
     * 
     * @param string $sCaminhoArquivo Caminho da imagem a ser inserida
     * @param string $sNome Nome a ser exibido
     */
    public function addImagemCorpo($sCaminhoArquivo, $sNome = "") {
        $sId = uniqid(rand());
        $this->getPHPMailer()->AddEmbeddedImage($sCaminhoArquivo, $sId, $sNome);
    }

    /**
     * Limpa o array que contém os destinatários do email
     */
    public function limpaDestinatarios() {
        $this->getPHPMailer()->ClearAddresses();
        return $this;
    }

    /**
     * Limpa o array que contém os destinatários que receberão uma
     * cópia do email
     */
    public function limpaDestinatariosCopia() {
        $this->getPHPMailer()->ClearCCs();
        return $this;
    }

    /**
     * Limpa o array que contém os destinatários que receberão uma
     * cópia oculta do email
     */
    public function limpaDestinatariosCopiaOculta() {
        $this->getPHPMailer()->ClearBCCs();
        return $this;
    }

    /**
     * Limpa o array que contém os destinatários principais, destinatários de
     * cópia e destinatários de cópia oculta
     */
    public function limpaDestinatariosAll() {
        $this->getPHPMailer()->ClearAllRecipients();
        return $this;
    }

    /**
     * Método responsável por criar e definir os dados do objeto PHPMailer
     * bem como realizar o envio do email 
     * 
     * @return string String do objeto a ser renderizado 
     */
    public function sendEmail() {
        return array($this->getPHPMailer()->send(), $this->getPHPMailer()->ErrorInfo);
    }
}

?>