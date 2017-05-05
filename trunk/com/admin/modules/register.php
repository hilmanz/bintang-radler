<?php
class register extends App{
		
	function beforeFilter(){ 
		global $LOCALE,$CONFIG; 
		$this->registerHelper = $this->useHelper("registerHelper");
		
		$this->assign('basedomain', $CONFIG['DASHBOARD_DOMAIN']);
		$this->assign('basedomainpath', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('locale', $LOCALE[1]);
		$this->assign('user', $this->user);
		$this->assign('tokenize',gettokenize(5000*60,$this->user->id));		
		
		$roleList = $this->registerHelper->roleList(); 
		$this->assign('roleList',$roleList);
		
		$brandList = $this->registerHelper->brandList(); 
		$this->assign('brandList',$brandList);
		
		$cityList = $this->registerHelper->cityList(); 
		$this->assign('city',$cityList);
	
	}
	
	 
	function main(){
		$registerList = $this->registerHelper->registerList($start=null,$limit=10);	
		// pr($registerList);
		$time['time'] = '%H:%M:%S';
		
		$this->assign('total',intval($registerList['total']));
		$this->assign('list',$registerList['result']);
		$this->assign('time',$time);
		$this->assign('notiftype',intval($this->_p('notiftype')));
		$this->assign('publishedtype',intval($this->_p('publishedtype')));
		$this->assign('search',strip_tags($this->_p('search')));
		$this->assign('startdate',$this->_p('startdate'));
		$this->assign('enddate',$this->_p('enddate'));
		$this->log('surf','register');
		
		
		return $this->View->toString(TEMPLATE_DOMAIN_DASHBOARD .'widgets/register-user-lists.html');
		
		
		
	}
	function hapus(){
		global $CONFIG;
	
		$cidStr = intval($this->_request('id'));
		
		$result = $this->registerHelper->getHapus($cidStr);
		if($result) {
			sendRedirect($CONFIG['DASHBOARD_DOMAIN']."register");
			exit;
		}
	}
	
	function doregister(){
		global $CONFIG;
		  
	if ($this->_p('submit')){
		// pr($_FILES);exit;
		// insert data dulu 
			
			$insertnewdata = $this->registerHelper->insertnewdata();
			if($insertnewdata)
			{
				$updateEvent = $this->registerHelper->yoidata($insertnewdata);
				$this->log('surf',"insert register");
				sendRedirect($CONFIG['DASHBOARD_DOMAIN']."register");
			}
			

		} 
	
		
		return $this->View->toString(TEMPLATE_DOMAIN_DASHBOARD .'apps/create-user.html');

		
		
	}
	function registeredit()
	{
		global $CONFIG;
		
		
		$id = intval($this->_request('id'));
		if($this->_p('editit')=='ok'){ 
			
			// pr($_FILES);
			// exit;
	
		
			$updatethedata = $this->registerHelper->updatethedata($id);  
			
			// exit;
			if($updatethedata==true){
				sendRedirect($CONFIG['DASHBOARD_DOMAIN']."register");
				exit;
			}
		}	
		$selectupdatedata = $this->registerHelper->selectupdatedata($id);
		// pr($selectupdatedata);
		$this->assign('selectupdatedata',$selectupdatedata); 
		
		return $this->View->toString(TEMPLATE_DOMAIN_DASHBOARD .'apps/register-edit.html');
	}
	
	
	

	function ajax(){
		$orderType = strip_tags($this->_p('orderType'));
		$orderBy = strip_tags($this->_p('orderBy'));
		$start = strip_tags($this->_p('start'));
		$search = strip_tags($this->_p('search'));
		if($search=="") $search=null;
		$limit = 20;
		$res = $this->registerHelper->userlists($orderBy,$orderType,$start,$limit,$search);
		print json_encode($res);exit;
	}
	
	function edit(){
		
		$res = $this->registerHelper->userlists();
		if($res){
			foreach($res as $key => $val){
				$this->assign($key,$val);
			}
		}
		return $this->View->toString(TEMPLATE_DOMAIN_DASHBOARD .'apps/edit-user.html');
	}
	
	function unusers(){
		global $CONFIG;
	
		$res = $this->registerHelper->unusers();
		sendRedirect( $CONFIG['BASE_DOMAIN']."register");
		exit;
	}
}
?>