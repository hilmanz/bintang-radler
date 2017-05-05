<?php
class gallery extends App{
	
	function beforeFilter(){
 		
		global $LOCALE,$CONFIG;
		$this->assign('basedomain',$CONFIG['BASE_DOMAIN']); 
		$this->flavourHelper = $this->useHelper("flavourHelper");
	}
	
	function main(){ 
		
		$gallery = $this->flavourHelper->galleryFlavour(array());
		//pr($gallery)
		$this->assign('gallery',$gallery); 

		if(strip_tags($this->_g('page'))=='gallery') $this->log('surf','gallery');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/gallery-list.html');		
	}

	function detail(){
		$userid = intval($this->_g('userid'));
		$flavorid = intval($this->_g('flavorid'));
		$statusLoginFB =0;
		if(@$this->uid)
		{
			$statusLoginFB =1;
		}
		
		if(!$flavorid){
			sendRedirect("{$CONFIG['BASE_DOMAIN']}gallery");
			return $this->out(TEMPLATE_DOMAIN_WEB . '/login_message.html');
			die();
		}

		$gallery_detail = $this->flavourHelper->listadedflavor($flavorid,$userid);
		$prevflavor = $this->flavourHelper->prevFlavour($flavorid);
		$nextflavor = $this->flavourHelper->nextFlavour($flavorid);
		$this->assign('flavour',$gallery_detail);
		$this->assign('prevflavor',$prevflavor);
		$this->assign('nextflavor',$nextflavor);
		$this->assign('statusLoginFB',$statusLoginFB); 
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'apps/gallery-detail.html');
	
	}

	function ajaxPaging(){
		$start = intval($this->_g('start'));
		
		$gallery = $this->flavourHelper->galleryFlavour(array('start'=>$start));

		if($gallery){
			echo json_encode($gallery);
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;

	}
	
}
?>
