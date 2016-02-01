<?php

	include_once('Actions.php');

	//$_localAction = LocalAction::getInstance();
	//$_fbAction = FbAction::getInstance();

	echo '---unit test---<br>';

	//$_localAction->sidEncrypt();
	LocalAction::sidEncrypt();
	echo '<br>';
	//$_getPic = $_fbAction->getPic();
	FbAction::getPic();
	echo '<br>';
	//$_localAction->saveImg();
	LocalAction::saveImg();
	echo '<br>';
	//$_localAction->toLog();
	LocalAction::toLog();

	echo '<br>---unit test OK !!---<br>';