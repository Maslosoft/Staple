<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Widgets\Vo;

use Maslosoft\Staple\Widgets\SubNav;

/**
 * SubNavItem
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SubNavItem
{

	public $title = '';
	public $url = '';
	public $items = [];

	public function __construct($url, $title, SubNav $nav)
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
