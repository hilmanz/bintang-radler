<?php
class galleryList extends App{
	
	function beforeFilter(){
 		
		global $LOCALE,$CONFIG;
		$this->assign('basedomain',$CONFIG['BASE_DOMAIN']); 
		$this->galleryHelper = $this->useHelper("galleryHelper");
		$this->flavourHelper = $this->useHelper("flavourHelper");
		
	}
	
	function main(){ 
		
		$galleryfinalist = $this->galleryHelper->galleryfinalist();
		// pr($allGalleryList);
		$this->assign('galleryfinalist',$galleryfinalist);  
		
		if($this->_p('submit')){
			// pr($_POST);exit;
			$storevotedata = $this->flavourHelper->storevotedata();		
		
		}
		
		
		
		if(strip_tags($this->_g('page'))=='galleryfinalist') $this->log('surf','galleryfinalist');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/gallery-finalist.html');		
	}
	
	function detail(){
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'apps/gallery-detail.html');
	
	}
	
}
?>
