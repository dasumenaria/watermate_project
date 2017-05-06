<?php
App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
date_default_timezone_set('Asia/Calcutta');
//ini_set('memory_limit', '256M');
set_time_limit(0);
class HandlerController extends AppController
{
	public $helper=array('html', 'form', 'Js');
	public $components = array(
    'Session','Cookie','RequestHandler','Paginator'=>array('Paginator')
 	);
	
	public function beforeFilter() 
	{
        Configure::write('debug',0);
    }
	
	/////// Start Page Name Function //////////
	
	public function web_record()
                {
                                $this->layout='ajax_layout';
                                $this->loadmodel('record');
                                                $form=date("Y-m-d");
                                                $from=date('Y-m-d',strtotime($form." -1 day"));
                                                $conditions=array('record.record_flag'=>0,'record.status_date'=> $from);;
                                                $to=$from;
                                $this->set(compact('from'));
                                $this->set(compact('to'));
                               
                               $village_records= $this->record->find('all',array('conditions'=>$conditions));
                                $this->set(compact('village_records'));
                               
                }
                public function complete_excel_website()
                {
                                $this->layout='ajax_layout';
                                $this->loadmodel('record');
                                                $form=date("Y-m-d");
                                                $from=date('Y-m-d',strtotime($form." -1 day"));
                                                $conditions=array('record.record_flag'=>0,'record.status_date'=> $from);;
                                                $to=$from;
                                $this->set(compact('from'));
                                $this->set(compact('to'));
                               
                               $village_records= $this->record->find('all',array('conditions'=>$conditions));
                                $this->set(compact('village_records'));
                }
	
	public function login()
	{
		$this->Session->destroy();
		$this->layout='login_layout';
		$this->loadmodel('user_login');
		//$token = $this->Session->read('_Token');
		//$this->set('token',$token['key']);
		//$email_string=$this->request->query('aqazp2yd');
		//$key='jainthela_facebook';
		//$user_email=$this->decode($email_string,$key);

       // $Name_fb=$this->request->query('NM');
		//$Name=$this->decode($Name_fb,$key);

      //  $conditions=array("email" => $user_email);
		
		//$result=$this->user_login->find('all', array('conditions' => $conditions));
		
       /* $count = sizeof($result);
		if($count>0)
		{
		    
			$user_id=$result[0]['user_login']['user_id'];
			$this->Session->write('user_id', $user_id);
			$this->redirect(array('action' => 'index'));
				
		}
		else
		{
		     $this->set('wrong4','Email not exist');
		}*/
		if (isset($this->request->data['login_submit']) || isset($this->request->data["login_submit_text"]))
		{
			
						
				$email=htmlentities($this->request->data["email"]);
				$password=htmlentities($this->request->data["password"]);
				$md5ed_password = md5($password);

				$this->loadmodel('user_login');
				$conditions=array("email" => $email, "password" => $md5ed_password);
				$result = $this->user_login->find('all',array('conditions'=>$conditions));
			
				$n = sizeof($result); 
				
				if($n==1)
				{
					$user_id=$result[0]['user_login']['user_id'];
					$this->Session->write('user_id', $user_id);
					if($result[0]['user_login']['user_role_id']==1)
					{
						$this->redirect(array('action' => 'index'));
					}
					else
					{
						$this->redirect(array('action' => 'search'));
					}
					
				}
				else
				{
					$this->loadmodel('user_login');
					$conditions=array("email" => $email);
					$result1 = $this->user_login->find('all',array('conditions'=>$conditions));
					 $n1 = sizeof($result1);
					if($n1>0)
					{ 
						 $this->set('wrong4', 'Password is Incorrect. Please try again.');
					}
					else
					{
						$this->set('wrong4', 'Email Id and Password are Incorrect.');
					}	
				}
				
		}
		
	}
	
	public function index() 
	{
		
			$user_id = $this->Session->read('user_id');
			
			$this->loadmodel('user_login');
			$result1 = $this->user_login->find('all',array('fields'=>array('user_role_id'),'conditions'=>array("user_id" => $user_id)));
			$role=$result1[0]['user_login']['user_role_id'];
			if($role==2)
					{
						
					$this->redirect(array('action' => 'search'));
					}
					
			
			else
			{
		$this->layout='index_layout';
		$this->loadmodel('record');
		if(isset($this->request->data['csv_submit']))
		{
			$user_id = $this->Session->read('user_id');
			$this->loadmodel('village');
			$this->loadmodel('block');
			$this->loadmodel('district');
			$file_temp=($this->request->form['filename']['tmp_name']);
			$f = fopen($this->request->form['filename']['tmp_name'], 'r') or die("ERROR OPENING DATA");
			
			$records=0;
			while (($line = fgetcsv($f, 4096, ',')) !== false) {
			
			$numcols = count($line);
			$test[]=$line;
			++$records;
			}
			$i=0;
			$field_name=array_keys($this->record->getColumnTypes());
			
			foreach($test as $child_ar)
			{ 
				$i++;
				if($i>3)
				{
					$j=0;
					$k=0;
					foreach($field_name as $data)
					{
						if($j>0)
						{
							if($data=='date_commission')
							{
								$this->request->data[$data]=date('Y-m-d',strtotime($child_ar[$k]));
							}
							else if($data=='date_lab_testing')
							{
								$this->request->data[$data]=date('Y-m-d',strtotime($child_ar[$k]));
							}
							else if($data=='status_date')
							{
								$this->request->data[$data]=date('Y-m-d',strtotime($child_ar[$k]));
							}
							else if($data=='operational_date')
							{
								$this->request->data[$data]=date('Y-m-d',strtotime($child_ar[$k]));
							}
							else if($data=='dispense_date')
							{
								$this->request->data[$data]=date('Y-m-d',strtotime($child_ar[$k]));
							}
							else if($data=='district_id')
							{
								$result_district=$this->district->find('all',array('fields'=>array('id'),'conditions'=>array('district_name'=>$child_ar[$k])));
								$this->request->data[$data]=$result_district[0]['district']['id'];
							}
							else if($data=='block_id')
							{
								$result_block=$this->block->find('all',array('fields'=>array('id'),'conditions'=>array('block_name'=>$child_ar[$k])));
								$this->request->data[$data]=$result_block[0]['block']['id'];
							}
							else if($data=='village_id')
							{
								$result_village=$this->village->find('all',array('fields'=>array('id'),'conditions'=>array('village_name'=>$child_ar[$k])));
								$this->request->data[$data]=$result_village[0]['village']['id'];
							}
							else
							{
								$this->request->data[$data]=$child_ar[$k];
							}
							
							$k++;
						}
						$j=1;
					}
					$this->record->saveAll($this->request->data);
					
				}
			}
	
		}
		}
	}
	
