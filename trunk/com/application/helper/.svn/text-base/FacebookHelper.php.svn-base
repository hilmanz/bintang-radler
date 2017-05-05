<?php
global $ENGINE_PATH;
include_once $ENGINE_PATH."Utility/facebook/facebook.php";
class FacebookHelper {
	var $fb;
	var $user_id;
	var $me;
	var $_access_token;
	var $logger;
	function __construct($apps=null){
		global $logger;
		$this->apps = $apps;
		$this->logger = $logger;
		$this->init();
		
	}
	
	function init(){
		global $FB,$CONFIG,$thisMobile;
	
			$this->fb = new Facebook(array(
			  'appId'  => $FB['appID'],
			  'secret' => $FB['appSecret'],
			));
			
			$this->logger->log('[FACEBOOK] : access API ');
			
			// if(isset($thisMobile)) $loginReqUri = "{$CONFIG['MOBILE_SITE']}?{$this->apps->Request->encrypt_params(array('page'=>'login'))}";
			// else $loginReqUri = "{$CONFIG['BASE_DOMAIN']}service/soursallyApiMedia/checkFb?{$this->apps->Request->encrypt_params(array('page'=>'login'))}";
			// $loginReqUri = "http://{$_SERVER['HTTP_HOST']}/soursally-2014/public_html/service/soursallyApiMedia/checkFb";
			 $loginReqUri = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
			
			
			//pr($this->fb->getUser());
			try{
				if($this->fb->getUser()){
					try{
						
						$this->logger->log('[FACEBOOK] [LOGIN ] : Success login, got logout url ');
						$this->fb->setExtendedAccessToken();
						$data['ac'] = $this->fb->getAccessToken();
						$data['user'] =$this->fb->getUser();
						$data['userProfile']['socimg']= "https://graph.facebook.com/{$this->fb->getUser()}/picture?type=square&return_ssl_resources=1";
						$data['userProfile']= $this->fb->api('/me');
						if(isset($thisMobile))$params['next'] = "{$CONFIG['MOBILE_SITE']}logout.php";
						else $params['next'] = $loginReqUri;
						
						if($this->fb->getUser()){
							$data['urlConnect'] =$this->fb->getLogoutUrl($params);
							
						}else{
							$params = array('scope' => 'user_mobile_phone,email,user_status,user_activities,publish_actions,user_likes,read_friendlists,user_about_me,user_location,publish_stream,user_relationships,read_stream','redirect_uri'=>"{$loginReqUri}");
							$data['urlConnect'] =$this->fb->getLoginUrl($params);
						}
						$userid['id']=$data['user'];
						$this->apps->session->setSession('facebook_session','facebook',$data);
						$this->apps->session->setSession($CONFIG['SESSION_NAME'],'WEB',$userid);
					}catch (Exception $e){
					
						$this->logger->log('[FACEBOOK] [LOGIN ] : failed to login , get url login ');
							
						$params = array('scope' => 'user_mobile_phone,email,user_status,user_activities,publish_actions,user_likes,read_friendlists,user_about_me,user_location,publish_stream,user_relationships,read_stream','redirect_uri'=>"{$loginReqUri}");
						$data['urlConnect'] =$this->fb->getLoginUrl($params);
						$this->apps->session->setSession('facebook_session','facebook',$data);
						
					}		
					
								
				}else {
				
					$this->logger->log('[FACEBOOK] : get login url ');
					
					$params = array('scope' => 'user_mobile_phone,email,user_status,user_activities,publish_actions,user_likes,read_friendlists,user_about_me,user_location,publish_stream,user_relationships,read_stream','redirect_uri'=>"{$loginReqUri}");
					$data['urlConnect'] =$this->fb->getLoginUrl($params);
					$this->apps->session->setSession('facebook_session','facebook',$data);
					
				}
				return $data;
			}catch (Exception $e){
			
					$this->logger->log('[FACEBOOK] : get login url , failed authorize ');
					
						$params = array('scope' => 'user_mobile_phone,email,user_status,user_activities,publish_actions,user_likes,read_friendlists,user_about_me,user_location,publish_stream,user_relationships,read_stream','redirect_uri'=>"{$loginReqUri}");
						$data['urlConnect'] =$this->fb->getLoginUrl($params);
						$this->apps->session->setSession('facebook_session','facebook',$data);
						return $data;
			}	
	}
	function checkUserLogin(){
		//pr($this->fb->getUser());
		
		if($this->fb->getUser()){
			return true;
		}
		return false;
	}
	function getUser()
	{
		if($this->fb->getUser()){
			$user = $this->fb->getUser();
			return $user;
		}
		return false;
	}
	function share($data){

			
			$sessionFacebook = $this->apps->session->getSession('facebook_session','facebook');
			$params = array(
				
				  "access_token" =>  $sessionFacebook->ac,// see:   "message" => $message,
				  "link" =>  'http://preview.kanadigital.com/',
				  "picture" =>  $data['flavor_img'],
				  "name" =>  'name',
				  "caption" =>  'caption',
				  "description" =>  'description'
				);
	
			try {
				  $ret = $this->fb->api('/100002512401757/feed', 'POST', $params);
				  
					$result['status']=1;
					$result['messages']='sucsess';
					return $result;
				} catch(Exception $e) {
					$result['status']=3;
					$result['messages']=$e->getMessage();
					return $result;
				
				}
	}
	
	
}
?>