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
		$path = dirname($filename);
		$parts = explode('/', $path);

		foreach ($parts as $part)
		{
			$filePath = sprintf('%s/%s', $path, $this->filename);
			if (file_exists($filePath))
			{
				$data = array_merge((array) json_decode(file_get_contents($filePath), false), $data);
			}
			$path = realpath($path . '/../');
			if ($path === $rootPath)
			{
				break;
			}
		}

		return $data;
	}

}
