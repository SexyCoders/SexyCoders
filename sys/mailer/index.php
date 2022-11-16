<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';

$app = new Slim\App;

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

function send_mail($data){
	$f=fopen("/etc/sexycoders/mail.passwd", "r");
	$passwd=fscanf($f, "%s");
	fclose($f);
	$mail = new PHPMailer(true);
	try {
		//Server settings
		$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'smtp.sexycoders.org';                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'mailer@sexycoders.org';                     //SMTP username
		$mail->Password   = $passwd[0];                               //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		//Recipients
		$mail->setFrom('mailer@sexycoders.org', 'SexyCoders Mailbot');
		//$mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
		$mail->addAddress($data->to);               //Name is optional
		$mail->addReplyTo($data->from, $data->name);
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		//Attachments
		//$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = $data->subject;
		$mail->Body    = $data->body."<br><br><br>".$data->sig;
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		$mail->send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
return $passwd;
}

////////////
//HELLO
////////////
$app->get('/hello', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello, this is the SexyCoders mailer api! No milf porn here were sorry, please refer to https://www.pornhub.com/");
});
$app->post('/hello', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello, this is the SexyCoders mailer api! No milf porn here were sorry, please refer to https://www.pornhub.com/");
});


////////////
//RESOLVE
////////////
$app->post('/webpage_contact',function(Request $request, Response $response){


    $req_data=json_decode($request->getBody());
    $data=new stdClass();
    $data->from=$req_data->from;
	$data->name=$req_data->name;
    $data->to="team@sexycoders.org";
    $data->subject='Contact Request - '.$req_data->subject;
    $data->body=$req_data->body;
    $data->sig=file_get_contents('./sigstring.html');

	$res=send_mail($data);

	$response->getBody()->write(json_encode($res));
	//$response->getBody()->write(file_get_contents('/etc/sexycoders/mail.passwd'));
});
$app->run();
