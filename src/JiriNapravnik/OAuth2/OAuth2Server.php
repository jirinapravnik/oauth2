<?php

namespace JiriNapravnik\OAuth2;

use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\ClientCredentials;
use OAuth2\Server;
use OAuth2\Storage\Pdo;

/**
 * OAuth2Authentication
 * @package Drahak\Restful\Security\Process
 * @author Drahomír Hanák
 */
class OAuth2Server
{

	private $server;

	private $adapter;
	private $host;
	private $dbname;
	private $username;
	private $password;
	private $allowCredentialsInRequestBody;

	public function setAdapter($adapter){
		$this->adapter = $adapter;
	}

	public function setDbname($dbname){
		$this->dbname = $dbname;
	}

	public function setHost($host){
		$this->host = $host;
	}

	public function setUsername($username){
		$this->username = $username;
	}

	public function setPassword($password){
		$this->password = $password;
	}

	public function setAllowCredentialsInRequestBody($allowCredentialsInRequestBody){
		$this->allowCredentialsInRequestBody = $allowCredentialsInRequestBody;
	}

	public function getServer()
	{
		if($this->server !== NULL){
			return $this->server;
		}

		// $dsn is the Data Source Name for your database, for exmaple "mysql:dbname=my_oauth2_db;host=localhost"
		$dsn = $this->adapter . ':dbname=' . $this->dbname . ';host=' . $this->host;
		$storage = new Pdo(array('dsn' => $dsn, 'username' => $this->username, 'password' => $this->password));

		// Pass a storage object or array of storage objects to the OAuth2 server class
		$server = new Server($storage);

		// Add the "Client Credentials" grant type (it is the simplest of the grant types)
		$server->addGrantType(new ClientCredentials($storage, [
			'allow_credentials_in_request_body' => $this->allowCredentialsInRequestBody,
		]));

		$this->server = $server;

		return $server;
	}

}
