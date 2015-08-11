<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
