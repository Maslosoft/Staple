<?php

/**
 * This software package is licensed under `AGLP, Commercial` license[s].
 *
 * @package maslosoft/staple
 * @license AGLP, Commercial
 *
 * @copyright Copyright (c) Peter Maselkowski <pmaselkowski@gmail.com>
 *
 */

namespace Maslosoft\Staple\Processors\Pre;

use Maslosoft\Staple\Interfaces\PreProcessorInterface;
use Maslosoft\Staple\Interfaces\RendererAwareInterface;

/**
 * ##Data Json Extractor##
 *
 * This extracts json data from content folder.
 * By default it's name is `data.json`
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class DataJsonExtractor implements PreProcessorInterface
{

	public $filename = 'data.json';

	public function decorate(RendererAwareInterface $owner, &$content, $data)
	{

	}

	public function getData(RendererAwareInterface $owner, $filename, $view)
	{
		$data = [];
		$path = sprintf('%s/%s/%s', $owner->getRootPath(), $owner->getContentPath(), $this->filename);
		if (file_exists($path))
		{
			$data = (array) json_decode(file_get_contents($path));
		}
		return $data;
	}

}
