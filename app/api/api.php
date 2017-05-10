<?php

require_once("Rest.inc.php"); 
date_default_timezone_set('asia/kolkata');


class API extends REST {

    public $data = "";
	
	const DB_SERVER = "localhost";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB = "hansahie_watermate";  

/*	const DB_SERVER = "localhost";
	const DB_USER = "phppoets_water";
	const DB_PASSWORD = "wKVkpR_yM_&}";
	const DB = "phppoets_watermate";       
*/ 
    private $db = NULL;

    public function __construct() 
	{
        parent::__construct();  // Init parent contructor
        $this->dbConnect();    // Initiate Database connection     
    }

    public function __destruct() 
	{
      $this->db = NULL;
    }

    private function dbConnect() 
	{
        // Set up the database
		
        try {            
            $this->db = new PDO('mysql:host=' . self::DB_SERVER . ';dbname=' . self::DB, self::DB_USER, self::DB_PASSWORD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

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
	
	//--------------                     Dsu Menaria DEVELOP OTHER API FUNCTION                       --------------------  ///

	public function LocationAccess() 
	{
		include_once("common/global.inc.php");
		global $link;
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
		$timestamp=date('Y-m-d h:i:s');
 		$user_id = $this->_request['user_id']; 
		$locationData = $this->_request['locationData'];
		$started= (bool)$this->_request['started'];
		$completed= (bool)$this->_request['completed'];
		$type = $this->_request['type'];
 
 		if($started === true)
		{    	$trip_id=(string)mt_rand(1000,9999);
			//- traval insert
				$NOTY_insert = $this->db->prepare("INSERT into travel_mappings(user_id,trip_id,type)VALUES(:user_id,:trip_id,:type)");
				$NOTY_insert->bindParam(":trip_id", $trip_id, PDO::PARAM_STR);
				$NOTY_insert->bindParam(":user_id", $user_id, PDO::PARAM_STR);
				$NOTY_insert->bindParam(":type", $type, PDO::PARAM_STR);
				$NOTY_insert->execute();
				$insert_id = $this->db->lastInsertId();	
				
				$locationArray= json_decode($locationData, true);
				$image_stingfor_google='';
				$x=0;
				foreach($locationArray as $latLong)
				{
					$x++;
					if($x != 1){$image_stingfor_google.='|';}
 					$latitude= $latLong['latitude'];
					$longitude= $latLong['longitude'];
					$image_stingfor_google.=$latitude.',-'.$longitude;
				//--- Insert LOcation
					$location_insert = $this->db->prepare("INSERT into location_datas(travel_mapping_id,latitude,longitude)VALUES(:travel_mapping_id,:latitude,:longitude)");
					$location_insert->bindParam(":travel_mapping_id", $insert_id, PDO::PARAM_STR);
					$location_insert->bindParam(":latitude", $latitude, PDO::PARAM_STR);
					$location_insert->bindParam(":longitude", $longitude, PDO::PARAM_STR);
					$location_insert->execute();
 				}
									
			if($completed === true)
			{
				$sql_update_travel = $this->db->prepare("UPDATE `travel_mappings` SET status='1' WHERE id='".$insert_id."'");
				$sql_update_travel->execute();
			}
			else
			{}
			//Image find On google
				$image_stingfor_google;
				$src = 'https://maps.googleapis.com/maps/api/staticmap?center='.$latitude.','.$longitude.'&zoom=15&size=600x400&maptype=roadmap&path='.$image_stingfor_google.'';
				$time = time();
				$desFolder = '../images/';
				$imageName = 'google-map_'.$time.'.jpg';
				$imagePath = $desFolder.$imageName;
				$im_pth='images/'.$imageName;
				file_put_contents($imagePath,file_get_contents($src));
				$img_path=$site_url.$im_pth;
			//-- Distance

				$first_latitude=$locationArray[0]['latitude'];
				$first_longitude=$locationArray[0]['longitude'];
 				$dist=@$this->distance($first_latitude,$first_longitude, $latitude,$longitude, "K");
				$distance=number_format($dist,3);
			//response
			$result=array('timestamp' => $timestamp,'trip_id' => $trip_id,'user_id' => $user_id,'image_path'=> $img_path, 'distance' => $distance);
			$success = array('status'=> true, "Error" => "Successfully submitted",'Responce' => $result);
			$this->response($this->json($success), 200);
		}
		else 
		{
			
				$std_nm = $this->db->prepare("SELECT `id` FROM `travel_mappings` where user_id='".$user_id."' AND status='0' ");
				$std_nm->execute();
				if($std_nm->rowCount()>0)
				{
					// update last  inseted
					$ftc_data= $std_nm->fetchALL(PDO::FETCH_ASSOC);
					$insert_id=$ftc_data['id'];
					
					$locationArray= json_decode($locationData, true);
					$image_stingfor_google='';
					$x=0;
					foreach($locationArray as $latLong)
					{
						$latitude= $latLong['latitude'];
						$longitude= $latLong['longitude'];
						$x++;
						if($x != 1){$image_stingfor_google.='|';}
						$latitude= $latLong['latitude'];
						$longitude= $latLong['longitude'];
						$image_stingfor_google.=$latitude.',-'.$longitude;
					//--- Insert LOcation
						$location_insert = $this->db->prepare("INSERT into location_datas(travel_mapping_id,latitude,longitude)VALUES(:travel_mapping_id,:latitude,:longitude)");
						$location_insert->bindParam(":travel_mapping_id", $insert_id, PDO::PARAM_STR);
						$location_insert->bindParam(":latitude", $latitude, PDO::PARAM_STR);
						$location_insert->bindParam(":longitude", $longitude, PDO::PARAM_STR);
						$location_insert->execute();	
					}
				}
				else
				{
					$trip_id=uniqid();
				//- traval insertecho
				 
					$NOTY_insert = $this->db->prepare("INSERT into travel_mappings(user_id,trip_id,type)VALUES(:user_id,:trip_id,:type)");
					$NOTY_insert->bindParam(":trip_id", $trip_id, PDO::PARAM_STR);
					$NOTY_insert->bindParam(":user_id", $user_id, PDO::PARAM_STR);
					$NOTY_insert->bindParam(":type", $type, PDO::PARAM_STR);
					$NOTY_insert->execute();
					$insert_id = $this->db->lastInsertId();	
					
					$locationArray= json_decode($locationData, true);
					$image_stingfor_google='';
					$x=0;
					foreach($locationArray as $latLong)
					{
						$latitude= $latLong['latitude'];
						$longitude= $latLong['longitude'];
						$x++;
						if($x != 1){$image_stingfor_google.='|';}
						$latitude= $latLong['latitude'];
						$longitude= $latLong['longitude'];
						$image_stingfor_google.=$latitude.',-'.$longitude;
					//--- Insert LOcation
						$location_insert = $this->db->prepare("INSERT into location_datas(travel_mapping_id,latitude,longitude)VALUES(:travel_mapping_id,:latitude,:longitude)");
						$location_insert->bindParam(":travel_mapping_id", $insert_id, PDO::PARAM_STR);
						$location_insert->bindParam(":latitude", $latitude, PDO::PARAM_STR);
						$location_insert->bindParam(":longitude", $longitude, PDO::PARAM_STR);
						$location_insert->execute();	
					}
						
				}

			if($completed === true)
			{
				$sql_update_travel = $this->db->prepare("UPDATE `travel_mappings` SET status='1' WHERE id='".$insert_id."'");
				$sql_update_travel->execute();
			}
			else
			{}
 			//Image find On google
				$image_stingfor_google;
				$src = 'https://maps.googleapis.com/maps/api/staticmap?center='.$latitude.','.$longitude.'&zoom=15&size=600x400&maptype=roadmap&path='.$image_stingfor_google.'';
				$time = time();
				$desFolder = '../images/';
				$imageName = 'google-map_'.$time.'.jpg';
				$imagePath = $desFolder.$imageName;
				$im_pth='images/'.$imageName;
				file_put_contents($imagePath,file_get_contents($src));
				$img_path=$site_url.$im_pth;
			//-- Distance
				$first_latitude=$locationArray[0]['latitude'];
				$first_longitude=$locationArray[0]['longitude'];
 				$dist=@$this->distance($first_latitude,$first_longitude, $latitude,$longitude, "K");
				$distance=number_format($dist,3);
			//response
			$result=array('timestamp' => $timestamp,'trip_id' => $trip_id,'user_id' => $user_id,'image_path'=> $img_path, 'distance' => $distance);
			$success = array('status'=> true, "Error" => "Successfully submitted",'Responce' => $result);
			$this->response($this->json($success), 200);
		}		
	}
	
	public function BillUpload()
	{
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
		$timestamp=date('Y-m-d h:i:s');
		$type = (string)$this->_request['type'];
		$user_id = (int)$this->_request['user_id'];
		@$trip_id = (int)$this->_request['trip_id'];
		//$completed= (bool)$this->_request['completed'];
		//$started= (bool)$this->_request['started'];
		$no_of_image= $this->_request['no_of_image'];
 		$DS='/';
 		@$tmpname = $_FILES['bill_image']['tmp_name'];
		@$filename = time() . $_FILES["bill_image"]["name"];
		@$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		
		 
		if(empty($trip_id))
		{ 
			$trip_id=(string)mt_rand(1000,9999);
			$filenames=time();
			$targetPath=@$filenames.'.'.$ext;
			$target = "../uploaded_bill/".$trip_id;
			$display_path="uploaded_bill/".$trip_id."/";
			$inserr_path=$site_url.$display_path.$targetPath;
			//- traval insertecho
				$NOTY_insert = $this->db->prepare("INSERT into travel_mappings(user_id,trip_id,type)VALUES(:user_id,:trip_id,:type)");
				$NOTY_insert->bindParam(":trip_id", $trip_id, PDO::PARAM_STR);
				$NOTY_insert->bindParam(":user_id", $user_id, PDO::PARAM_STR);
				$NOTY_insert->bindParam(":type", $type, PDO::PARAM_STR);
				$NOTY_insert->execute();
				$insert_id = $this->db->lastInsertId();
			//--- Insert Image Table
				$location_insert = $this->db->prepare("INSERT into bill_datas(travel_mapping_id,image_path)VALUES(:travel_mapping_id,:image_path)");
				$location_insert->bindParam(":travel_mapping_id", $insert_id, PDO::PARAM_STR);
				$location_insert->bindParam(":image_path", $inserr_path, PDO::PARAM_STR);
				$location_insert->execute();
		$std_nm1 = $this->db->prepare("SELECT `id` FROM `travel_mappings` where trip_id='".$trip_id."' AND  user_id='".$user_id."'");
		$std_nm1->execute();
		$ftc_datas= $std_nm1->fetchALL(PDO::FETCH_ASSOC);
 		$travel_mapping=$ftc_datas[0]['id']; 
		$ingcount = $this->db->prepare("SELECT `id` FROM `bill_datas` where travel_mapping_id='".$travel_mapping."'");
		$ingcount->execute();
		$total_images=$ingcount->rowCount(); 
  
		$completed = false;
                $all_uploaded = false;
		if($no_of_image==1 || $no_of_image==$total_images){ $completed=true; $all_uploaded = 'true' ;}
			if($completed === true)
			{
				$sql_update_travel = $this->db->prepare("UPDATE `travel_mappings` SET status='1' WHERE id='".$insert_id."'");
				$sql_update_travel->execute();
			}
			else
			{}				
		}
		else
		{
			$filenames=time();
			$targetPath=@$filenames.'.'.$ext;
			$target = "../uploaded_bill/".$trip_id;
			$display_path="uploaded_bill/".$trip_id."/";
			$inserr_path=$site_url.$display_path.$targetPath;
			
			$std_nm = $this->db->prepare("SELECT `id` FROM `travel_mappings` where trip_id='".$trip_id."'");
			$std_nm->execute();
			$ftc_data= $std_nm->fetchALL(PDO::FETCH_ASSOC);
 			$insert_id=$ftc_data[0]['id']; 
			//--- Insert Image Table
				$location_insert = $this->db->prepare("INSERT into bill_datas(travel_mapping_id,image_path)VALUES(:travel_mapping_id,:image_path)");
				$location_insert->bindParam(":travel_mapping_id", $insert_id, PDO::PARAM_STR);
				$location_insert->bindParam(":image_path", $inserr_path, PDO::PARAM_STR);
				$location_insert->execute();
		$std_nm1 = $this->db->prepare("SELECT `id` FROM `travel_mappings` where trip_id='".$trip_id."' AND  user_id='".$user_id."'");
		$std_nm1->execute();
		$ftc_datas= $std_nm1->fetchALL(PDO::FETCH_ASSOC);
 		$travel_mapping=$ftc_datas[0]['id']; 
		$ingcount = $this->db->prepare("SELECT `id` FROM `bill_datas` where travel_mapping_id='".$travel_mapping."'");
		$ingcount->execute();
		$total_images=$ingcount->rowCount(); 
  
		$completed = false;
                $all_uploaded = false;
		if($no_of_image==1 || $no_of_image==$total_images){ $completed=true; $all_uploaded = 'true' ;}

			if($completed === true)
			{
				$sql_update_travel = $this->db->prepare("UPDATE `travel_mappings` SET status='1' WHERE id='".$insert_id."'");
				$sql_update_travel->execute();
			}
			else
			{}	
		}
		
		$exist = is_dir($target);  
 		if(!$exist)
		{
			mkdir(dirname(__FILE__)."/../uploaded_bill/" . $DS . $trip_id);
 		}
 		move_uploaded_file($tmpname, dirname(__FILE__)."/".$target."/".$targetPath);
		
		//response
		$result=array('timestamp' => $timestamp,'trip_id' => $trip_id,'user_id' => $user_id,'image_path'=> $inserr_path);
		if($no_of_image==1 || $no_of_image==$total_images){ 
			$success = array('status'=> true, "Error" => "Successfully submitted",'Responce' => $result,'all_uploaded'=> true);
		}
		else
		{
			$success = array('status'=> true, "Error" => "Successfully submitted",'Responce' => $result,'all_uploaded'=> false);
		}
		$this->response($this->json($success), 200);
  		
	}
	
	public function login()
	{
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
		$timestamp=date('Y-m-d h:i:s');
		$user_id = (string)$this->_request['user_id'];
		//$password = (string)$this->_request['password'];
		
		if(!empty($user_id))
		{
			$md5pass=md5($password);
			$ingcount = $this->db->prepare("SELECT * FROM `login` where user_id='".$user_id."'");
			$ingcount->execute();
 			if($ingcount->rowCount() > 0)
			{
				$row_gp = $ingcount->fetch(PDO::FETCH_ASSOC);
				$update_id=$row_gp['id'];
				$mobile_no=$row_gp['mobile_no'];
				$user_id=$row_gp['user_id'];
				$random=(string)mt_rand(1000,9999);
				$sms=str_replace(' ', '+', 'Dear '.$user_id.', Your one time password is '.$random.'.');
				$working_key='A7a76ea72525fc05bbe9963267b48dd96';
				$sms_sender='FLEXIL';
				file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile_no.'&message='.$sms.'');
 				$update = $this->db->prepare("update `login` set `otp` = '".$random."' where id='".$update_id."'");
				$update->execute();
			
				foreach($row_gp as $key=>$valye)	
				{
					$string_insert[$key]=$row_gp[$key];
				}
				$string_insert['otp']=$random;
 				$success = array('status' => true, "Error" => '', 'login' => $string_insert);
				$this->response($this->json($success), 200);
			}
			else
			{
				$error = array('status' => false, "Error" => "Invalid User ID and Password", 'Responce' => '');
				$this->response($this->json($error), 400);
			}
		}
		else
		{
			$error = array('status' => false, "Error" => "Please provide user ID and password", 'Responce' => '');
			$this->response($this->json($error), 400);
		}		
 	}
	
	public function TokenUpdate() 
	{
		global $link;
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
			$this->response('', 406);
		}
		$device_token=$this->_request['device_token'];
		$id=$this->_request['id'];
		$sql = $this->db->prepare("SELECT * FROM login WHERE id=:id");
		$sql->bindParam(":id", $id, PDO::PARAM_STR);
		$sql->execute();
		
		if($sql->rowCount()>0)
		{
			$sql_update_token = $this->db->prepare("UPDATE `login` SET device_token='".$device_token."' WHERE id='".$id."' LIMIT 1;");
			$sql_update_token->execute();
			$success = array('status' => true, "msg" => 'Yes', 'Responce' => '');
			$this->response($this->json($success), 200);
		} 
		else
		{
			$error = array('status' => false, "Error" => "No", 'Responce' => '');
			$this->response($this->json($error), 200);
		}
	}

	public function OTPVerification() 
	{
		global $link;
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
		if(isset($this->_request['otp']))
		{
			@$otp = $this->_request['otp'];
			$sql = $this->db->prepare("SELECT * FROM login WHERE otp=:otp");
			$sql->bindParam(":otp", $otp, PDO::PARAM_STR);
			$sql->execute();
			if ($sql->rowCount()>0) { 
				$row_gp = $sql->fetch(PDO::FETCH_ASSOC);
					foreach($row_gp as $key=>$valye)	
					{
						$string_insert[$key]=$row_gp[$key];
					}
				$id = $row_gp['id'];
				
				$random='';
				$sql_insert = $this->db->prepare("update `login` set otp=:random where id=:id");
				$sql_insert->bindParam(":random", $random, PDO::PARAM_STR);
				$sql_insert->bindParam(":id", $id, PDO::PARAM_STR);
				$sql_insert->execute();
				$success = array('status' => true, "Error" => '', 'login' => $string_insert);
				$this->response($this->json($success), 200);
			}
			else
			{
				$success = array('status' => false, "Error" => 'Wrong OTP No ', 'Responce' => 0);
				$this->response($this->json($success), 200);
			}
		}
		else
		{
			$success = array('status' => false, "Error" => 'No data found', 'Responce' => '');
			$this->response($this->json($success), 200);
		}
 	}
	
	public function forgot_password() 
	{
			global $link;
			include_once("common/global.inc.php");
			if ($this->get_request_method() != "POST") {
				$this->response('', 406);
			}
			if(isset($this->_request['mobile_no']))
			{
				@$email = $this->_request['mobile_no'];
 				$sql1 = $this->db->prepare("SELECT * FROM login WHERE mobile_no=:mobile_no");
				$sql1->bindParam(":mobile_no", $email, PDO::PARAM_STR);
				$sql1->execute();
				if ($sql1->rowCount()>0) 
				{ 
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
								
					$sql_update1 = $this->db->prepare("update `login` set password=:pass_MD5,otp=:random where id=:id");
					$sql_update1->bindParam(":id", $update_id, PDO::PARAM_INT);
					$sql_update1->bindParam(":pass_MD5", $pass_MD5, PDO::PARAM_INT);
					$sql_update1->bindParam(":random", $random, PDO::PARAM_INT);
 					$sql_update1->execute();
					
					$result=array('otp'=>$random);
					$error = array('status' => true, "Error" => "Instructions for accessing your account have been sent to ".$email."", 'Response' => $result);
					$this->response($this->json($error), 200);
				
				}
				else
				{
					$error = array('status' => false, "Error" => "Sorry, the  mobile no you provide is not registered.", 'Response' => '');
					$this->response($this->json($error), 200);
				}
			}
 		}

	public function ChangePassword() 
	{
			global $link;
			include_once("common/global.inc.php");
			if ($this->get_request_method() != "POST") {
				$this->response('', 406);
			}
			if(!empty($this->_request['mobile_no']) && !empty($this->_request['otp']) && !empty($this->_request['password']))
			{	
				@$mobile_no = $this->_request['mobile_no'];
				@$otp = $this->_request['otp'];
				@$password = $this->_request['password'];
 				$sql1 = $this->db->prepare("SELECT * FROM login WHERE mobile_no=:mobile_no AND otp=:otp ");
				$sql1->bindParam(":mobile_no", $mobile_no, PDO::PARAM_STR);
				$sql1->bindParam(":otp", $otp, PDO::PARAM_STR);
				$sql1->execute();
				if ($sql1->rowCount()>0) 
				{ 
					$row_gp1 = $sql1->fetch(PDO::FETCH_ASSOC);
					$update_id=$row_gp1['id'];
 					$pass_MD5=md5($password);
								
					$sql_update1 = $this->db->prepare("update `login` set password=:pass_MD5 where id=:id AND otp=:random");
					$sql_update1->bindParam(":id", $update_id, PDO::PARAM_INT);
					$sql_update1->bindParam(":pass_MD5", $pass_MD5, PDO::PARAM_INT);
					$sql_update1->bindParam(":random", $random, PDO::PARAM_INT);
 					$sql_update1->execute();
					$result=array('otp'=>$random);
					$error = array('status' => true, "Error" => "Password Successfully changed", 'Response' => $result);
					$this->response($this->json($error), 200);
				
				}
				else
				{
					$error = array('status' => false, "Error" => "Sorry, the OTP you provide is not metch.", 'Response' => '');
					$this->response($this->json($error), 200);
				}
			}
 		}

	public function BookingTrip()
	{
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
		$timestamp=date('Y-m-d h:i:s');
		$type = (string)$this->_request['type'];
		$user_id = (int)$this->_request['user_id'];
		$from = $this->_request['from'];
		$to = (string)$this->_request['to'];
		$date_of_travel = $this->_request['date_of_travel'];
		$trip_id=(string)mt_rand(1000,9999);
		$status=1;
			//-- Mpping
			//- traval insert echo
			$mapping_insert = $this->db->prepare("INSERT into travel_mappings(user_id,trip_id,type)VALUES(:user_id,:trip_id,:type)");
			$mapping_insert->bindParam(":trip_id", $trip_id, PDO::PARAM_STR);
			$mapping_insert->bindParam(":user_id", $user_id, PDO::PARAM_STR);
			$mapping_insert->bindParam(":type", $type, PDO::PARAM_STR);
			$mapping_insert->execute();
			$mapping_id = $this->db->lastInsertId();
			//- Bookin  Insert
			$NOTY_insert = $this->db->prepare("INSERT into bookingtrips(user_id,trip_id,type,travel_from,travel_to,date_of_travel,status,travel_mapping_id)VALUES(:user_id,:trip_id,:type,:travel_from,:travel_to,:date_of_travel,:status,:travel_mapping_id)");
			$NOTY_insert->bindParam(":travel_mapping_id", $mapping_id, PDO::PARAM_STR);
			$NOTY_insert->bindParam(":trip_id", $trip_id, PDO::PARAM_STR);
			$NOTY_insert->bindParam(":user_id", $user_id, PDO::PARAM_STR);
			$NOTY_insert->bindParam(":travel_from", $from, PDO::PARAM_STR);
			$NOTY_insert->bindParam(":travel_to", $to, PDO::PARAM_STR);
			$NOTY_insert->bindParam(":date_of_travel", $date_of_travel, PDO::PARAM_STR);
			$NOTY_insert->bindParam(":type", $type, PDO::PARAM_STR);
			$NOTY_insert->bindParam(":status", $status, PDO::PARAM_STR);
			$NOTY_insert->execute();
			$insert_id = $this->db->lastInsertId();
			//--- Notification
				$std_nm = $this->db->prepare("SELECT `device_token`,`auth_key` FROM `login` where id='".$user_id."'");
				$std_nm->execute();
				$ftc_nm= $std_nm->fetch(PDO::FETCH_ASSOC);
				$device_token = $ftc_nm['device_token'];
				$notification_key = $ftc_nm['auth_key'];
					
					$message='Your booking successfully submitted';
					$title='Booking';
 					$user_id=$user_id;
					$date=date("M d Y");
					$time=date("h:i A");
					 
					$msg = array
					(
						'title' => $title,
						'message' 	=> $message,
						'button_text'	=> 'View',
						'link'	=> 'watermate://bookingtrips?id='.$insert_id,
						'notification_id'	=> $insert_id,
					);
 					$url = 'https://fcm.googleapis.com/fcm/send';
 					$fields = array
					(
						'registration_ids' 	=> array($device_token),
						'data'			=> $msg
					);
					$headers = array
					(
						'Authorization: key=' .$notification_key,
						'Content-Type: application/json'
					);
					// CURL
					json_encode($fields);
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
					$result = curl_exec($ch);
					curl_close($ch);
			
		$result=array('timestamp' => $timestamp,'trip_id' => $trip_id,'user_id' => $user_id,"status" => $status);
		$success = array('status'=> true, "Error" => "Booking successfully submitted",'Responce' => $result);
		$this->response($this->json($success), 200);  		
	}
 	
	public function BookingData() 
	{
		global $link;
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
		@$user_id = $this->_request['user_id'];
 		 
		$sql = $this->db->prepare("SELECT * FROM bookingtrips WHERE user_id=:user_id status='1' order by id DESC");
 		$sql->bindParam(":user_id", $user_id, PDO::PARAM_STR);
		$sql->execute();
		
		if ($sql->rowCount()>0) { 
			while($row_gp = $sql->fetch(PDO::FETCH_ASSOC))
			{
				foreach($row_gp as $key=>$valye)	
				{
					$string_insert[$key]=$row_gp[$key];
				}
				$string[]=$string_insert;
			}
 			$success = array('status' => true, "Error" => '', 'bookingtrips' => $string);
			$this->response($this->json($success), 200);
		}
		else
		{
			$success = array('status' => false, "Error" => 'No data found ', 'Responce' => 0);
			$this->response($this->json($success), 200);
		}
	}
	
	public function BookingCancel() 
	{
		global $link;
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
		@$id = $this->_request['id'];
		@$trip_id = $this->_request['trip_id'];
		 
		$sql = $this->db->prepare("SELECT * FROM bookingtrips WHERE id=:id AND trip_id=:trip_id");
		$sql->bindParam(":id", $id, PDO::PARAM_STR);
		$sql->bindParam(":trip_id", $trip_id, PDO::PARAM_STR);
		$sql->execute();
		$updatestatus=5;
		if ($sql->rowCount()>0) { 
		
			$sql_update1 = $this->db->prepare("update `bookingtrips` set status='".$updatestatus."' where id='".$id."'");
  			$sql_update1->execute();
	 
 			$success = array('status' => true, "Error" => 'Your booking canceled', 'Responce' => '');
			$this->response($this->json($success), 200);
		}
		else
		{
			$success = array('status' => false, "Error" => 'No data found ', 'Responce' => 0);
			$this->response($this->json($success), 200);
		}
		 
 	}
	
	public function ProjectData() 
	{
		global $link;
		include_once("common/global.inc.php");
		if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
 		$sql = $this->db->prepare("SELECT * FROM projects order by project_name ASC");
  		$sql->execute();
 		if ($sql->rowCount()>0) { 
		
			while($row_gp = $sql->fetch(PDO::FETCH_ASSOC))
			{
				echo  $id=$row_gp['id'];
				$sub = $this->db->prepare("SELECT * FROM sub_projects WHERE project_id=:id ");
				$sub->bindParam(":id", $id, PDO::PARAM_STR);
				$sub->execute();
				while($row_gps = $sub->fetch(PDO::FETCH_ASSOC))
				{	
					foreach($row_gps as $key=>$valyes)	
					{
						$string_inserta[$key]=$row_gps[$key];
					}
					$strings[]=$string_inserta;
					unset($string_inserta);
				} 
				  
				foreach($row_gp as $key=>$valye)	
				{
					$string_insert[$key]=$row_gp[$key];
				}
				$string_insert['sub_project']=$strings;
				unset($strings);
				$string[]=$string_insert;
				unset($string_insert);
			}
 			 $success = array('status' => true, "Error" => 'All records', 'projects' => $string);
			 $this->response($this->json($success), 200);
		}
		else
		{
			$success = array('status' => false, "Error" => 'No data found ', 'Responce' => 0);
			$this->response($this->json($success), 200);
		}
 	}
	

	function distance($lat1, $lon1, $lat2, $lon2, $unit) 
	{
		  $theta = $lon1 - $lon2;
		  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		  $dist = acos($dist);
		  $dist = rad2deg($dist);
		  $miles = $dist * 60 * 1.1515;
		  $unit = strtoupper($unit);
		
		  if ($unit == "K") {
			  return ($miles * 1.609344);
		  } else if ($unit == "N") {
			  return ($miles * 0.8684);
		  } else {
			  return $miles;
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