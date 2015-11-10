<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=localhost;dbname=eyoungdb_151109',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => 'root',
	'charset' => 'utf8',
	'tablePrefix' => 'tbl_',    //设置数据表的前缀
	'enableParamLogging' => true,   //设置sql语句绑定的参数信息
);