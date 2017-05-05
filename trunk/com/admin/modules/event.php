<?php
class event extends App{

	function beforeFilter(){
		global $LOCALE,$CONFIG;
		
		$this->sdkHelper = $this->useHelper('sdkHelper');
		$this->sdkEventHelper = $this->useHelper('sdkEventHelper');
		$this->eventHelper = $this->useHelper('eventHelper');
		$this->uploadHelper = $this->useHelper('uploadHelper');
		
		$this->assign('basedomain', $CONFIG['ADMIN_DOMAIN']);
		$this->assign('basedomainpath', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_ADMIN']);
		$this->assign('locale', $LOCALE[1]);		
		$this->assign('pages', strip_tags($this->_g('page')));
		$this->assign('user',$this->user);
	}
	
	function main(){
	
		$brandlist = $this->sdkEventHelper->brandlist();
		// pr($brandlist);
		$this->assign('brandlist',$brandlist);
	
		$this->log('surf','event');
		return $this->View->toString(TEMPLATE_DOMAIN_ADMIN .'/apps/event-list.html');
		// return $this->View->toString(TEMPLATE_DOMAIN_ADMIN .'/apps/sdk-pages.html');
	}
	
	function dataevent(){
	
		$eventlist = $this->sdkEventHelper->eventlist();
		// pr($eventlist);
		$this->assign('eventlist',$eventlist);
	
		$this->log('surf','event');
		return $this->View->toString(TEMPLATE_DOMAIN_ADMIN .'/apps/event-detail.html');
		
	}
	
	function listflowevent(){
	
		$flowlist = $this->sdkEventHelper->flowlist();
		// pr($flowlist);
		$this->assign('flowlist',$flowlist);
	
		$this->log('surf','event');
		return $this->View->toString(TEMPLATE_DOMAIN_ADMIN .'/apps/event-flow.html');
		
	}
	
	function createflowevent(){
	
		// pr($_GET);
		
		$flowid = $this->_g('flowid');
		
		if ($this->_p('submit')){
	
		// insert data dulu 
			$images = $_FILES['images'];
			$updatelistevent = $this->sdkEventHelper->updatelistevent();
			
			if($updatelistevent){
				$path = $CONFIG['LOCAL_PUBLIC_ASSET']."event/";
				// upload image dulu
				$uploadevent = $this->uploadHelper->uploadThisImage($images,$path);
				
				// update data
				$eventimageupdate = $this->sdkEventHelper->eventimageupdate($updatelistevent,$uploadevent['arrImage']['filename']);
				// $this->log('surf',"insert sdk templates");
				sendRedirect($CONFIG['ADMIN_DOMAIN']."event");
			}

		}else{
		
			$createlist = $this->sdkEventHelper->createlist();
			
			$this->assign('createlist',$createlist);
			$this->assign('flowid',$flowid);
		}
		
		return $this->View->toString(TEMPLATE_DOMAIN_ADMIN .'/apps/event-createFlow.html');
		
	}
		
	function addnewevent(){
	
		$this->log('surf','event');
		return $this->View->toString(TEMPLATE_DOMAIN_ADMIN .'/apps/event-add.html');
		
	}
		
	function newDataInput()
	{
		global $CONFIG; 
		if ($this->_p('input')==1){
		
			$uploadnews = array();
			
			$brand = $this->_p('brand');
			if($brand==4) $brandname = 'amild';
			else $brandname = 'marlboro';
		
			$path = $CONFIG['LOCAL_PUBLIC_ASSET']."sdk/";
			
			if ($_FILES){
				foreach ($_FILES as $key=>$val){
					// pr($val);
					if (!empty($val['name'])){
						
						$uploadnews = $this->uploadHelper->uploadThisImage($_FILES[$key],$path);
						
						$data['filename'] = $uploadnews['arrImage']['filename'];
						$data['brand'] = $brand;
						$data['brandname'] = $brandname;
						$data['sections'] = $key;
						// pr($data);
						$updateImage = $this->sdkHelper->updateImage($data);
					}
					
					
				}
			}
			
			// exit;
			
			$insertnewsupdate = $this->sdkHelper->insertnewsupdate();
			
			if($insertnewsupdate){
				
				// update data
				$updateEvent = $this->sdkHelper->newsupdate($insertnewsupdate,$uploadnews['arrImage']['filename']);
				$this->log('surf',"insert sdk");
				sendRedirect($CONFIG['ADMIN_DOMAIN']."sdk");
			}
	
		}else{
				$datatemplate= $this->sdkHelper->getTemplates();
		 // pr($datatemplate);
				$this->assign('brandid',$this->_g('brand'));
				$this->assign('datacustomize',$datatemplate);
		}
		
		return $this->View->toString(TEMPLATE_DOMAIN_ADMIN .'apps/template-generator.html');
		// return $this->View->toString(TEMPLATE_DOMAIN_ADMIN .'apps/sdk-add.html');
	} 
	
	
}
?>