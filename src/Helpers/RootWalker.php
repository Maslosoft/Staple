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

use Maslosoft\Staple\Interfaces\RequestAwareInterface;
use Maslosoft\Staple\Request\HttpRequest;

/**
 * RootWalker
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class RootWalker extends AbstractWalker implements RequestAwareInterface
{

	public function getPathItems()
	{
		$request = new HttpRequest;
		$url = $request->getPath();
		$items = [];
		do
		{
			$request->setPath($url);
			$filePath = $request->getFileName($this);

			$data = (object) (new PreProcessor)->getData($this, $filePath, basename($filePath));

			if (isset($data->title))
			{
				$fileBaseName = basename($filePath);
				$urlBaseName = basename($url);
				if($fileBaseName === $urlBaseName)
				{
					$suffix = '';
				}
				else
				{
					$suffix = '/';
				}

				$sanitizedUrl = rtrim($url, '/') . $suffix;
				$items[$sanitizedUrl] = $data->title;
			}
			$url = dirname($url);
		}
		while ($url !== '/');
		return $items;
	}

	public function getExtensions()
	{
		return $this->staple->getExtensions();
	}

}
