<?php
    header('Content-type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	//Load composer's autoloader
	require './phpmailer/vendor/autoload.php';
	
	$requestMail = new PHPMailer;
	$responseMail = new PHPMailer;
    $request = json_decode(file_get_contents("php://input"));    

    $urname=$request->Name;
	$email=$request->Email;
	$mobile=$request->Phone;
	$message=$request->Message;

    $requestMail->isSMTP();  

    /*$requestMail->Host = 'smtpout.secureserver.net';*/
    $requestMail->Host = 'smtp.gmail.com';
	$requestMail->SMTPAuth = true;
	/*$requestMail->Username = 'sales@suryanenergy.in';
	$requestMail->Password = 'SuryanEnergy@8700';*/
	$requestMail->Username = 'kishoravadi@gmail.com';
	$requestMail->Password = 'Kishor123';
	$requestMail->SMTPSecure = 'TLS';
	$requestMail->Port = 587;

	$requestMail->setFrom('kishoravadi@gmail.com','Enquire Details');
	$requestMail->addAddress('kishoravadi@gmail.com');
	$requestMail->AddEmbeddedImage('logo.png','logo');
	$requestMail->isHTML(true);

    $requestMail->Subject = 'You have a new Enquiry';
	$requestMail->Body    = "<!DOCTYPE html>
		<html>
		<body>
		<div style='border: 1px solid #CDD6DF;padding: 20px;'>
			<img src='cid:logo' style='width: 30%;display: block;margin-right: auto;margin-left: auto;'>
			<div style='background-color: #f5f5f5;margin-top: 20px;width: 75%;margin-left: auto;margin-right: auto;padding: 20px;'>
				<p style='text-align: center;font: 18px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;'>You have received a</p>
				<p style='text-align: center;font: 32px cursive;letter-spacing: 0px;color: #f00;opacity: 1;font-weight: bold;'>New Enquiry</p>
			</div>
			<div style='margin-top: 20px;width: 75%;margin-left: auto;margin-right: auto;border: 1px solid #CDD6DF;padding: 20px;'>
				<p style='text-align: left;font:18px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;font-weight: bold;'>Details :</p>
				<table style='display: block;margin-right: auto;margin-left: auto;'>
				    <tbody>
				        <tr>
				            <td style='text-align: left;font: 16px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;'>Name</td>
				            <td style='padding-left: 30px;text-align: left;font: 16px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;'><strong>- $urname</strong></td>
				        </tr>
				        <tr>
				            <td style='text-align: left;font: 16px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;'>Email</td>
				            <td style='padding-left: 30px;text-align: left;font: 16px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;'><strong>- $email</strong></td>
				        </tr>
				        <tr>
				            <td style='text-align: left;font: 16px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;'>Phone</td>
				            <td style='padding-left: 30px;text-align: left;font: 16px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;'><strong>- $mobile</strong></td>
				        </tr>
				        <tr>
				            <td style='text-align: left;font: 16px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;'>Message</td>
				            <td style='padding-left: 30px;text-align: left;font: 16px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;'><strong>- $message</strong></td>
				        </tr>
				    </tbody>
				</table>
			</div>
			<div style='padding-top: 150px;'>
				<a href='http://suryanenergy.in'><p style='text-align: center;font:14px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;'>Suryan Energy © 2021</p></a>
			</div>
		</div>
		</body>
		</html>";
	
	$requestMail->AltBody = 'check the latest enquiry..!';

	$myRequestObj =new stdClass();

	if(!$requestMail->send()) {
		$myRequestObj->status = "failure";
		$myRequestObj->msg = 'Message could not be sent.';
		$myRequestObj->errinfo=$requestMail->ErrorInfo;    
	} 
	else {
		$myRequestObj->status = "success";
		$myRequestObj->msg = 'Message has been sent';
	} 

	$responseMail->isSMTP();  

	$responseMail->Host = 'smtp.gmail.com';
    /*$responseMail->Host = 'smtpout.secureserver.net';*/
	$responseMail->SMTPAuth = true;
	$responseMail->Username = 'kishoravadi@gmail.com';
	$responseMail->Password = 'Kishor123';
	$responseMail->SMTPSecure = 'TLS';
	$responseMail->Port = 587;

	$responseMail->setFrom('kishoravadi@gmail.com','Suryan Energy');
	$responseMail->addAddress($email);
	$responseMail->AddEmbeddedImage('logo.png','logo');
	$responseMail->isHTML(true);

    $responseMail->Subject = 'Thank you for your enquiry.';
	$responseMail->Body    = "<!DOCTYPE html>
		<html>
		<body>
		<div style='border: 1px solid #CDD6DF;padding: 20px;'>
			<img src='cid:logo' style='width: 30%;display: block;margin-right: auto;margin-left: auto;'>
			<div style='background-color: #ffffff;margin-top: 20px;width: 75%;margin-left: auto;margin-right: auto;padding: 20px;'>
				<p style='text-align: center;font: 32px cursive;letter-spacing: 0px;color: #000;opacity: 1;font-weight: bold;margin: 0.5em 0;'>Thank you for your enquiry</p>
				<p style='text-align: center;font: 18px cursive;letter-spacing: 0px;color: #000;opacity: 1;'>Your message has been sent successfully.</p>
				<p style='text-align: center;font: 18px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;'>Thank you for your enquiry. It has been forwarded to the relevant department and will be dealt with as soon as possible.</p>
			</div>
			<div style='background-color: #ffffff;margin-top: 20px;width: 75%;margin-left: auto;margin-right: auto;padding: 20px;'>
				<p style='text-align: center;font: 18px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;'>Mean time take a look at our services <a href='http://suryanenergy.in/services'>Suryan Energy</a></p>
			</div>
			<div style='padding-top: 150px;'>
				<a href='http://suryanenergy.in'><p style='text-align: center;font:14px cursive;letter-spacing: 0px;color: #474C67;opacity: 1;'>Suryan Energy © 2021</p></a>
			</div>
		</div>
		</body>
		</html>";
	
	$responseMail->AltBody = 'It has been forwarded to the relevant department and we will get touch with you as soon as possible.';

	$myResponseObj =new stdClass();

	if(!$responseMail->send()) {
		$myResponseObj->status = "failure";
		$myResponseObj->msg = 'Message could not be sent.';
		$myResponseObj->errinfo=$responseMail->ErrorInfo;    
	} 
	else {
		$myResponseObj->status = "failure";
		$myResponseObj->msg = 'Message has been sent';
	} 

	$myJSON = json_encode($myResponseObj);
    return $myJSON;
?>

<script>
	alert("Thank you for your query. We will catch you soon");
</script>