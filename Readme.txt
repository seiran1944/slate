VM Guest OS的Lan IP  : http://192.168.201.104:8080/

//===================================================================================
Week 1 :
    ●ProjectName : ReadSoccerData
        網址:http://192.168.201.104:8080/Aris/ReadSoccerData/Main.html

        1. Webservice 練習
        1.1 寫一支程式定時每五分鐘讀取https://tw.sports.yahoo.com/soccer/worldcup/standings/的內容
        1.2 將 內容中的<div class="bd yom-tabview yui3-tabview-content">至 </div>資料使用 simple_dom 解析並存入資料庫，
        欄位僅需包含流水號、存入時間、文字內容

        說明 : Main.html  主頁  分上下兩個iframe 上方為讀取網頁內容，下方為資料庫存入資訊printout

        1.3 提供兩支Restful API
        1.3.1 一支提供資料庫中的所有資料列表，
        Input : void , output :JSON { ID,Updatetime}
        1.3.2 一支以流水號提供查詢文字內容與存取時間
        Input : ID , output :JSON { ID,Updatetime, text}

        說明 : rear.php 資料庫連線 與 API，提供Inqury() 與 InquryByID( $_id ) 皆回傳 json格式資料串

        完成日期:2014/9/9



    ●ProjectName : AjaxTest1
        網址 : http://192.168.201.104:8080/Aris/AjaxTest1/GetList.php

        2.1 寫一個PHP畫面包含列表(練習一存取之所有資料列表)，每筆資料請內含一個包含流水號之連結
        2.2 點取某一筆資料連結之後，已AJAX的方式將該列表讀出，並以Jquery的Box 顯示於畫面上

        說明 :  GetList.php //主頁  PS:不含AJAX的版本
        ShowDetail.php //瀏覽內容的PHP函式
        DB_connection.php //資料庫連結 與 API

        完成日期 : 2014/9/11



    ●ProjectName : RedisTest1
        網址 : http://192.168.201.104:8080/Aris/RedisTest1/Main.php

        3.1 使用迴圈將產生費波那契數列，依序從F1產生至F10000，並逐筆存入Redis，請於全部資料存入之前與全部資料存入之後記錄各時間點，
        並於程式執行結束前將執行時間計算出並顯示於畫面上。
        F1,F2,F3,F4,F5,F6,F7,F8,F9,F10,F11,F12,F13
        1,1,2,3,5,8,13,21,34,55,89,144,233

        說明 :     Main.php //主頁

        完成日期 : 2014/9/11



//===================================================================================
Week 2 :
    ●ProjectName : PHPDetectToolsInstall
        1. 於VM Guest OS中安裝 php documentor、PHPCS 、PHPCPD、PHPLOC、PHPMD、PHPUnit，並學習如何在PHPStorm中設定與使用
        ex :
        sudo apt-get install php-pear
        sudo pear config-set auto_discover 1
        sudo apt-get install -y php5-dev php5-xsl graphviz
        sudo pear channel-discover pear.phpdoc.org
        sudo pear install phpdoc/phpDocumentor-alpha
        請參考https://www.youtube.com/watch?v=Vb33bVvcviE
        1.1 請將安裝好的畫面與指令或步驟寫入PPT做說明

        說明 : 安裝步驟說明

        完成日期 : 2014/9/16


    ●ProjectName : FuelphpMsgBoard
        網址 : http://192.168.201.104:8080/Aris/FuelphpMsgBoard/public/

        於VM Guest OS中安裝 fuelphp，請參考http://fueldocs.ycnets.com/installation/instructions.html
        2.1. 請用 fuelphp 做一個留言版
        2.2. 留言版資料寫進 mysql

        說明 : fuelphp  mysql 留言版    已移除非撰寫檔案
        主要目錄為 /fuel/app/classes/controller/msgboard.php    //留言板controller
        /fuel/app/classes/model/msgboardDB.php        //留言板資料庫操作
        /fuel/views/msgboard.php            //留言板主頁

        完成日期 : 2014/9/17


