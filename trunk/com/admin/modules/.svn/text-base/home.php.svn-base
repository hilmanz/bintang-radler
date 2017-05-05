<?php
class home extends App{
	
	
	function beforeFilter(){
	  
		$this->reportHelper = $this->useHelper("reportHelper");
		
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['ADMIN_DOMAIN']);
		$this->assign('basedomainpath', $CONFIG['BASE_DOMAIN_PATH']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_ADMIN']);
				
		$this->assign('locale', $LOCALE[1]);
		$this->assign('startdate', $this->_g('startdate'));
		$this->assign('enddate', $this->_g('enddate'));
		
		$this->assign('pages', $this->_g('page'));
		$this->assign('acts', $this->_g('act')); 
		
		
	}
	
	function main(){
	
		$soursallyreportlist = $this->reportHelper->soursallyreportlist();
		// pr($soursallyreportlist);
		$this->assign("list", $soursallyreportlist['result']);
		$this->assign("total", $soursallyreportlist['total']);
		
		return $this->View->toString(TEMPLATE_DOMAIN_ADMIN .'apps/soursally-report.html');
		
	}
	
	function ajaxconfirmed()
	{
		
		$ajax = $this->reportHelper->ajax();
		// var_dump($ajax);
		
		if ($ajax){ 
			print json_encode(array('status'=>false));
		}else{ 
			print json_encode(array('status'=>true));
		}
		
		exit;
	}
	
	function ajaxPaging()
	{
		
		$start = intval($this->_g('start'));
		
		if ($this->_g('ajax')){
			$ajax = $this->reportHelper->soursallyreportlist($start);
		}
		// pr($ajax);
		if ($ajax){ 
			print json_encode(array('status'=>true, 'data'=>$ajax));
		}else{ 
			print json_encode(array('status'=>false));
		}
		
		exit;
	}
}
?>