<html>
    <head>
        <title>Fibuncii using Redis</title>
    </head>

    <body>
    
        <?php
            
            print "RedisTest<br>";
            
            $_redis = new Redis(); //redis
            $_result = $_redis->connect('127.0.0.1', 6379);
            
            //using redis as cache
            function FibunciiRedis($_scale)
            {
                global $_redis;
                $_value = $_scale;
                $_index = 'F(' . $_scale . ')';
            
                if ($_redis->exists($_index)) { //check in cache
                    $_value = $_redis->get($_index); //if there's value , calculation is no required
                    return $_value;
                }
            
                $_value = ($_scale > 1) ? (FibunciiRedis($_scale - 1) + FibunciiRedis($_scale - 2)) : 1;
                $_redis->set($_index, $_value);
            
                return $_value;
            }
            
            $_startTime = time(); //紀錄起始時間
            print "Time started at : " . $_startTime . "<br>";
            $_maxScale = 1000;
            
            for ($_i = 0; $_i <= $_maxScale; $_i++) {
                //print Fibuncii($_i)."<br>";
                $_index = 'F(' . $_i . ')';
            
                $_result = FibunciiRedis($_i);
            
                print $_index . ' = ' . $_result;
                print "<br>";
            }
            
            $_finishTime = time(); //紀錄完成時間
            
            //var_dump($_result);
            $_duration = $_finishTime - $_startTime; //總結
            
            print "Time finished at : " . $_finishTime . "<br>";
            print "Time elapse : " . $_duration . "<br>";
        
        ?>
    
    </body>
</html>

