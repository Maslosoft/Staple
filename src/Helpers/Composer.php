<?php

namespace Maslosoft\Staple\Helpers;

use Composer\Script\Event;

class Composer
{
	public static function postInstall(Event $event)
	{
		$src = __DIR__ . '/../bootstrap.php';
		$dst = getcwd() . '/bootstrap.php';
		copy($src, $dst);
		//var_dump($event->getComposer());
	}
}