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
