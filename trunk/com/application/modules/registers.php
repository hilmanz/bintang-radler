<?php
class register extends App{
		
	function beforeFilter(){
		$this->registerHelper = $this->useHelper('registerHelper');
	
	}
	
	function main(){
		global $CONFIG,$logger;
		$basedomain = $CONFIG['BASE_DOMAIN'];
		$this->assign('basedomain',$basedomain);
		$this->log('globalAction','LOGIN');
		$res = $this->registerHelper->registerPhase();
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/register-input.html');
	}
	
}
?>