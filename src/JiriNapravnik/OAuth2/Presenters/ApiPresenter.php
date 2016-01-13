<?php

namespace JiriNapravnik\OAuth2\Presenters;

use JiriNapravnik\OAuth2\OAuth2Server;
use Nette\Application\UI\Presenter;
use OAuth2\Request;

/**
 * TokenPresenter
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2014, Jiří Nápravník
 */

class ApiPresenter extends Presenter
{
	private $oauthServer;

	public function __construct(OAuth2Server $oauthServer){
		parent::__construct();
		$this->oauthServer = $oauthServer;
	}

	public function actionToken(){
		$this->oauthServer->getServer()->handleTokenRequest(Request::createFromGlobals())->send();
		$this->terminate();
	}
}
