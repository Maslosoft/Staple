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

namespace Maslosoft\Staple\Processors\Pre;

use Closure;
use Maslosoft\Staple\Interfaces\PreProcessorInterface;
use Maslosoft\Staple\Interfaces\RendererAwareInterface;

/**
 * ##Callback Extractor##
 *
 * This can be used to pass data from other php scripts.
 *
 * By default Callback Extractor is disabled, as it need to have configured
 * callback to do anything.
 *
 * Example configuration with anonymous function:
 * ```php
 * $staple->preProcessors[] = [
 * 			'class' => CallbackExtractor::class,
 * 			'callback' => function($owner, $filename, $view){
 * 				return ['message' => 'Hello World!']
 * 			}
 * 		];
 * ```
 * This will result in variable `$data->message` available in both view and template.
 *
 * Multiple Callback Extractors can be used to call different callbacks.
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class CallbackExtractor implements PreProcessorInterface
{

	/**
	 * Callback for getting data.
	 *
	 * This will be called with same arguments as `getData` method:
	 * ```php
	 * RendererAwareInterface $owner
	 * string $filename
	 * string$view
	 * ```
	 *
	 * It must return array, prefably associative, as it will be merged with other extractors data
	 * @var Closure
	 */
	public $callback = null;

	public function decorate(RendererAwareInterface $owner, &$content, $data)
	{

	}

	public function getData(RendererAwareInterface $owner, $filename, $view)
	{
		if (null !== $this->callback)
		{
			return call_user_func_array($this->callback, func_get_args());
		}
		return [];
	}

}