//===================================================================================
Week 3 :
    ●ProjectName：ProjectDataBuildup
        1. 在mysql內建立"XX系統"的資料表
        (1). 客戶基本資料 (2). 相關商品基本資料表 (3). 訂單資料表
        1.1 建立資料的SQL寫於BuildSystem.sql
        1.2 將BuildSystem.sql於MySQL 執行
        1.3 將上述SQL與執行畫面存放至Word檔(檔名XX系統資料建置.docx)

        說明 : 已完成

        完成日期 : 2014/9/19


    ●ProjectName：Fuelphp_OrmPractice
        網址 : http://192.168.201.104:8080/Aris/Fuelphp_OrmPractice/public/

        2. 請使用fuelphp實作以下功能
        (1) 使用 ORM 存取客戶基本資料(單一客戶，全部房客列表)
        (2) 使用 model_crud 存取商品基本資料(包含兩種：1. 單一商品，2.全部商品列表)
        (3) 使用 PHP Quick Profiler來查看PHP的CPU與MEMORY使用率

        說明 : 第(1)(2)小題 :
        僅將DB撈出的內容以var_dump輸出
        主要目錄為
        /fuel/app/classes/controller/ormpractice.php    //controller
        /fuel/app/classes/model/ormpractice.php        //model orm 與 Model_Crud 操作都在這邊
        /fuel/views/ormpractice.php            //view

        第(3)小題快照 :    2-3_QuickProfiler_Checking_Snapshot.png

        完成日期 : 2014/9/22


    ●ProjectName：FuelphpPackagePractice
        網址 : http://192.168.201.104:8080/Aris/Fuelphp_OrmPractice/public/

        3.1. InstallationUsing oil
        1. cd to your fuel project's root
        2. Run php oil package install casset
        3. Optionally edit fuel/packages/casset/config/casset.php (the defaults are sensible)
        4. Create public/assets/cache
        5. Add 'casset' to the 'always_load/packages' array in app/config/config.php
        (or callFuel::add_package('casset') whenever you want to use it).
        3.2. 將JQUERY.js放入asset資料夾，並使用casset呼叫

        說明 : 使用Fuelphp_OrmPractice當作環境
        見/fuel/views/ormpractice.php            //view

        完成日期 : 2014/9/22


    ●ProjectName：Fuelphp-CS_Install
        網址 : http://192.168.201.104:8080/Aris/Fuelphp_OrmPractice/public/
        4.1 請詳細閱讀https://github.com/eviweb/fuelphp-phpcs
        4.2 下載ruleset (https://github.com/eviweb/fuelphp-phpcs/blob/master/Standards/FuelPHP/ruleset.xml)
        4.3 安裝至OS
        1.clone the project git clone https://github.com/eviweb/fuelphp-phpcs.git
        2.change directory to ./fuelphp-phpcs cd fuelphp-phpcs
        3.run installer with root privileges sudo ./install.sh

        說明 : 使用Fuelphp_OrmPractice當作環境

        完成日期 : 2014/9/22


    ●ProjectName：GearmanStressTest
        網址 : http://192.168.201.104:8080/Aris/GearmanStressTest_/client.php

        1. Gearman 練習
        1.1. 在linux上安裝 Gearman，並啟動Gearman
        請參考http://blog.wu-boy.com/2013/06/how-to-install-gearman-on-ubuntu-or-debian-with-mysql/
        1.2.安裝php的gearman套件，使用預設的Queue裝置即可
        1.3. 撰寫Gearman的worker程式
        Worker1：產生128bit的字元資料，使用亂碼並使用MD5編碼過的SessionID
        Worker2：連結 Facebook API，並隨便讀取一個圖片檔
        Worker3：將此檔案內容存入/temp資料夾
        Worker4：將Work2與Work3的工作狀態寫入LOG資料庫
        1.4.  撰寫Gearman的 client 程式
        Client：與Gearman取得SessionID
        1.5. 單元測試：請將1.3 & 1.4 的程式寫出單元測試
        1.6. 壓力測試 : 做出壓力測試報告(Connections : 100,500,1000,2000,5000)
        請參考 http://www.ttlsa.com/distributed-processing-systems/large-scale-web-architecture-of-gearman-distributed-application-case/
        1.7. 將5000Test.xlsx擋名改為"GearmanStressTest5000NoResult" or "GearmanStressTest5000WithResult"
        1.8. 將壓力測試數據和程式碼放在"GearmanStressTest"的資料夾裡上傳至git

        說明 : 已完成 ※Facebook API 於9/26 串接完成 (測試時session沒有更新 導致一直無法撈到資料)
        Actions.php  //這裡定義所有 動作類別(Worker1~Worker4的動作)
        client.php   //client端執行動作需由頁面
        worker.php   //server端的workers ( 在這裡定義server workers 並調用 Worker1~Worker4的動作 )
        unitTest.php   //單元測試頁

        執行方式 : 1.先於server端運行worker.php
        2.使用Broswer連結client.php (http://192.168.201.104:8080/Aris/GearmanStressTest_/client.php)

        完成日期 : 2014/9/25


//===================================================================================
Week 4 :
    ●Project Name ： BlacklistSearch_MySQLRedis
        網址 : http://192.168.201.104:8080/Aris/BlacklistSearch_MySQLRedis_/Main.php

        1. 請將 full_blacklist_database.txt 內的IP第一段數字(1-255)與國家代號依序讀出並存入MySQL資料表(僅存入IPV4的IP即可)
        同一國家與同一第一段數字則依序(一筆IP一行文字)存入文字檔中(檔名：國家代號_IPPrefix.txt)，並將文字檔的路徑寫入第三欄位(file_location)
        CREATE TABLE black_ip_list (country varchar(3),ip_prefix varchar(3), file_location varchar(30) );
        ex ：
        2. 請試著撰寫PHP function (isIpExistsBlackList) 查詢該IP是否存在
        輸入：國家，IP
        輸出：True or false
        步驟：
        1) 依國家與第一段數字於資料庫中尋找文字檔，若不存在直接回傳FALSE
        2) 若存在資料庫，則使用全文檢索方式於文字檔中搜尋該IP，若有找到則回傳TRUE，反之傳回FALSE
        3. 使用jmeter 利用3000-threads * 10條連線 執行此PHP function ，並紀錄存取時間與錯誤率

        說明 :  Main.php    //主頁
        Model.php    //DB 與後端實際運作在這裡
        queryIP.php    //連結主頁動作與Model.php

        完成日期 : 2014/9/30



        ●Project Name ： FacebookApiFlow
        說明 : Facebook API取檔的流程圖

        完成日期 : 2014/10/1


