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

use Maslosoft\Staple\Widgets\Vo\PlaylistItem;

/**
 * Playlist
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Playlist extends Widget
{

	public array $options = [
		'items' => ''
	];

	public function getItems(): array
	{
		$items = [];
		foreach ($this->items as $url => $title)
		{
			$items[] = new PlaylistItem($url, $title, $this);
		}
		return $items;
	}

	public function __toString()
	{
		return (string)$this->mv->render('playlist', [], true);
	}

	public static function initJs(): string
	{
		return <<<JS
				<script>
	jQuery(document).ready(function () {
		jQuery('.maslosoft-playlist').each(function (index) {
			new Maslosoft.Playlist(this);
		})
	});
				</script>
JS;
	}

}
