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
