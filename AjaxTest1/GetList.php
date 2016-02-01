
<?php
	//this is a transmitter(controller)
    echo 'damn';
	print "GetList.php<br>";
	include('DB_connection.php');
	
	
	$_jsonList = Inqury();
	//$_jsonList = json_decode(Inqury());
	//echo $_jsonList;
	//-----this is unnecessary (view ctrl)
	function HtmlPrintOut( $_jsonArray ){
		
		$_tableHTML = "<table style='width:100%;' cellpadding='2' cellspacing='0' border='1' bordercolor='#000000'><tbody>";
		$_resultHTML = $_tableHTML;
		$_tagHTML = "<a href='ShowDetail.php?";
		
		$_currentData;//it's a pointer
		$_length = count( $_jsonArray );
		$_index = 0;
		$_date = 0;
		
		//for( $_i = 0 ; $_i < $_length ; $_i++){
			//echo $_i;
		foreach( $_jsonArray as $_i=>$_value ){
			$_currentData = $_jsonArray[$_i];
			
			$_index = $_currentData["_index"];
			$_date = $_currentData["_date"];
			
			$_hrefTag = $_tagHTML."_index=".$_index."&"."_date=".$_date.">".$_index."</a>";
			
			$_resultHTML = $_resultHTML."<tr>";//row
				$_resultHTML = $_resultHTML."<td>".$_hrefTag."</td>"."<td>".$_date."</td>";
			$_resultHTML = $_resultHTML."</tr>";
		} 
		$_resultHTML = $_resultHTML."</table>";
		
		
		return $_resultHTML;
	}
	
	echo HtmlPrintOut($_jsonList);
?>



