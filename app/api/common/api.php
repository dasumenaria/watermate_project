<?php

require_once("Rest.inc.php"); 



class API extends REST {

    public $data = "";
/* 
    const DB_SERVER = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB = "flexiloans";   
	 */ 
	const DB_SERVER = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = "Aws!FL##22!MuM";
    const DB = "aws_flexiloans_db";
  
 
    
    
    private $db = NULL;

    public function __construct() {
        parent::__construct();  // Init parent contructor
        $this->dbConnect();    // Initiate Database connection     
    }

    public function __destruct() {
      $this->db = NULL;
    }
    
    

    private function dbConnect() {
        // Set up the database
		
        try {            
            $this->db = new PDO('mysql:host=' . self::DB_SERVER . ';dbname=' . self::DB, self::DB_USER, self::DB_PASSWORD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();

           /* $error = array('Type' => 'Error', "Error" => 'Some Error From Server', 'Responce' => "");
            $this->response($this->json($error), 251);*/

        }
    }

    /*
     * Public method for access api.
     * This method dynmically call the method based on the query string
     *
     */
//--------------                     Dsu Menaria DEVELOP API FUNCTION  START                     --------------------  ///

//--------------                     Dsu Menaria DEVELOP OTHER API FUNCTION                       --------------------  ///

    public function processApi() 
	{
        $func = strtolower(trim(str_replace("/", "", $_REQUEST['rquest'])));
		
		
        if ((int) method_exists($this, $func) > 0){
           $this->$func();
		   }
        else{
            $this->response('', 404);  
			// If the method not exist with in this class, response would be "Page not found".
		}	
    }
    /////////  User Location API
	public function userlocation() 
	{
		global $link;
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

		$user_input=0;
		$lat_input=0;
		if(isset($this->_request['user_id']))
		{
			@$user_id = $this->_request['user_id'];
			$user_input=1;
		}
		if(isset($this->_request['location_lat']))
		{
			@$location_lat = $this->_request['location_lat'];
			 $lat_input=1;
		}
		if($user_input==1 && $lat_input==1)
		{ 
			
			$location_long = $this->_request['location_long'];
				
			if($user_id==0)
			{
				$error = array('Type' => "Error", "Error" => "Invalid user id value posted", 'Responce' => '0');
				$this->response($this->json($error), 400);exit;
			}else if($location_lat=='0.0')
			{
				$error = array('Type' => "Error", "Error" => "Invalid latitute value posted", 'Responce' => '0');
				$this->response($this->json($error), 400);exit;

			}else if($location_long=='0.0')
			{
				$error = array('Type' => "Error", "Error" => "Invalid longitute value posted", 'Responce' => '0');
				$this->response($this->json($error), 400);exit;	

			}else{
				$con=date('Y-m-d H:i:s');
				$sql_insert = $this->db->prepare("INSERT into `user_locations`(user_id,location_lat,location_long,created_on)VALUES(:userid,:locationlat,:locationlong,:createdon)");
				$sql_insert->bindParam(":userid", $user_id, PDO::PARAM_STR);
				$sql_insert->bindParam(":locationlat", $location_lat, PDO::PARAM_STR);
				$sql_insert->bindParam(":locationlong", $location_long, PDO::PARAM_STR);
				$sql_insert->bindParam(":createdon", $con, PDO::PARAM_STR);
	            $sql_insert->execute();

	            $success = array('Type' => 'OK', "Error" => '', 'Responce' => 1);
				$this->response($this->json($success), 200);
			}			
		}else{
			$error = array('Type' => "Error", "Error" => "An error occurred in post data", 'Responce' => '0');
			$this->response($this->json($error), 400);
		}
	}
    /////////  User Contacts API
	public function usercontacts() 
	{
		global $link;
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

		$user_input=0;
		$number_input=0;
		if(isset($this->_request['user_id']))
		{
			@$user_id = $this->_request['user_id'];
			$user_input=1;
		}
		if(isset($this->_request['number']))
		{
			@$number = $this->_request['number'];
			 $number_input=1;
		}
		if($user_input==1 && $number_input==1)
		{ 
			$con=date('Y-m-d H:i:s');
			$name = $this->_request['name'];
			$email = $this->_request['email'];
			$sql_insert = $this->db->prepare("INSERT into `user_contacts`(user_id,name,mob_no,email_id,created_on)VALUES(:userid,:name,:mob,:email,:createdon)");
			$sql_insert->bindParam(":userid", $user_id, PDO::PARAM_STR);
			$sql_insert->bindParam(":name", $name, PDO::PARAM_STR);
			$sql_insert->bindParam(":mob", $number, PDO::PARAM_STR);
			$sql_insert->bindParam(":email", $email, PDO::PARAM_STR);
			$sql_insert->bindParam(":createdon", $con, PDO::PARAM_STR);
            $sql_insert->execute();

            $success = array('Type' => 'OK', "Error" => '', 'Responce' => 1);
			$this->response($this->json($success), 200);
				
		}else{
			$error = array('Type' => "Error", "Error" => "An error occurred in post data", 'Responce' => '0');
			$this->response($this->json($error), 400);
		}
	}

    /////////  User Call Logs API
	public function usercalls() 
	{
		global $link;
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

		$user_input=0;
		$number_input=0;
		if(isset($this->_request['user_id']))
		{
			@$user_id = $this->_request['user_id'];
			$user_input=1;
		}
		if(isset($this->_request['number']))
		{
			@$number = $this->_request['number'];
			 $number_input=1;
		}
		if($user_input==1 && $number_input==1)
		{ 
			$con=date('Y-m-d H:i:s');
			$time = $this->_request['time'];
			$recdate = $this->_request['date'];
			$duration = $this->_request['duration'];
			$calltype = $this->_request['type'];
			$sql_insert = $this->db->prepare("INSERT into `user_call_logs`(user_id,from_no,receive_time,receive_date,duration,call_type,created_on)VALUES(:userid,:fromno,:rectime,:recdate,:duration,:calltype,:createdon)");
			$sql_insert->bindParam(":userid", $user_id, PDO::PARAM_STR);
			$sql_insert->bindParam(":fromno", $number, PDO::PARAM_STR);
			$sql_insert->bindParam(":rectime", $time, PDO::PARAM_STR);
			$sql_insert->bindParam(":recdate", $recdate, PDO::PARAM_STR);
			$sql_insert->bindParam(":duration", $duration, PDO::PARAM_STR);
			$sql_insert->bindParam(":calltype", $calltype, PDO::PARAM_STR);
			$sql_insert->bindParam(":createdon", $con, PDO::PARAM_STR);
            $sql_insert->execute();

            $success = array('Type' => 'OK', "Error" => '', 'Responce' => 1);
			$this->response($this->json($success), 200);
				
		}else{
			$error = array('Type' => "Error", "Error" => "An error occurred in post data", 'Responce' => '0');
			$this->response($this->json($error), 400);
		}
	}

    /////////  User SMS API
	public function usersms() 
	{
		global $link;
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

		$user_input=0;
		$from_input=0;
		if(isset($this->_request['user_id']))
		{
			@$user_id = $this->_request['user_id'];
			$user_input=1;
		}
		if(isset($this->_request['from']))
		{
			@$from_no = $this->_request['from'];
			 $from_input=1;
		}
		if($user_input==1 && $from_input==1)
		{ 
			$con=date('Y-m-d H:i:s');
			$content = $this->_request['content'];
			$recdate = $this->_request['date'];
			$sql_insert = $this->db->prepare("INSERT into `user_sms`(user_id,from_no,sms_content,receive_date,created_on)VALUES(:userid,:fromno,:smscontent,:recdate,:createdon)");
			$sql_insert->bindParam(":userid", $user_id, PDO::PARAM_STR);
			$sql_insert->bindParam(":fromno", $from_no, PDO::PARAM_STR);
			$sql_insert->bindParam(":smscontent", $content, PDO::PARAM_STR);
			$sql_insert->bindParam(":recdate", $recdate, PDO::PARAM_STR);
			$sql_insert->bindParam(":createdon", $con, PDO::PARAM_STR);
            $sql_insert->execute();

            $success = array('Type' => 'OK', "Error" => '', 'Responce' => 1);
			$this->response($this->json($success), 200);
				
		}else{
			$error = array('Type' => "Error", "Error" => "An error occurred in post data", 'Responce' => '0');
			$this->response($this->json($error), 400);
		}
	}

    /////////  FaceBook API
	public function fbaccess() 
	{
		global $link;
		include_once("common/global.inc.php");
		include_once("common/Facebook/autoload.php");
		// Define var
		$user_input=0;
		$access_input=0;

		$fb_name="";
		$fb_f_name="";
		$fb_l_name="";
		$fb_age_range="";
		$fb_gender="";
		$fb_locale="";
		$fb_profile_link="";
		$fb_picture_url="";
		$fb_timezone="";
		$fb_updated_time="";
		$fb_verified="";
		$fb_user_friends="";
		$fb_email_address="";

		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $fb = new Facebook\Facebook([
		  'app_id' => '1073509602720072',
		  'app_secret' => 'e5d864f92e3b3e7db15543030b085fc6',
		  'default_graph_version' => 'v2.2',
		  ]);
		$permissions = ['user_friends','user_likes']; // optional
			
		//$accessToken = 'EAAPQWe6IeUgBACOhTe8dxop0ZAWrD1SnWW2N7N6HjaalhHKrtRaywzKum1pO9bnBfrf7OSmeZAqFcccrOHp4QnANsrB1HcY6kRGTXf85ZCv4wEc2gpCSmRLB9B9tUO0X6bY012NirvRxF2C5Nv6X8LWjgy86husPiihk2ZAMigZDZD'; 
		$accessToken=$this->_request['access_token'];
		$fb->setDefaultAccessToken($accessToken);

		try {
			$profile_request = $fb->get('/me?fields=name,first_name,last_name,email,age_range,gender,updated_time,link,picture,friends,likes,birthday');
			$profile = $profile_request->getGraphNode()->asArray();
			
			$fb_id=$profile["id"];
			$fb_name=$profile["name"];
			$fb_f_name=$profile["first_name"];
			$fb_l_name=$profile["last_name"];
			$fb_age_range=$profile["age_range"]["min"];
			$fb_gender=$profile["gender"];
			//$fb_locale=$profile["gender"];
			$fb_profile_link=$profile["link"];
			$fb_picture_url=$profile["picture"]["url"];
			$fb_timezone=$profile["updated_time"]->getTimezone()->getName();
			$fb_updated_time=$profile["updated_time"]->format('Y-m-d H:i:s');
			$fb_email_address=$profile["email"];

		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			$error = array('Type' => "Error", "Error" => "Graph returned an error:".$e->getMessage(), 'Responce' => '0');
			//$this->response($this->json($error), 400);exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			$error = array('Type' => "Error", "Error" => "Facebook SDK returned an error:".$e->getMessage(), 'Responce' => '0');
			//$this->response($this->json($error), 400);exit;
		}

		$user_input=0;
		$access_input=0;
		if(isset($this->_request['user_id']))
		{
			@$user_id = $this->_request['user_id'];
			$user_input=1;
		}
		if(isset($this->_request['access_token']))
		{
			@$access_token = $this->_request['access_token'];
			 $access_input=1;
		}
		if($user_input==1 && $access_input==1)
		{ 
			//$sql = $this->db->prepare("SELECT id FROM user_fb_details WHERE user_id=:user_id AND access_token=:access_token");
			$sql = $this->db->prepare("SELECT id FROM user_fb_details WHERE user_id=:user_id");
			$sql->bindParam(":user_id", $user_id, PDO::PARAM_STR);
			//$sql->bindParam(":access_token", $access_token, PDO::PARAM_STR);
			$sql->execute();
			if ($sql->rowCount()==0) { 
				//echo "row Count ".$sql->rowCount();exit;
			
				$con=date('Y-m-d H:i:s');
				$sql_insert = $this->db->prepare("INSERT into `user_fb_details`
					(user_id,access_token,fb_id,name,f_name,l_name,age_range,gender,profile_link,picture_url,timezone,updated_time,email_address,created_on)
					VALUES(:userid,:accesstoken,:fb_id,:fb_name,:fb_f_name,:fb_l_name,:fb_age_range,:fb_gender,:fb_profile_link,:fb_picture_url,:fb_timezone,:fb_updated_time,:fb_email_address,:createdon)");
				
				$sql_insert->bindParam(":userid", $user_id, PDO::PARAM_STR);
				$sql_insert->bindParam(":accesstoken", $access_token, PDO::PARAM_STR);
				$sql_insert->bindParam(":fb_id", $fb_id, PDO::PARAM_STR);
				$sql_insert->bindParam(":fb_name", $fb_name, PDO::PARAM_STR);
				$sql_insert->bindParam(":fb_f_name", $fb_f_name, PDO::PARAM_STR);
				$sql_insert->bindParam(":fb_l_name", $fb_l_name, PDO::PARAM_STR);
				$sql_insert->bindParam(":fb_age_range", $fb_age_range, PDO::PARAM_STR);
				$sql_insert->bindParam(":fb_gender", $fb_gender, PDO::PARAM_STR);
				$sql_insert->bindParam(":fb_profile_link", $fb_profile_link, PDO::PARAM_STR);
				$sql_insert->bindParam(":fb_picture_url", $fb_picture_url, PDO::PARAM_STR);
				$sql_insert->bindParam(":fb_timezone", $fb_timezone, PDO::PARAM_STR);
				$sql_insert->bindParam(":fb_updated_time", $fb_updated_time, PDO::PARAM_STR);
				$sql_insert->bindParam(":fb_email_address", $fb_email_address, PDO::PARAM_STR);
				$sql_insert->bindParam(":createdon", $con, PDO::PARAM_STR);
                
                $sql_insert->execute();

                $success = array('Type' => 'OK', "Error" => '', 'Responce' => 1);
				$this->response($this->json($success), 200);exit;
			}
			else
			{
				
				$upd=date('Y-m-d H:i:s');
				$sql_upd = $this->db->prepare("UPDATE `user_fb_details` SET
					access_token=:accesstoken,fb_id=:fb_id,name=:fb_name,f_name=:fb_f_name,
					l_name=:fb_l_name,age_range=:fb_age_range,gender=:fb_gender,profile_link=:fb_profile_link,
					picture_url=:fb_picture_url,timezone=:fb_timezone,updated_time=:fb_updated_time,
					email_address=:fb_email_address,updated_on=:updatedon WHERE user_id=:userid LIMIT 1;");
				
				$sql_upd->bindParam(":userid", $user_id, PDO::PARAM_STR);
				$sql_upd->bindParam(":accesstoken", $access_token, PDO::PARAM_STR);
				$sql_upd->bindParam(":fb_id", $fb_id, PDO::PARAM_STR);
				$sql_upd->bindParam(":fb_name", $fb_name, PDO::PARAM_STR);
				$sql_upd->bindParam(":fb_f_name", $fb_f_name, PDO::PARAM_STR);
				$sql_upd->bindParam(":fb_l_name", $fb_l_name, PDO::PARAM_STR);
				$sql_upd->bindParam(":fb_age_range", $fb_age_range, PDO::PARAM_STR);
				$sql_upd->bindParam(":fb_gender", $fb_gender, PDO::PARAM_STR);
				$sql_upd->bindParam(":fb_profile_link", $fb_profile_link, PDO::PARAM_STR);
				$sql_upd->bindParam(":fb_picture_url", $fb_picture_url, PDO::PARAM_STR);
				$sql_upd->bindParam(":fb_timezone", $fb_timezone, PDO::PARAM_STR);
				$sql_upd->bindParam(":fb_updated_time", $fb_updated_time, PDO::PARAM_STR);
				$sql_upd->bindParam(":fb_email_address", $fb_email_address, PDO::PARAM_STR);
				$sql_upd->bindParam(":updatedon", $upd, PDO::PARAM_STR);
                
                $sql_upd->execute();

                $success = array('Type' => 'OK', "Error" => '', 'Responce' => 1);
				$this->response($this->json($success), 200);exit;
				//$error = array('Type' => "Error", "Error" => "Access code already exists", 'Responce' => '0');
				//$this->response($this->json($error), 400);exit;
			}		
		}else{
			$error = array('Type' => "Error", "Error" => "An error occurred in post data", 'Responce' => '0');
			$this->response($this->json($error), 400);exit;
		}
	}

	/////////  LOGIN API
	public function login() 
	{
		global $link;
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

		$email_input=0;
		$password_input=0;
		if(isset($this->_request['Username']))
		{
			@$email = $this->_request['Username'];
			////////////  Email Varify
			$email_check = $this->db->prepare("SELECT * FROM logins WHERE email=:email");
			$email_check->bindParam(":email", $email, PDO::PARAM_STR);
 			$email_check->execute();
			if ($email_check->rowCount()>0) {
 				$email_input=1;
			}
			else
			{
				////////////  Mobile Varify
				$check_mobile1 = $this->db->prepare("SELECT * FROM logins WHERE mobile_no=:mobile");
				$check_mobile1->bindParam(":mobile", $email, PDO::PARAM_STR);
 				$check_mobile1->execute();
				if ($check_mobile1->rowCount()>0) {
					$email_input=1;
				}
				else
				{
					////////////  Responce Varify
					$error = array('Type' => "Error", "Error" => "Username you've entered is incorrect.", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
				
			}
 		}
		if(isset($this->_request['Password']))
		{
			@$password = $this->_request['Password'];
			 $newpassword=md5($password);
			 $password_input=1;
		}
		if($password_input==1 && $email_input==1)
		{
			$sql = $this->db->prepare("SELECT * FROM logins WHERE email=:email AND password=:password");
			$sql->bindParam(":email", $email, PDO::PARAM_STR);
			$sql->bindParam(":password", $newpassword, PDO::PARAM_STR);

			$sql->execute();

			if ($sql->rowCount()==0) { 
				$check_mobile = $this->db->prepare("SELECT * FROM logins WHERE mobile_no=:mobile AND password=:password");
				$check_mobile->bindParam(":mobile", $email, PDO::PARAM_STR);
				$check_mobile->bindParam(":password", $pass_MD5, PDO::PARAM_STR);
				$check_mobile->execute();
					if ($check_mobile->rowCount()>0) {
						$row_gp = $check_mobile->fetch(PDO::FETCH_ASSOC);
						$result = array('id' => $row_gp['id'],
                       	'username' =>$row_gp['username'],
                        'email' => $row_gp['email'],
                        'mobile_no' => $row_gp['mobile_no']
			
                        );
						$result1 = array("logins" => $result );
						$success = array('Type' => 'OK', "Error" => '', 'Responce' => $result1);
						$this->response($this->json($success), 200);
					} 
					else{
						
						$error = array('Type' => "Error", "Error" => "Username or Password is Incorrect", 'Responce' => '');
                		$this->response($this->json($error), 400);
						
					}
			}
			else
			{
				$row_gp1 = $sql->fetch(PDO::FETCH_ASSOC);

				$result = array('id' => $row_gp1['id'],
                       	'username' =>$row_gp1['username'],
                        'email' => $row_gp1['email'],
                        'mobile_no' => $row_gp1['mobile_no']
			
                        );
						$result1 = array("logins" => $result );
				$success = array('Type' => 'OK', "Error" => '', 'Responce' => $result1);
				$this->response($this->json($success), 200);
			}
				
		}
	}
	
	/////////  VERIFY OTP
	public function otp() 
	{
		global $link;
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
		if(isset($this->_request['otp']))
		{
			@$otp = $this->_request['otp'];
			$sql = $this->db->prepare("SELECT * FROM logins WHERE random_code=:otp");
			$sql->bindParam(":otp", $otp, PDO::PARAM_STR);
			$sql->execute();
			if ($sql->rowCount()>0) { 
				
				$success = array('Type' => 'OK', "Error" => '', 'Responce' => 1);
				$this->response($this->json($success), 200);
			}else{$success = array('Type' => 'OK', "Error" => 'Wrong OTP No ', 'Responce' => 0);
				$this->response($this->json($success), 200);}
		}
		else{$success = array('Type' => 'OK', "Error" => 'No data found', 'Responce' => '');
				$this->response($this->json($success), 200);}
		
		
	}
	/////////  SIGN UP API
	public function sign_up() 
	{
		global $link;
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
	    $send_otp=0;
		$name_input=0;
		$email_input=0;
		$password_input=0;
		
		if(isset($this->_request['name']))
		{
			@$name = $this->_request['name'];
			$name_input=1;
		}
		if(isset($this->_request['email']))
		{
			@$email = $this->_request['email'];
			$check_email = $this->db->prepare("SELECT * FROM logins WHERE email=:email AND random_code = ''");
			$check_email->bindParam(":email", $email, PDO::PARAM_STR);
			$check_email->execute();
			//print_r($check_email->rowCount());exit;
			if ($check_email->rowCount() > 0) {
				
				$row_gp = $check_email->fetch(PDO::FETCH_ASSOC);
							
						$result = array('id' => $row_gp['id'],
                       	'username' =>$row_gp['username'],
                        'email' => $row_gp['email'],
                        'mobile_no' => $row_gp['mobile_no'],'response' => '1'
                        );
						$result1 = array("logins" => $result );
							
				$error = array('Type' => "Error", "Error" => "Email already exist", 'Responce' => $result1);
				$this->response($this->json($error), 400);
				$email_input=2;
			} else{$email_input=1;}
			
		}
		if(isset($this->_request['mobile']))
		{
			@$mobile = $this->_request['mobile'];

			$check_mobile = $this->db->prepare("SELECT * FROM logins WHERE mobile_no=:mobile AND random_code = ''");
			$check_mobile->bindParam(":mobile", $mobile, PDO::PARAM_STR);
			$check_mobile->execute();
			
			if ($check_mobile->rowCount() > 0) {
				$error = array('Type' => "Error", "Error" => "Mobile no already exist", 'Responce' => '1');
				$this->response($this->json($error), 400);
				$send_otp=2;
			}else{$send_otp=1;} 
		}
		if(isset($this->_request['password']))
		{
			@$password = $this->_request['password'];
			$mdPassword = md5($password);
			$password_input=1;
		}
		
		
		 
 		if($send_otp==1 && $name_input==1 && $email_input==1 && $password_input==1)
		{

   			$check_both = $this->db->prepare("SELECT * FROM logins WHERE mobile_no=:mobile AND email =:email");
			$check_both->bindParam(":mobile", $mobile, PDO::PARAM_STR);
			$check_both->bindParam(":email", $email, PDO::PARAM_STR);
			$check_both->execute();
		
			if ($check_both->rowCount() > 0) {
			//	update
			$row_ftc = $check_both->fetch(PDO::FETCH_ASSOC);
			$update_id=$row_ftc['id'];
				////// OTP CODE
				$random=(string)mt_rand(1000,9999);
				$time=date('h:i:s a', time());
				$date=date("d-m-Y");
				$sms1=str_replace(' ', '+', 'Dear '.$name.', Your one time password is '.$random.'.');
				$working_key='A7a76ea72525fc05bbe9963267b48dd96';
				$sms_sender='FLEXIL';
				file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
				///// Update Code
				
			$sql_insert = $this->db->prepare("update `logins` set login_id=:name,username=:name,email=:email,mobile_no=:mobile,password=:mdPassword,random_code=:random,date=:date,time=:time where id=:id");

				
					$sql_insert->bindParam(":name", $name, PDO::PARAM_STR);
					$sql_insert->bindParam(":name", $name, PDO::PARAM_STR);
					$sql_insert->bindParam(":email", $email, PDO::PARAM_STR);
					$sql_insert->bindParam(":mobile", $mobile, PDO::PARAM_STR);
					$sql_insert->bindParam(":mdPassword", $mdPassword, PDO::PARAM_STR);
					$sql_insert->bindParam(":random", $random, PDO::PARAM_STR);
					$sql_insert->bindParam(":date", $date, PDO::PARAM_STR);
					$sql_insert->bindParam(":time", $time, PDO::PARAM_STR);
					$sql_insert->bindParam(":id", $update_id, PDO::PARAM_STR);
 					$sql_insert->execute();
				   
						////----------------- VIEW DATA
						$sql =$this->db->prepare( "SELECT * FROM logins WHERE id = :last_id LIMIT 1");
						$sql->bindParam(":last_id", $update_id, PDO::PARAM_INT);
						$sql->execute();
						 if ($sql->rowCount() != 0) {     
								$row_gp = $sql->fetch(PDO::FETCH_ASSOC);
								
							$result = array('id' => $row_gp['id'],
							'username' =>$row_gp['username'],
							'email' => $row_gp['email'],
							'mobile_no' => $row_gp['mobile_no']
							);
							
							$result1 = array("logins" => $result );
							$success = array('Type' => 'OK', "Error" => '', 'Responce' => $result1);
							$this->response($this->json($success), 200);
						 }
 			}
			else
			{
				$check_Only_mobile = $this->db->prepare("SELECT * FROM logins WHERE mobile_no=:mobile AND random_code != ''");
				$check_Only_mobile->bindParam(":mobile", $mobile, PDO::PARAM_STR);
				$check_Only_mobile->execute();
				
				$check_Only_mail = $this->db->prepare("SELECT * FROM logins WHERE email=:email AND random_code != ''");
				$check_Only_mail->bindParam(":email", $email, PDO::PARAM_STR);
				$check_Only_mail->execute();
				
				if ($check_Only_mail->rowCount() > 0) {
					
					$error = array('Type' => "Error", "Error" => "Email id already exist", 'Responce' => '1');
					$this->response($this->json($error), 400);
 				}
				
				if ($check_Only_mobile->rowCount() > 0) {
				$error = array('Type' => "Error", "Error" => "Mobile no already exist", 'Responce' => '1');
				$this->response($this->json($error), 400);
				}
				else
				{
					//insert
					////// OTP CODE
						$random=(string)mt_rand(1000,9999);
						$time=date('h:i:s a', time());
						$date=date("d-m-Y");
						$sms1=str_replace(' ', '+', 'Dear '.$name.', Your one time password is '.$random.'.');
						$working_key='A7a76ea72525fc05bbe9963267b48dd96';
						$sms_sender='FLEXIL';
						file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms1.'');
						///// Insert Code
						$sql_insert = $this->db->prepare("INSERT into logins(login_id,username,email,mobile_no,password,random_code,date,time)VALUES(:name,:name,:email,:mobile,:mdPassword,:random,:date,:time)");
						
							$sql_insert->bindParam(":name", $name, PDO::PARAM_STR);
							$sql_insert->bindParam(":name", $name, PDO::PARAM_STR);
							$sql_insert->bindParam(":email", $email, PDO::PARAM_STR);
							$sql_insert->bindParam(":mobile", $mobile, PDO::PARAM_STR);
							$sql_insert->bindParam(":mdPassword", $mdPassword, PDO::PARAM_STR);
							$sql_insert->bindParam(":random", $random, PDO::PARAM_STR);
							$sql_insert->bindParam(":date", $date, PDO::PARAM_STR);
							$sql_insert->bindParam(":time", $time, PDO::PARAM_STR);
							$sql_insert->execute();
						   
							$userid = $this->db->lastInsertId();
			
			
							if($userid>0){
								////----------------- INSERT MODUAL
								$module_id='51,53,54,55'; 
								$sql_insert1 = $this->db->prepare("INSERT into `user_rights`(user_id,module_id)VALUES(:userid,:module_id)");
								$sql_insert1->bindParam(":userid", $userid, PDO::PARAM_STR);
								$sql_insert1->bindParam(":module_id", $module_id, PDO::PARAM_STR);
													$sql_insert1->execute();
								////----------------- NOTIFICATION INSERT
			
								$time=date('Y-m-d H:i:s');
								$massage='New user registered.';
								$icon='fa-check-circle';
								$type=1;
								
								$sql_insert2 = $this->db->prepare("INSERT into `notifications`(text,date_time,type,icon)VALUES(:massage,:time,:type,:icon)");
								$sql_insert2->bindParam(":massage", $massage, PDO::PARAM_STR);
								$sql_insert2->bindParam(":time", $time, PDO::PARAM_STR);
								$sql_insert2->bindParam(":type", $type, PDO::PARAM_STR);
								$sql_insert2->bindParam(":icon", $icon, PDO::PARAM_STR);
													$sql_insert2->execute();
								////----------------- NOTIFICATION INSERT
								////----------------- VIEW DATA
								$sql =$this->db->prepare( "SELECT * FROM logins WHERE id = :last_id LIMIT 1");
								$sql->bindParam(":last_id", $userid, PDO::PARAM_INT);
								$sql->execute();
								 if ($sql->rowCount() != 0) {     
										$row_gp = $sql->fetch(PDO::FETCH_ASSOC);
										
									$result = array('id' => $row_gp['id'],
									'username' =>$row_gp['username'],
									'email' => $row_gp['email'],
									'mobile_no' => $row_gp['mobile_no']
									);
									
									$result1 = array("logins" => $result );
									$success = array('Type' => 'OK', "Error" => '', 'Responce' => $result1);
									$this->response($this->json($success), 200);
								 }
							}
 				} 
				
			}
  			
		}
		else if(($send_otp==2 && $email_input==2) || ($send_otp==2 || $email_input==2))
		{
		}
		else
		{	///// ERROR IN SIGN UP 
			if(isset($this->_request['email']))
			{
				$error = array('Type' => "Error", "Error" => "", 'Responce' => '0');
				$this->response($this->json($error), 400);
			}
			if(isset($this->_request['mobile']))
			{
				$error = array('Type' => "Error", "Error" => "", 'Responce' => '0');
				$this->response($this->json($error), 400);
			}
			else
			{
				$error = array('Type' => "Error", "Error" => "", 'Responce' => '0');
				$this->response($this->json($error), 400);	
			}
				
		}
	}
	/////////  forgot_password
	public function forgot_password() 
	{
			global $link;
			include_once("common/global.inc.php");
			if ($this->get_request_method() != "POST") {
				$this->response('', 406);
			}
			if(isset($this->_request['email']))
			{
				@$email = $this->_request['email'];
				$sql = $this->db->prepare("SELECT * FROM logins WHERE email=:email");
				$sql->bindParam(":email", $email, PDO::PARAM_STR);
				$sql->execute();
				if ($sql->rowCount()>0) {
					
							$row_gp = $sql->fetch(PDO::FETCH_ASSOC);
							$id=$row_gp['id'];
							$data=base64_encode($id);
 						
					//file_get_contents('http://getlogo.in/flexiloansmail/email_api.php?email_id='.$email.'&data='.$data.'');
					
				/*$msg="It seems that you or someone requested to reset your login password.<br /><br />
				To reset your password, Please <a href='app.flexiloans.in/basic_detail?data=".$data."'>click here.</a><br /><br />
				In case you have not requested to reset your password, Please ignore it.";
				$to = $email; 
				$from="connect@flexiloans.in";
				$from_name="Flexiloans";
				$subject="Password Recovery";
				$Email =  @$this->sendmail($to, $from, $from_name, $subject,$msg, $is_gmail = true);
				*/
			
			 
				$error = array('Type' => "ok", "success" => "Instructions for accessing your account have been sent to ".$email."", 'Responce' => '');
						$this->response($this->json($error), 400);
				}
				else
				{
					$sql1 = $this->db->prepare("SELECT * FROM logins WHERE mobile_no=:mobile_no");
					$sql1->bindParam(":mobile_no", $email, PDO::PARAM_STR);
					$sql1->execute();
					if ($sql1->rowCount()>0) { 
							$row_gp1 = $sql1->fetch(PDO::FETCH_ASSOC);
							$update_id=$row_gp1['id'];
							
					$random=(string)mt_rand(1000,9999);
					$time=date('h:i:s a', time());
					$date=date("d-m-Y");
					$sms1=str_replace(' ', '+', 'Dear '.$name.', Your one time password is '.$random.'.');
	
					$working_key='A7a76ea72525fc05bbe9963267b48dd96';
					$sms_sender='FLEXIL';
					file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$email.'&message='.$sms1.'');
					$pass_MD5=md5($random);
					
				
					
					
					
	$sql_update1 = $this->db->prepare("update `logins` set password=:pass_MD5,random_code=:random,date=:date,time=:time where id=:id");
					$sql_update1->bindParam(":id", $update_id, PDO::PARAM_INT);
	$sql_update1->bindParam(":pass_MD5", $pass_MD5, PDO::PARAM_INT);
	$sql_update1->bindParam(":random", $random, PDO::PARAM_INT);
	$sql_update1->bindParam(":date", $date, PDO::PARAM_INT);
	$sql_update1->bindParam(":time", $time, PDO::PARAM_INT);
	
					$sql_update1->execute();
	
	$error = array('Type' => "ok", "success" => "Instructions for accessing your account have been sent to ".$email."", 'Responce' => '');
						$this->response($this->json($error), 400);
					
					}
					else
					{
						$error = array('Type' => "Error", "Error" => "Sorry, the email address or mobile no you provide is not registered to Flexiloans.", 'Responce' => '');
						$this->response($this->json($error), 400);
					}
						
				}
			}
			else
			{
				$error = array('Type' => "Error", "Error" => "Sorry, the email address or mobile no you provide is not registered to Flexiloans.", 'Responce' => '');
				$this->response($this->json($error), 400);
			}
		}
	/////////   Contact Us	
	public function contact_us() 
	{
	
		if(isset($this->_request['name']))
		{
			@$name = $this->_request['name'];	
		}
		if(isset($this->_request['email']))
		{
			@$email = $this->_request['email'];	
		}
		if(isset($this->_request['contact']))
		{
			@$contact = $this->_request['contact'];	
		}
		if(isset($this->_request['address']))
		{
			@$address = $this->_request['address'];	
		}
		if(isset($this->_request['message']))
		{
			@$message = $this->_request['message'];	
		}
		if(isset($this->_request['name']) && isset($this->_request['email']) && isset($this->_request['contact']) && isset($this->_request['address']) && isset($this->_request['message']))
		{

			/////// Contact Us EMAIL
			$len=strlen($message);
			$txt=str_replace(' ', '+', $text);
			file_get_contents('http://getlogo.in/flexiloansmail/email_contact_us.php?name='.$name.'&email='.$email.'&contact='.$contact.'&address='.$address.'&text='.$txt.'');
			////// Data INSERT 
			$time=date('h:i:s a', time());
			$date=date("d-m-Y");
			$sql_insert = $this->db->prepare("INSERT into contact_uses(name,email,contact,address,message,date,time)VALUES(:name,:email,:mobile,:address,:message,:date,:time)");
			
			    $sql_insert->bindParam(":name", $name, PDO::PARAM_STR);
                $sql_insert->bindParam(":email", $email, PDO::PARAM_STR);
                $sql_insert->bindParam(":mobile", $contact, PDO::PARAM_STR);
                $sql_insert->bindParam(":address", $address, PDO::PARAM_STR);
                $sql_insert->bindParam(":message", $message, PDO::PARAM_STR);
                $sql_insert->bindParam(":date", $date, PDO::PARAM_STR);
                $sql_insert->bindParam(":time", $time, PDO::PARAM_STR);
                $sql_insert->execute();
			/////	
			 $success = array('Type' => 'OK', "Error" => '', 'Responce' => 1);
             $this->response($this->json($success), 200);
		}
		else
		{
			 $error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '0');
             $this->response($this->json($error), 400);
		}
	}
	/////////   Existing Loan DETAILS
	public function existing_loan_details() 
	{
	
		if(isset($this->_request['user_id']))
		{
			@$user_id = $this->_request['user_id'];	
			include_once("common/global.inc.php");
        	global $link;
            $sql= $this->db->prepare("SELECT * FROM `loan_statuses` where user_id=:userid");
			$sql->bindParam(":userid", $user_id, PDO::PARAM_INT);
            $sql->execute();
           
             if ($sql->rowCount() != 0) 
				{
					while($row_gp = $sql->fetch(PDO::FETCH_ASSOC))
						{				
							foreach($row_gp as $key=>$valye)	
							{
								$string_insert[$key]=$row_gp[$key];
							}
												$string_insert1[]=$string_insert;
							unset($string_insert);
						}
						$result1 = array("loan_statuses" => $string_insert1);
						$success = array('Type' => 'OK', "Error" => '', 'Responce' => $result1);
						$this->response($this->json($success), 200);
					} 
					else 
					{
						$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
						$this->response($this->json($error), 400);
					}
			
		}
		else 
			{
				$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
				$this->response($this->json($error), 400);
			}
	}
	/////////  Upload Documents 
	public function upload() 
	{
		if(isset($this->_request['document_file']))
        {
			 $DS='/';
			 @$user_id = $this->_request['user_id'];
			 @$document_file = $this->_request['document_file'];
			 $target = "upload_document/".$user_id."/".$document_file;
			 //$file_type = $this->_request["file_type"];
			 $file = $this->_request["file"];
			 $decodeFile = base64_decode($file); 
			
			$target = dirname(__FILE__)."/../webroot/upload_document/".$user_id."/".$document_file;
			if(!is_dir($target)){
			@mkdir($target);
			}
		
			$ext ='jpeg';
			
            $exist = is_dir($target);
            if(!$exist)
            {
               mkdir(dirname(__FILE__)."/../webroot/upload_document" . $DS . $user_id);
                mkdir(dirname(__FILE__)."/../webroot/upload_document" . $DS . $user_id . $DS . $document_file . $DS);
		
            }
		  
		  	$filecount=0;
			if (glob($target. '/*') != false)
			{ 
				$filecount = count(glob($target . '/*'));
			}
		  
			if($filecount>0)
			{
				 $target1=@$target."/".$document_file.$filecount.'.'.$ext;
			}
			else
			{
				$target1=@$target."/".$document_file.'.'.$ext;	
			}
			
           if(file_put_contents($target1, $decodeFile))
		   {
			  
			   $result1 = array("Upload_document" => 'Uploded');
			   $success = array('Type' => "OK", "Error" => "", 'Responce' => $result1);
			  $this->response($this->json($success), 200);
		   }
		   else
		   {
			   
			$error = array('Type' => "Error", "Error" => "No file selected", 'Responce' => '');
			$this->response($this->json($error), 400);
		   }
			
		}
		
/*
		else if(isset($this->_request['document']))
        {
			$user_id=$this->_request['user_id'];
            $document_file=$this->_request['document'];
		   
            $document_folder = pathinfo($document_file, PATHINFO_FILENAME);
            $target = dirname(__FILE__)."/../webroot/upload_document/".$user_id."/".$document_folder;
            $images = glob($target.'/*');
            foreach($images as $image)
            {
                 @unlink($image);
            }
            rmdir($target);
			$result1 = array("Upload_document" => 'Deleted');
			$success = array('Type' => "OK", "Error" => "", 'Responce' => $result1);
			$this->response($this->json($success), 200);
        }
		*/
		
	}
	
//--------------                     Dsu Menaria DEVELOP APPLICATION API FUNCTION                       --------------------  ///

	/*Basic Details function*/
	public function basic_detail() 
	{
 		include_once("common/global.inc.php");
        global $link;
		if(isset($this->_request['response_type']))
		{
			$response_type=$this->_request['response_type'];
			$user_id=$this->_request['user_id'];
			if($response_type==1){
				
				$sql = $this->db->prepare("SELECT * FROM basic_details where user_id=:user_id AND flag =0");
				$sql->bindParam(":user_id", $user_id, PDO::PARAM_INT);
				$sql->execute();
				 if ($sql->rowCount() != 0) {     
						$row_gp = $sql->fetch(PDO::FETCH_ASSOC);
					foreach($row_gp as $key=>$valye)	
					{
						$string_insert[$key]=$row_gp[$key];
					}
					
					$result1 = array("basic_details" => $string_insert);
					$success = array('Type' => 'OK', "Error" => '', 'Responce' => $result1);
					$this->response($this->json($success), 200);
				} else {
					$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
			}
			/////// END OF  RESPONCE 1
			if($response_type==2){
				
				
				$login_chk = $this->db->prepare("select * from `logins` where id=:user_id");
				$login_chk->bindParam(":user_id", $user_id, PDO::PARAM_STR);
				$login_chk->execute();
				$login_count = $login_chk->rowCount();
				if($login_count > 0){
				
				$userres = $this->db->prepare("select `application_no` from `loan_statuses` where user_id=:user_id AND status =0");
				$userres->bindParam(":user_id", $user_id, PDO::PARAM_STR);
				$userres->execute();
				$pcnt = $userres->rowCount();
				if($pcnt > 0){
					$getuserid = $userres->fetch(PDO::FETCH_ASSOC);
					$application_no = $getuserid['application_no'];
					
					$basic_id = $this->db->prepare("select `id` from `basic_details` where application_no=:application_no AND user_id =:user_id");
					$basic_id->bindParam(":user_id", $user_id, PDO::PARAM_STR);
					$basic_id->bindParam(":application_no", $application_no, PDO::PARAM_STR);
					$basic_id->execute();
					$basic_detls = $basic_id->rowCount();
					
					if($basic_detls>0){
					$getid = $basic_id->fetch(PDO::FETCH_ASSOC);
					$update_id = $getid['id'];
					
					$record = '';
					if(isset($this->_request['loan_purpose']))
					{
						$loan_purpose=$this->_request['loan_purpose'];
						$record .= "loan_purpose ='" . $loan_purpose . "' ,";
					}
					if(isset($this->_request['loan_amount']))
					{
						$loan_amount=$this->_request['loan_amount'];
						$record .= "loan_amount ='" . $loan_amount . "' ,";
					}
					if(isset($this->_request['partner']))
					{
						$partner=$this->_request['partner'];
						$record .= "partner ='" . $partner . "' ,";
					}
					if(isset($this->_request['customer_id_number']))
					{
						$customer_id_number=$this->_request['customer_id_number'];
						$record .= "customer_id_number ='" . $customer_id_number . "' ,";
					}
					if(isset($this->_request['start_date_with_partner']))
					{
						$start_date_with_partner=$this->_request['start_date_with_partner'];
						$record .= "start_date_with_partner ='" . $start_date_with_partner . "' ,";
					}
					if(isset($this->_request['top_product']))
					{
						$top_product=$this->_request['top_product'];
						$record .= "top_product ='" . $top_product . "' ,";
					}
					if(isset($this->_request['product_sold']))
					{
						$product_sold=$this->_request['product_sold'];
						$record .= "product_sold ='" . $product_sold . "' ,";
					}
					if(isset($this->_request['average_returns']))
					{
						$average_returns=$this->_request['average_returns'];
						$record .= "average_returns ='" . $average_returns . "' ,";
					}
					if(isset($this->_request['monthly_sales']))
					{
						$monthly_sales=$this->_request['monthly_sales'];
						$record .= "monthly_sales ='" . $monthly_sales . "' ,";
					}
					if(isset($this->_request['credit_period']))
					{
						$credit_period=$this->_request['credit_period'];
						$record .= "credit_period ='" . $credit_period . "' ,";
					}
					if(isset($this->_request['sell_offline']))
					{
						$sell_offline=$this->_request['sell_offline'];
						$record .= "sell_offline ='" . $sell_offline . "' ,";
					}
					if(isset($this->_request['id_number']))
					{
						$id_number=$this->_request['id_number'];
						$record .= "id_number ='" . $id_number . "' ,";
					}
					if(isset($this->_request['start_date']))
					{
						$start_date=$this->_request['start_date'];
						$record .= "start_date ='" . $start_date . "' ,";
					}
					if(isset($this->_request['total_trip']))
					{
						$total_trip=$this->_request['total_trip'];
						$record .= "total_trip ='" . $total_trip . "' ,";
					}
					if(isset($this->_request['monthly_income']))
					{
						$monthly_income=$this->_request['monthly_income'];
						$record .= "monthly_income ='" . $monthly_income . "' ,";
					}
					if(isset($this->_request['cash_income']))
					{
						$cash_income=$this->_request['cash_income'];
						$record .= "cash_income ='" . $cash_income . "' ,";
					}
					if(isset($this->_request['wallet_income']))
					{
						$wallet_income=$this->_request['wallet_income'];
						$record .= "wallet_income ='" . $wallet_income . "' ,";
					}
					if(isset($this->_request['customer_ratings']))
					{
						$customer_ratings=$this->_request['customer_ratings'];
						$record .= "customer_ratings ='" . $customer_ratings . "' ,";
					}
					$form_valid=1;
					$record .= "`form_valid`='" . $form_valid. "' ,";
					
					$web_app=1;
					$record .= "web_app='" . $web_app. "'";
					
						$sql1= $this->db->prepare("update `basic_details` set " . $record . " where id=:update_id");
						$sql1->bindParam(":update_id" , $update_id, PDO::PARAM_INT);
						$sql1->execute();
						
						if ($sql1){
							$result=array('success' => 'Updated Successful '.$loan_amount,
                       		'application_no' =>$application_no);
							$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
							$this->response($this->json($success), 200);
						}else {
							$result = "Updated Unsuccessful";
							$error = array('Type' => "Error", "Error" => "Some Error From Server",'Responce' => $result);
							$this->response($this->json($error), 400);
						}
						
					}
					else
					{
						$record = '';
					if(isset($this->_request['loan_purpose']))
					{
						$loan_purpose=$this->_request['loan_purpose'];
						$record .= "loan_purpose ='" . $loan_purpose . "' ,";
					}
					if(isset($this->_request['loan_amount']))
					{
						$loan_amount=$this->_request['loan_amount'];
						$record .= "loan_amount ='" . $loan_amount . "' ,";
					}
					if(isset($this->_request['partner']))
					{
						$partner=$this->_request['partner'];
						$record .= "partner ='" . $partner . "' ,";
					}
					if(isset($this->_request['customer_id_number']))
					{
						$customer_id_number=$this->_request['customer_id_number'];
						$record .= "customer_id_number ='" . $customer_id_number . "' ,";
					}
					if(isset($this->_request['start_date_with_partner']))
					{
						$start_date_with_partner=$this->_request['start_date_with_partner'];
						$record .= "start_date_with_partner ='" . $start_date_with_partner . "' ,";
					}
					if(isset($this->_request['top_product']))
					{
						$top_product=$this->_request['top_product'];
						$record .= "top_product ='" . $top_product . "' ,";
					}
					if(isset($this->_request['product_sold']))
					{
						$product_sold=$this->_request['product_sold'];
						$record .= "product_sold ='" . $product_sold . "' ,";
					}
					if(isset($this->_request['average_returns']))
					{
						$average_returns=$this->_request['average_returns'];
						$record .= "average_returns ='" . $average_returns . "' ,";
					}
					if(isset($this->_request['monthly_sales']))
					{
						$monthly_sales=$this->_request['monthly_sales'];
						$record .= "monthly_sales ='" . $monthly_sales . "' ,";
					}
					if(isset($this->_request['credit_period']))
					{
						$credit_period=$this->_request['credit_period'];
						$record .= "credit_period ='" . $credit_period . "' ,";
					}
					if(isset($this->_request['sell_offline']))
					{
						$sell_offline=$this->_request['sell_offline'];
						$record .= "sell_offline ='" . $sell_offline . "' ,";
					}
					if(isset($this->_request['id_number']))
					{
						$id_number=$this->_request['id_number'];
						$record .= "id_number ='" . $id_number . "' ,";
					}
					if(isset($this->_request['start_date']))
					{
						$start_date=$this->_request['start_date'];
						$record .= "start_date ='" . $start_date . "' ,";
					}
					if(isset($this->_request['total_trip']))
					{
						$total_trip=$this->_request['total_trip'];
						$record .= "total_trip ='" . $total_trip . "' ,";
					}
					if(isset($this->_request['monthly_income']))
					{
						$monthly_income=$this->_request['monthly_income'];
						$record .= "monthly_income ='" . $monthly_income . "' ,";
					}
					if(isset($this->_request['cash_income']))
					{
						$cash_income=$this->_request['cash_income'];
						$record .= "cash_income ='" . $cash_income . "' ,";
					}
					if(isset($this->_request['wallet_income']))
					{
						$wallet_income=$this->_request['wallet_income'];
						$record .= "wallet_income ='" . $wallet_income . "' ,";
					}
					if(isset($this->_request['customer_ratings']))
					{
						$customer_ratings=$this->_request['customer_ratings'];
						$record .= "customer_ratings ='" . $customer_ratings . "' ,";
					}
					
					$record .= "application_no='" . $application_no. "' ,";
					$record .= "user_id='" . $user_id. "' ,";
					
					$data=date('Y-m-d');

					$record .= "date='" . $data. "' ,";
					
					$time=date('h:i:s a', time());	
					$record .= "time='" . $time. "' ,";
					
					$submitted=1;
					$record .= "submitted='" . $submitted. "' ,";
					
					$form_valid=1;
					$record .= "`form_valid`='" . $form_valid. "' ,";
					
					$submitted_date=date('d-m-Y');
					$record .= "submitted_date='" . $submitted_date. "' ,";
  
  					$web_app=1;
					$record .= "web_app='" . $web_app. "'";
					
					$ins_new = $this->db->prepare("INSERT into `basic_details` set " . $record . " ");
					
					$ins_new->execute();

					$result=array('success' => 'Insert Successful '.$loan_amount,
                       		'application_no' =>$application_no);
							$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
							$this->response($this->json($success), 200);
					////
				
						
					}
				}
				else if($pcnt==0)
				{
					$new_app = $this->db->prepare("select `application_no` from `loan_statuses` order by application_no DESC");
					$new_app->execute();
					$last_app = $new_app->fetch(PDO::FETCH_ASSOC);
					$app_no=$last_app['application_no'];
					////----------------- APPLICATION NO INCREMENT
					$facyear=date('Y') .'-'. (date('y')+1);
					$center='/APL';
					$murg=$facyear.$center;
					$incrementHERE=str_replace($murg,'',$app_no);
					$incrementHERE++;
					$len=strlen($incrementHERE);
					$mylen="";
					if($len==1)
					$mylen="000";
					else if($len==2)
					$mylen="00";
					else if($len==3)
					$mylen="0";
					$facyear=date('Y') .'-'. (date('y')+1);
					$center='/APL';
					$application_no=$facyear.$center.$mylen.$incrementHERE;
					////----------------- LOAN STATUS INSERT
					$sql_insert = $this->db->prepare("INSERT into loan_statuses(user_id,application_no)VALUES(:user_id,:application_no)");
                	$sql_insert->bindParam(":user_id", $user_id, PDO::PARAM_STR);
					$sql_insert->bindParam(":application_no", $application_no, PDO::PARAM_STR);
					$sql_insert->execute();
					////----------------- LOAN STATUS INSERT END
					////----------------- NOTIFICATION INSERT

					$time=date('Y-m-d H:i:s');
					$massage='New user signup in portal';
					$icon='fa-pencil-square';
					$type=1;
					
					$sql_insert2 = $this->db->prepare("INSERT into `notifications`(text,date_time,type,icon)VALUES(:massage,:time,:type,:icon)");
					$sql_insert2->bindParam(":massage", $massage, PDO::PARAM_STR);
					$sql_insert2->bindParam(":time", $time, PDO::PARAM_STR);
					$sql_insert2->bindParam(":type", $type, PDO::PARAM_STR);
					$sql_insert2->bindParam(":icon", $icon, PDO::PARAM_STR);
                    $sql_insert2->execute();
					////----------------- NOTIFICATION INSERT
					////----------------- BASIC DETAILS INSERT
					
					$record = '';
					if(isset($this->_request['loan_purpose']))
					{
						$loan_purpose=$this->_request['loan_purpose'];
						$record .= "loan_purpose ='" . $loan_purpose . "' ,";
					}
					if(isset($this->_request['loan_amount']))
					{
						$loan_amount=$this->_request['loan_amount'];
						$record .= "loan_amount ='" . $loan_amount . "' ,";
					}
					if(isset($this->_request['partner']))
					{
						$partner=$this->_request['partner'];
						$record .= "partner ='" . $partner . "' ,";
					}
					if(isset($this->_request['customer_id_number']))
					{
						$customer_id_number=$this->_request['customer_id_number'];
						$record .= "customer_id_number ='" . $customer_id_number . "' ,";
					}
					if(isset($this->_request['start_date_with_partner']))
					{
						$start_date_with_partner=$this->_request['start_date_with_partner'];
						$record .= "start_date_with_partner ='" . $start_date_with_partner . "' ,";
					}
					if(isset($this->_request['top_product']))
					{
						$top_product=$this->_request['top_product'];
						$record .= "top_product ='" . $top_product . "' ,";
					}
					if(isset($this->_request['product_sold']))
					{
						$product_sold=$this->_request['product_sold'];
						$record .= "product_sold ='" . $product_sold . "' ,";
					}
					if(isset($this->_request['average_returns']))
					{
						$average_returns=$this->_request['average_returns'];
						$record .= "average_returns ='" . $average_returns . "' ,";
					}
					if(isset($this->_request['monthly_sales']))
					{
						$monthly_sales=$this->_request['monthly_sales'];
						$record .= "monthly_sales ='" . $monthly_sales . "' ,";
					}
					if(isset($this->_request['credit_period']))
					{
						$credit_period=$this->_request['credit_period'];
						$record .= "credit_period ='" . $credit_period . "' ,";
					}
					if(isset($this->_request['sell_offline']))
					{
						$sell_offline=$this->_request['sell_offline'];
						$record .= "sell_offline ='" . $sell_offline . "' ,";
					}
					if(isset($this->_request['id_number']))
					{
						$id_number=$this->_request['id_number'];
						$record .= "id_number ='" . $id_number . "' ,";
					}
					if(isset($this->_request['start_date']))
					{
						$start_date=$this->_request['start_date'];
						$record .= "start_date ='" . $start_date . "' ,";
					}
					if(isset($this->_request['total_trip']))
					{
						$total_trip=$this->_request['total_trip'];
						$record .= "total_trip ='" . $total_trip . "' ,";
					}
					if(isset($this->_request['monthly_income']))
					{
						$monthly_income=$this->_request['monthly_income'];
						$record .= "monthly_income ='" . $monthly_income . "' ,";
					}
					if(isset($this->_request['cash_income']))
					{
						$cash_income=$this->_request['cash_income'];
						$record .= "cash_income ='" . $cash_income . "' ,";
					}
					if(isset($this->_request['wallet_income']))
					{
						$wallet_income=$this->_request['wallet_income'];
						$record .= "wallet_income ='" . $wallet_income . "' ,";
					}
					if(isset($this->_request['customer_ratings']))
					{
						$customer_ratings=$this->_request['customer_ratings'];
						$record .= "customer_ratings ='" . $customer_ratings . "' ,";
					}
					
					$record .= "application_no='" . $application_no. "' ,";
					$record .= "user_id='" . $user_id. "' ,";
					
					$data=date('Y-m-d');

					$record .= "date='" . $data. "' ,";
					
					$time=date('h:i:s a', time());	
					$record .= "time='" . $time. "' ,";
					
					$submitted=1;
					$record .= "submitted='" . $submitted. "' ,";
					
					$form_valid=1;
					$record .= "`form_valid`='" . $form_valid. "' ,";
					
					$submitted_date=date('d-m-Y');
					$record .= "submitted_date='" . $submitted_date. "' ,";
					
					$web_app=1;
					$record .= "web_app='" . $web_app. "'";
					
					$ins_new = $this->db->prepare("INSERT into `basic_details` set " . $record . " ");
					$ins_new->execute();

					$result=array('success' => 'Insert Successful '.$loan_amount,
                       		'application_no' =>$application_no);
							$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
							$this->response($this->json($success), 200);
					////
				}
				
				}
				else
				{
					$error = array('Type' => "Error", "Error" => "User not found", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
			}
			else 
				{
					$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
		}
		else 
		{
			$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
			$this->response($this->json($error), 400);
		}
			
		
    }
	///////// BUSINESS DETAILS
	public function business_detail() 
	{
	 	include_once("common/global.inc.php");
        global $link;
		if(isset($this->_request['response_type']))
		{
			$response_type=$this->_request['response_type'];
			$user_id=$this->_request['user_id'];
			if($response_type==1){
				
				$sql = $this->db->prepare("SELECT * FROM business_details where user_id=:user_id AND flag =0");
				$sql->bindParam(":user_id", $user_id, PDO::PARAM_INT);
				$sql->execute();
				 if ($sql->rowCount() != 0) 
				 {     
					$row_gp = $sql->fetch(PDO::FETCH_ASSOC);
					foreach($row_gp as $key=>$valye)	
					{
						$string_insert[$key]=$row_gp[$key];
					}
					
					$result1 = array("business_details" => $string_insert);
	
					$success = array('Type' => 'OK', "Error" => '', 'Responce' => $result1);
					$this->response($this->json($success), 200);
				} 
				else 
				{
					$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
			}
			/////// END OF  RESPONCE 1
			if($response_type==2){
				
				
				$login_chk = $this->db->prepare("select * from `logins` where id=:user_id");
				$login_chk->bindParam(":user_id", $user_id, PDO::PARAM_STR);
				$login_chk->execute();
				$login_count = $login_chk->rowCount();
				if($login_count > 0){
				
				$userres = $this->db->prepare("select `application_no` from `loan_statuses` where user_id=:user_id AND status =0");
				$userres->bindParam(":user_id", $user_id, PDO::PARAM_STR);
				$userres->execute();
				$pcnt = $userres->rowCount();
					if($pcnt > 0){
						$getuserid = $userres->fetch(PDO::FETCH_ASSOC);
						$application_no = $getuserid['application_no'];
						
						$basic_id = $this->db->prepare("select `id` from `business_details` where application_no=:application_no AND user_id =:user_id");
						$basic_id->bindParam(":user_id", $user_id, PDO::PARAM_STR);
						$basic_id->bindParam(":application_no", $application_no, PDO::PARAM_STR);
						$basic_id->execute();
						$bnusiness = $basic_id->rowCount();
						if($bnusiness > 0){
						$getid = $basic_id->fetch(PDO::FETCH_ASSOC);
						$update_id = $getid['id'];
						
						$record = '';
						if(isset($this->_request['legal_status_id']))
						{
							$legal_status_id=$this->_request['legal_status_id'];
							$record .= "legal_status_id ='" . $legal_status_id . "' ,";
						}
						if(isset($this->_request['company_name']))
						{
							$company_name=$this->_request['company_name'];
							$record .= "company_name ='" . $company_name . "' ,";
						}
						if(isset($this->_request['year_incorporation']))
						{
							$year_incorporation=$this->_request['year_incorporation'];
							$record .= "year_incorporation ='" . $year_incorporation . "' ,";
						}
						if(isset($this->_request['business_address']))
						{
							$business_address=$this->_request['business_address'];
							$record .= "business_address ='" . $business_address . "' ,";
						}
						if(isset($this->_request['business_pincode']))
						{
							$business_pincode=$this->_request['business_pincode'];
							$record .= "business_pincode ='" . $business_pincode . "' ,";
						}
						if(isset($this->_request['business_state']))
						{
							$business_state=$this->_request['business_state'];
							$record .= "busines_state ='" . $business_state . "' ,";
						}
						if(isset($this->_request['business_city']))
						{
							$business_city=$this->_request['business_city'];
							$record .= "business_city ='" . $business_city . "' ,";
						}
						if(isset($this->_request['business_ownership']))
						{
							$business_ownership=$this->_request['business_ownership'];
							$record .= "business_ownership ='" . $business_ownership . "' ,";
						}
						if(isset($this->_request['company_pan_no']))
						{
							$company_pan_no=$this->_request['company_pan_no'];
							$record .= "company_pan_no ='" . $company_pan_no . "' ,";
						}
						if(isset($this->_request['company_service_tax_no']))
						{
							$company_service_tax_no=$this->_request['company_service_tax_no'];
							$record .= "company_service_tax_no ='" . $company_service_tax_no . "' ,";
						}
						if(isset($this->_request['company_sale_tax_no']))
						{
							$company_sale_tax_no=$this->_request['company_sale_tax_no'];
							$record .= "company_sale_tax_no ='" . $company_sale_tax_no . "' ,";
						}
						if(isset($this->_request['no_of_employees']))
						{
							$no_of_employees=$this->_request['no_of_employees'];
							$record .= "no_of_employees ='" . $no_of_employees . "' ,";
						}
						if(isset($this->_request['website_url']))
						{
							$website_url=$this->_request['website_url'];
							$record .= "website_url ='" . $website_url . "' ,";
						}
						if(isset($this->_request['nature_of_business']))
						{
							$nature_of_business=$this->_request['nature_of_business'];
							$record .= "nature_of_business ='" . $nature_of_business . "' ,";
						}
						if(isset($this->_request['product_classification']))
						{
							$product_classification=$this->_request['product_classification'];
							$record .= "product_classification ='" . $product_classification . "' ,";
						}
						
						$form_valid=1;
						$record .= "`form_valid`='" . $form_valid. "' ,";
						
						$web_app=1;
						$record .= "web_app='" . $web_app. "'";
						
							$sql1= $this->db->prepare("update `business_details` set " . $record . " where id=:update_id");
							$sql1->bindParam(":update_id" , $update_id, PDO::PARAM_INT);
							$sql1->execute();
							
							if ($sql1){
								$result=array('success' => 'Updated Successful',
                       		'application_no' =>$application_no);
								$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
								$this->response($this->json($success), 200);
							}else {
								$result = "Updated Unsuccessful";
								$error = array('Type' => "Error", "Error" => "Some Error From Server",'Responce' => $result);
								$this->response($this->json($error), 400);
							}
						}
						else
						{
							////----------------- BASIC DETAILS INSERT
						
						$record = '';
						if(isset($this->_request['legal_status_id']))
						{
							$legal_status_id=$this->_request['legal_status_id'];
							$record .= "legal_status_id ='" . $legal_status_id . "' ,";
						}
						if(isset($this->_request['company_name']))
						{
							$company_name=$this->_request['company_name'];
							$record .= "company_name ='" . $company_name . "' ,";
						}
						if(isset($this->_request['year_incorporation']))
						{
							$year_incorporation=$this->_request['year_incorporation'];
							$record .= "year_incorporation ='" . $year_incorporation . "' ,";
						}
						if(isset($this->_request['business_address']))
						{
							$business_address=$this->_request['business_address'];
							$record .= "business_address ='" . $business_address . "' ,";
						}
						if(isset($this->_request['business_pincode']))
						{
							$business_pincode=$this->_request['business_pincode'];
							$record .= "business_pincode ='" . $business_pincode . "' ,";
						}
						if(isset($this->_request['busines_state']))
						{
							$busines_state=$this->_request['busines_state'];
							$record .= "busines_state ='" . $busines_state . "' ,";
						}
						if(isset($this->_request['business_city']))
						{
							$business_city=$this->_request['business_city'];
							$record .= "business_city ='" . $business_city . "' ,";
						}
						if(isset($this->_request['business_ownership']))
						{
							$business_ownership=$this->_request['business_ownership'];
							$record .= "business_ownership ='" . $business_ownership . "' ,";
						}
						if(isset($this->_request['company_pan_no']))
						{
							$company_pan_no=$this->_request['company_pan_no'];
							$record .= "company_pan_no ='" . $company_pan_no . "' ,";
						}
						if(isset($this->_request['company_service_tax_no']))
						{
							$company_service_tax_no=$this->_request['company_service_tax_no'];
							$record .= "company_service_tax_no ='" . $company_service_tax_no . "' ,";
						}
						if(isset($this->_request['company_sale_tax_no']))
						{
							$company_sale_tax_no=$this->_request['company_sale_tax_no'];
							$record .= "company_sale_tax_no ='" . $company_sale_tax_no . "' ,";
						}
						if(isset($this->_request['no_of_employees']))
						{
							$no_of_employees=$this->_request['no_of_employees'];
							$record .= "no_of_employees ='" . $no_of_employees . "' ,";
						}
						if(isset($this->_request['website_url']))
						{
							$website_url=$this->_request['website_url'];
							$record .= "website_url ='" . $website_url . "' ,";
						}
						if(isset($this->_request['nature_of_business']))
						{
							$nature_of_business=$this->_request['nature_of_business'];
							$record .= "nature_of_business ='" . $nature_of_business . "' ,";
						}
						if(isset($this->_request['product_classification']))
						{

							$product_classification=$this->_request['product_classification'];
							$record .= "product_classification ='" . $product_classification . "' ,";
						}
						
						$record .= "application_no='" . $application_no. "' ,";
						$record .= "user_id='" . $user_id. "' ,";
						
						$data=date('Y-m-d');
						$record .= "date='" . $data. "' ,";
						
						$time=date('h:i:s a', time());	
						$record .= "time='" . $time. "' ,";
						
						$form_valid=1;
						$record .= "`form_valid`='" . $form_valid. "' ,";
					
						$web_app=1;
						$record .= "web_app='" . $web_app. "'";
						
						$ins_new = $this->db->prepare("INSERT into `business_details` set " . $record . " ");
						$ins_new->execute();
	
							$result=array('success' => 'Insert Successful',
                       		'application_no' =>$application_no);
							$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
							$this->response($this->json($success), 200);
						////
							
						}
					}
				else if($pcnt==0)
					{
						$new_app = $this->db->prepare("select `application_no` from `loan_statuses` order by application_no DESC");
						$new_app->execute();
						$last_app = $new_app->fetch(PDO::FETCH_ASSOC);
						$app_no=$last_app['application_no'];
						////----------------- APPLICATION NO INCREMENT
						$facyear=date('Y') .'-'. (date('y')+1);
						$center='/APL';
						$murg=$facyear.$center;
						$incrementHERE=str_replace($murg,'',$app_no);
						$incrementHERE++;
						$len=strlen($incrementHERE);
						$mylen="";
						if($len==1)
						$mylen="000";
						else if($len==2)
						$mylen="00";
						else if($len==3)
						$mylen="0";
						$facyear=date('Y') .'-'. (date('y')+1);
						$center='/APL';
						$application_no=$facyear.$center.$mylen.$incrementHERE;
						////----------------- LOAN STATUS INSERT
						$sql_insert = $this->db->prepare("INSERT into loan_statuses(user_id,application_no)VALUES(:user_id,:application_no)");
						$sql_insert->bindParam(":user_id", $user_id, PDO::PARAM_STR);
						$sql_insert->bindParam(":application_no", $application_no, PDO::PARAM_STR);
						$sql_insert->execute();
						////----------------- LOAN STATUS INSERT END
						////----------------- NOTIFICATION INSERT
	
						$time=date('Y-m-d H:i:s');
						$massage='New user signup in portal';
						$icon='fa-pencil-square';
						$type=1;
						
						$sql_insert2 = $this->db->prepare("INSERT into `notifications`(text,date_time,type,icon)VALUES(:massage,:time,:type,:icon)");
						$sql_insert2->bindParam(":massage", $massage, PDO::PARAM_STR);
						$sql_insert2->bindParam(":time", $time, PDO::PARAM_STR);
						$sql_insert2->bindParam(":type", $type, PDO::PARAM_STR);
						$sql_insert2->bindParam(":icon", $icon, PDO::PARAM_STR);
						$sql_insert2->execute();
						////----------------- NOTIFICATION INSERT
						////----------------- BASIC DETAILS INSERT
						
						$record = '';
						if(isset($this->_request['legal_status_id']))
						{
							$legal_status_id=$this->_request['legal_status_id'];
							$record .= "legal_status_id ='" . $legal_status_id . "' ,";
						}
						if(isset($this->_request['company_name']))
						{
							$company_name=$this->_request['company_name'];
							$record .= "company_name ='" . $company_name . "' ,";
						}
						if(isset($this->_request['year_incorporation']))
						{
							$year_incorporation=$this->_request['year_incorporation'];
							$record .= "year_incorporation ='" . $year_incorporation . "' ,";
						}
						if(isset($this->_request['business_address']))
						{
							$business_address=$this->_request['business_address'];
							$record .= "business_address ='" . $business_address . "' ,";
						}
						if(isset($this->_request['business_pincode']))
						{
							$business_pincode=$this->_request['business_pincode'];
							$record .= "business_pincode ='" . $business_pincode . "' ,";
						}
						if(isset($this->_request['busines_state']))
						{
							$busines_state=$this->_request['busines_state'];
							$record .= "busines_state ='" . $busines_state . "' ,";
						}
						if(isset($this->_request['business_city']))
						{
							$business_city=$this->_request['business_city'];
							$record .= "business_city ='" . $business_city . "' ,";
						}
						if(isset($this->_request['business_ownership']))
						{
							$business_ownership=$this->_request['business_ownership'];
							$record .= "business_ownership ='" . $business_ownership . "' ,";
						}
						if(isset($this->_request['company_pan_no']))
						{
							$company_pan_no=$this->_request['company_pan_no'];
							$record .= "company_pan_no ='" . $company_pan_no . "' ,";
						}
						if(isset($this->_request['company_service_tax_no']))
						{
							$company_service_tax_no=$this->_request['company_service_tax_no'];
							$record .= "company_service_tax_no ='" . $company_service_tax_no . "' ,";
						}
						if(isset($this->_request['company_sale_tax_no']))
						{
							$company_sale_tax_no=$this->_request['company_sale_tax_no'];
							$record .= "company_sale_tax_no ='" . $company_sale_tax_no . "' ,";
						}
						if(isset($this->_request['no_of_employees']))
						{
							$no_of_employees=$this->_request['no_of_employees'];
							$record .= "no_of_employees ='" . $no_of_employees . "' ,";
						}
						if(isset($this->_request['website_url']))
						{
							$website_url=$this->_request['website_url'];
							$record .= "website_url ='" . $website_url . "' ,";
						}
						if(isset($this->_request['nature_of_business']))
						{
							$nature_of_business=$this->_request['nature_of_business'];
							$record .= "nature_of_business ='" . $nature_of_business . "' ,";
						}
						if(isset($this->_request['product_classification']))
						{

							$product_classification=$this->_request['product_classification'];
							$record .= "product_classification ='" . $product_classification . "' ,";
						}
						
						$record .= "application_no='" . $application_no. "' ,";
						$record .= "user_id='" . $user_id. "' ,";
						
						$data=date('Y-m-d');
						$record .= "date='" . $data. "' ,";
						
						$time=date('h:i:s a', time());	
						$record .= "time='" . $time. "' ,";
						
						$form_valid=1;
						$record .= "`form_valid`='" . $form_valid. "' ,";
					
						$web_app=1;
						$record .= "web_app='" . $web_app. "'";
						
						$ins_new = $this->db->prepare("INSERT into `business_details` set " . $record . " ");
						$ins_new->execute();
	
							$result=array('success' => 'Insert Successful',
                       		'application_no' =>$application_no);
							$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
							$this->response($this->json($success), 200);
						////
					}
				
				}
				else
				{
					$error = array('Type' => "Error", "Error" => "User not found", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
			}
			else 
				{
					$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
		}
		else 
		{
			$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
			$this->response($this->json($error), 400);
		}
		
    }
    ///////// LOAN DETAILS
	public function existing_loan() 
	{
	 	include_once("common/global.inc.php");
        global $link;
		if(isset($this->_request['response_type']))
		{
			 $response_type=$this->_request['response_type'];
			$user_id=$this->_request['user_id'];
				if($response_type==1){	

					$sql = $this->db->prepare("SELECT * FROM existing_loans where user_id=:user_id AND flag =0");
					$sql->bindParam(":user_id", $user_id, PDO::PARAM_INT);
					$sql->execute();
					
					 if ($sql->rowCount() != 0) 
					 {     
						$row_gp = $sql->fetch(PDO::FETCH_ASSOC);
						foreach($row_gp as $key=>$valye)	
						{
							$string_insert[$key]=$row_gp[$key];
						}
						
						
						$result1 = array("existing_loans" => $string_insert);
		
						$success = array('Type' => 'OK', "Error" => '', 'Responce' => $result1);
						$this->response($this->json($success), 200);
					} 
					else 
					{
						$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
						$this->response($this->json($error), 400);
					}
				}
					/////// END OF  RESPONCE 1
					if($response_type==2){
						
						
						$login_chk = $this->db->prepare("select * from `logins` where id=:user_id");
						$login_chk->bindParam(":user_id", $user_id, PDO::PARAM_STR);
						$login_chk->execute();
						$login_count = $login_chk->rowCount();
						if($login_count > 0){
						
						$userres = $this->db->prepare("select `application_no` from `loan_statuses` where user_id=:user_id AND status =0");
						$userres->bindParam(":user_id", $user_id, PDO::PARAM_STR);
						$userres->execute();
						$pcnt = $userres->rowCount();
						if($pcnt > 0){
							$getuserid = $userres->fetch(PDO::FETCH_ASSOC);
							$application_no = $getuserid['application_no'];
							
							$basic_id = $this->db->prepare("select `id` from `existing_loans` where application_no=:application_no AND user_id =:user_id");
							$basic_id->bindParam(":user_id", $user_id, PDO::PARAM_STR);
							$basic_id->bindParam(":application_no", $application_no, PDO::PARAM_STR);
							$basic_id->execute();
							$bnusiness = $basic_id->rowCount();
							if($bnusiness > 0){
							$getid = $basic_id->fetch(PDO::FETCH_ASSOC);
							$update_id = $getid['id'];
							
							$record = '';
							if(isset($this->_request['credit_facility']))
							{
								$credit_facility=$this->_request['credit_facility'];
								$record .= "credit_facility ='" . $credit_facility . "' ,";
							}
							if(isset($this->_request['od_cc_limit']))
							{
								$od_cc_limit=$this->_request['od_cc_limit'];
								$record .= "od_cc_limit ='" . $od_cc_limit . "' ,";
							}
							if(isset($this->_request['odcc_bank_name']))
							{
								$odcc_bank_name=$this->_request['odcc_bank_name'];
								$record .= "odcc_bank_name ='" . $odcc_bank_name . "' ,";
							}
							if(isset($this->_request['unsecured_busi_loan_amt']))
							{
								$unsecured_busi_loan_amt=$this->_request['unsecured_busi_loan_amt'];
								$record .= "unsecured_busi_loan_amt ='" . $unsecured_busi_loan_amt . "' ,";
							}
							if(isset($this->_request['business_bank_name']))
							{
								$business_bank_name=$this->_request['business_bank_name'];
								$record .= "business_bank_name ='" . $business_bank_name . "' ,";
							}
							if(isset($this->_request['loan_against_prop']))
							{
								$loan_against_prop=$this->_request['loan_against_prop'];
								$record .= "loan_against_prop ='" . $loan_against_prop . "' ,";
							}
							if(isset($this->_request['property_bank_name']))
							{
								$property_bank_name=$this->_request['property_bank_name'];
								$record .= "property_bank_name ='" . $property_bank_name . "' ,";
							}
							if(isset($this->_request['auto_loan_amt']))
							{
								$auto_loan_amt=$this->_request['auto_loan_amt'];
								$record .= "auto_loan_amt ='" . $auto_loan_amt . "' ,";
							}
							if(isset($this->_request['auto_bank_name']))
							{
								$auto_bank_name=$this->_request['auto_bank_name'];
								$record .= "auto_bank_name ='" . $auto_bank_name . "' ,";
							}
							if(isset($this->_request['personal_loan_amt']))
							{
								$personal_loan_amt=$this->_request['personal_loan_amt'];
								$record .= "personal_loan_amt ='" . $personal_loan_amt . "' ,";
							}
							if(isset($this->_request['personal_bank_name']))
							{
								$personal_bank_name=$this->_request['personal_bank_name'];
								$record .= "personal_bank_name ='" . $personal_bank_name . "' ,";
							}
							if(isset($this->_request['total_monthly_emi']))
							{
								$total_monthly_emi=$this->_request['total_monthly_emi'];
								$record .= "total_monthly_emi ='" . $total_monthly_emi . "' ,";
							}
							$form_valid=1;
							$record .= "`form_valid`='" . $form_valid. "' ,";
					
							$web_app=1;
							$record .= "web_app='" . $web_app. "'";
							
								$sql1= $this->db->prepare("update `existing_loans` set " . $record . " where id=:update_id");
								$sql1->bindParam(":update_id" , $update_id, PDO::PARAM_INT);
								$sql1->execute();
								
								if ($sql1){
									$result=array('success' => 'Updated Successful',
                       		'application_no' =>$application_no);
									$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
									$this->response($this->json($success), 200);
								}else {
									$result = "Updated Unsuccessful";
									$error = array('Type' => "Error", "Error" => "Some Error From Server",'Responce' => $result);
									$this->response($this->json($error), 400);
								}
							}
							else
							{
								////----------------- BASIC DETAILS INSERT
							
							$record = '';
							if(isset($this->_request['credit_facility']))
							{
								$credit_facility=$this->_request['credit_facility'];
								$record .= "credit_facility ='" . $credit_facility . "' ,";
							}
							if(isset($this->_request['od_cc_limit']))
							{
								$od_cc_limit=$this->_request['od_cc_limit'];
								$record .= "od_cc_limit ='" . $od_cc_limit . "' ,";
							}
							if(isset($this->_request['odcc_bank_name']))
							{
								$odcc_bank_name=$this->_request['odcc_bank_name'];
								$record .= "odcc_bank_name ='" . $odcc_bank_name . "' ,";
							}
							if(isset($this->_request['unsecured_busi_loan_amt']))
							{
								$unsecured_busi_loan_amt=$this->_request['unsecured_busi_loan_amt'];
								$record .= "unsecured_busi_loan_amt ='" . $unsecured_busi_loan_amt . "' ,";
							}
							if(isset($this->_request['business_bank_name']))
							{
								$business_bank_name=$this->_request['business_bank_name'];
								$record .= "business_bank_name ='" . $business_bank_name . "' ,";
							}
							if(isset($this->_request['loan_against_prop']))
							{
								$loan_against_prop=$this->_request['loan_against_prop'];
								$record .= "loan_against_prop ='" . $loan_against_prop . "' ,";
							}
							if(isset($this->_request['property_bank_name']))
							{
								$property_bank_name=$this->_request['property_bank_name'];
								$record .= "property_bank_name ='" . $property_bank_name . "' ,";
							}
							if(isset($this->_request['auto_loan_amt']))
							{
								$auto_loan_amt=$this->_request['auto_loan_amt'];
								$record .= "auto_loan_amt ='" . $auto_loan_amt . "' ,";
							}
							if(isset($this->_request['auto_bank_name']))
							{
								$auto_bank_name=$this->_request['auto_bank_name'];
								$record .= "auto_bank_name ='" . $auto_bank_name . "' ,";
							}
							if(isset($this->_request['personal_loan_amt']))
							{
								$personal_loan_amt=$this->_request['personal_loan_amt'];
								$record .= "personal_loan_amt ='" . $personal_loan_amt . "' ,";
							}
							if(isset($this->_request['personal_bank_name']))
							{
								$personal_bank_name=$this->_request['personal_bank_name'];
								$record .= "personal_bank_name ='" . $personal_bank_name . "' ,";
							}
							if(isset($this->_request['total_monthly_emi']))
							{
								$total_monthly_emi=$this->_request['total_monthly_emi'];
								$record .= "total_monthly_emi ='" . $total_monthly_emi . "' ,";
							}
							
							$record .= "application_no='" . $application_no. "' ,";
							$record .= "user_id='" . $user_id. "' ,";
							
							$data=date('Y-m-d');
							$record .= "date='" . $data. "' ,";
							
							$time=date('h:i:s a', time());	
							$record .= "time='" . $time. "' ,";
							
							$form_valid=1;
							$record .= "`form_valid`='" . $form_valid. "' ,";
							
							$web_app=1;
							$record .= "web_app='" . $web_app. "'";
							
							$ins_new = $this->db->prepare("INSERT into `existing_loans` set " . $record . " ");
							$ins_new->execute();
		
							$result=array('success' => 'Insert Successful',
                       		'application_no' =>$application_no);
							$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
							$this->response($this->json($success), 200);
							////
							}
						
						}
						else if($pcnt==0)
						{
							$new_app = $this->db->prepare("select `application_no` from `loan_statuses` order by application_no DESC");
							$new_app->execute();
							$last_app = $new_app->fetch(PDO::FETCH_ASSOC);
							$app_no=$last_app['application_no'];
							////----------------- APPLICATION NO INCREMENT
							$facyear=date('Y') .'-'. (date('y')+1);
							$center='/APL';
							$murg=$facyear.$center;
							$incrementHERE=str_replace($murg,'',$app_no);
							$incrementHERE++;
							$len=strlen($incrementHERE);
							$mylen="";
							if($len==1)
							$mylen="000";
							else if($len==2)
							$mylen="00";
							else if($len==3)
							$mylen="0";
							$facyear=date('Y') .'-'. (date('y')+1);
							$center='/APL';
							$application_no=$facyear.$center.$mylen.$incrementHERE;
							////----------------- LOAN STATUS INSERT
							$sql_insert = $this->db->prepare("INSERT into loan_statuses(user_id,application_no)VALUES(:user_id,:application_no)");
							$sql_insert->bindParam(":user_id", $user_id, PDO::PARAM_STR);
							$sql_insert->bindParam(":application_no", $application_no, PDO::PARAM_STR);
							$sql_insert->execute();
							////----------------- LOAN STATUS INSERT END
							////----------------- NOTIFICATION INSERT
		
							$time=date('Y-m-d H:i:s');
							$massage='New user signup in portal';
							$icon='fa-pencil-square';
							$type=1;
							
							$sql_insert2 = $this->db->prepare("INSERT into `notifications`(text,date_time,type,icon)VALUES(:massage,:time,:type,:icon)");
							$sql_insert2->bindParam(":massage", $massage, PDO::PARAM_STR);
							$sql_insert2->bindParam(":time", $time, PDO::PARAM_STR);
							$sql_insert2->bindParam(":type", $type, PDO::PARAM_STR);
							$sql_insert2->bindParam(":icon", $icon, PDO::PARAM_STR);
							$sql_insert2->execute();
							////----------------- NOTIFICATION INSERT
							////----------------- BASIC DETAILS INSERT
							
							$record = '';
							if(isset($this->_request['credit_facility']))
							{
								$credit_facility=$this->_request['credit_facility'];
								$record .= "credit_facility ='" . $credit_facility . "' ,";
							}
							if(isset($this->_request['od_cc_limit']))
							{
								$od_cc_limit=$this->_request['od_cc_limit'];
								$record .= "od_cc_limit ='" . $od_cc_limit . "' ,";
							}
							if(isset($this->_request['odcc_bank_name']))
							{
								$odcc_bank_name=$this->_request['odcc_bank_name'];
								$record .= "odcc_bank_name ='" . $odcc_bank_name . "' ,";
							}
							if(isset($this->_request['unsecured_busi_loan_amt']))
							{
								$unsecured_busi_loan_amt=$this->_request['unsecured_busi_loan_amt'];
								$record .= "unsecured_busi_loan_amt ='" . $unsecured_busi_loan_amt . "' ,";
							}
							if(isset($this->_request['business_bank_name']))
							{
								$business_bank_name=$this->_request['business_bank_name'];
								$record .= "business_bank_name ='" . $business_bank_name . "' ,";
							}
							if(isset($this->_request['loan_against_prop']))
							{
								$loan_against_prop=$this->_request['loan_against_prop'];
								$record .= "loan_against_prop ='" . $loan_against_prop . "' ,";
							}
							if(isset($this->_request['property_bank_name']))
							{
								$property_bank_name=$this->_request['property_bank_name'];
								$record .= "property_bank_name ='" . $property_bank_name . "' ,";
							}
							if(isset($this->_request['auto_loan_amt']))
							{
								$auto_loan_amt=$this->_request['auto_loan_amt'];
								$record .= "auto_loan_amt ='" . $auto_loan_amt . "' ,";
							}
							if(isset($this->_request['auto_bank_name']))
							{
								$auto_bank_name=$this->_request['auto_bank_name'];
								$record .= "auto_bank_name ='" . $auto_bank_name . "' ,";
							}
							if(isset($this->_request['personal_loan_amt']))
							{
								$personal_loan_amt=$this->_request['personal_loan_amt'];
								$record .= "personal_loan_amt ='" . $personal_loan_amt . "' ,";
							}
							if(isset($this->_request['personal_bank_name']))
							{
								$personal_bank_name=$this->_request['personal_bank_name'];
								$record .= "personal_bank_name ='" . $personal_bank_name . "' ,";
							}
							if(isset($this->_request['total_monthly_emi']))
							{
								$total_monthly_emi=$this->_request['total_monthly_emi'];
								$record .= "total_monthly_emi ='" . $total_monthly_emi . "' ,";
							}
							
							$record .= "application_no='" . $application_no. "' ,";
							$record .= "user_id='" . $user_id. "' ,";
							
							$data=date('Y-m-d');
							$record .= "date='" . $data. "' ,";
							
							$time=date('h:i:s a', time());	
							$record .= "time='" . $time. "' ,";
							
							$form_valid=1;
							$record .= "`form_valid`='" . $form_valid. "' ,";
							
							$web_app=1;
							$record .= "web_app='" . $web_app. "'";
							
							$ins_new = $this->db->prepare("INSERT into `existing_loans` set " . $record . " ");
							$ins_new->execute();
		
							$result=array('success' => 'Insert Successful',
                       		'application_no' =>$application_no);
							$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
							$this->response($this->json($success), 200);
							////
						}
						
					}
					else
					{
						$error = array('Type' => "Error", "Error" => "User not found", 'Responce' => '');
						$this->response($this->json($error), 400);
					}
				}
			else 
			{
				$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
				$this->response($this->json($error), 400);
			}
		}
		else 
		{
			$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
			$this->response($this->json($error), 400);
		}
    }
	///////// FINANCEIIAL DETAILS
	public function financial_detail() 
	{
	 	include_once("common/global.inc.php");
        global $link;
		if(isset($this->_request['response_type']))
		{
			$response_type=$this->_request['response_type'];
			$user_id=$this->_request['user_id'];
				if($response_type==1){	
					$sql = $this->db->prepare("SELECT * FROM financial_details where user_id=:user_id AND flag =0");
					$sql->bindParam(":user_id", $user_id, PDO::PARAM_INT);
					$sql->execute();
					 if ($sql->rowCount() != 0) 
					 {     
						$row_gp = $sql->fetch(PDO::FETCH_ASSOC);
						foreach($row_gp as $key=>$valye)	
						{
							$string_insert[$key]=$row_gp[$key];
						}
						
						$result1 = array("financial_details" => $string_insert);
		
						$success = array('Type' => 'OK', "Error" => '', 'Responce' => $result1);
						$this->response($this->json($success), 200);
					} 
					else 
					{
						$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
						$this->response($this->json($error), 400);
					}
				}
				/// End of One
					if($response_type==2){
						
						$login_chk = $this->db->prepare("select * from `logins` where id=:user_id");
						$login_chk->bindParam(":user_id", $user_id, PDO::PARAM_STR);
						$login_chk->execute();
						$login_count = $login_chk->rowCount();
						if($login_count > 0){
						
						$userres = $this->db->prepare("select `application_no` from `loan_statuses` where user_id=:user_id AND status =0");
						$userres->bindParam(":user_id", $user_id, PDO::PARAM_STR);
						$userres->execute();
						$pcnt = $userres->rowCount();
						if($pcnt > 0){
							$getuserid = $userres->fetch(PDO::FETCH_ASSOC);
							$application_no = $getuserid['application_no'];
							
							$basic_id = $this->db->prepare("select `id` from `financial_details` where application_no=:application_no AND user_id =:user_id");
							$basic_id->bindParam(":user_id", $user_id, PDO::PARAM_STR);
							$basic_id->bindParam(":application_no", $application_no, PDO::PARAM_STR);
							$basic_id->execute();
							$bnusiness = $basic_id->rowCount();
							if($bnusiness > 0){
							$getid = $basic_id->fetch(PDO::FETCH_ASSOC);
							$update_id = $getid['id'];
							
							$record = '';
							if(isset($this->_request['lastyear_turnover']))
							{
								$lastyear_turnover=$this->_request['lastyear_turnover'];
								$record .= "lastyear_turnover ='" . $lastyear_turnover . "' ,";
							}
							if(isset($this->_request['lastyear_profit']))
							{
								$lastyear_profit=$this->_request['lastyear_profit'];
								$record .= "lastyear_profit ='" . $lastyear_profit . "' ,";
							}
							if(isset($this->_request['business_assets']))
							{
								$business_assets=$this->_request['business_assets'];
								$record .= "business_assets ='" . $business_assets . "' ,";
							}
							if(isset($this->_request['received_period']))
							{
								$received_period=$this->_request['received_period'];
								$record .= "received_period ='" . $received_period . "' ,";
							}
							if(isset($this->_request['offered_customer']))
							{
								$offered_customer=$this->_request['offered_customer'];
								$record .= "offered_customer ='" . $offered_customer . "' ,";
							}
							if(isset($this->_request['inventory_retained']))
							{
								$inventory_retained=$this->_request['inventory_retained'];
								$record .= "inventory_retained ='" . $inventory_retained . "' ,";
							}
							if(isset($this->_request['auditors_name']))
							{
								$auditors_name=$this->_request['auditors_name'];
								$record .= "auditors_name ='" . $auditors_name . "' ,";
							}
							if(isset($this->_request['accounting_software']))
							{
								$accounting_software=$this->_request['accounting_software'];
								$record .= "accounting_software ='" . $accounting_software . "' ,";
							}
							if(isset($this->_request['existing_bankers']))
							{
								$existing_bankers=$this->_request['existing_bankers'];
								$record .= "existing_bankers ='" . $existing_bankers . "' ,";
							}
							if(isset($this->_request['ssi_unit']))
							{
								$ssi_unit=$this->_request['ssi_unit'];
								$record .= "ssi_unit ='" . $ssi_unit . "' ,";
							}
							if(isset($this->_request['ssi_unit_name']))
							{
								$ssi_unit_name=$this->_request['ssi_unit_name'];
								$record .= "ssi_unit_name ='" . $ssi_unit_name . "' ,";
							}
							if(isset($this->_request['business_insurance']))
							{
								$business_insurance=$this->_request['business_insurance'];
								$record .= "business_insurance ='" . $business_insurance . "' ,";
							}
							$form_valid=1;
							$record .= "`form_valid`='" . $form_valid. "' ,";
							
							$web_app=1;
							$record .= "web_app='" . $web_app. "'";
							
								$sql1= $this->db->prepare("update `financial_details` set " . $record . " where id=:update_id");
								$sql1->bindParam(":update_id" , $update_id, PDO::PARAM_INT);
								$sql1->execute();
								
								if ($sql1){
									$result=array('success' => 'Updated Successful',
                       		'application_no' =>$application_no);
									$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
									$this->response($this->json($success), 200);
								}else {
									$result = "Updated Unsuccessful";
									$error = array('Type' => "Error", "Error" => "Some Error From Server",'Responce' => $result);
									$this->response($this->json($error), 400);
								}
							}
							else
							{
								////----------------- BASIC DETAILS INSERT
							
							$record = '';
							if(isset($this->_request['lastyear_turnover']))
							{
								$lastyear_turnover=$this->_request['lastyear_turnover'];
								$record .= "lastyear_turnover ='" . $lastyear_turnover . "' ,";
							}
							if(isset($this->_request['lastyear_profit']))
							{
								$lastyear_profit=$this->_request['lastyear_profit'];
								$record .= "lastyear_profit ='" . $lastyear_profit . "' ,";
							}
							if(isset($this->_request['business_assets']))
							{
								$business_assets=$this->_request['business_assets'];
								$record .= "business_assets ='" . $business_assets . "' ,";
							}
							if(isset($this->_request['received_period']))
							{
								$received_period=$this->_request['received_period'];
								$record .= "received_period ='" . $received_period . "' ,";
							}
							if(isset($this->_request['offered_customer']))
							{
								$offered_customer=$this->_request['offered_customer'];
								$record .= "offered_customer ='" . $offered_customer . "' ,";
							}
							if(isset($this->_request['inventory_retained']))
							{
								$inventory_retained=$this->_request['inventory_retained'];
								$record .= "inventory_retained ='" . $inventory_retained . "' ,";
							}
							if(isset($this->_request['auditors_name']))
							{
								$auditors_name=$this->_request['auditors_name'];
								$record .= "auditors_name ='" . $auditors_name . "' ,";
							}
							if(isset($this->_request['accounting_software']))
							{
								$accounting_software=$this->_request['accounting_software'];
								$record .= "accounting_software ='" . $accounting_software . "' ,";
							}
							if(isset($this->_request['existing_bankers']))
							{
								$existing_bankers=$this->_request['existing_bankers'];
								$record .= "existing_bankers ='" . $existing_bankers . "' ,";
							}
							if(isset($this->_request['ssi_unit']))
							{
								$ssi_unit=$this->_request['ssi_unit'];
								$record .= "ssi_unit ='" . $ssi_unit . "' ,";
							}
							if(isset($this->_request['ssi_unit_name']))
							{
								$ssi_unit_name=$this->_request['ssi_unit_name'];
								$record .= "ssi_unit_name ='" . $ssi_unit_name . "' ,";
							}
							if(isset($this->_request['business_insurance']))
							{
								$business_insurance=$this->_request['business_insurance'];
								$record .= "business_insurance ='" . $business_insurance . "' ,";
							}
							
							$record .= "application_no='" . $application_no. "' ,";
							$record .= "user_id='" . $user_id. "' ,";
							
							$data=date('Y-m-d');
							$record .= "date='" . $data. "' ,";
							
							$time=date('h:i:s a', time());	
							$record .= "time='" . $time. "' ,";
							
							$form_valid=1;
							$record .= "`form_valid`='" . $form_valid. "' ,";
							
							$web_app=1;
							$record .= "web_app='" . $web_app. "'";
							
							$ins_new = $this->db->prepare("INSERT into `financial_details` set " . $record . " ");
							$ins_new->execute();
		
							$result=array('success' => 'Insert Successful',
                       		'application_no' =>$application_no);
							$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
							$this->response($this->json($success), 200);
							////
							}
						}
						else if($pcnt==0)
						{
							$new_app = $this->db->prepare("select `application_no` from `loan_statuses` order by application_no DESC");
							$new_app->execute();
							$last_app = $new_app->fetch(PDO::FETCH_ASSOC);
							$app_no=$last_app['application_no'];
							////----------------- APPLICATION NO INCREMENT
							$facyear=date('Y') .'-'. (date('y')+1);
							$center='/APL';
							$murg=$facyear.$center;
							$incrementHERE=str_replace($murg,'',$app_no);
							$incrementHERE++;
							$len=strlen($incrementHERE);
							$mylen="";
							if($len==1)
							$mylen="000";
							else if($len==2)
							$mylen="00";
							else if($len==3)
							$mylen="0";
							$facyear=date('Y') .'-'. (date('y')+1);
							$center='/APL';
							$application_no=$facyear.$center.$mylen.$incrementHERE;
							////----------------- LOAN STATUS INSERT
							$sql_insert = $this->db->prepare("INSERT into loan_statuses(user_id,application_no)VALUES(:user_id,:application_no)");
							$sql_insert->bindParam(":user_id", $user_id, PDO::PARAM_STR);
							$sql_insert->bindParam(":application_no", $application_no, PDO::PARAM_STR);
							$sql_insert->execute();
							////----------------- LOAN STATUS INSERT END
							////----------------- NOTIFICATION INSERT
		
							$time=date('Y-m-d H:i:s');
							$massage='New user signup in portal';
							$icon='fa-pencil-square';
							$type=1;
							
							$sql_insert2 = $this->db->prepare("INSERT into `notifications`(text,date_time,type,icon)VALUES(:massage,:time,:type,:icon)");
							$sql_insert2->bindParam(":massage", $massage, PDO::PARAM_STR);
							$sql_insert2->bindParam(":time", $time, PDO::PARAM_STR);
							$sql_insert2->bindParam(":type", $type, PDO::PARAM_STR);
							$sql_insert2->bindParam(":icon", $icon, PDO::PARAM_STR);
							$sql_insert2->execute();
							////----------------- NOTIFICATION INSERT
							////----------------- BASIC DETAILS INSERT
							
							$record = '';
							if(isset($this->_request['lastyear_turnover']))
							{
								$lastyear_turnover=$this->_request['lastyear_turnover'];
								$record .= "lastyear_turnover ='" . $lastyear_turnover . "' ,";
							}
							if(isset($this->_request['lastyear_profit']))
							{
								$lastyear_profit=$this->_request['lastyear_profit'];
								$record .= "lastyear_profit ='" . $lastyear_profit . "' ,";
							}
							if(isset($this->_request['business_assets']))
							{
								$business_assets=$this->_request['business_assets'];
								$record .= "business_assets ='" . $business_assets . "' ,";
							}
							if(isset($this->_request['received_period']))
							{
								$received_period=$this->_request['received_period'];
								$record .= "received_period ='" . $received_period . "' ,";
							}
							if(isset($this->_request['offered_customer']))
							{
								$offered_customer=$this->_request['offered_customer'];
								$record .= "offered_customer ='" . $offered_customer . "' ,";
							}
							if(isset($this->_request['inventory_retained']))
							{
								$inventory_retained=$this->_request['inventory_retained'];
								$record .= "inventory_retained ='" . $inventory_retained . "' ,";
							}
							if(isset($this->_request['auditors_name']))
							{
								$auditors_name=$this->_request['auditors_name'];
								$record .= "auditors_name ='" . $auditors_name . "' ,";
							}
							if(isset($this->_request['accounting_software']))
							{
								$accounting_software=$this->_request['accounting_software'];
								$record .= "accounting_software ='" . $accounting_software . "' ,";
							}
							if(isset($this->_request['existing_bankers']))
							{
								$existing_bankers=$this->_request['existing_bankers'];
								$record .= "existing_bankers ='" . $existing_bankers . "' ,";
							}
							if(isset($this->_request['ssi_unit']))
							{
								$ssi_unit=$this->_request['ssi_unit'];
								$record .= "ssi_unit ='" . $ssi_unit . "' ,";
							}
							if(isset($this->_request['ssi_unit_name']))
							{
								$ssi_unit_name=$this->_request['ssi_unit_name'];
								$record .= "ssi_unit_name ='" . $ssi_unit_name . "' ,";
							}
							if(isset($this->_request['business_insurance']))
							{
								$business_insurance=$this->_request['business_insurance'];
								$record .= "business_insurance ='" . $business_insurance . "' ,";
							}
							
							$record .= "application_no='" . $application_no. "' ,";
							$record .= "user_id='" . $user_id. "' ,";
							
							$data=date('Y-m-d');
							$record .= "date='" . $data. "' ,";
							
							$time=date('h:i:s a', time());	
							$record .= "time='" . $time. "' ,";
							
							$form_valid=1;
							$record .= "`form_valid`='" . $form_valid. "' ,";
							
							$web_app=1;
							$record .= "web_app='" . $web_app. "'";
							
							$ins_new = $this->db->prepare("INSERT into `financial_details` set " . $record . " ");
							$ins_new->execute();
		
							$result=array('success' => 'Insert Successful',
                       		'application_no' =>$application_no);
							$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
							$this->response($this->json($success), 200);
							////
						}
						
					}
					else
					{
						$error = array('Type' => "Error", "Error" => "User not found", 'Responce' => '');
						$this->response($this->json($error), 400);
					}
				}

				else 
				{
					$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
		}
		else 
		{
			$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
			$this->response($this->json($error), 400);
		}
    }
	///////// PERSONAL DETAILS
	public function ownership_detail() 
	{
 		include_once("common/global.inc.php");
        global $link;
		if(isset($this->_request['response_type']))
		{
			$response_type=$this->_request['response_type'];
			$user_id=$this->_request['user_id'];
			if($response_type==1){
				
				$sql = $this->db->prepare("SELECT * FROM `ownership_details` where user_id=:user_id AND flag =0");
				$sql->bindParam(":user_id", $user_id, PDO::PARAM_INT);
				$sql->execute();
				 if ($sql->rowCount() != 0) {     
						$row_gp = $sql->fetch(PDO::FETCH_ASSOC);
					foreach($row_gp as $key=>$valye)	
					{
						$string_insert[$key]=$row_gp[$key];
					}
					
					$result1 = array("ownership_details" => $string_insert);
					$success = array('Type' => 'OK', "Error" => '', 'Responce' => $result1);
					$this->response($this->json($success), 200);
				} else {
					$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
			}
			/////// END OF  RESPONCE 1
			if($response_type==2){
				if(isset($this->_request['data'])){
				$data=$this->_request['data'];
				$exolode_data=explode('|||', $data);
				$login_chk = $this->db->prepare("select * from `logins` where id=:user_id  ");
				$login_chk->bindParam(":user_id", $user_id, PDO::PARAM_STR);
				$login_chk->execute();
				$login_count = $login_chk->rowCount();
				if($login_count > 0){
				
				$userres = $this->db->prepare("select `application_no` from `loan_statuses` where user_id=:user_id AND status =0");
				$userres->bindParam(":user_id", $user_id, PDO::PARAM_STR);
				$userres->execute();
				$pcnt = $userres->rowCount();
				if($pcnt > 0){
					$getuserid = $userres->fetch(PDO::FETCH_ASSOC);
					$application_no = $getuserid['application_no'];
					
					$basic_id = $this->db->prepare("select `id` from `ownership_details` where application_no=:application_no AND user_id =:user_id");
					$basic_id->bindParam(":user_id", $user_id, PDO::PARAM_STR);
					$basic_id->bindParam(":application_no", $application_no, PDO::PARAM_STR);
					$basic_id->execute();
 					
					if ($basic_id->rowCount() != 0) 
					{
						while($row_gp = $basic_id->fetch(PDO::FETCH_ASSOC))
						{		//////////// Delete Code 		
 								$id=$row_gp['id'];
								$delete = $this->db->prepare("delete from `ownership_details` where  id=:id");
								$delete->bindParam(":id", $id, PDO::PARAM_INT);
								$delete->execute();
 						}
					} 
					//////////// INSERT CODE
					
						$x=0;
						foreach($exolode_data as $val)
						{$record='';
							$value=explode('!+!', $val);
							////insert
							$record .= "`name`='" . $value[0]. "' ,";
							$record .= "`dob`='" . $value[1]. "' ,";
							$record .= "`gender`='" . $value[2]. "' ,";
							$record .= "`education`='" . $value[3]. "' ,";
							$record .= "`marital_status`='" . $value[4]. "' ,";
							$record .= "`user_pan`='" . $value[5]. "' ,";
							$record .= "`user_aadhar_no`='" . $value[6]. "' ,";
							$record .= "`user_annual_income`='" . $value[7]. "' ,";
							$record .= "`total_depends`='" . $value[8]. "' ,";
							$record .= "`spouse_annual_income`='" . $value[9]. "' ,";
							$record .= "`residential_address`='" . $value[10]. "' ,";
							$record .= "`user_pincode`='" . $value[11]. "' ,";
							$record .= "`user_residence_ownership`='" . $value[12]. "' ,";
							
							$record .= "`application_no`='" . $application_no. "' ,";
							$record .= "`user_id`='" . $user_id. "' ,";
							
							$data=date('Y-m-d');
							$record .= "`date`='" . $data. "' ,";
							
							$time=date('h:i:s a', time());	
							$record .= "`time`='" . $time. "' ,";
							
							$form_valid=1;
							$record .= "`form_valid`='" . $form_valid. "' ,";
							
							$web_app=1;
							$record .= "`web_app`='" . $web_app. "'";
							
							$ins_new = $this->db->prepare("INSERT into `ownership_details` set " . $record . " ");
							$ins_new->execute();
							
							$ins_new='';
							$x++;
						}
						if($x>0){
						$result=array('success' => 'Insert Successful',
							'application_no' =>$application_no);
							$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
							$this->response($this->json($success), 200);
						}
					
				}
				else if($pcnt==0)
				{
					$new_app = $this->db->prepare("select `application_no` from `loan_statuses` order by application_no DESC");
					$new_app->execute();
					$last_app = $new_app->fetch(PDO::FETCH_ASSOC);
					$app_no=$last_app['application_no'];
					////----------------- APPLICATION NO INCREMENT
					$facyear=date('Y') .'-'. (date('y')+1);
					$center='/APL';
					$murg=$facyear.$center;
					$incrementHERE=str_replace($murg,'',$app_no);
					$incrementHERE++;
					$len=strlen($incrementHERE);
					$mylen="";
					if($len==1)
					$mylen="000";
					else if($len==2)
					$mylen="00";
					else if($len==3)
					$mylen="0";
					$facyear=date('Y') .'-'. (date('y')+1);
					$center='/APL';
					$application_no=$facyear.$center.$mylen.$incrementHERE;
					////----------------- LOAN STATUS INSERT
					$sql_insert = $this->db->prepare("INSERT into loan_statuses(user_id,application_no)VALUES(:user_id,:application_no)");
                	$sql_insert->bindParam(":user_id", $user_id, PDO::PARAM_STR);
					$sql_insert->bindParam(":application_no", $application_no, PDO::PARAM_STR);
					$sql_insert->execute();
					////----------------- LOAN STATUS INSERT END
					////----------------- NOTIFICATION INSERT

					$time=date('Y-m-d H:i:s');
					$massage='New user signup in portal';
					$icon='fa-pencil-square';
					$type=1;
					
					$sql_insert2 = $this->db->prepare("INSERT into `notifications`(text,date_time,type,icon)VALUES(:massage,:time,:type,:icon)");
					$sql_insert2->bindParam(":massage", $massage, PDO::PARAM_STR);
					$sql_insert2->bindParam(":time", $time, PDO::PARAM_STR);
					$sql_insert2->bindParam(":type", $type, PDO::PARAM_STR);
					$sql_insert2->bindParam(":icon", $icon, PDO::PARAM_STR);
                    $sql_insert2->execute();
					////----------------- NOTIFICATION INSERT
					////----------------- BASIC DETAILS INSERT
					
						$x=0;
						foreach($exolode_data as $val)
						{$record='';
							$value=explode('!+!', $val);
							////insert
							$record .= "`name`='" . $value[0]. "' ,";
							$record .= "`dob`='" . $value[1]. "' ,";
							$record .= "`gender`='" . $value[2]. "' ,";
							$record .= "`education`='" . $value[3]. "' ,";
							$record .= "`marital_status`='" . $value[4]. "' ,";
							$record .= "`user_pan`='" . $value[5]. "' ,";
							$record .= "`user_aadhar_no`='" . $value[6]. "' ,";
							$record .= "`user_annual_income`='" . $value[7]. "' ,";
							$record .= "`total_depends`='" . $value[8]. "' ,";
							$record .= "`spouse_annual_income`='" . $value[9]. "' ,";
							$record .= "`residential_address`='" . $value[10]. "' ,";
							$record .= "`user_pincode`='" . $value[11]. "' ,";
							$record .= "`user_residence_ownership`='" . $value[12]. "' ,";
							
							
							
							$record .= "`application_no`='" . $application_no. "' ,";
							$record .= "`user_id`='" . $user_id. "' ,";
							
							$data=date('Y-m-d');
							$record .= "`date`='" . $data. "' ,";
							
							$time=date('h:i:s a', time());	
							$record .= "`time`='" . $time. "' ,";
							
							$form_valid=1;
							$record .= "`form_valid`='" . $form_valid. "' ,";
														
							$web_app=1;
							$record .= "`web_app`='" . $web_app. "'";
							
							$ins_new = $this->db->prepare("INSERT into `ownership_details` set " . $record . " ");
							$ins_new->execute();
							
							$ins_new='';
							$x++;
						}
							if($x>0){
							$result=array('success' => 'Insert Successful',
								'application_no' =>$application_no);
								$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
								$this->response($this->json($success), 200);
							}
					
					
					}
				
				}
				else
				{
					$error = array('Type' => "Error", "Error" => "User not found", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
			}
			else 
				{
					$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
			}
			else
			{
				$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
					$this->response($this->json($error), 400);
			}
		}
		else 
		{
			$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
			$this->response($this->json($error), 400);
		}
    }
	///////// Refrrance Details
	public function reference() 
	{
 		include_once("common/global.inc.php");
        global $link;
		if(isset($this->_request['response_type']))
		{
			$response_type=$this->_request['response_type'];
			$user_id=$this->_request['user_id'];
			if($response_type==1){
				
				$sql = $this->db->prepare("SELECT * FROM `references` where user_id=:user_id AND flag =0");
				$sql->bindParam(":user_id", $user_id, PDO::PARAM_INT);
				$sql->execute();
				 if ($sql->rowCount() != 0) {     
						$row_gp = $sql->fetch(PDO::FETCH_ASSOC);
					foreach($row_gp as $key=>$valye)	
					{
						$string_insert[$key]=$row_gp[$key];
					}
					
					$result1 = array("references" => $string_insert);
					$success = array('Type' => 'OK', "Error" => '', 'Responce' => $result1);
					$this->response($this->json($success), 200);
				} else {
					$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
			}
			/////// END OF  RESPONCE 1
			if($response_type==2){
				if(isset($this->_request['data'])){
				$data=$this->_request['data'];
				$exolode_data=explode('|||', $data);

				$login_chk = $this->db->prepare("select * from `logins` where id=:user_id");
				$login_chk->bindParam(":user_id", $user_id, PDO::PARAM_STR);
				$login_chk->execute();
				$login_count = $login_chk->rowCount();
				if($login_count > 0){
				
				$userres = $this->db->prepare("select `application_no` from `loan_statuses` where user_id=:user_id AND status =0");
				$userres->bindParam(":user_id", $user_id, PDO::PARAM_STR);
				$userres->execute();
				$pcnt = $userres->rowCount();
				if($pcnt > 0){
					$getuserid = $userres->fetch(PDO::FETCH_ASSOC);
					$application_no = $getuserid['application_no'];
					
					$basic_id = $this->db->prepare("select * from `references` where application_no=:application_no AND user_id =:user_id");
					$basic_id->bindParam(":user_id", $user_id, PDO::PARAM_STR);
					$basic_id->bindParam(":application_no", $application_no, PDO::PARAM_STR);
					$basic_id->execute();
					$basic_id->rowCount();
					
					if ($basic_id->rowCount() != 0) 
					{
						while($row_gp = $basic_id->fetch(PDO::FETCH_ASSOC))
						{		//////////// Delete Code 		
 								$id=$row_gp['id'];
								$delete = $this->db->prepare("delete from `references` where  id=:id");
								$delete->bindParam(":id", $id, PDO::PARAM_INT);
								$delete->execute();
 						}
					} 
					//////////// Insert Code 
					
						$x=0;
						foreach($exolode_data as $val)
						{$record='';
							$value=explode('!+!', $val);
							
							////insert
							$record .= "`references_name`='" . $value[0]. "' ,";
							$record .= "`references_mobile`='" . $value[1]. "' ,";
							$record .= "`references_address`='" . $value[2]. "' ,";
							$record .= "`references_relation`='" . $value[3]. "' ,";
							
							$record .= "`application_no`='" . $application_no. "' ,";
							$record .= "`user_id`='" . $user_id. "' ,";
							
							$data=date('Y-m-d');
							$record .= "`date`='" . $data. "' ,";
							
							$time=date('h:i:s a', time());	
							$record .= "`time`='" . $time. "' ,";
							
							$form_valid=1;
							$record .= "`form_valid`='" . $form_valid. "' ,";
							
							$web_app=1;
							$record .= "`web_app`='" . $web_app. "'";
							
							$ins_new = $this->db->prepare("INSERT into `references` set " . $record . " ");
							
							$ins_new->execute();
							
							$ins_new='';
							$x++;
						}
						
						if($x>0){
						$result=array('success' => 'Insert Successful',
							'application_no' =>$application_no);
							$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
							$this->response($this->json($success), 200);
						}
					
					////
				
						
					
				}
				else if($pcnt==0)
				{
					$new_app = $this->db->prepare("select `application_no` from `loan_statuses` order by application_no DESC");
					$new_app->execute();
					$last_app = $new_app->fetch(PDO::FETCH_ASSOC);
					$app_no=$last_app['application_no'];
					////----------------- APPLICATION NO INCREMENT
					$facyear=date('Y') .'-'. (date('y')+1);
					$center='/APL';
					$murg=$facyear.$center;
					$incrementHERE=str_replace($murg,'',$app_no);
					$incrementHERE++;
					$len=strlen($incrementHERE);
					$mylen="";
					if($len==1)
					$mylen="000";
					else if($len==2)
					$mylen="00";
					else if($len==3)
					$mylen="0";
					$facyear=date('Y') .'-'. (date('y')+1);
					$center='/APL';
					$application_no=$facyear.$center.$mylen.$incrementHERE;
					////----------------- LOAN STATUS INSERT
					$sql_insert = $this->db->prepare("INSERT into loan_statuses(user_id,application_no)VALUES(:user_id,:application_no)");
                	$sql_insert->bindParam(":user_id", $user_id, PDO::PARAM_STR);
					$sql_insert->bindParam(":application_no", $application_no, PDO::PARAM_STR);
					$sql_insert->execute();
					////----------------- LOAN STATUS INSERT END
					////----------------- NOTIFICATION INSERT

					$time=date('Y-m-d H:i:s');
					$massage='New user signup in portal';
					$icon='fa-pencil-square';
					$type=1;
					
					$sql_insert2 = $this->db->prepare("INSERT into `notifications`(text,date_time,type,icon)VALUES(:massage,:time,:type,:icon)");
					$sql_insert2->bindParam(":massage", $massage, PDO::PARAM_STR);
					$sql_insert2->bindParam(":time", $time, PDO::PARAM_STR);
					$sql_insert2->bindParam(":type", $type, PDO::PARAM_STR);
					$sql_insert2->bindParam(":icon", $icon, PDO::PARAM_STR);
                    $sql_insert2->execute();
					////----------------- NOTIFICATION INSERT

					////----------------- BASIC DETAILS INSERT
					
						$x=0;
						foreach($exolode_data as $val)
						{$record='';
							$value=explode('!+!', $val);
							////insert
							$record .= "`references_name`='" . $value[0]. "' ,";
							$record .= "`references_mobile`='" . $value[1]. "' ,";
							$record .= "`references_address`='" . $value[2]. "' ,";
							$record .= "`references_relation`='" . $value[3]. "' ,";
							
							$record .= "`application_no`='" . $application_no. "' ,";
							$record .= "`user_id`='" . $user_id. "' ,";
							
							$data=date('Y-m-d');
							$record .= "`date`='" . $data. "' ,";
							
							$time=date('h:i:s a', time());	
							$record .= "`time`='" . $time. "' ,";
							
							$form_valid=1;
							$record .= "`form_valid`='" . $form_valid. "' ,";
							
							$web_app=1;
							$record .= "`web_app`='" . $web_app. "'";
							
							$ins_new = $this->db->prepare("INSERT into `references` set " . $record . " ");
							$ins_new->execute();
							
							$ins_new='';
							$x++;
						}
							if($x>0){
							$result=array('success' => 'Insert Successful',
								'application_no' =>$application_no);
								$success = array('Type' => 'OK', "Error" => '','Responce' => $result);
								$this->response($this->json($success), 200);
							}
					}
				
				}
				else
				{
					$error = array('Type' => "Error", "Error" => "User not found", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
			}
			else 
				{
					$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
					$this->response($this->json($error), 400);
				}
			}
			else
			{
				$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
					$this->response($this->json($error), 400);
			}
		}
		else 
		{
			$error = array('Type' => "Error", "Error" => "No data found", 'Responce' => '');
			$this->response($this->json($error), 400);
		}
    }
	///////// Image Upload 
	function image_upload() 
	{
			// Cross validation if the request method is DELETE else it will return "Not Acceptable" status
			if ($this->get_request_method() != "POST") {
				$this->response('', 406);
			}
			
			 @$user_id = $this->_request['user_id'];
			 @$image = $this->_request['image'];
			 @$tmpname = $_FILES['file']['tmp_name'];
			 @$name = time() . $_FILES["file"]["name"];
			 @$orname = time() . "lar_" . $_FILES["file"]["name"];
		
			$buffer = ImageCreateFromJPEG($tmpname);
			$exif = exif_read_data($tmpname);
			 
			if(!empty($exif['Orientation'])){
				switch($exif['Orientation']){
					case 8:
						$buffer = imagerotate($buffer,90,0);
					break;
					case 3:
						$buffer = imagerotate($buffer,180,0);
					break;
					case 6:
						$buffer = imagerotate($buffer,-90,0);
					break;
				}
			}
			imagejpeg($buffer, $tmpname, 90);
			
			@$image_resp = @$this->img_resize($user_id, $image, $tmpname, 200, dirname(__FILE__)."/../webroot/patient", $name, 1);
							
			$this->response($this->json($image_resp), 400);
		}
	///////// Image Resize
    function img_resize($user_id, $image, $tmpname, $size, $save_dir, $save_name, $maxisheight = 0) 
	{
        global $link;
        include_once("common/global.inc.php");

        $save_dir .= ( substr($save_dir, -1) != "/") ? "/" : "";
        $gis = getimagesize($tmpname);
        $type = $gis[2];
        switch ($type) {
            case "1": $imorig = imagecreatefromgif($tmpname);
                break;
            case "2": $imorig = imagecreatefromjpeg($tmpname);
                break;
            case "3": $imorig = imagecreatefrompng($tmpname);
                break;
            default: $imorig = imagecreatefromjpeg($tmpname);
        }

        $x = imagesx($imorig);
        $y = imagesy($imorig);

        $woh = (!$maxisheight) ? $gis[0] : $gis[1];

        if ($woh <= $size) {
            $aw = $x;
            $ah = $y;
        } else {
            if (!$maxisheight) {
                $aw = $size;
                $ah = $size * $y / $x;
            } else {
                $aw = $size * $x / $y;
                $ah = $size;
            }
        }
		
        $im = imagecreatetruecolor($aw, $ah);
		
        if (imagecopyresampled($im, $imorig, 0, 0, 0, 0, $aw, $ah, $x, $y)) {
        // print_r(dirname(__FILE__)."/../webroot/patient/".$save_name);
		 // var_dump(imagejpeg($im, dirname(__FILE__)."/../webroot/patient/".$save_name));exit;
		   if (imagejpeg($im, $save_dir . $save_name)) {
		    
                if (move_uploaded_file($tmpname, dirname(__FILE__)."/../webroot/patient/".$save_name)) {
                    $thumb_save_folder = dirname(__FILE__)."/../webroot/patient/".$save_name;
                    $image_save_folder = dirname(__FILE__)."/../webroot/patient/".$save_name;
                   
					$ext = explode('.', $save_name);
           
                    if ($ext[1] == "png") {
                        $im = imagecreatefrompng($image_save_folder);
                        imagepng($im, $thumb_save_folder);
                    } else if ($ext[1] == "gif") {
                        $im = ImageCreateFromgif($image_save_folder);
                        imagegif($im, $thumb_save_folder);
                    } else {
                        $im = imagecreatefromjpeg($image_save_folder);
                        imagejpeg($im, $thumb_save_folder);
                    }
					
					$sql_update = $this->db->prepare("update registration_patients set file=:file where id=:id");
                    //$sql_insert = $this->db->prepare("INSERT into tbl_userpicture(user_id,original_picture,thumbnail_picture,isProfilePicture) VALUES(:userid,:save_name,:save_name,:image)");
                    $sql_update->bindParam(":id", $user_id, PDO::PARAM_INT);
                    $sql_update->bindParam(":file", $save_name, PDO::PARAM_STR);
                    $sql_update->execute();
					
                    if ($sql_update) {

                        $success = array('Type' => "OK", "Error" => "", 'Responce' => 'success');
                        //$this->response($this->json($success), 200);
                    } else {
                        $success = array('Type' => "Error", "Error" => "Some Error From Server", 'Responce' => 'erroe');
                        //$this->response($this->json($error), 400);
                    }
					return $success;
                }
				
                return true;
            } else {
              
			   return false;
            }
        }
    }





//--------------                      END OF Dsu Menaria DEVELOP API FUNCTION                       --------------------  ///
	function sendmail($to,$from, $from_name, $subject, $message_web,  $is_gmail=true)
	{
		App::import('Vendor', 'PhpMailer', array('file' => 'phpmailer' . DS . 'class.phpmailer.php')); 
	
			global $error;
			
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->CharSet = 'UTF-8';
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl'; 
			$mail->Host = 'smtp.googlemail.com';
			$mail->Port = 465;  
			$mail->Username = 'ankit.sisodiya@spsu.ac.in';  
			$mail->Password = '!QAZSPSU@WSX';
			$mail->SMTPDebug = 1; 
			$mail->From = $from;
			$HTML = true;	 
			$mail->WordWrap = 50; // set word wrap
			$mail->IsHTML($HTML);
			
			$mail->FromName= $from_name;
	
			$mail->Subject = $subject;
			$mail->Body = $message_web;
			 
			$mail->addAddress($to);
	
			if(!$mail->Send()) {
				$error = 'Mail error: '.$mail->ErrorInfo;
				return false;
			} else {
				$error = 'Message sent!';
				return true;
			}
		
	}

    private function json($data) {

        if (is_array($data)) {
         
            return json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
        }
    }


}

// Initiiate Library    
$api = new API;
$api->processApi();
?>