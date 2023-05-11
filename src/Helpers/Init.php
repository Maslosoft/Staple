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

namespace Maslosoft\Staple\Helpers;

/**
 * Init
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Init
{

	public string $dir = '';

	public function __construct(string $dir = null)
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
		$index = $this->dir . '/index.php';
		$data = file_get_contents($index);
		if(str_contains($data, '%s'))
		{
			$new = sprintf($data, '_bootstrap.php');
			file_put_contents($index, $new);
		}
	}

	public function copy($file): void
	{

		$src = __DIR__ . '/../' . $file;
		$dest = $this->dir . '/' . $file;

		if (!file_exists($dest))
		{
			copy($src, $dest);
		}
	}

}
