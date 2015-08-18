<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Processors\Pre;

use Maslosoft\Staple\Interfaces\PreProcessorInterface;
use Maslosoft\Staple\Interfaces\RendererAwareInterface;

/**
 * ##View Json Extractor##
 *
 * This extracts data from json file named same as view file, but with json extension.
 * When resolving name, extension is not added to this json file.
 *
 * For example, when there is file `index.php` this will try to load data from
 * file `index.json`.
 * Some example files structure:
 * ```
 * products/
 * 		index.php
 * 		index.json
 * 		spoon.md.php
 * 		spoon.json
 * 		fork.md
 * 		fork.json
 * ```
 *
 * From example above data from json files will be attached by following associacions:
 * ```
 * index.json --> index.php
 * spoon.json --> sopon.md.php
 * fork.json --> fork.md
 * ```
 *
 * Extracted data is available both in view and in layout.
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ViewJsonExtractor implements PreProcessorInterface
{

	public function decorate(RendererAwareInterface $owner, &$content, $data)
	{

	}

	public function getData(RendererAwareInterface $owner, $filename, $view)
	{
		$data = [];
		$path = sprintf('%s/%s/%s.json', $owner->getRootPath(), $owner->getContentPath(), $view);
		if (file_exists($path))
		{
			$data = (array) json_decode(file_get_contents($path));
		}
		return $data;
	}

}
