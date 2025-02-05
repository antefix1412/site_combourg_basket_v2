<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taille = htmlspecialchars($_POST['taille']);
    $couleur = htmlspecialchars($_POST['couleur']);
    $flocage = htmlspecialchars($_POST['flocage']);
    $initiales = isset($_POST['initiales']) ? htmlspecialchars($_POST['initiales']) : 'N/A';

    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'a.lemesle26@gmail.com'; // 🔹 Ton adresse Gmail
        $mail->Password = 'ccny hzuk fyxg jwjt'; // 🔹 Ton mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataire
        $mail->setFrom('tonemail@gmail.com', 'Boutique Club');
        $mail->addAddress('a.lemesle26@gmail.com');

        // Contenu de l'e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Nouvelle commande de maillot';
        $mail->Body = "Nouvelle commande reçue :<br><br>
                       <strong>Taille :</strong> $taille<br>
                       <strong>Couleur :</strong> $couleur<br>
                       <strong>Flocage :</strong> $flocage<br>
                       <strong>Initiales :</strong> $initiales";

        $mail->send();
        echo "Commande envoyée avec succès ! Vous pouvez procéder au paiement.";
    } catch (Exception $e) {
        echo "❌ Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
    }
} else {
    echo "❌ Méthode non autorisée.";
}