		public function record_add() 
		{
			$user_id = $this->Session->read('user_id');
			$this->loadmodel('user_login');
			$result1 = $this->user_login->find('all',array('fields'=>array('user_role_id'),'conditions'=>array("user_id" => $user_id)));
			$role=$result1[0]['user_login']['user_role_id'];
			$this->set("role",$role);
			$this->layout='index_layout'; 
			$this->loadmodel('record');
			$this->loadmodel('village');
			$this->set('village' , $this->village->find('all',array('conditions'=>array('village_flag'=>1),'order'=>array('village_name ASC' ))));
			
			if(isset($this->request->query['add_record']))
			{
				$j=0;
				$village_id=$this->request->query['village_id'];
				$date_from=date('Y-m-d',strtotime($this->request->query['from']));
				$date_to=date('Y-m-d',strtotime($this->request->query['to']));
				$period = new DatePeriod(new DateTime($date_from), new DateInterval('P1D'), new DateTime($date_to. '.+1 day'));
				foreach ($period as $date) {
				$dates[] = $date->format("Y-m-d");
				}
				$atmcard_issues=$this->request->query['atmcard_issues'];
				$rwq_tds=$this->request->query['rwq_tds'];
				$rwq_fl=$this->request->query['rwq_fl'];
				$rwq_no=$this->request->query['rwq_no'];
				$twq_tds=$this->request->query['twq_tds'];
				$twq_fl=$this->request->query['twq_fl'];
				$twq_no=$this->request->query['twq_no'];
				$date_lab_testing=date('Y-m-d',strtotime($this->request->query['date_lab_testing']));
				$this->loadmodel('village');
				$village_record=$this->village->find('all',array('conditions'=>array('id' => $village_id,'village_flag'=>1)));
				$date_commission=$village_record[0]['village']['commissioning'];
				$district_id=$village_record[0]['village']['district_id'];
				$mla_costituency=$village_record[0]['village']['mla_costituency'];
				$block_id=$village_record[0]['village']['block_id'];
				$gram_panchayat=$village_record[0]['village']['gram_panchayat'];
				$population=$village_record[0]['village']['population'];
				$no_houses=$village_record[0]['village']['no_houses'];
				$ifr1=800;
				
				$sim_number=$village_record[0]['village']['sim_number'];
				//$remain=$fetchlast_id[0]['record']['total'];
			
				$i=0;
				
				foreach($dates as $data)
				{
				$start = strtotime("12:00:00");
				$end =  strtotime("02:00:00");
				$time = date("H:i", rand($start, $end));
				
				if($atmcard_issues == 1)
				{
				$atmcard=rand(10,25);
				$op_day=rand(100,200)/100;
				$status=['O','No','No','O'];
				}
				else if($atmcard_issues== 2)
				{
				$atmcard=rand(26,50);
				$op_day=rand(100,200)/100;
				$status=['O','No','O','No'];
				}
				
				else if($atmcard_issues== 3)
				{
				$atmcard=rand(51,75);
				$op_day=rand(200,300)/100;
				$status=['O','No','O','No'];
				}
				else if($atmcard_issues == 4)
				{
				$atmcard=rand(76,125);
				$op_day=rand(2300,500)/100;
				$status=['O','No','O','No'];
				}
				
				else if($atmcard_issues == 5)
				{
				$atmcard=rand(126,175);
				$op_day=rand(600,700)/100;
				$status=['O','O','O','O'];
				}
				else if($atmcard_issues == 6)
				{
				$atmcard=rand(176,225);
				$op_day=rand(700,800)/100;
				$status=['O','O','O','O'];
				}
				
				$cum_vol=($atmcard*15)/1000;
				$cu=$cum_vol*1000;
				//$fetchlast_id=$this->record->find('all', array('conditions'=>array('record_flag' => 0, 'village_id'=>$village_id),'order'=>'id DESC','limit'=>1));
				//$lst_id=$fetchlast_id[0]['record']['id'];
				$pen_atm=($atmcard/$no_houses)*100;
				$pen_vol=($cum_vol/$no_houses*15)*100;
				 $fetchlast=$this->record->find('all', array('conditions'=>array('record_flag' => 0, 'village_id'=>$village_id),'order'=>'id DESC','limit'=>1));
				//$remain=$fetchlast[0]['record']['total'];
				$last_op_date=$fetchlast[0]['record']['last_opr_date'];
				$last_cumm=$fetchlast[0]['record']['dispense_date'];
				$last_op=$fetchlast[0]['record']['operational_date'];
				if($j>3){
				$j=0;
				}
				if($status[$j]=='O')
					{	
						$ifr=$ifr1;
						$tds=rand( 150 , 175 );
						$pfr=rand( 460 , 490 );
						$recovery=$pfr/$ifr*100;
						$total_db=$pfr*4;
						//$total=$remain+$total_db;
						$reason='-';
						$op_day=$op_day;
						$last_op_date=date('Y-m-d');
						$cumm=$last_cumm+$cum_vol;
						$op_date=$last_op+$op_day;
					}
					else
					{
						$reason='TWT FULL';
						$ifr='-';
						$pfr='-';
						$tds='-';
						$recovery='-';
						$op_day=0;	
						$cumm=$last_cumm+$cum_vol;
						$op_date=$last_op;
					}
				
				$this->request->data['atmcard_issues']=$atmcard;
				$this->request->data['date_lab_testing']=$date_lab_testing;
				//$this->request->data['date_commission']=$date_commission;
				//$this->request->data['district_id']=$district_id;
				//$this->request->data['mla_costituency']=$mla_costituency;
				//$this->request->data['block_id']=$block_id;
				//$this->request->data['gram_panchayat']=$gram_panchayat;
				//$this->request->data['population']=$population;
				//$this->request->data['no_houses']=$no_houses;
				$this->request->data['rwq_tds']=$rwq_tds;
				$this->request->data['rwq_fl']=$rwq_fl;
				$this->request->data['rwq_no']=$rwq_no;
				$this->request->data['twq_tds']=$twq_tds;
				$this->request->data['twq_fl']=$twq_fl;
				$this->request->data['twq_no']=$twq_no;
				$this->request->data['sim_number']=$sim_number;
				$this->request->data['status_plant']=$status[$j];
				$this->request->data['last_opr_date']=$last_op_date;
				$this->request->data['reason_nonoperational']=$reason;
				$this->request->data['treated_tds']=$tds;
				$this->request->data['ifr']=$ifr;
				$this->request->data['pfr']=$pfr;
				$this->request->data['recovery']=$recovery;
				$this->request->data['operational_day']=$op_day;
				$this->request->data['operational_date']=$op_date;
				$this->request->data['village_id']=$village_id;
				$this->request->data['status_date']=$data;
				$this->request->data['status_time']=$time;
				$this->request->data['penetration_atm']=$pen_atm;
				$this->request->data['penetration_volume']=$pen_vol;
				$this->request->data['dispense_day']=$cum_vol;
				$this->request->data['dispense_date']=$cumm;
				//$this->request->data['total']=$total;
				$this->loadmodel('record');
				$this->record->saveAll($this->request->data);
				
				$j++;
				$i++;
				}
				
				}
				
			}
			
			
			
		
	public function search() 
	{
		$user_id = $this->Session->read('user_id');
		
		$this->loadmodel('user_login');
		$result1 = $this->user_login->find('all',array('fields'=>array('user_role_id'),'conditions'=>array("user_id" => $user_id)));
		if($result1[0]['user_login']['user_role_id']==1)
		{
			$this->layout='index_layout';
		}
		else
		{
			$this->layout='user_layout';
		}
		
		$this->loadmodel('district');
		$this->set('district' , $this->district->find('all',array('conditions'=>array('district_flag'=>1),'order'=>array('district_name ASC' ))));
		$this->loadmodel('block');
		$this->set('block' , $this->block->find('all',array('conditions'=>array('block_flag'=>1),'order'=>array('block_name ASC' ))));
		$this->loadmodel('village');
		$this->set('village' , $this->village->find('all',array('conditions'=>array('village_flag'=>1),'order'=>array('village_name ASC' ))));
		
	}
	
