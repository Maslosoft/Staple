<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
