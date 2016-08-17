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
