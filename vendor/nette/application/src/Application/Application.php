<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

namespace Nette\Application;

use Nette;


/**
 * Front Controller.
 */
class Application extends Nette\Object
{
	/** @var int */
	public static $maxLoop = 20;

	/** @var bool enable fault barrier? */
	public $catchExceptions;

	/** @var string */
	public $errorPresenter;

	/** @var callable[]  function (Application $sender); Occurs before the application loads presenter */
	public $onStartup;

	/** @var callable[]  function (Application $sender, \Exception $e = NULL); Occurs before the application shuts down */
	public $onShutdown;

	/** @var callable[]  function (Application $sender, Request $request); Occurs when a new request is received */
	public $onRequest;

	/** @var callable[]  function (Application $sender, Presenter $presenter); Occurs when a presenter is created */
	public $onPresenter;

	/** @var callable[]  function (Application $sender, IResponse $response); Occurs when a new response is ready for dispatch */
	public $onResponse;

	/** @var callable[]  function (Application $sender, \Exception $e); Occurs when an unhandled exception occurs in the application */
	public $onError;

	/** @var Request[] */
	private $requests = array();

	/** @var IPresenter */
	private $presenter;

	/** @var Nette\Http\IRequest */
	private $httpRequest;

	/** @var Nette\Http\IResponse */
	private $httpResponse;

	/** @var IPresenterFactory */
	private $presenterFactory;

	/** @var IRouter */
	private $router;


	public function __construct(IPresenterFactory $presenterFactory, IRouter $router, Nette\Http\IRequest $httpRequest, Nette\Http\IResponse $httpResponse)
	{
		$this->httpRequest = $httpRequest;
		$this->httpResponse = $httpResponse;
		$this->presenterFactory = $presenterFactory;
		$this->router = $router;
	}


	/**
	 * Dispatch a HTTP request to a front controller.
	 * @return void
	 */
	public function run()
	{
		try {
			$this->onStartup($this);
			$this->processRequest($this->createInitialRequest());
			$this->onShutdown($this);

		} catch (\Exception $e) {
			$this->onError($this, $e);
			if ($this->catchExceptions && $this->errorPresenter) {
				try {
					$this->processException($e);
					$this->onShutdown($this, $e);
					return;

				} catch (\Exception $e) {
					$this->onError($this, $e);
				}
			}
			$this->onShutdown($this, $e);
			throw $e;
		}
	}


	/**
	 * @return Request
	 */
	public function createInitialRequest()
	{
		$request = $this->router->match($this->httpRequest);

		if (!$request instanceof Request) {
			throw new BadRequestException('No route for HTTP request.');
		}
		$name = $request->getPresenterName();
		if (strcasecmp($name, $this->errorPresenter) === 0
			|| (Nette\Utils\Strings::startsWith($name, 'Nette:') && $name !== 'Nette:Micro')
		) {
			throw new BadRequestException('Invalid request. Presenter is not achievable.');
		}

		try {
			$this->presenterFactory->getPresenterClass($name);
		} catch (InvalidPresenterException $e) {
			throw new BadRequestException($e->getMessage(), 0, $e);
		}

		return $request;
	}


	/**
	 * @return void
	 */
	public function processRequest(Request $request)
	{
		if (count($this->requests) > self::$maxLoop) {
			throw new ApplicationException('Too many loops detected in application life cycle.');
		}

		$this->requests[] = $request;
		$this->onRequest($this, $request);

		$this->presenter = $this->presenterFactory->createPresenter($request->getPresenterName());
		$this->onPresenter($this, $this->presenter);
		$response = $this->presenter->run($request);

		if ($response instanceof Responses\ForwardResponse) {
			$this->processRequest($response->getRequest());

		} elseif ($response) {
			$this->onResponse($this, $response);
			$response->send($this->httpRequest, $this->httpResponse);
		}
	}


	/**
	 * @return void
	 */
	public function processException(\Exception $e)
	{
		if (!$e instanceof BadRequestException && $this->httpResponse instanceof Nette\Http\Response) {
			$this->httpResponse->warnOnBuffer = FALSE;
		}
		if (!$this->httpResponse->isSent()) {
			$this->httpResponse->setCode($e instanceof BadRequestException ? ($e->getCode() ?: 404) : 500);
		}

		$args = array('exception' => $e, 'request' => end($this->requests) ?: NULL);
		if ($this->presenter instanceof UI\Presenter) {
			try {
				$this->presenter->forward(":$this->errorPresenter:", $args);
			} catch (AbortException $foo) {
				$this->processRequest($this->presenter->getLastCreatedRequest());
			}
		} else {
			$this->processRequest(new Request($this->errorPresenter, Request::FORWARD, $args));
		}
	}


	/**
	 * Returns all processed requests.
	 * @return Request[]
	 */
	public function getRequests()
	{
		return $this->requests;
	}


	/**
	 * Returns current presenter.
	 * @return IPresenter
	 */
	public function getPresenter()
	{
		return $this->presenter;
	}


	/********************* services ****************d*g**/


	/**
	 * Returns router.
	 * @return IRouter
	 */
	public function getRouter()
	{
		return $this->router;
	}


	/**
	 * Returns presenter factory.
	 * @return IPresenterFactory
	 */
	public function getPresenterFactory()
	{
		return $this->presenterFactory;
	}

}
