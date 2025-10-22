<?php
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"]));
    
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Molimo ispunite sva polja ispravno!";
        echo json_encode($response);
        exit;
    }
    
    $to = "iva.sosic1@skole.hr";
    $subject = "Nova poruka od $name";
    $email_content = "Ime: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Poruka:\n$message\n";
    $headers = "From: $name <$email>";
    
    if (mail($to, $subject, $email_content, $headers)) {
        $response['success'] = true;
        $response['message'] = "Hvala vam! Vaša poruka je uspješno poslana.";
    } else {
        $response['message'] = "Došlo je do greške prilikom slanja poruke. Molimo pokušajte ponovo.";
    }
} else {
    $response['message'] = "Nevažeći zahtjev.";
}

echo json_encode($response);
?>