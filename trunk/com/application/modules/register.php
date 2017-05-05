<?php
class register extends App{
		
	function beforeFilter(){
	
		global $CONFIG,$logger;
		$basedomain = $CONFIG['BASE_DOMAIN'];
		$this->assign('basedomain',$basedomain);
		$this->log('globalAction','LOGIN');
		$this->registerHelper = $this->useHelper('registerHelper');
	
	}
	
	function main(){ 
	
		global $LOCALE,$CONFIG; 
	
		//pr($res);
		$time['time'] = '%H:%M:%S';
		$this->assign('time',$time);
		$this->assign('notiftype',intval($this->_p('notiftype')));
		$this->assign('publishedtype',intval($this->_p('publishedtype')));
	
		$this->log('surf','register');
	
		if ($this->_p('submit')){
	
	//echo $this->_p('email');exit;
			$emailval=$this->is_valid_email(strip_tags($this->_p('email')));
			if(!$emailval)
			{
				$this->assign('email_ngga_valid',"Oops, something wasn't right. Please make sure all fields are filled in correctly.");
				return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/register-input.html');
			}
			
			$name=strip_tags($this->_p('name'));
			//echo $name;exit;
			if (ctype_alpha(str_replace(' ', '', $name))==false||$name=='NAME'||$name=='')
			{
				$this->assign('nama_ngga_valid',"Oops, something wasn't right. Please make sure all fields are filled in correctly.");
				return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/register-input.html');
			}
			
			$alamat=strip_tags($this->_p('alamat'));
			
			if (!ctype_alpha(str_replace(' ', '', $alamat)))
			{
				$this->assign('alamat_ngga_valid',"Oops, something wasn't right. Please make sure all fields are filled in correctly.");
				return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/register-input.html');
			}
			
			$checkEmailExist = $this->registerHelper->checkEmailExist(strip_tags($this->_p('email')));
			//var_dump($checkEmailExist);exit;
			if($checkEmailExist){
				$this->assign('check_mail',"Oops, something wasn't right. Your email has been registered.");
				return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/register-input.html');
			}

			// pr($files);exit;
			$insertnewdata = $this->registerHelper->insertnewdata();
				if($insertnewdata==true){		
					$this->registerHelper->sendGlobalMail($insertnewdata);
					sendRedirect($CONFIG['BASE_DOMAIN']."thankyou");
				}else{
					$this->assign('alamat_ngga_valid',"Oops, something wasn't right. Please make sure all fields are filled in correctly.");
					return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/register-input.html');
				}
										
		}

		$now = time();
		if(!isset($_SESSION['expire'])){
			sendRedirect("{$CONFIG['BASE_DOMAIN']}{$CONFIG['DINAMIC_MODULE']}");
			die();
			//return $this->View->toString(TEMPLATE_DOMAIN_WEB .'landing.html');
		}else{
			if($now > $_SESSION['expire']){
				session_destroy();
				sendRedirect("{$CONFIG['BASE_DOMAIN']}{$CONFIG['DINAMIC_MODULE']}");
				die();
				//return $this->View->toString(TEMPLATE_DOMAIN_WEB .'landing.html');
			}else{
				return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/register-input.html');
			}
		}
		
	}
	
}
?>