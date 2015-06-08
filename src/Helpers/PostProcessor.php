<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Helpers;

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

}
