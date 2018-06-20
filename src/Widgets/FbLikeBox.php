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

namespace Maslosoft\Staple\Widgets;

/**
 * FbLikeBox
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class FbLikeBox
{

	public $options = [
		'href' => '',
		'width' => 500,
		'height' => 500,
		'hide_cover' => false,
		'show_facepile' => true,
		'show_posts' => false,
		'hide_cta' => false,
		'small_header' => false,
		'adapt_container_width' => true
	];
	private static $initialized = false;

	public function __construct($options = [])
	{
		if (is_string($options))
		{
			$this->options['href'] = $options;
			unset($options);
		}
		if (!empty($options))
		{
			$this->options = array_merge($this->options, $options);
		}
	}

	public function __toString()
	{
		$html = '';
		$init = <<<INIT
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
INIT;
		if (false === self::$initialized)
		{
			$html = $init;
		}
		$options = [];
		foreach ($this->options as $key => $value)
		{
			$options[] = sprintf('data-%s="%s"', $key, $value);
		}

		$params = implode(' ', $options);

		$tpl = <<<TPL
		<div class="text-center">
			<div class="fb-page" style="max-width: 100% !important;" $params></div>
		</div>
TPL;
		return $html . $tpl;
	}

}
