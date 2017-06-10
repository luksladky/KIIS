<?php
// source: C:\LUKAS\web\kiis3\app/config/config.neon 
// source: C:\LUKAS\web\kiis3\app/config/config.local.neon 

class Container_3174ce90a2 extends Nette\DI\Container
{
	protected $meta = array(
		'types' => array(
			'Nette\Object' => array(
				array(
					'application.application',
					'application.linkGenerator',
					'database.default.connection',
					'database.default.structure',
					'database.default.context',
					'http.requestFactory',
					'http.request',
					'http.response',
					'http.context',
					'security.user',
					'session.session',
					'facebook.config',
					'facebook.session',
					'facebook.panel',
					'facebook.client',
					'authorizator',
					'32_App_Model_CronManager',
					'34_App_Model_PermissionRepository',
					'35_App_Model_ProfileRepository',
					'authenticator',
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'container',
				),
			),
			'Nette\Application\Application' => array(1 => array('application.application')),
			'Nette\Application\IPresenterFactory' => array(
				1 => array('application.presenterFactory'),
			),
			'Nette\Application\LinkGenerator' => array(1 => array('application.linkGenerator')),
			'Nette\Caching\Storages\IJournal' => array(1 => array('cache.journal')),
			'Nette\Caching\IStorage' => array(1 => array('cache.storage')),
			'Nette\Database\Connection' => array(
				1 => array('database.default.connection'),
			),
			'Nette\Database\IStructure' => array(
				1 => array('database.default.structure'),
			),
			'Nette\Database\Structure' => array(
				1 => array('database.default.structure'),
			),
			'Nette\Database\IConventions' => array(
				1 => array('database.default.conventions'),
			),
			'Nette\Database\Conventions\DiscoveredConventions' => array(
				1 => array('database.default.conventions'),
			),
			'Nette\Database\Context' => array(1 => array('database.default.context')),
			'Nette\Http\RequestFactory' => array(1 => array('http.requestFactory')),
			'Nette\Http\IRequest' => array(1 => array('http.request')),
			'Nette\Http\Request' => array(1 => array('http.request')),
			'Nette\Http\IResponse' => array(1 => array('http.response')),
			'Nette\Http\Response' => array(1 => array('http.response')),
			'Nette\Http\Context' => array(1 => array('http.context')),
			'Nette\Bridges\ApplicationLatte\ILatteFactory' => array(1 => array('latte.latteFactory')),
			'Nette\Application\UI\ITemplateFactory' => array(1 => array('latte.templateFactory')),
			'Latte\Object' => array(array('nette.latte')),
			'Latte\Engine' => array(array('nette.latte')),
			'Nette\Mail\IMailer' => array(1 => array('mail.mailer')),
			'Nette\Application\IRouter' => array(1 => array('routing.router')),
			'Nette\Security\IUserStorage' => array(1 => array('security.userStorage')),
			'Nette\Security\User' => array(1 => array('security.user')),
			'Nette\Http\Session' => array(1 => array('session.session')),
			'Tracy\ILogger' => array(1 => array('tracy.logger')),
			'Tracy\BlueScreen' => array(1 => array('tracy.blueScreen')),
			'Tracy\Bar' => array(1 => array('tracy.bar')),
			'WebChemistry\Images\AbstractStorage' => array(1 => array('images.storage')),
			'Kdyby\Facebook\Configuration' => array(1 => array('facebook.config')),
			'Kdyby\Facebook\SessionStorage' => array(1 => array('facebook.session')),
			'Kdyby\Facebook\ApiClient' => array(1 => array('facebook.apiClient')),
			'Tracy\IBarPanel' => array(1 => array('facebook.panel')),
			'Kdyby\Facebook\Diagnostics\Panel' => array(1 => array('facebook.panel')),
			'Kdyby\Facebook\Facebook' => array(1 => array('facebook.client')),
			'Nette\Security\IAuthorizator' => array(1 => array('authorizator')),
			'App\Model\Authorizator' => array(1 => array('authorizator')),
			'App\Model\Repository' => array(
				1 => array(
					'32_App_Model_CronManager',
					'34_App_Model_PermissionRepository',
					'35_App_Model_ProfileRepository',
				),
			),
			'App\Model\CronManager' => array(1 => array('32_App_Model_CronManager')),
			'App\Model\EventFacade' => array(1 => array('33_App_Model_EventFacade')),
			'App\Model\PermissionRepository' => array(
				1 => array('34_App_Model_PermissionRepository'),
			),
			'App\Model\ProfileRepository' => array(
				1 => array('35_App_Model_ProfileRepository'),
			),
			'App\Model\ThreadFacade' => array(1 => array('36_App_Model_ThreadFacade')),
			'Nette\Security\IAuthenticator' => array(1 => array('authenticator')),
			'App\Model\UserManager' => array(1 => array('authenticator')),
			'Texy\Texy' => array(1 => array('texy')),
			'App\Presenters\BasePresenter' => array(
				array(
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
				),
			),
			'Nette\Application\UI\Presenter' => array(
				array(
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
				),
			),
			'Nette\Application\UI\Control' => array(
				array(
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
				),
			),
			'Nette\Application\UI\PresenterComponent' => array(
				array(
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
				),
			),
			'Nette\ComponentModel\Container' => array(
				array(
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
				),
			),
			'Nette\ComponentModel\Component' => array(
				array(
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
				),
			),
			'Nette\Application\UI\IRenderable' => array(
				array(
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
				),
			),
			'Nette\ComponentModel\IContainer' => array(
				array(
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
				),
			),
			'Nette\ComponentModel\IComponent' => array(
				array(
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
				),
			),
			'Nette\Application\UI\ISignalReceiver' => array(
				array(
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
				),
			),
			'Nette\Application\UI\IStatePersistent' => array(
				array(
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
				),
			),
			'ArrayAccess' => array(
				array(
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
				),
			),
			'Nette\Application\IPresenter' => array(
				array(
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
				),
			),
			'App\Presenters\ApiPresenter' => array(array('application.1')),
			'App\Presenters\Error4xxPresenter' => array(array('application.3')),
			'App\Presenters\ErrorPresenter' => array(array('application.4')),
			'App\Presenters\BaseSecurePresenter' => array(
				array(
					'application.5',
					'application.6',
					'application.7',
					'application.9',
				),
			),
			'App\Presenters\EventPresenter' => array(array('application.5')),
			'App\Presenters\HomepagePresenter' => array(array('application.6')),
			'App\Presenters\ProfilePresenter' => array(array('application.7')),
			'App\Presenters\SignPresenter' => array(array('application.8')),
			'App\Presenters\ThreadPresenter' => array(array('application.9')),
			'NetteModule\ErrorPresenter' => array(array('application.10')),
			'NetteModule\MicroPresenter' => array(array('application.11')),
			'Nette\DI\Container' => array(1 => array('container')),
		),
		'services' => array(
			'32_App_Model_CronManager' => 'App\Model\CronManager',
			'33_App_Model_EventFacade' => 'App\Model\EventFacade',
			'34_App_Model_PermissionRepository' => 'App\Model\PermissionRepository',
			'35_App_Model_ProfileRepository' => 'App\Model\ProfileRepository',
			'36_App_Model_ThreadFacade' => 'App\Model\ThreadFacade',
			'application.1' => 'App\Presenters\ApiPresenter',
			'application.10' => 'NetteModule\ErrorPresenter',
			'application.11' => 'NetteModule\MicroPresenter',
			'application.2' => 'App\Presenters\BasePresenter',
			'application.3' => 'App\Presenters\Error4xxPresenter',
			'application.4' => 'App\Presenters\ErrorPresenter',
			'application.5' => 'App\Presenters\EventPresenter',
			'application.6' => 'App\Presenters\HomepagePresenter',
			'application.7' => 'App\Presenters\ProfilePresenter',
			'application.8' => 'App\Presenters\SignPresenter',
			'application.9' => 'App\Presenters\ThreadPresenter',
			'application.application' => 'Nette\Application\Application',
			'application.linkGenerator' => 'Nette\Application\LinkGenerator',
			'application.presenterFactory' => 'Nette\Application\IPresenterFactory',
			'authenticator' => 'App\Model\UserManager',
			'authorizator' => 'App\Model\Authorizator',
			'cache.journal' => 'Nette\Caching\Storages\IJournal',
			'cache.storage' => 'Nette\Caching\IStorage',
			'container' => 'Nette\DI\Container',
			'database.default.connection' => 'Nette\Database\Connection',
			'database.default.context' => 'Nette\Database\Context',
			'database.default.conventions' => 'Nette\Database\Conventions\DiscoveredConventions',
			'database.default.structure' => 'Nette\Database\Structure',
			'facebook.apiClient' => 'Kdyby\Facebook\ApiClient',
			'facebook.client' => 'Kdyby\Facebook\Facebook',
			'facebook.config' => 'Kdyby\Facebook\Configuration',
			'facebook.panel' => 'Kdyby\Facebook\Diagnostics\Panel',
			'facebook.session' => 'Kdyby\Facebook\SessionStorage',
			'http.context' => 'Nette\Http\Context',
			'http.request' => 'Nette\Http\Request',
			'http.requestFactory' => 'Nette\Http\RequestFactory',
			'http.response' => 'Nette\Http\Response',
			'images.storage' => 'WebChemistry\Images\AbstractStorage',
			'latte.latteFactory' => 'Latte\Engine',
			'latte.templateFactory' => 'Nette\Application\UI\ITemplateFactory',
			'mail.mailer' => 'Nette\Mail\IMailer',
			'nette.latte' => 'Latte\Engine',
			'routing.router' => 'Nette\Application\IRouter',
			'security.user' => 'Nette\Security\User',
			'security.userStorage' => 'Nette\Security\IUserStorage',
			'session.session' => 'Nette\Http\Session',
			'texy' => 'Texy\Texy',
			'tracy.bar' => 'Tracy\Bar',
			'tracy.blueScreen' => 'Tracy\BlueScreen',
			'tracy.logger' => 'Tracy\ILogger',
		),
		'tags' => array(
			'inject' => array(
				'application.1' => TRUE,
				'application.10' => TRUE,
				'application.11' => TRUE,
				'application.2' => TRUE,
				'application.3' => TRUE,
				'application.4' => TRUE,
				'application.5' => TRUE,
				'application.6' => TRUE,
				'application.7' => TRUE,
				'application.8' => TRUE,
				'application.9' => TRUE,
				'facebook.apiClient' => FALSE,
				'facebook.client' => FALSE,
				'facebook.config' => FALSE,
				'facebook.panel' => FALSE,
				'facebook.session' => FALSE,
			),
			'nette.presenter' => array(
				'application.1' => 'App\Presenters\ApiPresenter',
				'application.10' => 'NetteModule\ErrorPresenter',
				'application.11' => 'NetteModule\MicroPresenter',
				'application.2' => 'App\Presenters\BasePresenter',
				'application.3' => 'App\Presenters\Error4xxPresenter',
				'application.4' => 'App\Presenters\ErrorPresenter',
				'application.5' => 'App\Presenters\EventPresenter',
				'application.6' => 'App\Presenters\HomepagePresenter',
				'application.7' => 'App\Presenters\ProfilePresenter',
				'application.8' => 'App\Presenters\SignPresenter',
				'application.9' => 'App\Presenters\ThreadPresenter',
			),
		),
		'aliases' => array(
			'application' => 'application.application',
			'cacheStorage' => 'cache.storage',
			'database.default' => 'database.default.connection',
			'httpRequest' => 'http.request',
			'httpResponse' => 'http.response',
			'nette.cacheJournal' => 'cache.journal',
			'nette.database.default' => 'database.default',
			'nette.database.default.context' => 'database.default.context',
			'nette.httpContext' => 'http.context',
			'nette.httpRequestFactory' => 'http.requestFactory',
			'nette.latteFactory' => 'latte.latteFactory',
			'nette.mailer' => 'mail.mailer',
			'nette.presenterFactory' => 'application.presenterFactory',
			'nette.templateFactory' => 'latte.templateFactory',
			'nette.userStorage' => 'security.userStorage',
			'router' => 'routing.router',
			'session' => 'session.session',
			'user' => 'security.user',
		),
	);


