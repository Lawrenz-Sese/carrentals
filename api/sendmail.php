<?php
header('Access-Control-Allow-Origin: *');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

error_log('Sending Mail by Php File', 0);

if(isset($_POST['user_email'])){
    error_log('Got Some Post Parrams', 0);

    $user_email            = $_POST['user_email'];
    $user_verification     = $_POST['user_verification'];
    $user_fname  =$_POST['user_fname'];

}else{
    error_log('Data Params Found on this server, try post some data', 0);

    $postcontent = file_get_contents("php://input");
    $postData = json_decode($postcontent);

    if(isset($postData)){
        $user_email = $postData -> user_email;
        $user_verification = $postData -> user_verification;
        $user_fname = $postData -> user_fname;


        error_log(json_encode($user_email),0);
        error_log(json_encode($user_verification),0);
        error_log(json_encode($user_fname),0);


$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'plantipshop@gmail.com';                     
    $mail->Password   = 'iyqzdcxvgmlpprqw';                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;                                    

    $mail->setFrom('from@example.com', 'PLANTIP');                             
    $mail->addAddress("$user_email");               
    $mail->addReplyTo('plantipshop@gmail.com', 'PLANTIP');
    
    $mail->isHTML(true);                                  
    $mail->Subject = 'Plantip Verification Code';
    $mail->Body    = "
    <style>
    table, td, div, h1, p {
      font-family: Arial, sans-serif;
    }
    @media screen and (max-width: 530px) {
      .unsub {
        display: block;
        padding: 8px;
        margin-top: 14px;
        border-radius: 6px;
        background-color: #f8f8f8;
        text-decoration: none !important;
        font-weight: bold;
      }
      .col-lge {
        max-width: 100% !important;
      }
    }
    @media screen and (min-width: 531px) {
      .col-sml {
        max-width: 27% !important;
      }
      .col-lge {
        max-width: 73% !important;
      }
    }
  </style>
</head>
<body style='margin:0;padding:0;word-spacing:normal;background-color:#f8f8f8;'>
  <div role='article' aria-roledescription='email' lang='en' style='text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#f8f8f8;'>
    <table role='presentation' style='width:100%;border:none;border-spacing:0;'>
      <tr>
        <td align='center' style='padding:0;'>
          <!--[if mso]>
          <table role='presentation' align='center' style='width:600px;'>
          <tr>
          <td>
          <![endif]-->
          <table role='presentation' style='width:94%;max-width:600px;border:none;border-spacing:0;text-align:left;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:#fff;'>
            <tr>
              <td style='padding:40px 30px 30px 30px;text-align:center;font-size:24px;font-weight:bold;'>
                <a href='http://www.example.com/' style='text-decoration:none;'></a>
              </td>
            </tr>
            <tr>
              <td style='padding:30px;background-color:#ffffff; color:#404040;'>
                <h1 style='margin-top:0;margin-bottom:16px;font-size:26px;line-height:32px; color:#404040;font-weight:bold;letter-spacing:-0.02em;'>Hey $user_fname!</h1>
                <p style='margin:0; color:#404040;'>Please enter the one-time pin code below to complete your registration.</p>
              </td>
            </tr>
            <tr>
              <td style='padding:35px 30px 11px 30px;font-size:0;background-color:#ffffff;border-bottom:1px solid #f0f0f5;border-color:rgba(201,201,207,.35);'>
                <!--[if mso]>
                <table role='presentation' width='100%'>
                <tr>
                <td style='width:395px;padding-bottom:20px;' valign='top'>
                <![endif]-->
                <div class='col-lge' style='background-color: #5F7161;
                color: white;
                border-radius: 10px;
                padding: 13px;
                width:30%;
                font-weight: bold;
                display:block;
                margin-left:auto;
                margin-right:auto;
                font-size: 20px'>
                  <p style='margin:0; text-align:center;'>$user_verification</p>
                </div>
                <!--[if mso]>
                </td>
                </tr>
                </table>
                <![endif]-->
              </td>
            </tr>
            <tr>
              <td style='padding:30px;text-align:center;font-size:12px;background-color:#f8f8f8;color:#fff;'>
                
              </td>
            </tr>
          </table>
          <!--[if mso]>
          </td>
          </tr>
          </table>
          <![endif]-->
        </td>
      </tr>
    </table>
  </div>
</body>";

    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
    error_log('Message has been sent', 0);
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}",0);
}

    } else {

    }
}



?>s