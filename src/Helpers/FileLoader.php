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


use Maslosoft\Staple\Exceptions\NotFoundException;

class FileLoader
{
	/**
	 * Load file if possible
	 * @param $path
	 * @return string
	 * @throws NotFoundException
	 */
	public static function load($path): string
	{
		if (!file_exists($path))
		{
			throw new NotFoundException("File $path does not exists");
		}
		if (!is_readable($path))
		{
			throw new NotFoundException("File $path is not readable");
		}
		return file_get_contents($path);
	}
}