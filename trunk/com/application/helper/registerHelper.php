<?php 

class registerHelper {
	
	function __construct($apps){
		global $logger;
		$this->logger = $logger;
		$this->apps = $apps;
		if(is_object($this->apps->user)) $this->uid = intval($this->apps->user->id);
		$this->dbshema= 'tbl';
	}
	
		protected function encrypt($string)
	{	
		$ENC_KEY='youknowwho2014';
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($ENC_KEY), $string, MCRYPT_MODE_CBC, md5(md5($ENC_KEY))));
	}
	protected function decrypt($encrypted)
	{
		$ENC_KEY='youknowwho2014';
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($ENC_KEY), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($ENC_KEY))), "\0");
	}
	
	function checkEmailExist($email){
		global $CONFIG;
		$sql = "SELECT * FROM {$CONFIG['DATABASE_WEB']}.user_register
				WHERE email = '{$email}' LIMIT 1";

		$rs = $this->apps->fetch($sql);

		return $rs;
	}
	
	function insertnewdata(){
		
		global $CONFIG;
		//pr($_POST);exit;
		$nama = strip_tags($this->apps->_p('name')); 
		$email = strip_tags($this->apps->_p('email')); 
		//$telp = intval($this->apps->_p('telepon')); 
		$alamat = strip_tags($this->apps->_p('alamat')); 
	//pr($CONFIG['DATABASE_WEB']);exit;
				
		$submit = $this->apps->_p('submit');
		// var_dump($submit);
		if($submit){
			$sql = "INSERT INTO {$CONFIG['DATABASE_WEB']}.user_register set nama='{$nama}',email='{$email}',telp='{$telp}',alamat='{$alamat}'";
					
			//pr($sql);exit;
			$res = $this->apps->query($sql);
			if ($res) return $this->apps->getLastInsertId();
			return false;
		}
		
		
	}
	
	function sendGlobalMail($insertnewdata=true){
	
	
	
	global $CONFIG;
	//pr($_POST);exit;
						
	$sqlselect=("select * from {$CONFIG['DATABASE_WEB']}.user_register where id='{$insertnewdata}' LIMIT 1");
						//pr($sqlselect);exit;
	$data=$this->apps->fetch($sqlselect);
	$email=$data['email'];
	
	GLOBAL $ENGINE_PATH, $CONFIG, $LOCALE;
	require_once $ENGINE_PATH."Utility/PHPMailer/class.phpmailer.php";
		
		//echo $email;exit;
						
		$to = $email;
		
	
		$msg = 'Thank you for your interest in Bintang Radler. We will contact you with information on where you can get Bintang Radler soon.
Cheers!';
		
		$mail = new PHPMailer();
				

		$mail->Host       = $CONFIG['EMAIL_SMTP_HOST'];  // sets the SMTP server
		$mail->SMTPAuth   = false;                  // enable SMTP authentication
		// $mail->Port       = 26;                    // set the SMTP port for the GMAIL server
		$mail->Username   = $CONFIG['EMAIL_SMTP_USER']; // SMTP account username
		$mail->Password   = $CONFIG['EMAIL_SMTP_PASSWORD'];        // SMTP account password
		
		$mail->From = $CONFIG['EMAIL_FROM_DEFAULT'];
		$mail->FromName = $CONFIG['EMAIL_FROM_DEFAULT'];
		$mail->addAddress($to, $data['nama']);  // Add a recipient
		//$mail->SetFrom($CONFIG['EMAIL_FROM_DEFAULT'], 'No Reply Account');
		// $mail->From =$CONFIG['EMAIL_FROM_DEFAULT'];	
		$mail->Subject    = "Get Ready to Taste The Double Refreshment! ";
		// if ($flag = 1){
		// 	$mail->Subject    = "Get Ready to Taste The Double Refreshment! ";
		// }
		// if ($flag = 2){
		// 	$mail->Subject    = "Get Ready to Taste The Double Refreshment! ";
		// }
		$mail->WordWrap = 50;
		$mail->AltBody    = $msg; // optional, comment out and test
		$mail->isHTML(true);
		$mail->MsgHTML($this->email_template());

		// $address = $to;
		// $mail->AddAddress($address);

		//$mail->AddAttachment("'.$CONFIG['ASSETS_DOMAIN_WEB'].'email/phpmailer.gif");      // attachment
		
		$result = $mail->Send();
		

			
		
	}

	function email_template(){
		global $CONFIG;
		$template ='<html>
					<head>
					<title>Template Email (FIX)</title>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					</head>
					<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
					<!-- Save for Web Slices (Template Email (FIX).psd) -->
					<table id="Table_01" width="700" height="687" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
						<tr>
							<td>
								<img src="'.$CONFIG['ASSETS_DOMAIN_WEB'].'email/roll_01.jpg" width="700" height="184" alt=""></td>
						</tr>
						<tr>
							<td height="190" background="'.$CONFIG['ASSETS_DOMAIN_WEB'].'email/roll_02.jpg">
					        	<div style="padding:30px 50px; font-family:Tahoma, Geneva, sans-serif; color:#fff; text-align:center;">
					            	<h3 style="font-weight:normal; font-size:16px;">Thank you for your interest in Bintang Radler. We will contact you with <br>
									information on where you can get Bintang Radler soon.</h3>
									<h3 style="font-weight:normal; font-size:16px;">Cheers!</h3>
					            </div>
								</td>
						</tr>
						<tr>
							<td>
								<img src="'.$CONFIG['ASSETS_DOMAIN_WEB'].'email/roll_03.jpg" width="700" height="313" alt=""></td>
						</tr>
					</table>
					<!-- End Save for Web Slices -->
					</body>
					</html>';
		return $template;
	}
	
	
	
	
	
	
}
?>
