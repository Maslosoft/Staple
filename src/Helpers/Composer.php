<?php

namespace Maslosoft\Staple\Helpers;

use Composer\Installer\PackageEvent;
use Maslosoft\Staple\Staple;

class Composer
{

	public static function postInstall(PackageEvent $event)
	{
		$src = __DIR__ . '/../' . Staple::BootstrapName;
		$dst = getcwd() . '/' . Staple::BootstrapName;

		$srcIndex = __DIR__ . '/../index.php';
		$dstIndex = getcwd() . '/index.php';
		copy($src, $dst);
		if (!file_exists($dstIndex))
		{
			$index = sprintf(file_get_contents($srcIndex), Staple::BootstrapName);
			file_put_contents($dstIndex, $index);
		}
	}

}