	public function create_login() 
	{
	
			$this->layout='index_layout';
			$this->loadmodel('user_role');
			$this->set('role_fetch' , $this->user_role->find('all'));
			$this->loadmodel('user_login');
			if($this->request->is('post'))
			{
				if(isset($this->request->data['login_reg']))
				{  
				
				$email=$this->request->data['email'];
				$password=htmlentities($this->request->data["password"]);
				$md5ed_password = md5($password);
				$this->user_login->password=$md5ed_password;
				$this->user_login->save($this->request->data);
				
				}
			}
	}
	public function village_info() 
	{
		$user_id = $this->Session->read('user_id');
		$this->loadmodel('user_login');
		$result1 = $this->user_login->find('all',array('fields'=>array('user_role_id'),'conditions'=>array("user_id" => $user_id)));
		if($result1[0]['user_login']['user_role_id']==1)
		{
			$this->layout='index_layout';
		}
		else
		{
			$this->layout='user_layout';
		}
		$this->loadmodel('village');
		$village_record=$this->village->find('all',array('conditions'=>array('village_flag'=>1),'order'=>array('village_name ASC' )));
		//$village_record = $this->village->find('all',array('condition'=>'order'=>array('village_name ASC' )));
		$this->set('village_record', $village_record);
		
	}
	
