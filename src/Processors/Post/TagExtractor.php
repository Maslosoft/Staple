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

namespace Maslosoft\Staple\Processors\Post;

use Maslosoft\Staple\Interfaces\DataExtractingPostProcessorInterface;
use Maslosoft\Staple\Interfaces\PostProcessorInterface;
use Maslosoft\Staple\Interfaces\PreProcessorInterface;
use Maslosoft\Staple\Interfaces\RendererAwareInterface;

/**
 * ##Tag Extractor##
 *
 * This class extracts selected tags from view and pass it to layout.
 *
 * Tags can have any name, they do *not* have to be html compliant,
 * as they are used only internally.
 *
 * Tags will be removed from view. Should not contain any attributes,
 * as they are extracted in a very simple and not recommended (but fast) method.
 *
 * If tag contains any attribute it will not be processed.
 *
 * Example tags:
 * ```html
 * <title>My page title</title>
 * ```
 * This will be passed to template and can be used, for instance in document head as a title:
 * ```php
 * <head>
 * 		<title><?= $this->data->title;?></title>
 * </head>
 * ```
 *
 * This can also be used with Template Applier to use different template for any page:
 * ```html
 * <template>product</template>
 * ```
 * This will lookup for `product.php` file in your layouts directory. If template
 * exists it will be used by Template Applier (if it's enabled).
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class TagExtractor implements PostProcessorInterface, DataExtractingPostProcessorInterface
{

	public $tags = [
		'template',
		'title',
		'description'
	];

	public function decorate(RendererAwareInterface $owner, &$content, $data): void
	{

	}

	public function getData(RendererAwareInterface $owner, $filename, $view, &$content): array
	{
		$data = [];

		foreach ($this->tags as $tag)
		{
			$matches = [];
			$pattern = $this->_getPattern($tag);
			if (preg_match($pattern, $content, $matches))
			{
				$data[$tag] = $matches[1];
				$content = preg_replace($pattern, '', $content);
			}
		}
		return $data;
	}

	private function _getPattern($tag): string
	{
		return "~<$tag>(.+?)</$tag>~i";
	}

}