	public function __construct()
	{
		parent::__construct(array(
			'appDir' => 'C:\LUKAS\web\kiis3\app',
			'wwwDir' => 'C:\LUKAS\web\kiis3\www',
			'debugMode' => TRUE,
			'productionMode' => FALSE,
			'environment' => 'development',
			'consoleMode' => FALSE,
			'container' => array('class' => NULL, 'parent' => NULL),
			'tempDir' => 'C:\LUKAS\web\kiis3\app/../temp',
		));
	}


	/**
	 * @return App\Model\CronManager
	 */
	public function createService__32_App_Model_CronManager()
	{
		$service = new App\Model\CronManager($this->getService('35_App_Model_ProfileRepository'), $this->getService('33_App_Model_EventFacade'),
			$this->getService('database.default.context'));
		return $service;
	}


	/**
	 * @return App\Model\EventFacade
	 */
	public function createService__33_App_Model_EventFacade()
	{
		$service = new App\Model\EventFacade($this->getService('database.default.context'));
		return $service;
	}


	/**
	 * @return App\Model\PermissionRepository
	 */
	public function createService__34_App_Model_PermissionRepository()
	{
		$service = new App\Model\PermissionRepository($this->getService('database.default.context'));
		return $service;
	}


	/**
	 * @return App\Model\ProfileRepository
	 */
	public function createService__35_App_Model_ProfileRepository()
	{
		$service = new App\Model\ProfileRepository($this->getService('database.default.context'));
		return $service;
	}


