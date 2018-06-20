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

namespace Maslosoft\Staple\Widgets\Vo;

use Maslosoft\Staple\Widgets\Playlist;

/**
 * PlaylistItem
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class PlaylistItem
{

	private $title = '';
	private $url = '';

	public function __construct($url, $title, Playlist $playlist)
	{
		$this->url = $url;
		$this->title = $title;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getUrl()
	{
		return $this->url;
	}

}
