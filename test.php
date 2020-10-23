<?php

//set_include_path('.../dompdf');
//echo get_include_path() .  "..test/dompdf";

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Cake\Core\Plugin;
use Cake\Http\BaseApplication;
use Cake\Core\App;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

//App::uses('CakeEmail', 'Network/Email');

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml('hello world');

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

$test = <<<'ENDHTML'
<html>
 <body>
  <h1>Hello Dompdf</h1>
 </body>
</html>
ENDHTML;

// Render the HTML as PDF
$dompdf->render();

$email_subject = "Form Test";


$output = $dompdf->output();

file_put_contents('Brochure.pdf', $output);

$file_size = filesize('Brochure.pdf');

$fp = fopen('Brochure.pdf', "rb");
$file_data = fread($fp, $file_size);
fclose($fp);
$data = chunk_split(base64_encode($file_data));

$short_name = 'Brochure.pdf';

echo $file_size;

//echo $data;

$email_content = "Content-Type: application/pdf; \r\n";
$email_content .= "Content-Disposition: attachment; filename=".$short_name."\r\n";
$email_content .= "Content-Transfer-Encoding: base64\r\n\r\n";

//mail("gness9@ksu.edu", $email_subject, $email_content);

//Create a new PHPMailer instance
$mail = new PHPMailer();


$mail->isSMTP();                                            // Send using SMTP

$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
$mail->Host       = 'smtp.mailtrap.io';                    // Set the SMTP server to send through
$mail->Port       = 2525;                             // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
$mail->Username   = '29051e10dafcce';                     // SMTP username
$mail->Password   = '1bc6dad6ec0eda';                               // SMTP password
//$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged

$mail->SMTPDebug = 2;
// Set PHPMailer to use the sendmail transport
$mail->isSMTP();
//Set who the message is to be sent from
$mail->setFrom('glenn.n@ravenengineer.org', 'GMAN Ness');
//Set who the message is to be sent to

$mail->addAddress('gness9@ksu.edu', 'Glenn Ness');
//Set the subject line
$mail->Subject = 'PHPMailer POP-before-SMTP test';

$mail->isHTML(true);
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->Body = $email_content;
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
$mail->addAttachment('Brochure.pdf');

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}
// Output the generated PDF to Browser


?>

<html>
	<head>
		<title>PHP-Test</title>
	</head>
	<body>
		<h1><?php ?></h1>
	</body>
</html>