	/**
	 * @return App\Model\ThreadFacade
	 */
	public function createService__36_App_Model_ThreadFacade()
	{
		$service = new App\Model\ThreadFacade($this->getService('database.default.context'));
		return $service;
	}


	/**
	 * @return App\Presenters\ApiPresenter
	 */
	public function createServiceApplication__1()
	{
		$service = new App\Presenters\ApiPresenter;
		$service->injectPrimary($this, $this->getService('application.presenterFactory'), $this->getService('routing.router'),
			$this->getService('http.request'), $this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->imageStorage = $this->getService('images.storage');
		$service->cronManager = $this->getService('32_App_Model_CronManager');
		$service->permissionRepository = $this->getService('34_App_Model_PermissionRepository');
		$service->threadFacade = $this->getService('36_App_Model_ThreadFacade');
		$service->profileRepository = $this->getService('35_App_Model_ProfileRepository');
		$service->eventFacade = $this->getService('33_App_Model_EventFacade');
		$service->invalidLinkMode = 5;
		return $service;
	}


	/**
	 * @return NetteModule\ErrorPresenter
	 */
	public function createServiceApplication__10()
	{
		$service = new NetteModule\ErrorPresenter($this->getService('tracy.logger'));
		return $service;
	}


	/**
	 * @return NetteModule\MicroPresenter
	 */
	public function createServiceApplication__11()
	{
		$service = new NetteModule\MicroPresenter($this, $this->getService('http.request'), $this->getService('routing.router'));
		return $service;
	}


	/**
	 * @return App\Presenters\BasePresenter
	 */
	public function createServiceApplication__2()
	{
		$service = new App\Presenters\BasePresenter;
		$service->injectPrimary($this, $this->getService('application.presenterFactory'), $this->getService('routing.router'),
			$this->getService('http.request'), $this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->imageStorage = $this->getService('images.storage');
		$service->invalidLinkMode = 5;
		return $service;
	}


	/**
	 * @return App\Presenters\Error4xxPresenter
	 */
	public function createServiceApplication__3()
	{
		$service = new App\Presenters\Error4xxPresenter;
		$service->injectPrimary($this, $this->getService('application.presenterFactory'), $this->getService('routing.router'),
			$this->getService('http.request'), $this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->imageStorage = $this->getService('images.storage');
		$service->invalidLinkMode = 5;
		return $service;
	}


	/**
	 * @return App\Presenters\ErrorPresenter
	 */
	public function createServiceApplication__4()
	{
		$service = new App\Presenters\ErrorPresenter($this->getService('tracy.logger'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'), $this->getService('routing.router'),
			$this->getService('http.request'), $this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->imageStorage = $this->getService('images.storage');
		$service->invalidLinkMode = 5;
		return $service;
	}


	/**
	 * @return App\Presenters\EventPresenter
	 */
	public function createServiceApplication__5()
	{
		$service = new App\Presenters\EventPresenter;
		$service->injectPrimary($this, $this->getService('application.presenterFactory'), $this->getService('routing.router'),
			$this->getService('http.request'), $this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->imageStorage = $this->getService('images.storage');
		$service->cronManager = $this->getService('32_App_Model_CronManager');
		$service->profileRepository = $this->getService('35_App_Model_ProfileRepository');
		$service->texy = $this->getService('texy');
		$service->database = $this->getService('database.default.context');
		$service->threadFacade = $this->getService('36_App_Model_ThreadFacade');
		$service->eventFacade = $this->getService('33_App_Model_EventFacade');
		$service->invalidLinkMode = 5;
		return $service;
	}


	/**
	 * @return App\Presenters\HomepagePresenter
	 */
	public function createServiceApplication__6()
	{
		$service = new App\Presenters\HomepagePresenter($this->getService('database.default.context'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'), $this->getService('routing.router'),
			$this->getService('http.request'), $this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->imageStorage = $this->getService('images.storage');
		$service->cronManager = $this->getService('32_App_Model_CronManager');
		$service->threadFacade = $this->getService('36_App_Model_ThreadFacade');
		$service->eventFacade = $this->getService('33_App_Model_EventFacade');
		$service->profileRepository = $this->getService('35_App_Model_ProfileRepository');
		$service->texy = $this->getService('texy');
		$service->invalidLinkMode = 5;
		return $service;
	}


	/**
	 * @return App\Presenters\ProfilePresenter
	 */
	public function createServiceApplication__7()
	{
		$service = new App\Presenters\ProfilePresenter;
		$service->injectPrimary($this, $this->getService('application.presenterFactory'), $this->getService('routing.router'),
			$this->getService('http.request'), $this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->imageStorage = $this->getService('images.storage');
		$service->cronManager = $this->getService('32_App_Model_CronManager');
		$service->threadFacade = $this->getService('36_App_Model_ThreadFacade');
		$service->permissionRepository = $this->getService('34_App_Model_PermissionRepository');
		$service->userManager = $this->getService('authenticator');
		$service->eventFacade = $this->getService('33_App_Model_EventFacade');
		$service->profileRepository = $this->getService('35_App_Model_ProfileRepository');
		$service->invalidLinkMode = 5;
		return $service;
	}


	/**
	 * @return App\Presenters\SignPresenter
	 */
	public function createServiceApplication__8()
	{
		$service = new App\Presenters\SignPresenter;
		$service->injectPrimary($this, $this->getService('application.presenterFactory'), $this->getService('routing.router'),
			$this->getService('http.request'), $this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->imageStorage = $this->getService('images.storage');
		$service->userManager = $this->getService('authenticator');
		$service->invalidLinkMode = 5;
		return $service;
	}


	/**
	 * @return App\Presenters\ThreadPresenter
	 */
	public function createServiceApplication__9()
	{
		$service = new App\Presenters\ThreadPresenter;
		$service->injectPrimary($this, $this->getService('application.presenterFactory'), $this->getService('routing.router'),
			$this->getService('http.request'), $this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->imageStorage = $this->getService('images.storage');
		$service->cronManager = $this->getService('32_App_Model_CronManager');
		$service->eventFacade = $this->getService('33_App_Model_EventFacade');
		$service->profileRepository = $this->getService('35_App_Model_ProfileRepository');
		$service->texy = $this->getService('texy');
		$service->threadFacade = $this->getService('36_App_Model_ThreadFacade');
		$service->invalidLinkMode = 5;
		return $service;
	}


	/**
	 * @return Nette\Application\Application
	 */
	public function createServiceApplication__application()
	{
		$service = new Nette\Application\Application($this->getService('application.presenterFactory'), $this->getService('routing.router'),
			$this->getService('http.request'), $this->getService('http.response'));
		$service->catchExceptions = FALSE;
		$service->errorPresenter = 'Error';
		Nette\Bridges\ApplicationTracy\RoutingPanel::initializePanel($service);
		$this->getService('tracy.bar')->addPanel(new Nette\Bridges\ApplicationTracy\RoutingPanel($this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('application.presenterFactory')));
		return $service;
	}


	/**
	 * @return Nette\Application\LinkGenerator
	 */
	public function createServiceApplication__linkGenerator()
	{
		$service = new Nette\Application\LinkGenerator($this->getService('routing.router'), $this->getService('http.request')->getUrl(),
			$this->getService('application.presenterFactory'));
		return $service;
	}


	/**
	 * @return Nette\Application\IPresenterFactory
	 */
	public function createServiceApplication__presenterFactory()
	{
		$service = new Nette\Application\PresenterFactory(new Nette\Bridges\ApplicationDI\PresenterFactoryCallback($this, 5, 'C:\LUKAS\web\kiis3\app/../temp/cache/Nette%5CBridges%5CApplicationDI%5CApplicationExtension'));
		$service->setMapping(array(
			'*' => 'App\*Module\Presenters\*Presenter',
		));
		return $service;
	}


	/**
	 * @return App\Model\UserManager
	 */
	public function createServiceAuthenticator()
	{
		$service = new App\Model\UserManager($this->getService('database.default.context'), $this->getService('35_App_Model_ProfileRepository'));
		return $service;
	}


	/**
	 * @return App\Model\Authorizator
	 */
	public function createServiceAuthorizator()
	{
		$service = new App\Model\Authorizator;
		return $service;
	}


	/**
	 * @return Nette\Caching\Storages\IJournal
	 */
	public function createServiceCache__journal()
	{
		$service = new Nette\Caching\Storages\FileJournal('C:\LUKAS\web\kiis3\app/../temp');
		return $service;
	}


	/**
	 * @return Nette\Caching\IStorage
	 */
	public function createServiceCache__storage()
	{
		$service = new Nette\Caching\Storages\FileStorage('C:\LUKAS\web\kiis3\app/../temp/cache', $this->getService('cache.journal'));
		return $service;
	}


	/**
	 * @return Nette\DI\Container
	 */
	public function createServiceContainer()
	{
		return $this;
	}


	/**
	 * @return Nette\Database\Connection
	 */
	public function createServiceDatabase__default__connection()
	{
		$service = new Nette\Database\Connection('mysql:host=127.0.0.1;dbname=kiis', 'root', NULL, array('lazy' => TRUE));
		$this->getService('tracy.blueScreen')->addPanel('Nette\Bridges\DatabaseTracy\ConnectionPanel::renderException');
		Nette\Database\Helpers::createDebugPanel($service, TRUE, 'default');
		return $service;
	}


	/**
	 * @return Nette\Database\Context
	 */
	public function createServiceDatabase__default__context()
	{
		$service = new Nette\Database\Context($this->getService('database.default.connection'), $this->getService('database.default.structure'),
			$this->getService('database.default.conventions'), $this->getService('cache.storage'));
		return $service;
	}


	/**
	 * @return Nette\Database\Conventions\DiscoveredConventions
	 */
	public function createServiceDatabase__default__conventions()
	{
		$service = new Nette\Database\Conventions\DiscoveredConventions($this->getService('database.default.structure'));
		return $service;
	}


	/**
	 * @return Nette\Database\Structure
	 */
	public function createServiceDatabase__default__structure()
	{
		$service = new Nette\Database\Structure($this->getService('database.default.connection'), $this->getService('cache.storage'));
		return $service;
	}


	/**
	 * @return Kdyby\Facebook\ApiClient
	 */
	public function createServiceFacebook__apiClient()
	{
		$service = new Kdyby\Facebook\Api\CurlClient;
		$service->curlOptions = array(
			78 => 10,
			13 => 60,
			10023 => array('User-Agent: kdyby-facebook-1.1'),
			2 => TRUE,
			42 => TRUE,
			19913 => TRUE,
		);;
		$this->getService('facebook.panel')->register($service);
		return $service;
	}


	/**
	 * @return Kdyby\Facebook\Facebook
	 */
	public function createServiceFacebook__client()
	{
		$service = new Kdyby\Facebook\Facebook($this->getService('facebook.config'), $this->getService('facebook.session'),
			$this->getService('facebook.apiClient'), $this->getService('http.request'), $this->getService('http.response'));
		return $service;
	}


	/**
	 * @return Kdyby\Facebook\Configuration
	 */
	public function createServiceFacebook__config()
	{
		$service = new Kdyby\Facebook\Configuration('1567829150181860', '39afdc620204f9f05396be3a3e314545');
		$service->verifyApiCalls = TRUE;
		$service->fileUploadSupport = FALSE;
		$service->trustForwarded = FALSE;
		$service->permissions = array('public_profile', 'email');
		$service->canvasBaseUrl = NULL;
		$service->graphVersion = 'v2.3';
		return $service;
	}


	/**
	 * @return Kdyby\Facebook\Diagnostics\Panel
	 */
	public function createServiceFacebook__panel()
	{
		$service = new Kdyby\Facebook\Diagnostics\Panel;
		return $service;
	}


	/**
	 * @return Kdyby\Facebook\SessionStorage
	 */
	public function createServiceFacebook__session()
	{
		$service = new Kdyby\Facebook\SessionStorage($this->getService('session.session'), $this->getService('facebook.config'));
		return $service;
	}


	/**
	 * @return Nette\Http\Context
	 */
	public function createServiceHttp__context()
	{
		$service = new Nette\Http\Context($this->getService('http.request'), $this->getService('http.response'));
		return $service;
	}


	/**
	 * @return Nette\Http\Request
	 */
	public function createServiceHttp__request()
	{
		$service = $this->getService('http.requestFactory')->createHttpRequest();
		if (!$service instanceof Nette\Http\Request) {
			throw new Nette\UnexpectedValueException('Unable to create service \'http.request\', value returned by factory is not Nette\Http\Request type.');
		}
		return $service;
	}


	/**
	 * @return Nette\Http\RequestFactory
	 */
	public function createServiceHttp__requestFactory()
	{
		$service = new Nette\Http\RequestFactory;
		$service->setProxy(array());
		return $service;
	}


	/**
	 * @return Nette\Http\Response
	 */
	public function createServiceHttp__response()
	{
		$service = new Nette\Http\Response;
		return $service;
	}


	/**
	 * @return WebChemistry\Images\AbstractStorage
	 */
	public function createServiceImages__storage()
	{
		$service = new WebChemistry\Images\FileStorage\FileStorage('default/default.png', array(
			'defaultImage' => 'default/default.png',
			'registration' => array(
				'upload' => TRUE,
				'multiUpload' => FALSE,
				'presenter' => TRUE,
			),
			'assetsDir' => 'assets',
			'wwwDir' => 'C:\LUKAS\web\kiis3\www',
			'helpers' => array(
				'crop' => 'WebChemistry\Images\Helpers\Crop',
				'sharpen' => 'WebChemistry\Images\Helpers\Sharpen',
			),
			'checkbox' => array('caption' => NULL),
			'quality' => 85,
		), $this->getService('http.request'));
		return $service;
	}


	/**
	 * @return Nette\Bridges\ApplicationLatte\ILatteFactory
	 */
	public function createServiceLatte__latteFactory()
	{
		return new Container_3174ce90a2_Nette_Bridges_ApplicationLatte_ILatteFactoryImpl_latte_latteFactory($this);
	}


	/**
	 * @return Nette\Application\UI\ITemplateFactory
	 */
	public function createServiceLatte__templateFactory()
	{
		$service = new Nette\Bridges\ApplicationLatte\TemplateFactory($this->getService('latte.latteFactory'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('security.user'), $this->getService('cache.storage'));
		return $service;
	}


	/**
	 * @return Nette\Mail\IMailer
	 */
	public function createServiceMail__mailer()
	{
		$service = new Nette\Mail\SendmailMailer;
		return $service;
	}


	/**
	 * @return Latte\Engine
	 */
	public function createServiceNette__latte()
	{
		$service = new Latte\Engine;
		trigger_error('Service nette.latte is deprecated, implement Nette\Bridges\ApplicationLatte\ILatteFactory.',
			16384);
		$service->setTempDirectory('C:\LUKAS\web\kiis3\app/../temp/cache/latte');
		$service->setAutoRefresh(TRUE);
		$service->setContentType('html');
		Nette\Utils\Html::$xhtml = FALSE;
		return $service;
	}


	/**
	 * @return Nette\Application\IRouter
	 */
	public function createServiceRouting__router()
	{
		$service = App\RouterFactory::createRouter();
		if (!$service instanceof Nette\Application\IRouter) {
			throw new Nette\UnexpectedValueException('Unable to create service \'routing.router\', value returned by factory is not Nette\Application\IRouter type.');
		}
		return $service;
	}


	/**
	 * @return Nette\Security\User
	 */
	public function createServiceSecurity__user()
	{
		$service = new Nette\Security\User($this->getService('security.userStorage'), $this->getService('authenticator'),
			$this->getService('authorizator'));
		$this->getService('tracy.bar')->addPanel(new Nette\Bridges\SecurityTracy\UserPanel($service));
		$sl = $this; $service->onLoggedOut[] = function () use ($sl) { $sl->getService('facebook.session')->clearAll(); };
		return $service;
	}


	/**
	 * @return Nette\Security\IUserStorage
	 */
	public function createServiceSecurity__userStorage()
	{
		$service = new Nette\Http\UserStorage($this->getService('session.session'));
		return $service;
	}


	/**
	 * @return Nette\Http\Session
	 */
	public function createServiceSession__session()
	{
		$service = new Nette\Http\Session($this->getService('http.request'), $this->getService('http.response'));
		$service->setExpiration('14 days');
		$service->setOptions(array(
			'save_path' => 'C:\LUKAS\web\kiis3\app/../temp/session',
		));
		return $service;
	}


	/**
	 * @return Texy\Texy
	 */
	public function createServiceTexy()
	{
		$service = new Texy\Texy;
		return $service;
	}


	/**
	 * @return Tracy\Bar
	 */
	public function createServiceTracy__bar()
	{
		$service = Tracy\Debugger::getBar();
		if (!$service instanceof Tracy\Bar) {
			throw new Nette\UnexpectedValueException('Unable to create service \'tracy.bar\', value returned by factory is not Tracy\Bar type.');
		}
		return $service;
	}


	/**
	 * @return Tracy\BlueScreen
	 */
	public function createServiceTracy__blueScreen()
	{
		$service = Tracy\Debugger::getBlueScreen();
		if (!$service instanceof Tracy\BlueScreen) {
			throw new Nette\UnexpectedValueException('Unable to create service \'tracy.blueScreen\', value returned by factory is not Tracy\BlueScreen type.');
		}
		return $service;
	}


	/**
	 * @return Tracy\ILogger
	 */
	public function createServiceTracy__logger()
	{
		$service = Tracy\Debugger::getLogger();
		if (!$service instanceof Tracy\ILogger) {
			throw new Nette\UnexpectedValueException('Unable to create service \'tracy.logger\', value returned by factory is not Tracy\ILogger type.');
		}
		return $service;
	}


	public function initialize()
	{
		date_default_timezone_set('Europe/Prague');
		header('X-Frame-Options: SAMEORIGIN');
		header('X-Powered-By: Nette Framework');
		header('Content-Type: text/html; charset=utf-8');
		Nette\Reflection\AnnotationsParser::setCacheStorage($this->getByType("Nette\Caching\IStorage"));
		Nette\Reflection\AnnotationsParser::$autoRefresh = TRUE;
		$this->getService('session.session')->exists() && $this->getService('session.session')->start();
		WebChemistry\Images\Controls\Upload::register();
	}

}



final class Container_3174ce90a2_Nette_Bridges_ApplicationLatte_ILatteFactoryImpl_latte_latteFactory implements Nette\Bridges\ApplicationLatte\ILatteFactory
{
	private $container;


	public function __construct(Container_3174ce90a2 $container)
	{
		$this->container = $container;
	}


	public function create()
	{
		$service = new Latte\Engine;
		$service->setTempDirectory('C:\LUKAS\web\kiis3\app/../temp/cache/latte');
		$service->setAutoRefresh(TRUE);
		$service->setContentType('html');
		Nette\Utils\Html::$xhtml = FALSE;
		WebChemistry\Images\Template\Macros::install($service->getCompiler());
		return $service;
	}

}
