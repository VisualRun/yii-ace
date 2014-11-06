<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'任务系统',
	'defaultController'=>'site',
	'timezone'=>'Asia/Shanghai',
	'language'=>'zh_cn',
	'sourceLanguage'=>'en_us',
	'theme'=>'classic',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.*',
		'application.actions.*',
		'application.widgets.*',
		'application.vendors.phpexcel.PHPExcel',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'111111',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),

	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			// 'loginUrl' => array('site/login'),
			// 'returnUrl' => array('/home/index'),
		),

		// uncomment the following to enable URLs in path-format

		//'urlManager'=>array(
		//	'urlFormat'=>'path',
		//	'showScriptName'=>false,
		//	'urlSuffix'=>'.html',
		//	'rules'=>array(
		//		'<controller:\w+>/<id:\d+>'=>'<controller>/view',
		//		'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		//		'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
		//	),
		//),


		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
				/******需要调试sql打开以下2数组******/
                // array(
                //     'class' => 'CWebLogRoute',
                //     'levels' => 'profile,trace',
                // ),
                // array(
                //     'class' => 'CProfileLogRoute',
                //     'levels' => 'profile',
                // ),
                /**********************************/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => require(dirname(__FILE__).'/params.php'),
);
