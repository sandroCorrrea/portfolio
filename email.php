<?php 

    // <-======================= BIBLIOTECAS ULTILIZADAS ====================================->
    use PHPMailer\PHPMailer\PHPMailer;
    require_once("./vendor/autoload.php");

    // <-======================= EXTRAINDO INFORMAÇÕES DO ARRAY POST ====================================->
    extract($_POST);

    // <-======================= DADOS PARA ENVIAR O E-MAIL ====================================->
    if(is_file('config/.env')){
        $parsed     = parse_ini_file('config/.env');
    }else{
        header("Location: ./contact.html?msg=erro");
        die;
    }

    // <-======================= CONF. PARA ENVIO DE EMAIL ====================================->
    try{
        $mail               = new PHPMailer();
        $mail->isSMTP();
        $mail->Host         = $parsed['MAIL_HOST'];
        $mail->SMTPAuth     = true;
        $mail->SMTPSecure   = $parsed['MAIL_SMTP_SECURE'];
        $mail->Username     = $parsed['MAIL_MAILER'];
        $mail->Password     = $parsed['MAIL_PASSWORD'];
        $mail->Port         = $parsed['MAIL_PORT'];
        $mail->setFrom($parsed['MAIL_MAILER'], $parsed['MAIL_USERNAME']);
        $mail->addAddress($parsed['MAIL_FROM'], 'Sandro Junior');
        $mail->isHTML(true);
        $mail->CharSet      = $parsed['MAIL_ENCRYPTION'];
        $mail->Subject      = "Mensagem Portfólio";
        $mail->Body         = "Você recebeu uma mensagem em seu portfólio com as seguintes informações: <br><b>Nome:</b> {$name}<br><b>Email:</b> {$email}<br><b>Telefone: </b>{$phone}<br><b>Mensagem: </b>{$message}";

        if(!$mail->send()   ){
            header("Location: ./contact.html?msg=erro");
            die;
        }else{
            header("Location: ./contact.html?msg=success");
            die;
        }
    }catch(Exception $erro){  
        header("Location: ./contact.html?msg=erro");
        die;
    }
?>