//===================================================================================
Week 5 :
    ●Project Name ： Nodejs_SocketIO_Practice
        網址 : http://192.168.201.104:8080(:3000)

        http://192.168.201.104:3000/file
        http://192.168.201.104:3000/db/write
        http://192.168.201.104:3000/db/read
        http://192.168.201.104:8080

        1. 安裝 Node.js與 npm
        2. (Web server) 建立 server.js，讓使用者可在瀏覽器上透過 Port 3000，連接至 server，並於頁面上顯示今天日期與時間。
        3. (檔案讀寫) 建立 fileread.js 並載入到 server.js，在/var/log/裡新增 node 資料夾，資料夾內新增 今天日期.log
        ，在每次訪問頁面時(網址為 IP:3000/file)，將request資訊寫入 log檔案，並於頁面上顯示目前 log檔案內的內容。
        4. (資料庫連接) 建立 database.js 並載入到 server.js，使每次訪問頁面時(網址為 IP:3000/db/write)，將"使用者 IP"、"User-Agent"、"現在日期時間"存入資料庫；
        5. (資料庫連接) 每次訪問頁面時(網址為 IP:3000/db/read)，將資料庫中的資料取出並顯示於頁面上。
        6. (Socket.io) 安裝 socket.io，讓 server.js 載入 socket.io 模組，Listen Port 8080，監聽事件(connect, disconnect, message)。
        7. (Socket.io) 頁面成功連接至 server.js 後，於頁面上顯示 "Connected to Server"文字及連接時間。(e.g. Connected to Server @ 2014-09-18 10:55:12)
        8. (Socket.io) 由頁面建立一按鈕，按下按鈕可發送message事件，傳送 timestamp 給 server.js，
        server.js 收到後建立 JSON物件(內容為 id, content 兩屬性, id 為收到的順序,
        content為收到的內容)透過message事件回傳給頁面，頁面上顯示自 server.js 收的內容
        9. (Socket.io) 當 server.js收到3次 message 事件後10秒，由 server.js將socket.io斷線，
        並於頁面上顯示 "Disconnected from Server"文字與斷線時間。(e.g. Disconnected from Server @ 2014-09-18 11:08:12)

        說明 :

        完成日期 : 2014/10/7



    ●Project Name ： UnitTest_BankAccount

        1. 請試著寫一隻銀行帳戶的類別 BankAccount
            方法：
                獲取銀行帳戶餘額
                設定銀行帳戶餘額
                存款
                提款
            限制：
                銀行帳戶的初始餘額必須為0。
                銀行帳戶的餘額不能為負數。
        2. 針對這個銀行帳戶的類別寫單元測試
        3. 請試著使用phpstorm列出測試涵蓋率

        說明 : Unit test 課堂作業

        完成日期 : 2014/10/13



    ●Project Name ： SQLitePerformanceTest
        請閱讀"羽量級開源記憶體中資料庫SQLite性能測試.wps"文件並按照文件內的步驟實做壓力測試，並寫出心得


