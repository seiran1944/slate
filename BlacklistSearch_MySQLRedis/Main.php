<html>

<head>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script language="javascript">
        function queryIP() {
            <!--先取得欄位值-->
            var country = $('#country').val();
            var ip = $('#ip').val();
            <!--判斷有無正確填寫-->
            if (country == "" || ip == "") {
                alert('Please enter infos of up above');
                return false;
            }

            //真正的AJAX動作從這裡開始
            $.ajax({
                url: "queryIP.php",
                data: "country=" + country + "&ip=" + ip,
                type: "POST",
                beforeSend: function () {
                    //$('#loading_div').show();
                    //beforeSend 發送請求之前會執行的函式
                },
                success: function (msg) {
                    alert(msg);
                },
                error: function (xhr) {
                    alert('Ajax request 發生錯誤 : ' + xhr);
                },
                complete: function () {

                }
            });
        }
        ;
    </script>
</head>

<body>

<div id="query_block" align='center'>
    <form id="query" method="POST">
        <table id="query_table">
            <tr>
                <td>
                    <p>BlacklistSearch_MySQLRedis</p>
                    <label>Country Code Name :</label><input type="text" name="country" id="country"/><br/>
                    <label>IP address :</label><input type="text" name="ip" id="ip"/><br/>

                    <input type='button' id='query' value='Query' onclick='queryIP();'/>
                </td>
            </tr>
        </table>
    </form>
    <div id="msg"></div>

</div>

</body>

</html>
