<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Widgets\Vo;

use Maslosoft\Staple\Widgets\Carousel;

/**
 * Carousel Item Value Object
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class CarouselItem
{

	private $title = '';
	private $caption = '';
	private $image = '';

	public function __construct($data, Carousel $carousel)
	{
		// Try different title names
		foreach (['title', 'label', 'name'] as $field)
		{
			if (!empty($data[$field]))
			{
				$this->title = $data[$field];
			}
		}
		if (!empty($data['caption']))
		{
			$this->caption = $data['caption'];
		}
		if (!empty($data['image']))
		{
			$this->image = $data['image'];
		}
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getCaption()
	{
		return $this->caption;
	}

	public function getImage()
	{
		return $this->image;
	}

}