//===================================================================================
Week 6 :
    ●Project Name ： Nodejs_NodeXmpp_Practice
        1. 安裝並使用node.js 與 node-xmpp 套件
        2. 已自己的Gmail 帳號登入google talk
        3. 傳測試訊息給mengiunlo@gmail.com
        (example message : abcdefghij1234567899 from XXX@gmail.com via node.js & node-xmpp)

        說明 : ※使用Node.js登入的GOOGLE帳號不要使用其他登入驗證(手機認證)，會造成登入驗證錯誤(XMPP Authentication failure)
               ※接、收方須互加入好友才能正常傳送訊息，若只以GMAIL視窗對話而沒有互加，執行Code仍會無法傳訊。

        完成日期 : 2014/10/15


----------->bonus
        請藉以掃描工具PHPCS與PHPMD了解自己的CodingStyle是否符合規範和程式碼複雜度，並將掃出的問題寫入文字檔內加上自己的註解與應如何修正後於下週作業一起上傳

        
//===================================================================================
Week 7:
    ●Project Name : DriveManager
        1. 下載並閱讀 https://github.com/KevinJay/node.js ，利用本framework 製作一個網路硬碟管理系統(請參考Google)與Wiki (請參考維基百科)。
        2. 下載並閱讀 https://github.com/google/google-api-nodejs-client ，利用本範例製作GoogleDoc檔案列表、上傳與下載、刪除的功能
        3. 將功能1與功能2結合在同一介面，讓使用者可選擇檔案上傳位置是Google Drive。

        說明 : 頁面數值更新稍慢  需稍後刷新才會彈出更新列表(等待更新未做)

        完成日期 : 2014/10/28


//===================================================================================
Week 8:
    ●ProjectName ： ScrumManagementSoftware
        本週工作如下，請於週四下班前完成並上傳GITLAB：
        1. 請試著閱讀以下兩個Project
            //https://github.com/zondor/ScrumPoker    //already wasted !!
            https://github.com/venil7/ScrumPoker
            https://github.com/ti-dev/Scrum-it
        1.1 依序安裝兩種Scrum 專案管理之OpenSource Project
        1.2 將安裝步驟與使用說明製作成40頁以上PPT，檔名ScrumMSIntro.ppt

        完成日期 : 2014/10/30


    ●ProjectName ： OOP1
        1. 請試著使用DAO模式存取學生成績系統的資料
        1.1 請至 Z:\研發A\0共用\OOP作業\course.sql取得檔案
        1.2 製作出3個DTO(student,class,score)
        1.3 Implement DAO Interface (student,class,score)
        1.4 Implement DAO(student,class,score)
        1.5 Implement DaoFactory Interface and MySQLDaoFactory Class
        1.6 Implement Controller to execute the $studentDao->getScorelist()
        (欄位：學生姓名、分數)

        完成日期 : 2014/10/31


