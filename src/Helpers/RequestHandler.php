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

	public function handle(ProcessorAwareInterface $owner, $basePath, $path, $view)
	{
		$preProcessor = new PreProcessor();
		$data = $preProcessor->getData($owner, $path, $view);
		$content = $owner->getRenderer($path)->render($view, $data);
		$preProcessor->decorate($owner, $content, $data);
		(new PostProcessor())->decorate($owner, $content, $data);

		return $content;
	}

}
