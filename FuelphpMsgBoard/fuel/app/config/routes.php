<?php
return array(
	//'_root_'  => 'welcome/index',  // The default route
	'_root_'  => 'msgboard/getarticles',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route

   // 'to'    => 'msgboard/to' ,//public/index.php/to
    'newmsg'    => 'msgboard/newmsg' ,//public/index.php/to
    //'public/123' => 'msgboard/to',

	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);