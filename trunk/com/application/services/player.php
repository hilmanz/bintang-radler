<?php
class player  extends ServiceAPI{
			

	function beforeFilter(){
		$this->playerSubmitHelper = $this->useHelper('playerSubmitHelper');
		global $LOCALE,$CONFIG;	
		if($this->isUserOnline())  {
			$this->user = $this->getUserOnline();	
		}
	}
	
	function lists(){
		//pr($this->user);exit;
		$startPage = strip_tags($this->_p('start'));
		$orderBy = strip_tags($this->_p('orderBy'));
		$orderType = strip_tags($this->_p('orderType'));
		$from = strip_tags($this->_p('fromDate'));
		$to = strip_tags($this->_p('toDate'));
		$username = strip_tags($this->_p('username'));
		$detail = strip_tags($this->_p('detail'));

		$response = $this->playerSubmitHelper->getPlayerLogs($orderBy,$orderType,$from,$to,$startPage,10,$username,$detail);
	
		return $response;
	}

	function add(){
		$response = $this->playerSubmitHelper->setPlayerLogs();
		return $response;
	}
	function getUID(){
		$response = $this->playerSubmitHelper->getUserID();
		return $response;
	}
}
?>
