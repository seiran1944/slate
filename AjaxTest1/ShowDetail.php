
		<?php
			header("Content-Type:text/html; charset=utf-8");
			print "ShowDetail.php<br>";
			include('DB_connection.php');
	
			$_requestIndex = $_GET["_index"];
	
			$_contentData = InquryByID( $_requestIndex );
	
			$_html = '';
			foreach( $_contentData as $_i=>$_value ){
				
				//$_html = $_value;
				$_html += ( html_entity_decode($_value) );
				//echo ( ($_value) );
			}

			echo '<html>'.'<head></head>'.'<body>'.$_html.'</body>'.'</html>';
	
		?>

