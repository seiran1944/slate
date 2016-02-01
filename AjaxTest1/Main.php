<?php
	//include("/ReadSoccerData/Rear.php");
	//ConnectDB();
	//$_sql = "SELECT _idex FROM Soccer";
?>

<html>
	<head>
	
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="json.js"></script>
			
		<script type="text/javascript">
			function ButtonClicked(){
				var showText = "Started !!!";

				var _showBoard = document.getElementById('showBoard');
				_showBoard.innerHTML = showText;//trace info
				
				//--------------------------ajax
				$.ajax({
					url:"GetList.php",
					data:"",
					type : "POST",
					beforeSend:function(){
									_showBoard.innerHTML += "<br>beforeSend";
								},
					success:function(_echo){
									//windows.print(_echo);
									_showBoard.innerHTML += "<br>success";
									//_showBoard.innerHTML += _echo;
									/*
									var _dataPack = JSON.parse(_echo);
									var _tableHTML = "<table style='width:100%;' cellpadding='2' cellspacing='0' border='1' bordercolor='#000000'><tbody>";
									var _resultHTML = _tableHTML;
									for( var _i in _dataPack ){
										//<tr>	//row
											//<td> //colume
										_resultHTML += "<tr>";
										windows.print( _i + " : " + _dataPack[i] );
										//</tr>
										_resultHTML += "</tr>";
									}
									_resultHTML += "</table>";
									*/
								},
					error:function(xhr){
									_showBoard.innerHTML += "<br>error";
								},
					complete:function(_echo){
									_showBoard.innerHTML += "<br>complete";
								}
				} );//end ajax
				//-----------------END------ajax
				console.table();
			}//end ButtonClicked();
		</script>
	</head>

	<body>

		<button onclick='ButtonClicked();'>Using Ajax</button>
		<pre id="showBoard"></pre>
		<a href="GetList.php">None Ajax</a>
		
		<form action="test_post.php" method="post">
¡@			Name: <input type="text" name="Email" />
¡@			<input type="submit" value="Suuum"/>
		</form> 
		
		<script type="text/javascript">
			
		</script>
		

	</body>
</html>