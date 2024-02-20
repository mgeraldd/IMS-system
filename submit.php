<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    $to = "mbogholi64@gmail.com"; 
    $subject = "New Contact Form Submission";
    $headers = "From: $email";
    
    $mailContent = "Name: $name\n";
    $mailContent .= "Email: $email\n\n";
    $mailContent .= "Message:\n$message";
    
    if (mail($to, $subject, $mailContent, $headers)) {
        echo "Message sent successfully.";
    } else {
        echo "Message could not be sent.";
    }
}
?>
