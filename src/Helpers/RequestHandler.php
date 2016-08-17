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
