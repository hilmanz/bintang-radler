<?php 
class settings extends App{

	function beforeFilter(){
		global $LOCALE,$CONFIG;
		
		$this->settinghelper = $this->useHelper('settinghelper');
		$this->uploadHelper = $this->useHelper('uploadHelper');
		
		$this->assign('basedomain', $CONFIG['ADMIN_DOMAIN']);
		$this->assign('basedomainpath', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_ADMIN']);
		$this->assign('locale', $LOCALE[1]);		
		$this->assign('pages', strip_tags($this->_g('page')));
		$this->assign('projects', intval($this->_g('projects')));
		$this->assign('user',$this->user);
	}
	
	function main(){
	
		$projectList = $this->settinghelper->projectList();
		// pr($sdklisttemplate);
		$this->assign('projectList',$projectList);
		
		$this->log('surf','registrant_management');
		return $this->View->toString(TEMPLATE_DOMAIN_ADMIN .'/apps/project-list.html');
		 
	}
		
	function designs()
	{
		global $CONFIG; 
	 
				$datatemplate= $this->settinghelper->getDesign();
		 
				$this->assign('brandid',$this->_g('brand'));
				$this->assign('datacustomize',$datatemplate);
		 
		
		return $this->View->toString(TEMPLATE_DOMAIN_ADMIN .'apps/template-generator.html');
	 
	}
	
	function savedesign()
	{
		global $CONFIG; 
	 
		$data['result'] = false;
		$data['message'] = "halt!!";
		$data['filename']='';
			$images = array();
			$filenames = false;
			$brand = $this->_p('brand');
			$sections = $this->_p('sections');
		 
		
			// $path = $CONFIG['BASE_DOMAIN_PATH']."public_html/public_assets/content/{$sections}/";
			
			$path = $CONFIG['LOCAL_PUBLIC_ASSET']."content/{$sections}/";
			
			if(isset($_FILES['images'])&&$_FILES['images']['name']!=NULL) {
				if (isset($_FILES['images'])&&$_FILES['images']['size'] <= 20000000) {
						  
						$images = $this->uploadHelper->uploadThisImage($_FILES['images'],$path);
					 
						
						$filenames= $images['arrImage']['filename'];
						$data['filename']= $CONFIG['BASE_DOMAIN_PATH']."public_html/public_assets/content/{$sections}/{$images['arrImage']['filename']}";
										
				}
			}
			
			// exit;
			
			$result = $this->settinghelper->updateDesignRow($filenames);
			if($result){
				$data['result'] = true;
				$data['message'] = 'success';
			}
		 
		 
		
		echo json_encode($data);
		exit;
	 
	}

 
	
	function addRowDesign(){
	 
	global $CONFIG;
		$data['result'] = false;
		$data['message'] = "halt!!";
		$data['filename']='';
			$images = array();
			$filenames = false;
			$brand = $this->_p('brand');
			$sections = $this->_p('sections');
		 
		
			// $path = $CONFIG['BASE_DOMAIN_PATH']."public_html/public_assets/content/{$sections}/";
			
			$path = $CONFIG['LOCAL_PUBLIC_ASSET']."content/{$sections}/";
			
			if(isset($_FILES['images'])&&$_FILES['images']['name']!=NULL) {
				if (isset($_FILES['images'])&&$_FILES['images']['size'] <= 20000000) {
						  
						$images = $this->uploadHelper->uploadThisImage($_FILES['images'],$path);
					 
						
						$filenames= $images['arrImage']['filename'];
						$data['filename']= $CONFIG['BASE_DOMAIN_PATH']."public_html/public_assets/content/{$sections}/{$images['arrImage']['filename']}";
										
				}
			}
			
			// exit;
			
			$result = $this->settinghelper->addDesignRow($filenames);
			if($result){
				$data['result'] = true;
				$data['message'] = 'success';
			}
		 
		echo json_encode($data);
		exit;
	
	}
	
	
	function clearDesign(){
	$data['result'] = false;
		$data['message'] = "halt!!";
		$result = $this->settinghelper->unplublishDesign();
		if($result){
				$data['result'] = true;
				$data['message'] = 'success delete design';
			}
		 
		echo json_encode($data);
		exit;
		
	}
	function activateDesign(){
	$data['result'] = false;
		$data['message'] = "halt!!";
		$result = $this->settinghelper->plublishDesign();
		if($result){
				$data['result'] = true;
				$data['message'] = 'success activated design';
			}
		 
		echo json_encode($data);
		exit;
		
	}
	
	function trashDesign(){
	$data['result'] = false;
		$data['message'] = "halt!!";
		$result = $this->settinghelper->trashDesign();
		if($result){
				$data['result'] = true;
				$data['message'] = 'success trashing design';
			}
		 
		echo json_encode($data);
		exit;
		
	}
	
	
}
?>