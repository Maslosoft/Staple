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
 * TagExtractor
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class TagExtractor implements PreProcessorInterface
{

	public $tags = [
		'template',
		'title',
		'description'
	];

	public function decorate(RendererAwareInterface $owner, &$content, $data)
	{
		foreach ($this->tags as $tag)
		{
			$matches = [];
			$pattern = $this->_getPattern($tag);
			if (preg_match($pattern, $content, $matches))
			{
				$content = preg_replace($pattern, '', $content);
			}
		}
	}

	public function getData(RendererAwareInterface $owner, $filename, $view)
	{
		$content = '';
		if (!empty($filename))
		{
			$content = file_get_contents($filename);
		}

		$data = [];
		foreach ($this->tags as $tag)
		{
			$matches = [];
			if (preg_match($this->_getPattern($tag), $content, $matches))
			{
				$data[$tag] = $matches[1];
			}
		}
		return $data;
	}

	private function _getPattern($tag)
	{
		return "~<$tag>(.+?)</$tag>~i";
	}

}
