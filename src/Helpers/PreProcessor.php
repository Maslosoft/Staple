<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Helpers;

use Maslosoft\Staple\Interfaces\RendererAwareInterface;

/**
 * PreProcessor
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class PreProcessor
{

	public function getData(RendererAwareInterface $owner, $path, $view)
	{
		$data = [];
		foreach ($owner->getPreProcessors() as $preProcessor)
		{
			$data = array_merge($data, $preProcessor->getData($owner, $path, $view));
		}
		return $data;
	}

	public function decorate(RendererAwareInterface $owner, &$content, $data)
	{
		foreach ($owner->getPreProcessors() as $preProcessor)
		{
			$preProcessor->decorate($owner, $content, $data);
		}
	}

}
