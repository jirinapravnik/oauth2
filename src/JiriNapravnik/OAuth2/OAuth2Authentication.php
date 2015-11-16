<?php

namespace JiriNapravnik\OAuth2;

use Drahak\Restful\Http\IInput;
use Drahak\Restful\Security\AuthenticationException;
use Drahak\Restful\Security\Process\AuthenticationProcess;
use OAuth2\Request;

/**
 * OAuth2Authentication
 * @package Drahak\Restful\Security\Process
 * @author Drahomír Hanák
 */
class OAuth2Authentication extends AuthenticationProcess
{
	
	private $oAuthServer;
	private $request;

	public function __construct(OAuth2Server $oAuthServer)
	{
		$this->oAuthServer = $oAuthServer->getServer();
	}

	private function getRequest(){
		if($this->request === NULL){
			$this->request = Request::createFromGlobals();
		}
		return $this->request;
	}
	
	/**
	 * Authenticate request data
	 * @param IInput $input
	 * @return void
	 *
	 * @throws AuthenticationException
	 */
	protected function authRequestData(IInput $input)
	{
		$request = $this->getRequest();
		$headers = $request->headers('Authorization');
		
		$bearerName = $this->oAuthServer->getConfig('token_bearer_header_name');
		
		if(count($headers) === 0 || preg_match('/' . $bearerName . '\s(\S+)/i', $headers, $matches) === 0){
			throw new AuthenticationException('Invalid authorization header');
		}
	}

	/**
	 * Authenticate request timeout
	 * @param IInput $input
	 * @return bool|void
	 *
	 * @throws AuthenticationException
	 */
	protected function authRequestTimeout(IInput $input)
	{
		if($this->oAuthServer->verifyResourceRequest($this->getRequest()) === TRUE){
			return TRUE;
		}
		throw new AuthenticationException('Invalid or expired token');
	}


}