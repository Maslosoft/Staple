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

namespace Maslosoft\Staple\Application\Commands;

use Maslosoft\Staple\Helpers\Init;
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * InitCommand
 * @buildignore
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class InitCommand extends ConsoleCommand
{

	protected function configure(): void
	{
		$this->setName("init");
		$this->setDescription("Init new website in current folder");
		$this->setDefinition([
		]);

		$help = <<<EOT
The <info>init</info> command will create (if not exists) basic files necessary to start a website.
EOT;
		$this->setHelp($help);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		new Init();
		return 0;
	}
}
