<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

namespace Nette\Bridges\ApplicationLatte;

use Latte;


interface ILatteFactory
{

	/**
	 * @return Latte\Engine
	 */
	function create();

}
