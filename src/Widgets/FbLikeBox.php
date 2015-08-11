<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
		'width' => 340,
		'height' => 500,
		'hide_cover' => false,
		'show_facepile' => true,
		'show_posts' => false,
		'hide_cta' => false,
		'small_header' => false,
		'adapt_container_width' => true
	];
	private static $initialized = false;

	public function __construct($href, $options = [])
	{
		if (!empty($options))
		{
			$this->options = $options;
		}
		$this->options['href'] = $href;
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



		$tpl = <<<TPL
		<div class="fb-page" $params></div>
TPL;
		return $html . $tpl;
	}

}
