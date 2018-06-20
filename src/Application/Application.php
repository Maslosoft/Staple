<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/staple
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @link https://maslosoft.com/staple/
 */

namespace Maslosoft\Staple\Application;

use Maslosoft\Staple\Application\Commands\InitCommand;
use Maslosoft\Staple\Staple;
use Symfony\Component\Console\Application as ConsoleApplication;

/**
 * StapleApplication
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Application extends ConsoleApplication
{

	const Logo = <<<LOGO
   _____ __              __
  / ___// /_____ _____  / /__
  \__ \/ __/ __ `/ __ \/ / _ \
 ___/ / /_/ /_/ / /_/ / /  __/
/____/\__/\__,_/ .___/_/\___/
              /_/

LOGO;

	public function __construct()
	{
		parent::__construct('Staple', (new Staple)->getVersion());
		$this->add(new InitCommand());
	}

	public function getHelp()
	{
		return self::Logo . parent::getHelp();
	}

}
