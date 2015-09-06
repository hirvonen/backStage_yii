<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=localhost;dbname=eyoungdb_150905',
//	'connectionString' => 'mysql:host=121.41.104.220;dbname=eyoungdb',
//	'connectionString' => 'mysql:host=10.168.241.67;dbname=eyoungdb',
//	'connectionString' => 'mysql:host=rds0gna5y7u92a0uk0wa4.mysql.rds.aliyuncs.com;dbname=eyoungdb',
	'emulatePrepare' => true,
//	'username' => 'eyoungadmin',
//	'password' => 'Cccc1111',
	'username' => 'root',
	'password' => 'root',
	'charset' => 'utf8',
	'tablePrefix' => 'tbl_',    //设置数据表的前缀
	'enableParamLogging' => true,   //设置sql语句绑定的参数信息
);