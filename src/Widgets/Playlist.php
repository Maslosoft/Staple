<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Widgets;

use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Widgets\Vo\PlaylistItem;

/**
 * Playlist
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Playlist
{

	public $items = [];
	public $options = [
		'items' => ''
	];

	/**
	 * View
	 * @var MiniView
	 */
	private $mv = null;

	public function __construct($options = [])
	{
		if (!empty($options))
		{
			$this->options = array_merge($this->options, $options);
		}

		// Apply configuration
		EmbeDi::fly()->apply($this->options, $this);

		// Setup view
		$this->mv = new MiniView($this);
	}

	public function getItems()
	{
		foreach ($this->items as $url => $title)
		{
			yield new PlaylistItem($url, $title, $this);
		}
	}

	public function __toString()
	{
		return $this->mv->render('playlist', [], true);
	}

	public static function initJs()
	{
		$js = <<<JS
				<script>
	jQuery(document).ready(function () {
		jQuery('.maslosoft-playlist').each(function (index) {
			new Maslosoft.Playlist(this);
		});
	});
				</script>
JS;
		return $js;
	}

}
