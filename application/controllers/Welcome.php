<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('front/inc/head');
		$this->load->view('front/homepage');
		$this->load->view('front/inc/foot');
	}

	public function testmail()
	{
		// $config = array(
		// 	'protocol' => 'smtp',
		// 	'smtp_host' => 'relay-hosting.secureserver.net',
		// 	'smtp_port' => 25,
		// 	'smtp_user' => 'info@allcents.tech',
		// 	'smtp_pass' => 'Abracadabra_86',
		// 	'smtp_auth' => false,
		// 	'smtp_secure' => 'ssl',
		// 	'mailtype' => 'html',
		// 	'starttls'  => false,
		// 	'newline'   => "\r\n",
		// );

		// $this->load->library('email');
		// $this->email->initialize($config);

		// $this->email->set_newline("\r\n");
		// $this->email->from('scriptech.codes@gmail.com', 'Sentebale');
		// $this->email->to('arijit.nandi.2008@gmail.com');
		// $this->email->subject('test mail 1');
		// $this->email->message('this is sendmail() method');

		// if ($this->email->send()) {
		// 	echo "Sent";
		// } else {
		// 	print_r($this->email->print_debugger());
		// 	echo "Failed";
		// }

		$this->load->library('phpmailer_library');

		// PHPMailer object
		$mail = $this->phpmailer_library->load();

		// SMTP configuration
		$mail->isSMTP();
		$mail->Host = 'localhost';
		$mail->SMTPAuth = false;
		$mail->Username = 'info@allcents.tech';
		$mail->Password = 'Snt@2021#';
		$mail->SMTPSecure = '';
		$mail->SMTPAutoTLS = false;
		$mail->Port = 25;

		$mail->setFrom('info@allcents.tech', 'Sentebale');
		$mail->addReplyTo('info@allcents.tech', 'Sentebale');

		// Add a recipient
		$mail->addAddress('arijit.nandi.2008@gmail.com');

		// Add cc or bcc 
		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');

		// Email subject
		$mail->Subject = 'Send Email via SMTP using PHPMailer in CodeIgniter';

		// Set email format to HTML
		$mail->isHTML(true);

		// Email body content
		$mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
            <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
		$mail->Body = $mailContent;

		// Send email
		if (!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message has been sent';
		}
	}

	public function testmail2()
	{
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		//More headers
		$headers .= 'From: Sentebale Health App <info@allcents.tech>' . "\r\n";

		if (mail('arijit.nandi.2008@gmail.com', "test mail 2", "this is normal mail() method", $headers)) {
			echo "Sent";
		} else {
			print_r($this->email->print_debugger());
			echo "Failed";
		}
	}

	public function testsms()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.sandbox.africastalking.com/restless/send?username=sandbox&Apikey=e2263d244c6c8422596bf81091cba132f29b72b3b864fe41c9da5cf93f0f839b&to=+919674289380&message=Demo%20message%20from%20AllCents',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
		)
		);

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;

	}
}