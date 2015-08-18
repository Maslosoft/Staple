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
