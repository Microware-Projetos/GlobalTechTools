<?php

$data = filter_input_array(INPUT_POST,FILTER_DEFAULT);

define('EMAIL', 'sales@globaltechtools.com');
//define('EMAIL', 'contato@liniker.com.br');
//define('EMAIL', 'sales@globaltechtools.com');
define('NAME', 'Global Techtools');

$name       = !empty($data['name'])?  utf8_decode($data['name']):null;
$company    = !empty($data['company'])? utf8_decode($data['company']):null;
$email      = !empty($data['email'])? utf8_decode($data['email']):null;
$phone      = !empty($data['phone'])? utf8_decode($data['phone']):null;
$job        = !empty($data['job'])? utf8_decode($data['job']):null;
$message    = !empty($data['message']) ?  utf8_decode($data['message']) : null;
$googleCode     = $data['g-recaptcha-response'];
$key = '6LfE6R4UAAAAAH5MiUyFEzmXEkefS30MSDTUDyGU';

$resposta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$key&response=".$googleCode."&remoteip=".$_SERVER['REMOTE_ADDR']);
$obj = json_decode($resposta);


if (!$obj->success) {
    echo "
        <div class='alert alert-danger fade in alert-dismissable'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>×</a>
        <strong>Sorry! </strong>The message could not be sent, please try again.
        <i class='fa fa-exclamation-triangle fa-fw'></i><small>Validate the captcha</small>
        </div>
        ";
    exit;
}

$message = "
            <table style='height: 118px;' width='352' cellpadding='5'>
                <tbody>
                <tr>
                    <td style='text-align: center; background: #187fb0;' colspan='2'>
                        <h3><span style='color: #ffffff;'><strong>Global Techtools</strong></span></h3>
                    </td>
                </tr>
                <tr>
                    <td width='80'><strong><span style='color: #3366ff;'>Name:</span></strong></td>
                    <td>".$name."</td>
                </tr>
                <tr>
                    <td><strong><span style='color: #3366ff;'>Company:</span></strong></td>
                   <td>".$company."</td>
                </tr>
                <tr>
                    <td><strong><span style='color: #3366ff;'>E-mail:</span></strong></td>
                    <td>".$email."</td>
                </tr>
                <tr>
                    <td><strong><span style='color: #3366ff;'>Phone:</span></strong></td>
                    <td>".$phone."</td>
                </tr>
                <tr>
                    <td><strong><span style='color: #3366ff;'>Job:</span></strong></td>
                    <td>".$job."</td>
                </tr>
                <tr>
                    <td><strong><span style='color: #3366ff;'>Message:</span></strong></td>
                   <td>".$message."</td>
                </tr>
                </tbody>
            </table>
            ";

$response = "

        <p style='#187fb0;font-family: calibri'>Dear $name,</p>
        <p style='#187fb0;font-family: calibri'>Your email has been successfully received.</p>       
        <p style='#187fb0;font-family: calibri'>We are processing your request and will contact you shortly.</p>
        <br>
        <p style='#187fb0;font-family: calibri'>Best regards</p>    
        <p style='#187fb0;font-family: calibri'><strong>Global Techtools Team</strong></p>
        <span style='#187fb0;font-family: calibri'>sales@globaltechtools.com</span>
        <br>
        <span style='#187fb0;font-family: calibri'>+1-305-809-0366</span>
        <br>
        <span style='#187fb0;font-family: calibri'><address>2330 Ponce de Leon Blvd. Coral Gables Miami, FL 33134, USA</address></span>
        <br>
        <a href='www.globaltechtools.com'>www.globaltechtools.com</a>

";



$from       = $email;
$fromName   = $name;
$dist       = EMAIL;
$distName   = NAME;
$subject    = 'Global TechTools - www.globaltechtools.com';
$body       = $message;

include_once "Email.php";

$sendEmailContact = Email::sendMail($from,$fromName,$dist,$distName,$subject,$body);



if(!$sendEmailContact) {
    echo "
        <div class='alert alert-danger fade in alert-dismissable'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>×</a>
        <strong>Sorry!</strong>The message could not be sent, please try again.
        </div>
        ";
} else {
    echo "
        <div class='alert alert-success fade in alert-dismissable'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>×</a>
        <strong>Success!</strong> Your message has been sent successfully.
        </div>
         ";

    $r_from       = EMAIL;
    $r_fromName   = NAME;
    $r_dist       = $email;
    $r_distName   = $name;
    $r_subject    = 'Thank you for contacting Global Techtools';
    $r_body       = $response;

    $email = Email::sendMail($r_from,$r_fromName,$r_dist,$r_distName, $r_subject,$r_body);
    //sendEmail($r_from,$r_fromName,$r_dist,$r_distName,$r_subject,$r_body);
}