	public function search_report() 
	{
		$user_id = $this->Session->read('user_id');
		$this->loadmodel('user_login');
		$result1 = $this->user_login->find('all',array('fields'=>array('user_role_id'),'conditions'=>array("user_id" => $user_id)));
		if($result1[0]['user_login']['user_role_id']==1)
		{
			$this->layout='index_layout';
		}
		else
		{
			$this->layout='user_layout';
		}
		if(!empty($this->request->query['village_id']))
		{
			$this->set('village_id',$this->request->query['village_id']);
			$village_id=$this->request->query['village_id'];
			$this->loadmodel('village');
			$result_village=$this->village->find('all',array('conditions'=>array('id'=>$village_id,'village_flag'=>1)));
				$this->set('result_village', $result_village);
			$target_dir = "images_post/village/".$village_id;
			$images = glob($target_dir.'/*');
			$this->set('images',$images);
		}
	}
	public function edit_record()
	{
		$user_id = $this->Session->read('user_id');
		$this->loadmodel('user_login');
		$result1 = $this->user_login->find('all',array('fields'=>array('user_role_id'),'conditions'=>array("user_id" => $user_id)));
		$role=$result1[0]['user_login']['user_role_id'];
		$this->set("role",$role);
		$this->layout='index_layout'; 
		$this->loadmodel('record');
		$this->loadmodel('village');
		$this->set('village' , $this->village->find('all',array('conditions'=>array('village_flag'=>1),'order'=>array('village_name ASC' ))));
	}
	public function fetch_record()
	{
		$user_id = $this->Session->read('user_id');
		$this->loadmodel('user_login');
		$result1 = $this->user_login->find('all',array('fields'=>array('user_role_id'),'conditions'=>array("user_id" => $user_id)));
		$role=$result1[0]['user_login']['user_role_id'];
		$this->set("role",$role);
		$this->layout='index_layout'; 
		$this->loadmodel('record');
		$this->loadmodel('village');
		if(isset($this->request->query['find_record']))
		{
			$from=date('Y-m-d',strtotime($this->request->query['from']));
			$date_lab_testing=date('Y-m-d',strtotime($this->request->query['date_lab_testing']));
			if(strtotime($this->request->query['to'])>strtotime(date('d-m-Y')))
			{
				$to=date('Y-m-d');
			}
			else
			{
				$to=date('Y-m-d',strtotime($this->request->query['to']));
			}
			
			$this->set(compact('from'));
			$this->set(compact('to'));
			$this->set(compact('date_lab_testing'));
			if(!empty($this->request->query['village_id']))
			{
				$conditions=array('record.record_flag'=>0,'record.date_lab_testing'=>$date_lab_testing,'record.status_date between ? and ?'=> array($from, $to),'record.village_id'=>$this->request->query['village_id']);
				$this->set('village_id',$this->request->query['village_id']);
			}
			
			$this->Paginator->settings = array(
        'conditions' => $conditions,
        'limit' => 15
		);
		$records = $this->Paginator->paginate('record');
		$this->set(compact('records'));
		
		}
	}
	public function record() 
	{
		$user_id = $this->Session->read('user_id');
		$this->loadmodel('user_login');
		$this->loadmodel('record');
		$result1 = $this->user_login->find('all',array('fields'=>array('user_role_id'),'conditions'=>array("user_id" => $user_id)));
		if($result1[0]['user_login']['user_role_id']==1)
		{
			$this->layout='index_layout';
		}
		else
		{
			$this->layout='user_layout';
		}
		
		if(isset($this->request->query['find_record']))
		{
			$from=date('Y-m-d',strtotime($this->request->query['from']));
			
			if(strtotime($this->request->query['to'])>strtotime(date('d-m-Y')))
			{
				$to=date('Y-m-d');
			}
			else
			{
				$to=date('Y-m-d',strtotime($this->request->query['to']));
			}
			
			$this->set(compact('from'));
			$this->set(compact('to'));
			if(!empty($this->request->query['district']))
			{
				$conditions=array('record.status_date between ? and ?'=> array($from, $to),'record.record_flag'=>0);
				$this->set('district','all_district');
			}
			else if(!empty($this->request->query['district_id']))
			{
				$conditions=array('record.record_flag'=>0,'record.status_date between ? and ?'=> array($from, $to),'record.district_id'=>$this->request->query['district_id']);
				$this->set('district_id',$this->request->query['district_id']);
			}
			else if(!empty($this->request->query['block_id']))
			{
				$conditions=array('record.record_flag'=>0,'record.status_date between ? and ?'=> array($from, $to),'record.block_id'=>$this->request->query['block_id']);
				$this->set('block_id',$this->request->query['block_id']);
			}
			else if(!empty($this->request->query['village_id']))
			{
				$conditions=array('record.record_flag'=>0,'record.status_date between ? and ?'=> array($from, $to),'record.village_id'=>$this->request->query['village_id']);
				$this->set('village_id',$this->request->query['village_id']);
			}
			
			$this->Paginator->settings = array(
        'conditions' => $conditions,
        'limit' => 15
		);
		$records = $this->Paginator->paginate('record');
		$this->set(compact('records'));
		
		}
	}
	
	
	public function edit_data() 
	{
		
		$this->layout='index_layout'; 
			$this->loadmodel('record');
			$from=date('Y-m-d',strtotime($this->request->query['from']));
			$op_value='';
			$date_lab_testing=date('Y-m-d',strtotime($this->request->query['date_lab_testing']));
			if(strtotime($this->request->query['to'])>strtotime(date('d-m-Y')))
			{
				$to=date('Y-m-d');
			}
			else
			{
				$to=date('Y-m-d',strtotime($this->request->query['to']));
			}
			
			if(!empty($this->request->query['village_id']))
			{
				$conditions=array('record.record_flag'=>0,'record.date_lab_testing'=>$date_lab_testing,'record.status_date between ? and ?'=> array($from, $to),'record.village_id'=>$this->request->query['village_id']);
				$this->set('village_id',$this->request->query['village_id']);
				$this->set('lab_test',date('d-m-Y',strtotime($date_lab_testing)));
			}
			
			$record_id= $this->record->find('all',array('conditions'=>$conditions));
			foreach($record_id as $val)
			{
				$up_id[]=$val['record']['id'];
			}
			
			$record_first= $this->record->find('first',array('conditions'=>$conditions));
			$record_last= $this->record->find('first',array('conditions'=>$conditions,'order' =>('id DESC' )));
			$this->set('r_tds',$record_first['record']['rwq_tds']);
			$this->set('r_fl',$record_first['record']['rwq_fl']);
			$this->set('r_no',$record_first['record']['rwq_no']);
			$this->set('t_tds',$record_first['record']['twq_tds']);
			$this->set('t_fl',$record_first['record']['twq_fl']);
			$this->set('t_no',$record_first['record']['twq_no']);
			
			$atm_issue=$record_first['record']['atmcard_issues'];
			if($atm_issue)
				if($atm_issue>9 && $atm_issue<=25)
				{
				$op_value=1;
				}
				else if($atm_issue>25 && $atm_issue<=50)
				{
				$op_value=2;
				}
				else if($atm_issue>50 && $atm_issue<=75)
				{
				$op_value=3;
				}
				else if($atm_issue>75 && $atm_issue<=125)
				{
				$op_value=4;
				}
				else if($atm_issue>125 && $atm_issue<=175)
				{
				$op_value=5;
				}
				else if($atm_issue>175 && $atm_issue<=225)
				{
				$op_value=6;
				}
			$this->set('op_val',$op_value);	
			$strt_date=date('d-m-Y',strtotime($record_first['record']['status_date']));
			$end_date=date('d-m-Y',strtotime($record_last['record']['status_date']));
			$this->set('strt_date',$strt_date);
			$this->set('end_date',$end_date);
			if(isset($this->request->query['edit_record1']))
			{
				$j=0;
				$village_id=$this->request->query['village_id'];
				$date_from=date('Y-m-d',strtotime($this->request->query['from']));
				$date_to=date('Y-m-d',strtotime($this->request->query['to']));
				$period = new DatePeriod(new DateTime($date_from), new DateInterval('P1D'), new DateTime($date_to. '.+1 day'));
				foreach ($period as $date) {
				$dates[] = $date->format("Y-m-d");
				}
				$atmcard_issues=$this->request->query['atmcard_issues'];
				$rwq_tds=$this->request->query['rwq_tds'];
				$rwq_fl=$this->request->query['rwq_fl'];
				$rwq_no=$this->request->query['rwq_no'];
				$twq_tds=$this->request->query['twq_tds'];
				$twq_fl=$this->request->query['twq_fl'];
				$twq_no=$this->request->query['twq_no'];
				$date_lab_testing=date('Y-m-d',strtotime($this->request->query['date_lab_testing']));
				$this->loadmodel('village');
				$village_record=$this->village->find('all',array('conditions'=>array('id' => $village_id,'village_flag'=>1)));
				$date_commission=$village_record[0]['village']['commissioning'];
				$district_id=$village_record[0]['village']['district_id'];
				$mla_costituency=$village_record[0]['village']['mla_costituency'];
				$block_id=$village_record[0]['village']['block_id'];
				$gram_panchayat=$village_record[0]['village']['gram_panchayat'];
				$population=$village_record[0]['village']['population'];
				$no_houses=$village_record[0]['village']['no_houses'];
				$ifr1=800;
				
				$sim_number=$village_record[0]['village']['sim_number'];
				//$remain=$fetchlast_id[0]['record']['total'];
			
				$i=0;
				
				foreach($dates as $data)
				{
				$start = strtotime("12:00:00");
				$end =  strtotime("02:00:00");
				$time = date("H:i", rand($start, $end));
				
				if($atmcard_issues == 1)
				{
				$atmcard=rand(10,25);
				$op_day=rand(100,200)/100;
				$status=['O','No','No','O'];
				}
				else if($atmcard_issues== 2)
				{
				$atmcard=rand(26,50);
				$op_day=rand(100,200)/100;
				$status=['O','No','O','No'];
				}
				
				else if($atmcard_issues== 3)
				{
				$atmcard=rand(51,75);
				$op_day=rand(200,300)/100;
				$status=['O','No','O','No'];
				}
				else if($atmcard_issues == 4)
				{
				$atmcard=rand(76,125);
				$op_day=rand(2300,500)/100;
				$status=['O','No','O','No'];
				}
				
				else if($atmcard_issues == 5)
				{
				$atmcard=rand(126,175);
				$op_day=rand(600,700)/100;
				$status=['O','O','O','O'];
				}
				else if($atmcard_issues == 6)
				{
				$atmcard=rand(176,225);
				$op_day=rand(700,800)/100;
				$status=['O','O','O','O'];
				}
				
				$cum_vol=($atmcard*15)/1000;
				$cu=$cum_vol*1000;
				//$fetchlast_id=$this->record->find('all', array('conditions'=>array('record_flag' => 0, 'village_id'=>$village_id),'order'=>'id DESC','limit'=>1));
				//$lst_id=$fetchlast_id[0]['record']['id'];
				$pen_atm=($atmcard/$no_houses)*100;
				$pen_vol=($cum_vol/$no_houses*15)*100;
				 $fetchlast=$this->record->find('all', array('conditions'=>array('record_flag' => 0, 'village_id'=>$village_id),'order'=>'id DESC','limit'=>1));
				//$remain=$fetchlast[0]['record']['total'];
				$last_op_date=$fetchlast[0]['record']['last_opr_date'];
				$last_cumm=$fetchlast[0]['record']['dispense_date'];
				$last_op=$fetchlast[0]['record']['operational_date'];
				if($j>3){
				$j=0;
				}
				if($status[$j]=='O')
					{	
						$ifr=$ifr1;
						$tds=rand( 150 , 175 );
						$pfr=rand( 460 , 490 );
						$recovery=$pfr/$ifr*100;
						$total_db=$pfr*4;
						//$total=$remain+$total_db;
						$reason='-';
						$op_day=$op_day;
						$last_op_date=date('Y-m-d');
						$cumm=$last_cumm+$cum_vol;
						$op_date=$last_op+$op_day;
					}
					else
					{
						$reason='TWT FULL';
						$ifr='-';
						$pfr='-';
						$tds='-';
						$recovery='-';
						$op_day=0;	
						$cumm=$last_cumm+$cum_vol;
						$op_date=$last_op;
					}
				$this->request->data['id']=$up_id[$i];
				$this->request->data['atmcard_issues']=$atmcard;
				$this->request->data['date_lab_testing']=$date_lab_testing;
				//$this->request->data['date_commission']=$date_commission;
				//$this->request->data['district_id']=$district_id;
				//$this->request->data['mla_costituency']=$mla_costituency;
				//$this->request->data['block_id']=$block_id;
				//$this->request->data['gram_panchayat']=$gram_panchayat;
				//$this->request->data['population']=$population;
				//$this->request->data['no_houses']=$no_houses;
				$this->request->data['rwq_tds']=$rwq_tds;
				$this->request->data['rwq_fl']=$rwq_fl;
				$this->request->data['rwq_no']=$rwq_no;
				$this->request->data['twq_tds']=$twq_tds;
				$this->request->data['twq_fl']=$twq_fl;
				$this->request->data['twq_no']=$twq_no;
				$this->request->data['sim_number']=$sim_number;
				$this->request->data['status_plant']=$status[$j];
				$this->request->data['last_opr_date']=$last_op_date;
				$this->request->data['reason_nonoperational']=$reason;
				$this->request->data['treated_tds']=$tds;
				$this->request->data['ifr']=$ifr;
				$this->request->data['pfr']=$pfr;
				$this->request->data['recovery']=$recovery;
				$this->request->data['operational_day']=$op_day;
				$this->request->data['operational_date']=$op_date;
				$this->request->data['village_id']=$village_id;
				$this->request->data['status_date']=$data;
				$this->request->data['status_time']=$time;
				$this->request->data['penetration_atm']=$pen_atm;
				$this->request->data['penetration_volume']=$pen_vol;
				$this->request->data['dispense_day']=$cum_vol;
				$this->request->data['dispense_date']=$cumm;
				//$this->request->data['total']=$total;
				$this->loadmodel('record');
				$this->record->saveAll($this->request->data);
				
				$j++;
				$i++;
				}	
				
			$this->redirect(array('action' => 'edit_record'));	
			}
			
			
	}

