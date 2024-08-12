<?php
require_once ('src/PHPMailer.php');
require_once ('src/SMTP.php');
require_once ('src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{
    public function enviarEmail($email, $local)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'emulador.igor2@gmail.com';
            $mail->Password = 'pvlt vtfu mcxg brhs';
            $mail->Port = 587;

            $mail->setFrom('emulador.igor2@gmail.com');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = utf8_decode('Email de verificação');

            if ($local === "recuperarSenha") {
                $link = '
                    <!DOCTYPE html>
                    <html lang="pt-br">

                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Mensagem de Confirmação</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                text-align: center;
                                padding: 20px;
                            }

                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                padding: 20px;
                                background-color: #ffffff;
                                border-radius: 8px;
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            }

                            .logo {
                                margin-bottom: 20px;
                            }

                            .content {
                                padding: 20px;
                                border-top: 1px solid #cccccc;
                            }

                            .content img {
                                max-width: 100%; /* Ajusta a largura máxima da imagem para o tamanho da container */
                                height: auto; /* Mantém as proporções da imagem */
                                margin-bottom: 20px; /* Adiciona um espaço entre a imagem e o texto */
                            }   

                            .button {
                                display: inline-block;
                                padding: 10px 20px;
                                font-size: 16px;
                                background-color: #007bff;
                                color: #ffffff;
                                text-decoration: none;
                                border-radius: 4px;
                                transition: background-color 0.3s ease;
                            }

                            .button:hover {
                                background-color: #0056b3;
                            }
                        </style>
                    </head>

                    <body>
                        <div class="container">
                            <div class="content">
                                <p>Prezado(a),</p>
                                <p>Esperamos que este e-mail o encontre bem.</p>
                                <p>Por favor, clique no botão abaixo para confirmar que você recebeu este e-mail:</p>
                                <p><<a href="https://localhost/projeto-integrador/view/nova-senha.php?emailUsuario=' . $email . '">Clique aqui para confirmar</a></p>
                                <p>Se você não conseguir verificar, entre em contato com o suporte através do canal XXXXX-XXXXX</p>
                            </div>
                        </div>
                    </body>

                    </html>';
            } else if ($local === "co") {
                $link = '
                    <!DOCTYPE html>
                    <html lang="pt-br">

                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Mensagem de Confirmação</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                text-align: center;
                                padding: 20px;
                            }

                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                padding: 20px;
                                background-color: #ffffff;
                                border-radius: 8px;
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            }

                            .logo {
                                margin-bottom: 20px;
                            }

                            .content {
                                padding: 20px;
                                border-top: 1px solid #cccccc;
                            }

                            .content img {
                                max-width: 100%; /* Ajusta a largura máxima da imagem para o tamanho da container */
                                height: auto; /* Mantém as proporções da imagem */
                                margin-bottom: 20px; /* Adiciona um espaço entre a imagem e o texto */
                            }   

                            .button {
                                display: inline-block;
                                padding: 10px 20px;
                                font-size: 16px;
                                background-color: #007bff;
                                color: #ffffff;
                                text-decoration: none;
                                border-radius: 4px;
                                transition: background-color 0.3s ease;
                            }

                            .button:hover {
                                background-color: #0056b3;
                            }
                        </style>
                    </head>

                    <body>
                        <div class="container">
                            <div class="content">
                                <p>Prezado(a),</p>
                                <p>Esperamos que este e-mail o encontre bem.</p>
                                <p>Por favor, clique no botão abaixo para confirmar que você recebeu este e-mail:</p>
                                <p><a href="https://localhost/projeto-integrador/view-confeitaria/editar-usuario-confeitaria.php?v=verif">Clique aqui para confirmar</a></p>
                                <p>Se você não conseguir verificar, entre em contato com o suporte através do canal XXXXX-XXXXX</p></div>
                        </div>
                    </body>

                    </html>';
            } else if ($local === "cl") {
                $link = '
                    <!DOCTYPE html>
                    <html lang="pt-br">

                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Mensagem de Confirmação</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                text-align: center;
                                padding: 20px;
                            }

                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                padding: 20px;
                                background-color: #ffffff;
                                border-radius: 8px;
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            }

                            .logo {
                                margin-bottom: 20px;
                            }

                            .content {
                                padding: 20px;
                                border-top: 1px solid #cccccc;
                            }

                            .content img {
                                max-width: 100%; /* Ajusta a largura máxima da imagem para o tamanho da container */
                                height: auto; /* Mantém as proporções da imagem */
                                margin-bottom: 20px; /* Adiciona um espaço entre a imagem e o texto */
                            }   

                            .button {
                                display: inline-block;
                                padding: 10px 20px;
                                font-size: 16px;
                                background-color: #007bff;
                                color: #ffffff;
                                text-decoration: none;
                                border-radius: 4px;
                                transition: background-color 0.3s ease;
                            }

                            .button:hover {
                                background-color: #0056b3;
                            }
                        </style>
                    </head>

                    <body>
                        <div class="container">
                            <div class="content">
                                <p>Prezado(a),</p>
                                <p>Esperamos que este e-mail o encontre bem.</p>
                                <p>Por favor, clique no botão abaixo para confirmar que você recebeu este e-mail:</p>
                                <p><a href="https://localhost/projeto-integrador/view-cliente/editar-usuario-cliente.php?v=verif">Clique aqui para confirmar</a></p>
                                <p>Se você não conseguir verificar, entre em contato com o suporte através do canal XXXXX-XXXXX</p></div></div>
                        </div>
                    </body>

                    </html>';
            } else if ($local === "2") {
                $link = '
                    <!DOCTYPE html>
                    <html lang="pt-br">

                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Mensagem de Confirmação</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                text-align: center;
                                padding: 20px;
                            }

                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                padding: 20px;
                                background-color: #ffffff;
                                border-radius: 8px;
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            }

                            .logo {
                                margin-bottom: 20px;
                            }

                            .content {
                                padding: 20px;
                                border-top: 1px solid #cccccc;
                            }

                            .content img {
                                max-width: 100%; /* Ajusta a largura máxima da imagem para o tamanho da container */
                                height: auto; /* Mantém as proporções da imagem */
                                margin-bottom: 20px; /* Adiciona um espaço entre a imagem e o texto */
                            }   

                            .button {
                                display: inline-block;
                                padding: 10px 20px;
                                font-size: 16px;
                                background-color: #007bff;
                                color: #ffffff;
                                text-decoration: none;
                                border-radius: 4px;
                                transition: background-color 0.3s ease;
                            }

                            .button:hover {
                                background-color: #0056b3;
                            }
                        </style>
                    </head>

                    <body>
                        <div class="container">
                            <div class="content">
                                <p>Prezado(a),</p>
                                <p>Esperamos que este e-mail o encontre bem.</p>
                                <p>Por favor, clique no botão abaixo para confirmar que você recebeu este e-mail:</p>
                                <p><a href="https://localhost/projeto-integrador/view/valida-usuario.php?e=' . $email . '&u=cliente">Clique aqui para confirmar</a></p>
                                <p>Se você não conseguir verificar, entre em contato com o suporte através do canal XXXXX-XXXXX</p></div></div> </div>
                        </div>
                    </body>

                    </html>';
            } else if ($local === "3") {
                $link = '
                    <!DOCTYPE html>
                    <html lang="pt-br">

                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Mensagem de Confirmação</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                text-align: center;
                                padding: 20px;
                            }

                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                padding: 20px;
                                background-color: #ffffff;
                                border-radius: 8px;
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            }

                            .logo {
                                margin-bottom: 20px;
                            }

                            .content {
                                padding: 20px;
                                border-top: 1px solid #cccccc;
                            }

                            .content img {
                                max-width: 100%; /* Ajusta a largura máxima da imagem para o tamanho da container */
                                height: auto; /* Mantém as proporções da imagem */
                                margin-bottom: 20px; /* Adiciona um espaço entre a imagem e o texto */
                            }   

                            .button {
                                display: inline-block;
                                padding: 10px 20px;
                                font-size: 16px;
                                background-color: #007bff;
                                color: #ffffff;
                                text-decoration: none;
                                border-radius: 4px;
                                transition: background-color 0.3s ease;
                            }

                            .button:hover {
                                background-color: #0056b3;
                            }
                        </style>
                    </head>

                    <body>
                        <div class="container">
                            <div class="content">
                                <p>Prezado(a),</p>
                                <p>Esperamos que este e-mail o encontre bem.</p>
                                <p>Por favor, clique no botão abaixo para confirmar que você recebeu este e-mail:</p>
                                <p><a href="https://localhost/projeto-integrador/view/valida-usuario.php?e=' . $email . '&u=confeitaria">Clique aqui para confirmar</a></p>
                                <p>Se você não conseguir verificar, entre em contato com o suporte através do canal XXXXX-XXXXX</p></div></div> </div></div>
                        </div>
                    </body>

                    </html>';
                } else if ($local === "feedback") {
                    $link = '
                    <!DOCTYPE html>
                    <html lang="pt-br">

                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Mensagem de Confirmação</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                                text-align: center;
                                padding: 20px;
                            }

                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                padding: 20px;
                                background-color: #ffffff;
                                border-radius: 8px;
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            }

                            .logo {
                                margin-bottom: 20px;
                            }

                            .content {
                                padding: 20px;
                                border-top: 1px solid #cccccc;
                            }

                            .content img {
                                max-width: 100%; /* Ajusta a largura máxima da imagem para o tamanho da container */
                                height: auto; /* Mantém as proporções da imagem */
                                margin-bottom: 20px; /* Adiciona um espaço entre a imagem e o texto */
                            }   

                            .button {
                                display: inline-block;
                                padding: 10px 20px;
                                font-size: 16px;
                                background-color: #007bff;
                                color: #ffffff;
                                text-decoration: none;
                                border-radius: 4px;
                                transition: background-color 0.3s ease;
                            }

                            .button:hover {
                                background-color: #0056b3;
                            }
                        </style>
                    </head>

                    <body>
                        <div class="container">
                            <div class="content">
                                <p>Seu problema foi resolvido com sucesso!</p>
                                <p>Entre em contato conosco para receber mais detalhes.</p>
                            </div>
                        </div>
                    </body>

                    </html>';
            }

            $link = utf8_decode($link);
            $mail->Body = $link;

            if (!$mail->send()) {
                echo 'Erro ao enviar o e-mail.';
            } else if ($local === "feedback") {
                echo "<script language='javascript' type='text/javascript'>window.location.href='../view-root/dashboard-root.php'</script>";
            } else {
                echo "<script language='javascript' type='text/javascript'>window.location.href='../view/aviso.html'</script>";
            }
        } catch (Exception $e) {
            echo "ERRO ao enviar mensagem: {$mail->ErrorInfo}";
        }
    }
}
