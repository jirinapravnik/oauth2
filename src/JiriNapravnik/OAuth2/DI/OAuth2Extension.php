<?php

/**
 * OAuth2Extension
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2014, Jiří Nápravník
 */

namespace JiriNapravnik\OAuth2\DI;

class OAuth2Extension extends \Nette\DI\CompilerExtension
{

	protected $defaults = [
		'allowCredentialsInRequestBody' => TRUE,
		'database' => [
			'adapter' => 'mysql',
			'host' => NULL,
			'dbname' => NULL,
			'username' => NULL,
			'password' =>NULL,
		]
	];
	
	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('authentication'))
			->setClass('JiriNapravnik\OAuth2\OAuth2Authentication');
		
		$databaseConfig = $config['database'];
		$builder->addDefinition($this->prefix('server'))
			->setClass('JiriNapravnik\OAuth2\OAuth2Server')
			->addSetup('setAdapter', [$databaseConfig['adapter']])
			->addSetup('setHost', [$databaseConfig['host']])
			->addSetup('setDbname', [$databaseConfig['dbname']])
			->addSetup('setUsername', [$databaseConfig['username']])
			->addSetup('setPassword', [$databaseConfig['password']])
			->addSetup('setAllowCredentialsInRequestBody', [$config['allowCredentialsInRequestBody']]);
	}

}
