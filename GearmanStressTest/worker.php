
<?php
	include_once('Actions.php');
	//session_start();
	//define actions
	//$_localAction = LocalAction::getInstance();
	//$_fbAction = FbAction::getInstance();

	function sidEncrypt(){
		//return $_localAction->sidEncrypt();
		return LocalAction::sidEncrypt();
	}

	function getPic(){
		//return $_fbAction->getPic();
		return FbAction::getPic();
	}

	function saveImg( $_job ){
		//echo("ouch saveImg !!");
		$_data = unserialize( $_job->workload() );
		//return $_localAction->saveImg();
		return LocalAction::saveImg( $_data['_imgUrl'] );
	}

	function toLog( $_job ){
		//echo("ouch toLog !!");
		$_data = unserialize( $_job->workload() );
		//return $_localAction->toLog( $_data['action'] , $_data['duration'] );
		return LocalAction::toLog( $_data['_action'] , $_data['_duration'] );
	}

	//init worker
	$worker = new GearmanWorker();//
	$worker->addServer(); // ______ localhost
	$worker->addFunction('EncryptSID', 'sidEncrypt');
	$worker->addFunction('FbAPI', 'getPic');
	$worker->addFunction('SaveToTemp', 'saveImg');
	$worker->addFunction('SaveToLog', 'toLog');
	
	//run like a hale !! 
	while($worker->work()) {
	    sleep(5); //to check every 5 sec
	}

	