//===================================================================================
Week 9:
    ●Projectname : Learning-Defensive-programming
        1.  請試著閱讀
        http://lab.asika.tw/programming/theories-and-concepts/40-strong-php-1-defensive-programming.html
        並將實作方法與心得製作出20頁以上之PPT，檔名：Learning-Defensive-programming.ppt

        說明：學習如何寫出強壯之PHP程式碼

        完成日期 : 2014/11/03
        

    ●Projectname：CSAutoValidation
        2. 請試著閱讀
        http://lab.asika.tw/programming/tools/37-phpstorm-ide-codesniffer.html
        2.1 將PHPStorm 設定為自動驗正程式碼
        2.2 將自動驗證程式碼之HINT訊息擷取成圖片後上傳PHPStorm_CS_Validation_Hint為命名之資料夾

       說明：學習如何將PHPStorm設定為自動驗正程式碼

       完成日期 : 2014/11/03


    ●Projectname：UnixSignalDeamon
        說明：學習如何製作PHP Deamon並熟悉UNIX Signal之運作
            請試著閱讀
        http://www.freebsd.org/doc/zh_TW/books/handbook/basics-daemons.html
        與
        http://lab.asika.tw/programming/php/32-php-daemon-unix-signal.html
        3.1 請依其步驟實做出一個PHP Deamon
        3.2 擷取各UNIX訊號之LOG(檔名：phpdeamon.log)與其程式碼一併上傳Gitlab 

        完成日期 : 2014/11/03


    ●ProjectName ： OOP2
        2. 請試著使用抽象工廠模式計算出學生的總成績
        2.1. 下載SQL壓縮檔案 學習成績SQL
        2.2 執行SQL檔案中的指令將資料存入資料庫
        2.3 撰寫抽象工廠模式的抽象Factory Class
        2.4 撰寫時做抽像工廠的Factory Class
        2.4.1 課程'c01'的加權指數為1，將分數*加權指數計算出各科的加權分數
        2.4.2 課程'c05'的加權指數為5，課程'c06'的加權指數為1
        2.4.3 其餘課程依此類推
        2.5 將所有的分數加總起來得到總分

        完成日期 : 2014/11/07


//===================================================================================
Week 10:
    ●Projectname : 多memcached 和 mysql 主從 環境下PHP開發
        1. 請依"多memcached 和 mysql 主從 環境下PHP開發.doc"文件之配置與程式撰寫將功能實現

        完成日期 : 2014/11/14


    ●Projectname : Mysql壓力測試

        2.  閱讀 "MySQL壓力測試工具 (mysqlslap).docx"文件 
     
        3. MYSQL主從服務器做壓力測試
            3.1 使用mysqlslap 從MYSQL讀出資料 10000筆
            3.2 使用mysqlslap 寫入MYSQL資料庫 1000筆

        4. 接續上面的mysqlslap，並使用jmeter啟動遠端服務做壓力測試
             4.1 配置三台服務器可執行mysqlslap的機器
             4.2 使用jmeter.sh做遠端全部啟動(共三台)
             4.3 同時啟動1000個執行緒做壓力測試
             4.4 同時啟動10000個執行緒做壓力測試
             4.5 同時啟動100000個執行緒做壓力測試

        5. 紀錄已上壓力測試的結果
             5.1 寫入與存取時間
             5.2 錯誤率、最高時間、最低時間
             5.3 比較各種數量間的效能
             5.4 壓力測試心得報告(500字左右)寫於TXT檔中
             5.5 請依實作寫出製作過程與心得(40頁PPT)

        完成日期 : 2014/11/13


    ●Projectname : Mysql性能優化
        6. 請參考Mysql 性能優化教程.doc
        6.1  依據此文件中提到的指令在MySQL中作練習
        6.2  請依實作寫出心得(10頁PPT)

        完成日期 : 2014/11/13


//===================================================================================
Week 11:
    ●ProjectName：DrupalPractice
        URL : http://192.168.201.104:8080/Aris/d7-2/

        1. 安裝drupal (CMS Server)，並使用此Server實做一個請假流程
        1.1. 角色：職員、主管、人資專員
        1.2. 流程：
            1.2.1 職員填寫假單並送出，送出後假單會流向主管以供批示
            1.2.2 主管可核可或駁回，並需要一個備註欄填寫核可或駁回的原因
            1.2.3 若主管將假單駁回，則假單將流回職員的inbox
            1.2.4 若主管將假單核可，則假單將流向人資專員以供通知並留底
            1.2.5 提供人資專員一個結案的按鈕，當結案前，請產出文字檔，欄位以"，"做區隔，一行文字代表一筆資料
               欄位為請假職員姓名，請假時間，假單時間，主管姓名，批示狀態，備註


        2. 請以過去寫好的系統找出能夠重構的部分，並將其補上單元測試的測試程式

        說明 : 

        完成日期 : 2014/11/20



