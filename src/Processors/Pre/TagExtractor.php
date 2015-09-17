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

namespace Maslosoft\Staple\Processors\Pre;

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
class TagExtractor implements PreProcessorInterface
{

	public $tags = [
		'template',
		'title',
		'description'
	];

	public function decorate(RendererAwareInterface $owner, &$content, $data)
	{
		foreach ($this->tags as $tag)
		{
			$matches = [];
			$pattern = $this->_getPattern($tag);
			if (preg_match($pattern, $content, $matches))
			{
				$content = preg_replace($pattern, '', $content);
			}
		}
	}

	public function getData(RendererAwareInterface $owner, $filename, $view)
	{
		$data = [];
		$content = '';
		if (!empty($filename))
		{
			if (file_exists($filename))
			{
				$content = file_get_contents($filename);
			}
			else
			{
				return $data;
			}
		}

		foreach ($this->tags as $tag)
		{
			$matches = [];
			if (preg_match($this->_getPattern($tag), $content, $matches))
			{
				$data[$tag] = $matches[1];
			}
		}
		return $data;
	}

	private function _getPattern($tag)
	{
		return "~<$tag>(.+?)</$tag>~i";
	}

}
