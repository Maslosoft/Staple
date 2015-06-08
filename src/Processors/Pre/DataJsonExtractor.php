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
 * DataJsonExtractor
 *
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