//===================================================================================
Week 12:
    ●ProjectName：Node-Workflow
        URL : http://192.168.201.104:3000/

        1. 請觀看Video Node & Express as Workflow Tools
            https://www.youtube.com/watch?v=ISKA10JQOuo

        2. 下載並安裝下面兩個套件
            https://github.com/kusor/node-workflow
            https://github.com/kusor/node-workflow-example

        3. 使用此Server與套件實做一個請假流程
            3.1. 角色：職員、主管、人資專員
                3.2. 流程：
            3.2.1 職員填寫假單並送出，送出後假單會流向主管以供批示
            3.2.2 主管可核可或駁回，並需要一個備註欄填寫核可或駁回的原因
            3.2.3 若主管將假單駁回，則假單將流回職員的inbox
            3.2.4 若主管將假單核可，則假單將流向人資專員以供通知並留底
            3.2.5 提供人資專員一個結案的按鈕，當結案前，請產出文字檔，欄位已"，"做區隔，一行文字代表一筆資料
               欄位為請假職員姓名，請假時間，假單時間，主管姓名，批示狀態，備註

        說明 : 
                使用範例 :
                        http://192.168.201.104:3000/leave?name='Sunny'&date='141127'&plot='love'        //請假
                        http://192.168.201.104:3000/approve?leaderName='Jinny'&approve=true&comment='love'      //主管核可
                        http://192.168.201.104:3000/hrConfirm?name='Judy'       //人資確認
                        http://192.168.201.104:3000/caseClose           //結案

                web server預備動作 :
                        redis-cli flushall
                        /var/www/html/Aris/Workflow/example/node_modules/.bin$ nodejs workflow-runner config.json
                        /var/www/html/Aris/Workflow/example$ nodejs server.js

        完成日期 : 2014/11/27


//===================================================================================
Week 13:
    ●Projectname：Oauth2_QRCode_GMap_Practice
    1. 請安裝如下node.js的套件：
        1.1 https://github.com/jaredhanson/passport-google-oauth
        1.2 https://github.com/soldair/node-qrcode
        1.3 https://github.com/moshen/node-googlemaps
    2. 製作一產生User之 QRCode之HTML頁面，此頁面包含一個UserID輸入框，與"產生QRCode"的按鈕
    3. 待使用者於頁面按下"產生QRCode"的按鈕後，則執行node-qrcode產生QRCode圖片
    4. 將UserID(欄位一) 與 QRCode圖片之密文解碼(欄位二)存於資料庫，並顯示於頁面上供使用者存檔
    5. 製作一登入驗證(使用Google-Oauth或QRCode登入)之頁面
        1. QRCode驗證 :
            登入頁面：UserID輸入框、QRCode圖片上傳、驗證按鈕
            驗證功能：執行上傳之QRCode圖片之密文解碼與資料庫中的資料做搜尋，若搜尋得到資料且比對UserID相同則驗證成功
        2. Google-Oauth驗證：使用passport-google-oauth驗證使用者身分
    6. 驗證成功則導向"搜尋定位之頁面"(後續項目中將會實作)，驗證失敗則導向登入之首頁
    7. 製作一HTML包含一個輸入框可輸入門牌，與一個搜尋定位之按鈕
    8. 待使用者於業面輸入地址並按下搜尋定位之按鈕後，執行GoogleMapAPI得到定位結果後，於頁面上顯示GOOGLE地圖的定位
    9. 當使用者順時針點選特定的坐標，系統會框出特定的區塊
    10. 當使用者按下「確認」的按鈕，系統傳回該特定區塊的項點坐標。
        例如：[{"X": 306342.560,"Y": 2771226.221},{......},{......}]


    說明 : 
        使用範例 :
            http://192.168.201.104:3000/qrcode?code=SUNNY       //restify 產生(並註冊)QR CODE
            http://192.168.201.104:3000/login                   //QR CODE登入
            http://192.168.201.104:3000/oauthLogin              //oauth登入
            http://192.168.201.104:3000/gmap                    //GMAP   登入後自動導頁
                (confirm 按鈕在左上角)

    完成日期 : 2014/12/2


//===================================================================================
Final :
    ●ProjectName : 期末作業
        網址 : http://192.168.201.104:8080/Aris/MyHotel/index.php
        說明 : 施工中
        完成日期 : 尚未完成