	public function complete_excel_data() 
	{
		$this->layout='ajax_layout';
	
		if(isset($this->request->query['complete_data']))
		{ 
 			$conditions[]=''; 
 			$this->loadmodel('record');
			$records=$this->record->find('all',array('conditions'=>$conditions));
 			$this->set(compact('records'));
		}
	}
	
	public function complete_excel() 
	{
		$this->layout='ajax_layout';
 	
		if(isset($this->request->query['complete_data']))
		{
			$conditions[]='';
			$this->request->query=array_filter($this->request->query);
			if(!empty($this->request->query['from']) && !empty($this->request->query['to']))
			{ 
				$from=date('Y-m-d',strtotime($this->request->query['from']));
				if(strtotime($this->request->query['to'])>strtotime(date('d-m-Y')))
				{
					$to=date('Y-m-d');
				}
				else
				{
					$to=date('Y-m-d',strtotime($this->request->query['to']));
				}
				$conditions['record.status_date between ? and ?'] = array($from, $to);
			}
			else
			{
			$to=date('Y-m-d');
			//-- DSU EDITING
			$todate=date('Y-m-d');
 			$status_date=date("Y-m-d",strtotime($todate." -1 day"));
			//-- DSU EDITING
			$conditions['record.status_date']=$status_date;
			//$conditions['record.status_date <='] = $to;	
			}
			
			if(!empty($this->request->query['district']))
			{
				$conditions[]='';
			}
			else if(!empty($this->request->query['district_id']))
			{
				$conditions['record.district_id']=$this->request->query['district_id'];
			}
			else if(!empty($this->request->query['block_id']))
			{
				$conditions['record.block_id']=$this->request->query['block_id'];
			}
			else if(!empty($this->request->query['village_id']))
			{
				$conditions['record.village_id']=$this->request->query['village_id'];
			}
			
			$this->loadmodel('record');
			$records=$this->record->find('all',array('conditions'=>$conditions));
			 //print_r($records); exit;
			$this->set(compact('records'));
		}
	}
	
