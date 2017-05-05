<?php 

class playerSubmitHelper{

	function __construct($apps){
		global $logger,$CONFIG;
		$this->logger = $logger;
		$this->apps = $apps;
		$this->user = $this->apps->getUserOnline();
		$this->user = $this->user->leaderdetail;
	}

	function getUserID(){
		if($this->uid==0){
			return array('status'=>0,'message'=>"Please Login first.");exit;
		}else{
			return array('status'=>1,'message'=>'OK','data'=> array('user_id'=>$this->uid,'survey_date'=>date("YmdHi")));exit;
		}
	}
	
	function getPlayerLogs($orderBy=0,$orderType=0,$from=null,$to=null,$startPage=0,$limit=10,$search=null,$detail=null){
		global $logger,$CONFIG;
		
		$filterType='';
		//pr($this->user);exit;
		switch ($this->user->type) {
			case '7':
				$filterType="AND sm.deviceid = '{$this->user->description}'";
				break;
			case '2':
				$filterType="AND sm.deviceid = '{$this->user->description}'";
				break;
			case '5':
				$filterType="AND sm.deviceid = '{$this->user->description}'";
				break;
			case '100':
				$filterType='';
				break;
			
			default:
				# code...
				break;
		}


		//filter
		$filter="WHERE 1";
		if($search!=null){
			if($search!=''&&$search!='all'){
				$filter="WHERE (bpl.username LIKE '%{$search}%' OR sm.name LIKE '%{$search}%')";
			}
		}
		$filter2="";
		if($from!=null && $to!=null){
			if($from!='null'&&$to!='null'){
				$filter2 = "AND bpl.submit_date BETWEEN '{$from} 00:00:00'AND '{$to} 23:59:59'";
			}
		}
		$limitFilter="";
		if($limit!='all'){
			$limitFilter="LIMIT {$startPage},{$limit}";
		}

		if($orderType==0){
			$orderType="DESC";
		}else{
			$orderType="ASC";
		}

		switch($orderBy){
			case 'date':
				$orderBy = 'submit_date';
				break;
			case 'play_date':
				$orderBy = 'playing_date';
				break;
			case 'name':
				$orderBy = 'ba_name';
				break;
			case 'username':
				$orderBy = 'bpl.username';
				break;
			case 'play':
				$orderBy = 'play';
				break;
			case 'win':
				$orderBy = 'win';
				break;
			case 'lose':
				$orderBy = 'lose';
				break;
			default:
				$orderBy = 'submit_date';

		}
		//pr($detail);exit;
		if($detail!=true){
			$sql = "SELECT DATE_FORMAT(MAX(bpl.submit_date),'%d/%m/%Y %H:%i:%s') AS submit_date, 
							COUNT(bpl.username) AS play, 
							SUM(bpl.play_status) AS win,
							SUM(IF(bpl.play_status, 0, 1)) AS lose,
							MAX(bpl.submit_date_ts) AS submit_date_ts, 
							bpl.username, sm.name AS ba_name
					FROM ba_player_logs bpl
					LEFT JOIN social_member sm ON bpl.username = sm.username
					{$filter} {$filter2} {$filterType}
					GROUP BY bpl.username
					ORDER BY {$orderBy} {$orderType}
					{$limitFilter}";	
			//pr($sql);exit;
			$this->logger->log($sql);
			$qData = $this->apps->fetch($sql,1);

			//pr($sql);exit;
			if($qData){
				$sql = "SELECT COUNT(DISTINCT bpl.username) total
						FROM ba_player_logs bpl
					LEFT JOIN social_member sm ON bpl.username = sm.username
						{$filter} {$filter2} {$filterType}";	
				$qDataTotal = $this->apps->fetch($sql);
				return array('data'=>$qData,'total'=>$qDataTotal['total']);
			}else{
				return array('data'=>null,'total'=>0);
			}
		}else{
			$sql = "SELECT DATE_FORMAT(bpl.submit_date,'%d/%m/%Y %H:%i:%s') AS submit_date, 
							DATE_FORMAT(bpl.playing_date,'%d/%m/%Y %H:%i:%s') AS playing_date, 
							bpl.play_status AS win,
							IF(bpl.play_status, 0, 1) AS lose,
							bpl.submit_date_ts AS submit_date_ts, 
							bpl.username, sm.name AS ba_name
					FROM ba_player_logs bpl
					LEFT JOIN social_member sm ON bpl.username = sm.username
					{$filter} {$filter2}
					ORDER BY {$orderBy} {$orderType}
					{$limitFilter}";
			//pr($sql);exit;
			$this->logger->log($sql);
			$qData = $this->apps->fetch($sql,1);

			if($qData){
				$sql = "SELECT COUNT(bpl.username) total
						FROM ba_player_logs bpl
					LEFT JOIN social_member sm ON bpl.username = sm.username
						{$filter} {$filter2}";	
				$qDataTotal = $this->apps->fetch($sql);
				return array('data'=>$qData,'total'=>$qDataTotal['total']);
			}else{
				return array('data'=>null,'total'=>0);
			}	
		}
	}

	function setPlayerLogs(){
		global $logger,$CONFIG;
		$salt = "InOrOut_Game";
		$token = strip_tags($this->apps->_p('token'));
		//$token = sha1("terra"."true{".$salt."}");
		$username = strip_tags($this->apps->_p('username'));
		$play_status = intval(strip_tags($this->apps->_p('play_status')));
		$this->logger->log($this->apps->_p('play_date'));
		$playing_date_ts = $this->apps->_p('play_date');
		$playing_date = date("Y-m-d H:i:s",$this->apps->_p('play_date')/1000);
		$submit_date = date("Y-m-d H:i:s");
		$submit_date_ts = (strtotime($submit_date) * 1000);
		/*$this->logger->log(date('Y-m-d H:s:i',$submit_date_ts/1000));
		$this->logger->log(date('Y-m-d H:s:i',$playing_date_ts/1000));*/
		
		if(!$token){ 
			$this->logger->log('Access token is not found.');
			return array('status'=>0,'message'=>'Access token is not found.');exit;
		}
		$sql = "SELECT * FROM social_member WHERE username='{$username}' LIMIT 1";
		$rs = $this->apps->fetch($sql);
		
		if(!$rs){
			$this->logger->log('BA is not registered');
			return array('status'=>0,'message'=>'BA is not registered.');exit;
		}	

		/* token matching with erwin */
		$mytoken = sha1($username."true{".$salt."}");
		
		if($token!=$mytoken) {
			$this->logger->log('token miss match');
			return array('status'=>0,'message'=>'Your token is not match.');exit;
		}
			$sql="INSERT INTO ba_player_logs
					(username,submit_date,submit_date_ts,play_status,playing_date,playing_date_ts)
				VALUES (
						'{$username}',
						'{$submit_date}',
						{$submit_date_ts},
						{$play_status},
						'{$playing_date}','{$playing_date_ts}')";
			$this->apps->query($sql);
			//pr($sql);exit;
			$this->logger->log($sql);
			if($this->apps->getLastInsertId()){
				return array('status'=>1,'message'=>"BA player data has been saved.");
			}else return false;
		
	}
}

?>
