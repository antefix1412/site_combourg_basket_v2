<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/phpmailer/src/Exception.php';
require 'assets/phpmailer/src/PHPMailer.php';
require 'assets/phpmailer/src/SMTP.php';

header('Content-Type: application/json'); // ✅ On force la réponse en JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taille = htmlspecialchars($_POST['taille']);
    $couleur = htmlspecialchars($_POST['couleur']);
    $flocage = htmlspecialchars($_POST['flocage']);
    $initiales = isset($_POST['initiales']) ? htmlspecialchars($_POST['initiales']) : 'N/A';

    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tonemail@gmail.com';
        $mail->Password = 'mot_de_passe_application';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataire
        $mail->setFrom('tonemail@gmail.com', 'Boutique Club');
        $mail->addAddress('a.lemesle26@gmail.com');

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = 'Nouvelle commande de maillot';
        $mail->Body = "Nouvelle commande reçue :<br>
                       <strong>Taille :</strong> $taille<br>
                       <strong>Couleur :</strong> $couleur<br>
                       <strong>Flocage :</strong> $flocage<br>
                       <strong>Initiales :</strong> $initiales";

        $mail->send();
        echo json_encode(["message" => "Commande envoyée avec succès ! Vous pouvez procéder au paiement."]); // ✅ Réponse JSON correcte
    } catch (Exception $e) {
        echo json_encode(["error" => "Erreur lors de l'envoi de l'email : " . $mail->ErrorInfo]); // ✅ JSON en cas d'erreur
    }
} else {
    echo json_encode(["error" => "Méthode non autorisée."]); // ✅ JSON valide
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo json_encode(["message" => "Commande envoyée avec succès !"]);
} else {
    echo json_encode(["error" => "Méthode non autorisée."]);
}
?>
