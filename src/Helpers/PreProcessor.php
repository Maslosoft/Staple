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

use Maslosoft\Staple\Interfaces\ProcessorAwareInterface;

/**
 * PreProcessor
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class PreProcessor
{

	/**
	 *
	 * @param ProcessorAwareInterface $owner
	 * @param string                  $path Full file system path to view
	 * @param string                  $view View file name
	 * @return mixed
	 */
	public function getData(ProcessorAwareInterface $owner, string $path, string $view): mixed
	{
		$data = [];
		foreach ($owner->getPreProcessors() as $preProcessor)
		{
			$data = array_merge($data, $preProcessor->getData($owner, $path, $view));
		}
		return $data;
	}

	public function decorate(ProcessorAwareInterface $owner, &$content, $data): void
	{
		foreach ($owner->getPreProcessors() as $preProcessor)
		{
			$preProcessor->decorate($owner, $content, $data);
		}
	}

}
