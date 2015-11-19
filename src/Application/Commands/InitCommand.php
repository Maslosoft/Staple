<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Application\Commands;

use Maslosoft\Sitcom\Command;
use Maslosoft\Staple\Helpers\Init;
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * InitCommand
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class InitCommand extends ConsoleCommand
{

	protected function configure()
	{
		$this->setName("init");
		$this->setDescription("Init new website in current folder");
		$this->setDefinition([
		]);

		$help = <<<EOT
The <info>init</info> command will create (if not exists) basic files nessesary to start a website.
EOT;
		$this->setHelp($help);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		new Init();
	}

	/**
	 * @SlotFor(Command)
	 * @param Command $signal
	 */
	public function reactOn(Command $signal)
	{
		$signal->add($this, 'hedron');
	}

}
