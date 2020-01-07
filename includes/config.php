<?php
//standard login details to datbase
$config['db_user'] = 'sbau01';
$config['db_pass'] = 'bbkmysql';
$config['db_host'] = 'mysqlsrv.dcs.bbk.ac.uk';
$config['db_name'] = 'sbau01dbm';
 
//congig folder for images, both set up with 777 permission
$config['folder'] = 'original/';
$config['thumbs'] = 'thumbnails/';

//configurate an absolute path for the file to be stored
$config['app_dir'] = dirname(dirname(__FILE__));
$config['upload_dir'] = $config['app_dir'] . '/original/';
	
?>