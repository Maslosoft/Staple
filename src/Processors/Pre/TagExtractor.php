<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Processors\Pre;

/**
 * TagExtractor
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class TagExtractor implements \Maslosoft\Staple\Interfaces\PreProcessorInterface
{

	public $tags = [
		'template',
		'title',
		'description'
	];

	public function decorate(&$content, $data)
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

	public function getData($filename, $view)
	{
		$content = file_get_contents($filename);
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
