<?php
class finalists extends App{
	
	
	function beforeFilter(){
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);		
		$this->assign('locale', $LOCALE[1]);
		$this->galleryHelper = $this->useHelper("galleryHelper");
		$this->flavourHelper = $this->useHelper("flavourHelper");
		
	}
	
	function main(){
		$galleryfinalist = $this->galleryHelper->galleryfinalist();
		// pr($allGalleryList);
		$this->assign('galleryfinalist',$galleryfinalist);
		if(!isset($this->user->id)) $user = 0;
		else $user = $this->user->id;

		$this->assign('active',$user);  
		
		
		
		if(strip_tags($this->_g('page'))=='finalists') $this->log('surf','finalists');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'apps/gallery-finalist.html');
		
	}

	function save(){
		global $CONFIG;
		if($this->_p('submit')){
			
			$storevotedata = $this->flavourHelper->storevotedata();	
			
		
		}
		sendRedirect("{$CONFIG['BASE_DOMAIN']}finalists");
			return $this->out(TEMPLATE_DOMAIN_WEB . '/login_message.html');
			die();	
	}
	
}
?>