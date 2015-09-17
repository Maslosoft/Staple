<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Processors\Pre;

use Maslosoft\Staple\Interfaces\RendererAwareInterface;

/**
 * ##Cascading Data Json Extractor##
 *
 * This extracts json data from content folder. Additionally it traverse folders
 * above, check for json data and merge it all from top to bottom.
 *
 * Data files closer to current view have higher priority and will overwrite
 * data from files closer to the root of website.
 *
 * By default it's name is `data.json`
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class CascadingDataJsonExtractor
{

	public $filename = 'data.json';

	public function decorate(RendererAwareInterface $owner, &$content, $data)
	{

	}

	public function getData(RendererAwareInterface $owner, $filename, $view)
	{
		$data = [];
		$rootPath = realpath($owner->getRootPath());
		$path = sprintf('%s/%s/%s', $rootPath, $owner->getContentPath(), $this->filename);
		$parts = explode('/', $path);

		foreach ($parts as $part)
		{
			$path = realpath($path . '/../');
			if (file_exists($path))
			{
				$data = array_merge((array) json_decode(file_get_contents($path)), $data);
			}
			if ($path === $rootPath)
			{
				break;
			}
		}
		return $data;
	}

}
