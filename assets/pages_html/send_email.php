<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $taille = htmlspecialchars($_POST['taille'] ?? '');
        $couleur = htmlspecialchars($_POST['couleur'] ?? '');
        $flocage = htmlspecialchars($_POST['flocage'] ?? '');
        $initiales = htmlspecialchars($_POST['initiales'] ?? 'N/A');

        $to = 'a.lemesle26@gmail.com';
        $subject = 'Nouvelle commande de maillot';
        $message = "Nouvelle commande reçue :\n\n" .
                   "Taille: $taille\n" .
                   "Couleur: $couleur\n" .
                   "Flocage: $flocage\n" .
                   "Initiales: $initiales";
        $headers = "From: noreply@votresite.com\r\n" .
                   "Reply-To: noreply@votresite.com\r\n" .
                   "Content-Type: text/plain; charset=UTF-8";

        if (mail($to, $subject, $message, $headers)) {
            echo json_encode([
                'success' => true,
                'message' => "Commande envoyée avec succès ! Vous pouvez procéder au paiement."
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "Erreur lors de l'envoi de l'email. Vérifiez votre serveur."
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => "Une erreur est survenue : " . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => "Méthode non autorisée."
    ]);
}