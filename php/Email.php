<?php

class Email
{
    private $fromName    = 'Liniker';
    private $fromEmail   = 'linikerdev@gmail.com';
    private $host        = 'mail.globaltechtools.com';
    private $username    = 'sendsite@globaltechtools.com';
    private $password    = '@Mware2017global';
    private $port        = 587;
    public $mailer;


    public  function __construct(){

        include_once('PHPMailer/PHPMailerAutoload.php');
        $this->mailer = new PHPMailer;
        $this->mailer->Host =  $this->host;
        $this->mailer->Username = $this->username;
        $this->mailer->Password = $this->password;
        $this->mailer->Port = $this->port;
        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth = true;
        $this->mailer->SetLanguage("br");
        $this->mailer->isHTML(true);   
    }



    public static function sendMail($fromEmail,$fromName,$distEmail, $distName,$subject,$body)
    {
        $mail = new static();
        $mail->mailer->setFrom($fromEmail,$fromName);
        $mail->mailer->addAddress($distEmail, $distName);
        $mail->mailer->Subject  = $subject;
        $mail->mailer->Body     = $body;
        return $mail->mailer->send() ? true : false;


    }



    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }



}