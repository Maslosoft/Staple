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
 * RequestHandler
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class RequestHandler
{

	private $data = [];

	public function handle(ProcessorAwareInterface $owner, $basePath, $path, $view)
	{

		$preProcessor = new PreProcessor();
		$this->data = $preProcessor->getData($owner, $path, $view);
		$content = $owner->getRenderer($path)->render($view, $this->data);
		$preProcessor->decorate($owner, $content, $this->data);
		(new PostProcessor())->decorate($owner, $content, $this->data);


		return $content;
	}

	public function getData()
	{
		return $this->data;
	}

}
