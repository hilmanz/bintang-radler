<?php
class registerHelper {
	
	var $_mainLayout="";
	
	var $login = false;
	
	function __construct($apps=false){
		global $logger,$CONFIG;
		$this->logger = $logger;
		$this->apps = $apps;
		$this->config = $CONFIG;
	}
	
	
	function registerPhase(){
		$ok = false;
		global $CONFIG;
		
		if($this->apps->_p('register')==1){
		
			$this->logger->log('can register');
			$reg = $this->doRegister();
			return $reg;
		}
		$this->logger->log('can not register');
		return false;
	}
	
	
	function roleList()
	{
		global $CONFIG;
		$rolelist = "
		SELECT * FROM {$CONFIG['DATABASE'][0]['DATABASE']}.my_profile_type";
			//pr($sql);exit;
		// pr($sql);
		$rqData = $this->apps->fetch($rolelist,1);
	
		return $rqData;
		
	}
	
		function brandList()
	{
		global $CONFIG;
		$brandlist = "
		SELECT * FROM {$CONFIG['DATABASE'][0]['DATABASE']}.tbl_brand_master";
			//pr($sql);exit;
		// pr($sql);
		$brandData = $this->apps->fetch($brandlist,1);
	
		return $brandData;
		
	}
			function cityList()
	{
		global $CONFIG;
		$citylist = "
		SELECT * FROM {$CONFIG['DATABASE'][0]['DATABASE']}.city_reference";
			//pr($sql);exit;
		// pr($sql);
		$cityData = $this->apps->fetch($citylist,1);
	
		return $cityData;
		
	}
	
	
	
	function registerList($start=null,$limit=10)
	{
		global $CONFIG;
		
		$result['result'] = false;
		$result['total'] = 0;
		
		if($start==null)$start = intval($this->apps->_request('start'));
		$limit = intval($limit);
		
		$search = strip_tags($this->apps->_p('search'));
		$notiftype = intval($this->apps->_p('notiftype'));
		// $publishedtype = intval($this->apps->_p('publishedtype'));
		$startdate = $this->apps->_p('startdate');
		$enddate = $this->apps->_p('enddate');
		
		//RUN FILTER
		$filter = "";
		$filter = $search=="Search..." ? "" : "AND (name LIKE '%{$search}%' )";
		// $filter .= $notiftype!=0 ? " AND notiftype = {$notiftype}" : " AND notiftype = 3";
		// $filter .= $publishedtype ? "AND n_status = {$publishedtype}" : " AND n_status != 3";
		$filter .= $startdate ? " AND postdate >= '{$startdate}'" : "";
		$filter .= $enddate ? " AND postdate < '{$enddate}'" : "";
		
		//GET TOTAL
		$sql = "SELECT count(*) total FROM {$CONFIG['DATABASE'][0]['DATABASE']}.social_member";
		$total = $this->apps->fetch($sql);		
		
	//pr($sql);exit;
		if(intval($total['total'])<=$limit) $start = 0;
		
		//GET LIST
		$sql = "
SELECT *,social_member.name as nama FROM {$CONFIG['DATABASE'][0]['DATABASE']}.social_member 
LEFT JOIN {$CONFIG['DATABASE'][0]['DATABASE']}.my_profile ON {$CONFIG['DATABASE'][0]['DATABASE']}.social_member.id={$CONFIG['DATABASE'][0]['DATABASE']}.my_profile.ownerid 
LEFT JOIN {$CONFIG['DATABASE'][0]['DATABASE']}.city_reference ON {$CONFIG['DATABASE'][0]['DATABASE']}.my_profile.city={$CONFIG['DATABASE'][0]['DATABASE']}.city_reference.id 
LEFT JOIN {$CONFIG['DATABASE'][0]['DATABASE']}.tbl_brand_master ON {$CONFIG['DATABASE'][0]['DATABASE']}.my_profile.brand={$CONFIG['DATABASE'][0]['DATABASE']}.tbl_brand_master.id 
LEFT JOIN {$CONFIG['DATABASE'][0]['DATABASE']}.my_profile_type ON {$CONFIG['DATABASE'][0]['DATABASE']}.my_profile.type={$CONFIG['DATABASE'][0]['DATABASE']}.my_profile_type.id 
ORDER BY {$CONFIG['DATABASE'][0]['DATABASE']}.social_member.id DESC,{$CONFIG['DATABASE'][0]['DATABASE']}.social_member.id DESC LIMIT {$start},{$limit}
	
	"; 
		// pr($sql);
		$rqData = $this->apps->fetch($sql,1);
		if($rqData) {
			$no = $start+1;
			foreach($rqData as $key => $val){
				$val['no'] = $no++;
				$rqData[$key] = $val;
			}
			
			if($rqData) $qData=	$rqData;
			else $qData = false;
		} else $qData = false;
		
		$result['result'] = $qData;
		$result['total'] = intval($total['total']);
		return $result;
	}
	
