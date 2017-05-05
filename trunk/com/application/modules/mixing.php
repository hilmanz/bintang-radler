<?php
class mixing extends App{
	
	function beforeFilter(){
 		
		global $LOCALE,$CONFIG;
		$this->assign('basedomain',$CONFIG['BASE_DOMAIN']); 
		$this->flavourHelper = $this->useHelper("flavourHelper");
		$this->uploadHelper = $this->useHelper("uploadHelper");
		
	}
	
	function main(){ 
		
		$flavour_list = $this->flavourHelper->flavorList();
		$this->assign('flavour',$flavour_list);

		if(strip_tags($this->_g('page'))=='mixing') $this->log('surf','mixing');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/mixing.html');		
	}


	function result(){
		global $CONFIG;

		$check_user = $this->flavourHelper->checkYoggyUser();
		//pr($check_user);exit;
		$statusLoginTwitter=0;
		if(@isset($this->session->getSession('twitter_session','twitter')->token))
			{
				$statusLoginTwitter=1;
			}
		if($check_user){
			$generateImg = $this->uploadHelper->yoggyImageGenerator();
			if($generateImg){
				$flavour = $this->flavourHelper->addthedata($generateImg['img_created']);
				//pr($flavour);exit;
				$this->assign('flavour',$flavour);
					$this->assign('statusLoginTwitter',$statusLoginTwitter);
			}else{
				sendRedirect("{$CONFIG['BASE_DOMAIN']}mixing");
				return $this->out(TEMPLATE_DOMAIN_WEB . '/login_message.html');
				die();
			}
		}else{
			sendRedirect("{$CONFIG['BASE_DOMAIN']}mixing");
			return $this->out(TEMPLATE_DOMAIN_WEB . '/login_message.html');
			die();
		}
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'apps/mixing-result.html');
	
	}
	
}
?>
