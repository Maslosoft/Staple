<?php

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
				$sanitizedUrl = rtrim($url, '/') . '/';
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