	function getHapus($cid){
		global $CONFIG;
		
		if($cid){
			$sql = "delete social_member,my_profile FROM social_member LEFT JOIN my_profile ON social_member.id=my_profile.ownerid  WHERE social_member.id={$cid} ";
	
			//pr($sql);exit;
			$qdata  =  $this->apps->query($sql);

					if ($qdata) $data = true;
			else $data = false;
		}else {
			$data = false;	
		}
		return $data;		
	}
	protected function encrypt($string)
	{	
		$ENC_KEY='youknowwho2014';
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($ENC_KEY), $string, MCRYPT_MODE_CBC, md5(md5($ENC_KEY))));
	}
		protected function decrypt($encrypted)
	{
		$ENC_KEY='youknowwho2014';
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($ENC_KEY), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($ENC_KEY))), "\0");
	}
	function insertnewdata(){
		
		$password = trim($this->apps->_p('password'));
		$repassword = $this->apps->_p('repassword');
			global $CONFIG;
		//pr($_POST);
		$role = $this->apps->_p('role'); 
		$o_brand = $this->apps->_p('brandsubid');   
		$area_l = $this->apps->_p('areaid');   
		$name = $this->apps->_p('name');       
		$nickname = $this->apps->_p('nickname');  
		$username = $this->apps->_p('username');  
		

		$brand = $this->apps->_p('brandid');  
		$city = $this->apps->_p('city');  
		$pl = $this->apps->_p('otherid'); 
		$last_name = $this->apps->_p('lastname');  
		$gender = $this->apps->_p('sex');  
		$email = $this->apps->_p('email'); 
	
		$master = $this->apps->_p('masterrole');  
		$created_date = date("Y-m-d H:i:s");
		$closed_date = date("Y-m-d H:i:s");
		
		$saltnya='12345678';
		
		$hash = $this->encrypt($password);
		
		if ($password==!NULL&&$name==!NULL)
		{
			if ($password==$repassword)
		{
	
	
		$submit = $this->apps->_p('submit');
		// var_dump($submit);
	
		if($submit){
			$sql1 = "INSERT INTO {$CONFIG['DATABASE'][0]['DATABASE']}.social_member (`name`, `nickname`,`email`,`username`,`sex`,`last_name`,`salt`,`password`) 
					VALUES ('{$name}', '{$nickname}', '{$email}','{$username}','{$gender}','{$last_name}','{$saltnya}','{$hash}')";
		  
			$res = $this->apps->query($sql1);
			$lastID = $this->apps->getLastInsertId();
			if($lastID>0)  { 
				$sql2 = "INSERT INTO {$CONFIG['DATABASE'][0]['DATABASE']}.my_profile (`name`, `created_date`,`closed_date`,`type`,`brand`,`city`,ownerid) 
					VALUES ('{$name}', '{$created_date}', '{$closed_date}', '{$role}', '{$o_brand}', '{$city}', '{$lastID}')";
				$res = $this->apps->query($sql2);
			}
			return $this->apps->getLastInsertId();
		}
		
		return false;
		
		}
		
		else 
		{
			?>
			<script>
						alert("Mohon Retype Password Dengan Benar");
			</script>
			
			<?php
		}
		}
		else {
			?>
			<script>
						alert("Mohon Input Data dengan Benar");
			</script>
			
			<?php
		}
		
		
	}
	
	
	
	
	//add query setelah insert data awal , compare sama email , Insert data Baru
	function yoidata($insertnewdata=false)
	{
		global $CONFIG;
		//update
		// pr($images); exit;
		if (!$insertnewdata) return false;
		
		
		
			$sql3 = "SELECT * FROM {$CONFIG['DATABASE'][0]['DATABASE']}.social_member order by id desc limit 1 ";
			$qData = $this->apps->fetch($sql3);		
		
			$sql4 = "UPDATE {$CONFIG['DATABASE'][0]['DATABASE']}.my_profile SET ownerid={$qData['id']} WHERE name ='{$qData['name']}' LIMIT 1"; 		
					
					
			$res = $this->apps->query($sql4);
			
		 return $res;
	}
	
	//untuk select data yang ada di social member dan my_profile
	function selectupdatedata($id=NULL)
	{
		
		global $CONFIG;
		$sql = "select * ,social_member.id as idola,social_member.name as nama
				FROM {$CONFIG['DATABASE'][0]['DATABASE']}.social_member LEFT JOIN 
				{$CONFIG['DATABASE'][0]['DATABASE']}.my_profile ON {$CONFIG['DATABASE'][0]['DATABASE']}.social_member.id={$CONFIG['DATABASE'][0]['DATABASE']}.my_profile.ownerid
				where {$CONFIG['DATABASE'][0]['DATABASE']}.social_member.id={$id} 
				
				";
		
		// pr($sql);
		// fetch()
		$qData = $this->apps->fetch($sql);
		return $qData;
	
	}
	
	function updatethedata($id=NULL){
		global $CONFIG;
		//pr($_POST);
		$role = $this->apps->_p('role'); 
		$o_brand = $this->apps->_p('brandsubid');   
		$area_l = $this->apps->_p('areaid');   
		$name = $this->apps->_p('name');       
		$nickname = $this->apps->_p('nickname');  
		$username = $this->apps->_p('username');  
		$password = trim(strip_tags($this->apps->_p('password'))); 
		$brand = $this->apps->_p('brandid');  
		$city = $this->apps->_p('city');  
		$pl = $this->apps->_p('otherid'); 
		$last_name = $this->apps->_p('lastname');  
		$gender = $this->apps->_p('sex');  
		$email = $this->apps->_p('email'); 
		$repassword = $this->apps->_p('repassword');
		$master = $this->apps->_p('masterrole');  
		
		
		$created_date = date("Y-m-d H:i:s");
		$closed_date = date("Y-m-d H:i:s");
		
		
		$submit = $this->apps->_p('submit');
		// var_dump($submit);
				  
		$submit = $this->apps->_p('submit');
	
		if(isset($submit)){
		
			$sql = "UPDATE {$CONFIG['DATABASE'][0]['DATABASE']}.social_member SET `name` = '{$name}',`nickname`='{$nickname}',
					`username`='{$username}',`last_name`='{$last_name}',`sex`='{$gender}',email='{$email}' WHERE id = {$id} "; 
			$sql2 = "UPDATE {$CONFIG['DATABASE'][0]['DATABASE']}.my_profile SET `type`='{$role}',`brand`='{$o_brand}',`city`='{$city}',`n_status`='1' where ownerid= {$id} ";		

					
			$res = $this->apps->query($sql);
			$res = $this->apps->query($sql2);
			
			return $res;
		}
		
		return false;
	}
	
	

	function doRegister(){
		global $CONFIG;
		$this->logger->log('do register');
		
		
		 $notsaved = "not save";
		 $saved = "saved";
		// user stat
		$masterrole = intval($this->apps->_p('masterrole'));
		$name = strip_tags($this->apps->_p('name'));
		$last_name = strip_tags($this->apps->_p('lastname'));
		$nickname = strip_tags($this->apps->_p('nickname'));
		
		$password = trim(strip_tags($this->apps->_p('password')));
		$repassword = trim($this->apps->_p('repassword'));
		$nickname = strip_tags($this->apps->_p('name'));
		//if edit
		$edit = $this->apps->_p('edit');
		$email = null;
		$email = trim(strip_tags($this->apps->_p('email')));
		if($edit!=1){
			
			$username = strip_tags($this->apps->_p('username'));
		}
		$gender = trim(strip_tags($this->apps->_p('gender')));
		
		//page stat
		// 	ownerid 	name 	description 	type 	img 	otherid	brandid 	brandsubid 	areaid 	city 	created_date 	closed_date 	n_statu
		$role = explode("_",strip_tags($this->apps->_p('role')));
		$ownerid = intval($this->apps->_p('ownerid'));
		$rolesname = $name.' '.$last_name;
		$description = strip_tags($this->apps->_p('description'));
		$type =$role[1];
		$img = strip_tags($this->apps->_p('img'));
		$otherid = intval($this->apps->_p('otherid'));
		$brandid = intval($this->apps->_p('brandid'));
		$brandsubid = intval($this->apps->_p('brandsubid'));
		$areaid = intval($this->apps->_p('areaid'));
		$city = strip_tags($this->apps->_p('city'));
		$created_date = date("Y-m-d H:i:s");
		$closed_date = date("Y-m-d H:i:s");
		$n_status = 1;
		
		if($email==''||$email==null){
			$this->logger->log('form registration not complete.');
			return   "form registration not complete. email not found";
		}
			
		$hashPass = sha1($password.$CONFIG['salt']);
		$sql = "SELECT * FROM {$this->config['DATABASE'][0]['DATABASE']}.social_member WHERE email='{$email}' LIMIT 1 ";
		$qData = $this->apps->fetch($sql);
		
		if($qData){
			if($email==''||$email==null){
				$this->logger->log('form registration not complete.');
				return  "form registration not complete. email not found";
			}
			if($password!=''||$password!=null){
				if($password!=$repassword) {
					$this->logger->log('pass and re pass not match');
					return 'Please make sure confirm password is same as the password.';
				}else{
					$updatepass=",password='{$hashPass}'";
				}
			}

			$sql = "
				UPDATE {$this->config['DATABASE'][0]['DATABASE']}.social_member SET name='{$name}',gender='{$gender}',nickname='{$nickname}',last_name='{$last_name}' , n_status = 1,try_to_login=0{$updatepass}
					WHERE id = {$qData['id']} LIMIT 1				
				
			";
			//pr($sql);exit;
			$this->apps->query($sql);
			$sql = "SELECT ownerid FROM {$this->config['DATABASE'][0]['DATABASE']}.my_profile WHERE ownerid={$qData['id']} LIMIT 1 ";
			$rqData = $this->apps->fetch($sql);
			
			if($rqData){
				$dataupdate = false;
				if($rolesname!='') $dataupdate[] = "name='{$rolesname}'";
				if($type!='') $dataupdate[] = "type='{$type}'";
				if($img!='') $dataupdate[] = "img='{$img}'";
				if($otherid!='') $dataupdate[] = "otherid='{$otherid}'";
				$dataupdate[] = "brandid='{$brandid}'";
				$dataupdate[] = "brandsubid='{$brandsubid}'";
				if($areaid!='') $dataupdate[] = "areaid='{$areaid}'";
				if($city!='') $dataupdate[] = "city='{$city}'";
				if($masterrole!='') $dataupdate[] = "masterrole='{$masterrole}'";
				$qUpdateData = "";
				if($dataupdate){
					$qUpdateData = implode(',',$dataupdate);
				}else return $saved;
				



				$sql = "
						UPDATE {$this->config['DATABASE'][0]['DATABASE']}.my_profile SET 
						{$qUpdateData} 
						WHERE ownerid = {$qData['id']} LIMIT 1				
				"; 
				
				$this->apps->query($sql);
				 
				return "Update Success. ";
			}else{
				$sql = "
					INSERT INTO {$this->config['DATABASE'][0]['DATABASE']}.my_profile (ownerid ,	name, 	description ,	type 	,img ,	otherid,	brandid 	,brandsubid ,	areaid ,	city 	,created_date ,	closed_date,n_status,masterrole) 
					VALUES ('{$qData['id']}','{$rolesname}','',{$type},'{$img}',{$otherid},{$brandid},{$brandsubid},{$areaid},'{$city}',NOW(),DATE_ADD(NOW(),INTERVAL 5 YEAR),1,'{$masterrole}')
				";
				// pr($sql);
				 $this->apps->query($sql);
					if($this->apps->getLastInsertId()>0)  { 
							 
						return 'Update Successs.';
					}
			
			}
		}else{
			if($email==''||$email==null||$password==''){
				$this->logger->log('form registration not complete.');
				return   "form registration not complete. email not found";
			}
			if($password!=$repassword) {
				$this->logger->log('pass and re pass not match');
				return 'Please make sure confirm password is same as the password.';
			}

			$sql = "
				INSERT INTO {$this->config['DATABASE'][0]['DATABASE']}.social_member (password,email,register_date,salt,n_status,name,nickname,username,last_name,gender) 
				VALUES ('{$hashPass}','{$email}',NOW(),'{$CONFIG['salt']}',1,'{$name}','{$nickname}','{$username}','{$last_name}','{$gender}')			
			";
			$this->apps->query($sql);
			$lastID = $this->apps->getLastInsertId();
			if($lastID>0) {
				$sql = "
					INSERT INTO {$this->config['DATABASE'][0]['DATABASE']}.my_profile (ownerid ,	name, 	description ,	type 	,img ,	otherid,	brandid 	,brandsubid ,	areaid ,	city 	,created_date ,	closed_date,n_status,masterrole) 
					VALUES ('{$lastID}','{$rolesname}','',{$type},'{$img}',{$otherid},{$brandid},{$brandsubid},{$areaid},'{$city}',NOW(),DATE_ADD(NOW(),INTERVAL 5 YEAR),1,'{$masterrole}')
				";
				// pr($sql);exit;
				 $this->apps->query($sql);
					if($this->apps->getLastInsertId()>0)  { 
						return  'Registration Complete.';
					}
			}		
		}
 		return  "Failed";
	
	}
	

	function getLeader($type=2){
		$qmasterquery = " ";
		if($type==2)$qmasterquery = " AND   sm.n_status  IN (1,9)";
		if($type==3)$qmasterquery = " AND masterrole = 1 AND sm.n_status  IN (1,9)";
		if($type==5)$qmasterquery = " AND masterrole = 1 ";
		$sql  = "
			SELECT sm.id,pages.name pagename,sm.name, sm.last_name 
			FROM {$this->config['DATABASE'][0]['DATABASE']}.social_member sm
			LEFT JOIN {$this->config['DATABASE'][0]['DATABASE']}.my_profile pages ON pages.ownerid = sm.id
			WHERE type={$type} {$qmasterquery}   ";
		
		$qData = $this->apps->fetch($sql,1);
		
		return $qData;
	}
	
	
	function userlists($orderBy='name',$orderType='ASC',$start=0,$limit=20,$search=null){
		$searchFilter="";
		if($search){
			$searchFilter="AND (sm.name LIKE '%{$search}%' OR sm.email LIKE '%{$search}%')";
		}

		//create user list per hirarki
		$uid = intval($this->apps->_request('uid'));
		if($uid!=0) $qUsers = " AND sm.id = {$uid} ";
		else  $qUsers = "";
		mysql_query('SET CHARACTER SET utf8');
		$sql  = "
			SELECT 
			sm.id,sm.name, sm.last_name ,sm.email,sm.username,sm.password,sm.birthday,sm.phone_number,sm.nickname,sm.gender,
			ptype.name pagename,ptype.id pagetype,pages.brandid,pages.brandsubid,pages.areaid,pages.otherid,pages.city,CONCAT(UCASE(LEFT(cref.city, 1)),SUBSTRING(cref.city, 2)) cityname
			FROM {$this->config['DATABASE'][0]['DATABASE']}.social_member sm
			LEFT JOIN {$this->config['DATABASE'][0]['DATABASE']}.my_profile pages ON pages.ownerid = sm.id
			LEFT JOIN {$this->config['DATABASE'][0]['DATABASE']}.my_profile_type ptype ON ptype.id = pages.type
			LEFT JOIN beat_city_reference cref ON cref.id = pages.city
			WHERE sm.n_status IN (1,9) {$searchFilter}
			{$qUsers}
			ORDER BY {$orderBy} {$orderType}
			LIMIT {$start},{$limit} ";
		// pr($sql);exit;
		if($uid!=0) {
			$qData = $this->apps->fetch($sql);
			return $qData;
		}else{
		 	$qData = $this->apps->fetch($sql,1);

		 	$sql  = "
					SELECT 
					COUNT(sm.id) AS total
					FROM {$this->config['DATABASE'][0]['DATABASE']}.social_member sm
					LEFT JOIN {$this->config['DATABASE'][0]['DATABASE']}.my_profile pages ON pages.ownerid = sm.id
					LEFT JOIN {$this->config['DATABASE'][0]['DATABASE']}.my_profile_type ptype ON ptype.id = pages.type
					LEFT JOIN beat_city_reference cref ON cref.id = pages.city
					WHERE sm.n_status IN (1,9) {$searchFilter}";
				//pr($qData);	
		 	$total_row = $this->apps->fetch($sql);
		 	//pr($qData);exit;
		 	return array('data'=>$qData,'total'=>$total_row['total']);
		}
		
	}
	
	function unusers(){
		//create user list per hirarki
		$uid = intval($this->apps->_request('uid'));
		$sql = "
				UPDATE {$this->config['DATABASE'][0]['DATABASE']}.social_member SET n_status = 3
				WHERE id = {$uid} LIMIT 1				
			";
			
		$this->apps->query($sql);
		
		return true;
	}
	 
	
	function getMasterData($type=0){
	
	if($type==0)return false;
	
	$sql =" 
		SELECT sm.id,sm.name FROM {$this->config['DATABASE'][0]['DATABASE']}.social_member sm
		LEFT JOIN {$this->config['DATABASE'][0]['DATABASE']}.my_profile p ON p.ownerid = sm.id
		WHERE p.masterrole = 1 AND p.type= {$type} 
	";
	$qData = $this->apps->fetch($sql,1);
	if($qData )return $qData;
	return false;
		
	} 
	
	function getMasterCity(){
	   
		$sql="SELECT *
				FROM city_reference
				WHERE n_status = 1 ";
		$rs = $this->apps->fetch($sql,1);

		if($rs) return $rs;
		return false;
	}
	
	function getMasterRole(){
	 
		$sql="SELECT *
				FROM {$this->config['DATABASE'][0]['DATABASE']}.my_profile_type
				WHERE id <=100 ";
		$rs = $this->apps->fetch($sql,1);

		if($rs) return $rs;
		return false;
	}

}
	