<?php
class about extends App{
	
	
	function beforeFilter(){
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);		
		$this->assign('locale', $LOCALE[1]);
		
	}
	
	function main(){
		
		
		if(strip_tags($this->_g('page'))=='about') $this->log('surf','about');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'apps/about.html');
		
	}
/*	function howto(){
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'apps/about-howto.html');
	
	}*/
	
}
?>