	public function village_edit() 
	{
		$this->layout='index_layout'; 
		$this->loadmodel('village');
		$this->set('village' , $this->village->find('all',array('conditions'=>array('village_flag'=>1),'order'=>array('village_name ASC' ))));
		$this->Paginator->settings = array(
        'conditions' => array('village.village_flag'=>1),
        'limit' => 10,
		'order'=>'village_name ASC'
		);
		$result_village = $this->Paginator->paginate('village');
		$this->set(compact('result_village'));
	}
	public function village_search_ajax()
	{
		$this->layout='ajax_layout'; 
		$this->loadmodel('village');
		$village_id=$this->request->query['q'];
		$this->set('village' , $this->village->find('all',array('conditions'=>array('village_flag'=>1,'id'=>$village_id))));
	}
	public function record_edit() 
	{
		$user_id = $this->Session->read('user_id');
		$this->loadmodel('user_login');
		$result1 = $this->user_login->find('all',array('fields'=>array('user_role_id'),'conditions'=>array("user_id" => $user_id)));
		$role=$result1[0]['user_login']['user_role_id'];
		$this->set("role",$role);
		$this->layout='index_layout'; 
		$this->loadmodel('record');
		$this->loadmodel('village');
		$this->set('village' , $this->village->find('all',array('conditions'=>array('village_flag'=>1),'order'=>array('village_name ASC' ))));
		if(isset($this->request->query['find_record']))
		{
			$from=date('Y-m-d',strtotime($this->request->query['from']));
			
			if(strtotime($this->request->query['to'])>strtotime(date('d-m-Y')))
			{
				$to=date('Y-m-d');
			}
			else
			{
				$to=date('Y-m-d',strtotime($this->request->query['to']));
			}
			if(!empty($this->request->query['village_id']))
			{
			$village_id=$this->request->query['village_id'];
			if($role==1){ 
			$this->Paginator->settings = array(
			'conditions' => array('status_date between ? and ?'=> array($from, $to),'village_id' => $village_id ,'record_flag !='=>2),
			'limit' => 10,'order'=>'status_date ASC'
			);
			}
			else{
			$this->Paginator->settings = array(
			'conditions' => array('status_date between ? and ?'=> array($from, $to),'record_flag'=>0),
			'limit' => 10,'order'=>'status_date ASC'
			);	
			}
			}
			else{
			if($role==1){ 
			$this->Paginator->settings = array(
			'conditions' => array('status_date between ? and ?'=> array($from, $to),'record_flag!='=> 2),
			'limit' => 10,'order'=>'status_date ASC'
			);
			}
			else{
			$this->Paginator->settings = array(
			'conditions' => array('status_date between ? and ?'=> array($from, $to) ,'record_flag'=>0),
			'limit' => 10,'order'=>'status_date ASC'
			);	
			}
			}
			$result_record = $this->Paginator->paginate('record');
			$this->set(compact('result_record'));
		
			}
			
	}
	
	
	public function excel_report_datewise() 
	{
		$this->layout='ajax_layout';
		$this->loadmodel('village');
		$this->loadmodel('block');
		$this->loadmodel('district');
		$this->loadmodel('record');
	
		$date_range=explode('/',$this->request->data['date_range']);
		$from=date('Y-m-d',strtotime($date_range[0]));
		
		if(strtotime($date_range[1])>strtotime(date('d-m-Y')))
		{
			$to=date('Y-m-d');
		}
		else
		{
			$to=date('Y-m-d',strtotime($date_range[1]));
		}
		if(!empty($this->request->data['village_id']))
		{
			
			$village_id=$this->request->data['village_id'];
			$result=$this->village->find('all',array('conditions'=>array('id'=>$village_id,'village_flag'=>1)));
			
			foreach($result as $data)
			{ 
				$result_record=$this->record->find('all',array('conditions'=>array('status_date between ? and ?'=> array($from, $to),'village_id'=>$data['village']['id'])));
				
				$result_district=$this->district->find('all',array('fields'=>array('district_name'),'conditions'=>array('id'=>$result_record[0]['record']['district_id'])));
				
				$result_block=$this->block->find('all',array('fields'=>array('block_name'),'conditions'=>array('id'=>$result_record[0]['record']['block_id'])));
				
				$result_village=$this->village->find('all',array('fields'=>array('village_name'),'conditions'=>array('id'=>$result_record[0]['record']['village_id'])));
				$this->set('result_record', $result_record);
				$this->set('result_district', $result_district);
				$this->set('result_block', $result_block);
				$this->set('result_village', $result_village);
			}
			
		}
		
		
	}		
	
	public function pdf_excel() 
	{
		$this->set('export_data', $this->request->data['data_export']);
		if(isset($this->request->data['excel']))
		{
			$this->layout='ajax_layout';
			$this->set('export_in', 'excel');
			$this->set('file_name', $this->request->data['excel']);
		}
		if(isset($this->request->data['pdf']))
		{
			$this->layout='pdf';
			$this->set('export_in', 'pdf');
			$this->set('file_name', $this->request->data['pdf']);
		}
	}
	/////// End Page Name Function //////////
	
