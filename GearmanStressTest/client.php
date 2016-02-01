<?php
	echo 'GearmanClient';

	$_fbMsg = 'not working';
	$_saveImgMsg = 'not working';

	job1();
	//job3('http://s2.gigacircle.com/media/s2_53f2e7917dad8.jpg');
	//job4( $_fbMsg , $_saveImgMsg );
	//echo "client task is added.\n";

	function jobEcho( $_task ){//work respond gathering 
			switch ( $_task->unique() ) {
				case 'job1' ://當job1回復已完成時   執行job2
						print session_id()." :::";
						session_id( $_task->data() );//將worker產生的session id 設回
						print "EncryptSID : " . $_task->unique() . ", " . $_task->data() . ":" . session_id() . "\n"; 
						job2();
					break;

				case 'job2'://當job2回復已完成時   執行job3
						Global $_fbMsg;
						$_fbMsg = "FbAPI : " . $_task->unique() . ", " . $_task->data() . ":" ."\n"; 
						print $_fbMsg;
						job3( $_task->data() );
					break;

				case 'job3'://當job3回復已完成時   執行job4
						echo 'job3 done';
						Global $_fbMsg , $_saveImgMsg;
						$_saveImgMsg = "SaveToTemp : " . $_task->unique() . ", " . $_task->data() . ":" ."\n"; 
						print $_saveImgMsg;
						job4( $_fbMsg , $_saveImgMsg );
					break;

				case 'job4':
						print("job4 done !!\n");
					break;
				
				default:
					# code...
					print "unknown responding!! \n";
					break;
			}
	}

	function CreateNewClient(){
		$_client = new GearmanClient();
		$_client->addServer("192.168.201.12");
		$_client->setCompleteCallback("jobEcho");
		return $_client;
	}

	function job1(){
		$_client = CreateNewClient();
		
		$_uid = 'job1';
		$_client->addTask('EncryptSID',"data" , null , $_uid );
		$_client->runTasks();
	}

	function job2(){
		$_client = CreateNewClient();

		$_uid = 'job2';
		$_client->addTask('FbAPI',"data" , null , $_uid );
		$_client->runTasks();
	}

	function job3( $_imgUrl ){
		$_client = CreateNewClient();

		$_uid = 'job3';
		$_data = array('_imgUrl' => $_imgUrl );
		$_client->addTask('SaveToTemp',serialize($_data) , null , $_uid );
		$_client->runTasks();
	}

	function job4( $_fbMsg , $_saveImgMsg ){
		$_client = CreateNewClient();

		$_uid = 'job4';
		$_data = array('_action' => $_fbMsg , 
						'_duration' => $_saveImgMsg
						);
		//print "\njob4 start : ".$_fbMsg." : ".$_saveImgMsg."\n";
		$_client->addTask('SaveToLog', serialize($_data) , null , $_uid );
		$_client->runTasks();
	}

