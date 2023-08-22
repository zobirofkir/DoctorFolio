<?php
$username = 'admin';
$password = 'admin';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $database = new PDO("mysql:host=localhost;dbname=DoctorFolio;charset=utf8", $username, $password);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST["contact"])) {
        $username = $_POST["username"];
        $PhoneNumber = $_POST["PhoneNumber"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        $PostData = $database->prepare("INSERT INTO DoctorFolio(username, PhoneNumber, email, message) VALUES(:username, :PhoneNumber, :email, :message)");
        $PostData->bindParam(":username", $username);
        $PostData->bindParam(":PhoneNumber", $PhoneNumber);
        $PostData->bindParam(":email", $email);
        $PostData->bindParam(":message", $message);

        if ($PostData->execute()) {
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'Zobirofkir30@gmail.com';
                $mail->Password = 'owykcaqhectjbwsy';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom($email, $username);
                $mail->addAddress('zobirofkir30@gmail.com', 'ZOBIR');

                $mail->isHTML(true);
                $mail->Subject = 'Contact Details';
                $mail->Body = '<h2>Contact Details</h2>' .
                    '<p><strong>Name:</strong> ' . $username . '</p>' .
                    '<p><strong>Phone Number:</strong> ' . $PhoneNumber . '</p>' .
                    '<p><strong>Email:</strong> ' . $email . '</p>' .
                    '<p><strong>Message:</strong> ' . $message . '</p>';

                $mail->send();
                echo "We call you soon";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
} catch (PDOException $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>