	/////// Start Calling Function //////////

	
	public function authentication()
	{
		$user_id=$this->Session->read('user_id');
		$conditions=array("user_id" => $user_id);
		
		$this->loadmodel('user_login');
		$result = $this->user_login->find('all',array('fields'=>array('username'),'conditions'=>$conditions));
		
		if(empty($user_id))
		{
			$this->Session->destroy();
			$this->redirect(array('action' => 'login'));
		}
		return $result;
	}
	public function menu()
	{
		$user_id=$this->Session->read('user_id');
		$this->loadmodel('module');
		return $fetch_menu = $this->module->find('all',array('order' => 'preferance ASC'));
	}
	function user_rights()
	{
		$user_id=$this->Session->read('user_id');
		$this->loadmodel('user_right');
		$conditions=array("user_id" => $user_id);
	
		return $fetch_user_right = $this->user_right->find('all',array('conditions'=>$conditions));
		
	}
	public function menu_submenu($main_menu)
	{
		$user_id=$this->Session->read('user_id');
		$this->loadmodel('module');
		$conditions=array("main_menu" => $main_menu);
		
		return $fetch_menu_submenu = $this->module->find('all',array('conditions'=>$conditions));
		
	}
	public function submenu($sub_menu)
	{
		$user_id=$this->Session->read('user_id');
		$this->loadmodel('module');
		$conditions=array("sub_menu" => $sub_menu);
		return $fetch_submenu = $this->module->find('all',array('conditions'=>$conditions));
		
	}
	public function find_block($district_id)
	{
		$this->loadmodel('block');
		return $result_block=$this->block->find('all',array('fields'=>array('block_name','id'),'conditions'=>array('district_id'=>$district_id)));
	}
	public function find_block1($blodk_id)
	{
		$this->loadmodel('block');
		return $result_block=$this->block->find('all',array('fields'=>array('block_name','district_id'),'conditions'=>array('id'=>$blodk_id)));
	}
	public function find_village($block_id)
	{
		$this->loadmodel('village');
		return $result_village=$this->village->find('all',array('fields'=>array('village_name','id'),'conditions'=>array('block_id'=>$block_id)));
	}
	public function find_village1($village_id)
	{
		$this->loadmodel('village');
		return $result_village=$this->village->find('all',array('fields'=>array('village_name'),'conditions'=>array('id'=>$village_id)));
	}
	public function find_village_all($village_id)
	{
		$this->loadmodel('village');
		return $result_village_all=$this->village->find('all',array('conditions'=>array('id'=>$village_id)));
	}
	public function find_district($id)
	{
		$this->loadmodel('district');
		return $result_district=$this->district->find('all',array('fields'=>array('district_name'),'conditions'=>array('id'=>$id)));
	}
	public function find_record($village_id,$from,$to)
	{
		$from=date('Y-m-d',strtotime($from));
		$to=date('Y-m-d',strtotime($to));
		$this->loadmodel('record');
		return $this->record->find('all',array('conditions'=>array('status_date between ? and ?'=> array($from, $to),'village_id'=>$village_id)));
	}
	public function find_record_complete($village_id)
	{
		$date=date('Y-m-d');
		
		$this->loadmodel('record');
		return $this->record->find('all',array('conditions'=>array('status_date <='=> $date,'village_id'=>$village_id)));
	}
	function ajax_php_file()
	{
		$this->layout='ajax_layout';
		
		if(isset($this->request->query['village_edit_ajax'])==1)
		{
			$this->loadmodel('village');
			$this->village->save($this->request->data);
			exit;
		}
		if(isset($this->request->query['record_edit'])==1)
		{
			$this->loadmodel('record');
			$this->record->save($this->request->data);
			
			exit;
		}
		
		if(isset($this->request->query['search_report'])==1)
		{
			$this->loadmodel('village');
			$this->loadmodel('block');
			$this->loadmodel('district');
			$this->loadmodel('record');
			$from=date('Y-m-d',strtotime($this->request->query['daterangepicker_start']));
			
			if(strtotime($this->request->query['daterangepicker_end'])>strtotime(date('d-m-Y')))
			{
				$to=date('Y-m-d');
			}
			else
			{
				$to=date('Y-m-d',strtotime($this->request->query['daterangepicker_end']));
			}
			if(!empty($this->request->query['village_id']))
			{
				$village_id=$this->request->query['village_id'];
				$result=$this->village->find('all',array('conditions'=>array('id'=>$village_id,'village_flag'=>1)));
			}
			foreach($result as $data)
			{ 
				$result_record=$this->record->find('all',array('conditions'=>array('status_date between ? and ?'=> array($from, $to),'village_id'=>$data['village']['id'],'order'=>'status_date ASC')));
				?>
				<div class="col-sm-12">
				<button type="submit" class="btn btn-sm btn-primary pull-right print" name="excel" value="Watermate" formaction="excel_report_datewise"  style="margin-right: 5px;"><i class="fa fa-download"></i> Excel</button>
				
				</div>
				<div class="col-sm-12">
				<div class="box-body table-responsive no-padding"  id="report">
					<table class="table table-bordered" border="1">
						<thead>
							<tr>
							<th>Date of commissioning of plant</th><th>District</th><th>MLA Costituency</th><th>Block/Panchayat Samity</th><th>Gram Panchayat</th><th>Name of Village/ habitation</th><th>Poulation ( 2011 Census)</th><th>Nos of Household</th><th>Nos. of ATM Card issued </th><th>Date of sample (lab testing)</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$result_district=$this->district->find('all',array('fields'=>array('district_name'),'conditions'=>array('id'=>$result_record[0]['record']['district_id'])));
						$result_block=$this->block->find('all',array('fields'=>array('block_name'),'conditions'=>array('id'=>$result_record[0]['record']['block_id'])));
						$result_village=$this->village->find('all',array('fields'=>array('village_name'),'conditions'=>array('id'=>$result_record[0]['record']['village_id'])));
						foreach($result_record as $data_record)
						{
							?>
							<tr>
								<td><?php echo date('d-m-Y',strtotime($data_record['record']['date_commission'])); ?></td>
								<td><?php echo $result_district[0]['district']['district_name']; ?></td>
								<td><?php echo $data_record['record']['mla_costituency']; ?></td>
								<td><?php echo $result_block[0]['block']['block_name']; ?></td>
								<td><?php echo $data_record['record']['gram_panchayat']; ?></td>
								<td><?php echo $result_village[0]['village']['village_name']; ?></td>
								<td><?php echo $data_record['record']['population']; ?></td>
								<td><?php echo $data_record['record']['no_houses']; ?></td>
								<td><?php echo $data_record['record']['atmcard_issues']; ?></td>
								<td><?php echo date('d-m-Y',strtotime($data_record['record']['date_lab_testing'])); ?></td>
							</tr>
							<?php
						}
						?>
						</tbody>
					</table>
				</div>
				</div>
				<?php	
			}
			exit;
		}
		if(isset($this->request->query['search'])==1)
		{
			$condtions='';
			if(!empty($this->request->query['village_id']))
			{
				$village_id=$this->request->query['village_id'];
				$this->loadmodel('village');
				$result=$this->village->find('all',array('conditions'=>array('id'=>$village_id,'village_flag'=>1)));
				?>
				<div class="row">
					<?php 
					foreach($result as $data)
					{
						$target_dir = "images_post/village/".$data['village']['id'];
						$images = glob($target_dir.'/*');
						?>
						<div class="col-lg-3 col-xs-6">
						  <!-- small box -->
						  <a href="<?php echo $this->webroot; ?>search_report?village_id=<?php echo $data['village']['id']; ?>" >
					  <div class="small-box bg-aqua" style="border:1px solid aqua;">
							 <img style="width:100%; height:150px; overflow:hidden;" src="<?php echo $images[0]; ?>"/>
							
							<div class="small-box-footer" style="color:#fff; font-weight:700; text-transform: uppercase;">
								<?php echo $data['village']['village_name']; ?>
							</div>
						  </div>
						  </a>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
			else if(!empty($this->request->query['block_id']))
			{
				$block_id=$this->request->query['block_id'];
				$this->loadmodel('village');
				$result=$this->village->find('all',array('conditions'=>array('block_id'=>$block_id,'village_flag'=>1)));
				?>
				<div class="row">
					<?php
					foreach($result as $data)
					{
						$target_dir = "images_post/village/".$data['village']['id'];
						$images = glob($target_dir.'/*');
						?>
						<div class="col-lg-3 col-xs-6">
						  <!-- small box -->
						 <a href="<?php echo $this->webroot; ?>search_report?village_id=<?php echo $data['village']['id']; ?>" >
						 
					  <div class="small-box bg-aqua" style="border:1px solid aqua;">
							 <img style="width:100%; height:150px; overflow:hidden;" src="<?php echo $images[0]; ?>"/>
							
							<div class="small-box-footer" style=" color:#fff; font-weight:700; text-transform: uppercase;">
								<?php echo $data['village']['village_name']; ?>
							</div>
						  </div>
						  </a>
						</div>
						<?php
					}
					?>
				</div>
				<form method="get" id="form">
					<input type="hidden" name="block_id" value="<?php echo $block_id; ?>" />
					<div class="col-sm-12">
					  <div class="form-group col-sm-4">
						<label>Date range:</label>
						<div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
							<input class="form-control" name="from" type="text">
							<span class="input-group-addon" style="background-color:e5e5e5 !important;">
							To </span>
							<input class="form-control" name="to" type="text">
						</div>
						<span class="help-block">
						Select date range </span>
						<!-- /.input group -->
					  </div>
					  <div class="form-group col-sm-2">
					  <label></label>
						<button type="submit" name="find_record" class="btn btn-block btn-primary" formaction="record" >Record</button>
						</div>
					</div>
				</form>
				<?php
			}
			else if(!empty($this->request->query['district_id']))
			{
				$district_id=$this->request->query['district_id'];
				$this->loadmodel('block');
				$result=$this->block->find('all',array('conditions'=>array('district_id'=>$district_id,'block_flag'=>1)));
				?>
				<div class="row">
					<?php
					foreach($result as $data)
					{
						$target_dir = "images_post/block/".$data['block']['id'];
						$images = glob($target_dir.'/*');
						?>
						<div class="col-lg-3 col-xs-6">
						  <!-- small box -->
						  <a  class="search_data" district_id="" block_id="<?php echo $data['block']['id']; ?>" style="cursor:pointer;">
					  <div class="small-box bg-aqua" style="border:1px solid aqua;">
							  <img style="width:100%; height:150px; overflow:hidden;" src="<?php echo $images[0]; ?>"/>
							
							<div class="small-box-footer" style=" color:#fff; font-weight:700; text-transform: uppercase;">
								<?php echo $data['block']['block_name']; ?>
							</div>
						  </div>
						  </a>
						</div>
						
						<?php
					}
					?>
				</div>
				<form method="get" id="form">
					<input type="hidden" name="district_id" value="<?php echo $district_id; ?>" />
					<div class="col-sm-12">
					  <div class="form-group col-sm-4">
						<label>Date range:</label>
						<div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
							<input class="form-control" name="from" type="text">
							<span class="input-group-addon" style="background-color:e5e5e5 !important;">
							To </span>
							<input class="form-control" name="to" type="text">
						</div>
						<span class="help-block">
						Select date range </span>
						<!-- /.input group -->
					  </div>
					  <div class="form-group col-sm-2">
					  <label></label>
						<button type="submit" name="find_record" class="btn btn-block btn-primary" formaction="record" >Record</button>
						</div>
					</div>
				</form>
				<?php
			}
			exit;
			
		}
		
	}
	/////// End Calling Function //////////
function ajax_delete_record(){
$this->loadmodel('record');
$auto_id = $this->request->query('con');
$result=$this->record->UpdateAll(array('record_flag'=>1), array('id'=>$auto_id));

}	
////////
function ajax_undo_record(){
$this->loadmodel('record');
$auto_id = $this->request->query('con');
$result=$this->record->UpdateAll(array('record_flag'=>0), array('id'=>$auto_id));
}
///////
function ajax_del_record(){
$this->loadmodel('record');
$auto_id = $this->request->query('con');
$result=$this->record->UpdateAll(array('record_flag'=>2), array('id'=>$auto_id));

}


function ajax_delete_all()
{
$this->loadmodel('record');
$v = $this->request->query('v');
$f= base64_decode($this->request->query('f'));
$from=date("Y-m-d",strtotime($f));
echo $t= base64_decode($this->request->query('t'));
$to=date("Y-m-d",strtotime($t));
$result=$this->record->UpdateAll(array('record_flag'=>"'2'"), array('status_date between ? and ?'=> array($from, $to),'village_id'=>$v));
}


function datefordb($date)
	{$date_new=date("Y-m-d",strtotime($date));return($date_new);}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function dateforview($date)
	{
	$date_no='N/A';	
	$date_new=date("d-m-Y",strtotime($date));
	if($date_new=='01-01-1970')
	return($date_no);
	else
	return($date_new);
	}	
}
?>
