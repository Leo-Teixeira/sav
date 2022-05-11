<?php
    /* Déclaration d'utilisation de la librairie phpMailer */
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    /* appelle des différentes autres codes php dont nous avons besoin */
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'zip/zip.lib.php';

    function connexion_smtp()
    {
        $mail = new PHPMailer(true);
        try 
        {
            /* configuration de phpmailer */
            $mail->setLanguage('fr', 'PHPMailer/language/');
            $mail -> charSet = "UTF-8";
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = 'smtp.auth.orange-business.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'info@groupe-step.com';
            $mail->Password = 'Inf34Ste@';
            $mail->SMTPSecure = 'auto';
            $mail->Port = 587;

            /* adresse d'envoie du mail */
            $mail->Sender='info@groupe-step.com';
            $mail->setFrom('info@groupe-step.com', 'Service SAV', false);

            return $mail;
        }
        catch(Exception $e)
        {
            echo($e);
        }
    }

    function sendmailPJ($destinateur, $sujet, $corps, $destinataire, $nameFile, $sizeFile, $typeFile, $tmp_name)
    {
        $mail = connexion_smtp();

        /* Déclarations de nouvelles instances */
        $zip = new zipfile();

        $mail->addAddress($destinataire);     // Add a recipient
        $mail->addReplyTo($destinateur);


        /* piece jointe */
        for ($cpt = 0; $cpt<count($nameFile); $cpt++)
        {
            $open = fopen($tmp_name[$cpt], 'r');
            $read = fread($open, $sizeFile[$cpt]);
            fclose($open);
            $zip->addfile($read, $nameFile[$cpt]);
        }
        $archive = $zip->file();

        /*avoir l'heure francaise */
        setlocale(LC_TIME, 'fr_FR');
        date_default_timezone_set('Europe/Paris');
        $mail->AddStringAttachment($archive, 'sav.'.utf8_encode(strftime('%A %d %B %Y, %H:%M:%S')).'.zip');

        /* corps du mail */
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $sujet;
        $mail->Body    = $destinateur.'<br><br>'.$corps;

        /* envoie du mail */
        $mail->send();
        echo 'Message envoyer';
    }

    function sendMail($destinateur, $sujet, $corps, $destinataire)
    {
        $mail = connexion_smtp();

        $mail->addAddress($destinataire);     // Add a recipient
        $mail->addReplyTo($destinateur);

        /* piece jointe */
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $sujet;
        $mail->Body    = $destinateur.'<br><br>'.$corps;

        /* envoie du mail */
        $mail->send();
        echo 'Message has been sent';
    }
?>