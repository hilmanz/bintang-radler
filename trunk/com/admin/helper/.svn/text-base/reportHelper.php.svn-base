<?php 

class reportHelper {

	function __construct($apps){
		global $CONFIG,$logger;
		$this->logger = $logger;
		$this->apps = $apps;
		if(is_object($this->apps->user)) $this->uid = intval($this->apps->user->id);

		$this->dbshemaWeb =$CONFIG['DATABASE'][0]['DATABASE'];	
		$this->dbshema =$CONFIG['DATABASE'][0]['DATABASE'];	
	} 
	
	function soursallyreportlist($start=null,$limit=20,$limitstatus=true){
		global $CONFIG;
		// pr('masuk');
		$start = intval($this->apps->_g('start'));
		$n_status = $this->apps->_g('n_status');
		if($n_status =='') $n_status = -1;
		$result['result'] = false;
		$result['total'] = 0;
		
		if($start==null)$start = intval($this->apps->_request('start'));
		$limit = intval($limit);
				
		$qDate = "";
		$startdate = strip_tags($this->apps->_g('enddate'));
		$enddate = strip_tags($this->apps->_g('startdate'));
		
		if($startdate) $startdate = date("Y-m-d",strtotime($startdate));
		if($enddate) $enddate = date("Y-m-d",strtotime($enddate));
		
		$qLimit = " LIMIT {$start},{$limit}";
		if($limitstatus==false) $qLimit = " ";
		if(!$enddate) if($startdate)  $enddate = date("Y-m-d",strtotime($startdate. "+7 day"));
		
		if($startdate&&$enddate){
		
		 
			$qDate = " AND DATE(rd.register_date) >= DATE('{$startdate}') AND DATE(rd.register_date) <= DATE('{$enddate}') ";
		}
		
		//GET TOTAL
		$sql = "SELECT COUNT(1) total FROM (SELECT uf.id
				FROM user_flavors uf
				LEFT JOIN social_member sm ON uf.userid = sm.id
				LEFT JOIN user_votes uv ON uv.usr_flavor_id = uf.id) sub";
		// pr($sql);
		$total = $this->apps->fetch($sql);	
		// pr($sql);	
		// pr($total);	
		if(intval($total['total'])<=$limit) $start = 0;
			// pr($total);
		$sql = "SELECT MAX(uv.voted_date) AS voted_date,MAX(ul.voted_date) AS liked_date, uf.datetimes, uf.name AS flavor_name, uf.id, uf.flavor_list, uf.flavor_img, uf.n_status, sm.name, sm.last_name,
				SUM(IF(uv.n_status=1,1,0)) AS vote_count,
				SUM(IF(ul.n_status=1,1,0)) AS vote_like
				FROM user_flavors uf
				LEFT JOIN social_member sm ON uf.userid = sm.id
				LEFT JOIN user_votes uv ON uv.usr_flavor_id = uf.id
				LEFT JOIN user_likes ul ON ul.usr_flavor_id = uf.id
				GROUP BY uf.id
				ORDER BY vote_like DESC
				{$qLimit} ";
		$qData = $this->apps->fetch($sql,1);
		// pr($sql);
		$this->logger->log($sql);
		$start=$start+1;
		$no = 0+$start;
		if($qData){
			foreach($qData as $key => $val){
				$qData[$key]['no'] = $no++;
				$qData[$key]['link_img'] = $CONFIG['BASE_DOMAIN'].'public_assets/yoggy/'.$val['flavor_img'];
			 	$qData[$key]['datetimes'] = date('d/m/y H:i:s',strtotime($val['datetimes']));
			 	if($val['voted_date']){
					$qData[$key]['voted_date'] = date('d/m/y H:i:s',strtotime($val['voted_date']));
				}
				if($val['liked_date']){
					$qData[$key]['liked_date'] = date('d/m/y H:i:s',strtotime($val['liked_date']));
				}
				$flavor_list = unserialize($val['flavor_list']);
				$flavor_list = implode(',', $flavor_list);

				$sql = "SELECT * FROM flavour
						WHERE id IN ({$flavor_list}) LIMIT 4";
				//pr($sql);exit;
				$rs = $this->apps->fetch($sql,1);
				$arrange = array();
				foreach ($rs as $k => $value) {
					$arrange[$value['categories']] = $value['flavor_name'];
				}
				$qData[$key]['ingredient'] = $arrange;
			}
			// return $qData;
			$result['result'] = $qData;
			$result['total'] = intval($total['total']);
			//pr($result);exit;
			return $result;
		}
		return false;
	}

	function ajax(){ 
		
		$n_status = $this->apps->_p('n_status'); 
		$id = $this->apps->_p('id');
		
			$sql = "UPDATE user_flavors SET n_status = {$n_status} WHERE id = {$id}";
			// pr($sql);
			$qData = $this->apps->query($sql);
			if(!$qData) return false;
			
	}
	 
}

?>

