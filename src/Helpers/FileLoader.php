<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 20.06.18
 * Time: 18:02
 */

namespace Maslosoft\Staple\Helpers;


use Maslosoft\Staple\Exceptions\NotFoundException;

class FileLoader
{
	/**
	 * Load file if possible
	 * @param $path
	 * @throws NotFoundException
	 */
	public static function load($path)
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