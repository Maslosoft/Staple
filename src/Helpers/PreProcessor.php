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
