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

use Maslosoft\Staple\Interfaces\ProcessorAwareInterface;

/**
 * PreProcessor
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class PreProcessor
{

	public function getData(ProcessorAwareInterface $owner, $path, $view)
	{
		$data = [];
		foreach ($owner->getPreProcessors() as $preProcessor)
		{
			$data = array_merge($data, $preProcessor->getData($owner, $path, $view));
		}
		return $data;
	}

	public function decorate(ProcessorAwareInterface $owner, &$content, $data)
	{
		foreach ($owner->getPreProcessors() as $preProcessor)
		{
			$preProcessor->decorate($owner, $content, $data);
		}
	}

}
