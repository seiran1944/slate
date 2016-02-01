/**
 * Created by aris on 9/17/14.
 */

function NewMsg(){
    alert('NewMsg');
    $.ajax({
        url:"index.php/newmsg",
        data:{},//"user_id="+user_id+"&user_password="+user_password,
        type : "POST",
        beforeSend:function(){
            //$('#loadings_div').show();
            //beforeSend 發送請求之前會執行的函式
            alert('beforeSend');
        },
        success:function(msg){
            /*
            if(msg =="success"){
                $('#login_showname').text('Welcome!'+user_id);
                $('#login_success').text('You have successfully login!');
                $('#login_success').fadeIn();
                //如果成功登入，就不需要再出現登入表單，而出現登出表單
                $('#error_msg').hide();
                $('#user_login').hide();
                $('#user_logout').fadeIn();
                //<meta HTTP-EQUIV="refresh" CONTENT="幾秒後換頁;url=所要連結的語法">  //自動換頁
                //window.location.reload("http://www.yahoo.com.tw");    //自動換頁
            }else{
                $('#error_msg').show();
                $('#error_msg').html('Please Login again,<br/>沒有此用戶或密碼不正確');
            }*/
            alert(msg);
        },
        error:function(xhr){
            alert(xhr);
            //alert('Ajax request 發生錯誤 : ' + xhr );
        },
        complete:function(){
            alert('complete');
            //$('#loading_div').hide();
            //$('#user_login').hide();
            //complete請求完成實執行的函式，不管是success或是error
        }
    });


}