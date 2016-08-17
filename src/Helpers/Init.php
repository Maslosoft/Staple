<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/staple
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @link http://maslosoft.com/staple/
 */

namespace Maslosoft\Staple\Helpers;

/**
 * Init
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Init
{

	public $dir = '';

	public function __construct($dir = null)
	{
		if (null === $dir)
		{
			$dir = getcwd();
		}
		$this->dir = $dir;
		$files = [
			'_bootstrap.php',
			'index.php'
		];
		foreach ($files as $file)
		{
			$this->copy($file);
		}
	}

	public function copy($file)
	{

		$src = __DIR__ . '/../' . $file;
		$dest = $this->dir . '/' . $file;

		if (!file_exists($dest))
		{
			copy($src, $dest);
		}
	}

}
