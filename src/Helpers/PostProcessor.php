<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/staple
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @link https://maslosoft.com/staple/
 */

namespace Maslosoft\Staple\Helpers;

use Maslosoft\Staple\Interfaces\DataExtractingPostProcessorInterface;
use Maslosoft\Staple\Interfaces\ProcessorAwareInterface;
use Maslosoft\Staple\Interfaces\RendererAwareInterface;

/**
 * PostProcessor
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class PostProcessor
{

	public function decorate(RendererAwareInterface $owner, &$content, $data)
	{
		foreach ($owner->getPostProcessors() as $postProcessor)
		{
			$postProcessor->decorate($owner, $content, $data);
		}
	}

	public function getData(ProcessorAwareInterface $owner, string $path, string $view, string $content)
	{
		$data = [];
		foreach ($owner->getPostProcessors() as $postProcessor)
		{
			if($postProcessor instanceof DataExtractingPostProcessorInterface)
			{
				$data = array_merge($data, $postProcessor->getData($owner, $path, $view, $content));
			}
		}
		return $data;
	}
}
