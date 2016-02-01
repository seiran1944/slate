<!--
<h1>WTF, <?php //echo $name ?>!</h1>
view msgboard <?php //echo $name ?>, how's it going?
-->
<html>
    <head>
        <title>FuelphpMsgBoard</title>>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/msgboard.js"> ///js/View_index.js </script>
        <script language="javascript">
            ///js/View_index.js
            function NMsg(){
                //alert('NewMsg');
                var _author = $('#author').val();
                var _content = $('#content').val();
                //var _content = document.getElementsByName('content').value;

                if( _author == null || _author == "" ){
                    alert("Please leave your name !");
                    return;
                }

                if( _content == null || _content == "" ){
                    alert("Please leave your message !");
                    return;
                }

                $.ajax({
                    url:"index.php/newmsg",
                    data:{'_author': _author , '_content':_content },
                    type : "POST",
                    beforeSend:function(){
                        alert('Are you sure you wanna send this msg??');
                    },
                    success:function(msg){
                        //alert(msg);
                        location.reload();
                    },
                    error:function(xhr){
                        //alert('error : '+xhr);
                        //location.reload();
                    },
                    complete:function(){
                        //alert('complete');
                    }
                });
            }

        </script>
    </head>

    <body>

        <p align='center'>
            <?php
                //var_dump( $_articles );
                foreach( $_articles as $i=>$row ){
                    echo '#'.$i.'------------------------------------<br>';
                    echo '['.$row['_author'].'] : '.$row['_content'].'<br>-----at : '.$row['_date'].'-----';
                    echo '<br>====================================<br><br>';
                }
            ?>
        </p>

        <div align='center' >
            <form id="newMsg" method="POST" >
                <table id="newMsg_table">
                    <tr>
                        <td>
                            <label>Name :</label><input type="text" name="author" id="author"/><br/>
                            <label>Say :<br></label><textarea name="content" id="content" rows="7" ></textarea>
                            <br/>
                            <input type='button' id='Send' value='Send' onclick='NMsg();' />
                        </td>
                    </tr>
                </table>
            </form>
        </div>

    </body>

</html>


<!-- end of /fuel/app/views/hello.php -->