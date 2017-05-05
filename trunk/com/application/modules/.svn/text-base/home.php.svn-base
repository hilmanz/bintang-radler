<?php
class home extends App{
		
	function beforeFilter(){

		global $CONFIG,$logger;
		$basedomain = $CONFIG['BASE_DOMAIN'];
		$this->assign('basedomain',$basedomain);
		$this->assign('locale', $LOCALE[1]);
	
	
	}
	
	function main(){ 

		global $LOCALE,$CONFIG; 
		if(strip_tags($this->_g('page'))=='home')
		$this->log('surf','landing');
		$now = time(); // checking the time now when home page starts

		if(intval($this->_p('age_check'))){
			$d = intval($this->_p('dday'));
			$m = intval($this->_p('dmonth'));
			$y = intval($this->_p('dyear'));
			

			if($d>0){}else return $this->View->toString(TEMPLATE_DOMAIN_WEB .'landing.html');
			if($m>0){}else return $this->View->toString(TEMPLATE_DOMAIN_WEB .'landing.html');
			if($y>0){}else return $this->View->toString(TEMPLATE_DOMAIN_WEB .'landing.html');

			if($y>51&&$y<92){
				$y='19'.$y;

				$inputdate = date('m/d/Y',strtotime($y.'-'.$m.'-'.$d));
				$birthDate = explode("/", $inputdate);
				$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")? ((date("Y") - $birthDate[2]) - 1): (date("Y") - $birthDate[2]));
			}else{
				return $this->View->toString(TEMPLATE_DOMAIN_WEB .'landing.html');
			}


			if($age>=21) {
				$_SESSION['start'] = time();
				if(!isset($_SESSION['expire'])){
			        $_SESSION['expire'] = $_SESSION['start'] + (1* 180) ; // ending a session in 30 seconds
			    }
			   
			}

		}

		if(!isset($_SESSION['expire'])){
			return $this->View->toString(TEMPLATE_DOMAIN_WEB .'landing.html');
		}else{
			if($now > $_SESSION['expire']){
				session_destroy();
				return $this->View->toString(TEMPLATE_DOMAIN_WEB .'landing.html');
			}else{
				return $this->View->toString(TEMPLATE_DOMAIN_WEB .'home.html');
			}
		}

		
		 
		
	}
}
?>