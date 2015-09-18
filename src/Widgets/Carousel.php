<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Widgets;

/**
 * Carousel
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Carousel
{

	const DefaultId = 'carousel';

	public $id = self::DefaultId;
	private static $idCounter = 0;

	/**
	 * Default image width and height. Should fit nicely on layouts
	 */
	const DefaultWidth = 1600;
	const DefaultHeight = 1200;

	public $width = self::DefaultWidth;
	public $height = self::DefaultHeight;
	public $options = [
		'id' => self::DefaultId,
		'width' => self::DefaultWidth,
		'height' => self::DefaultHeight,
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

		// Set auto id if id is default
		if ($this->id === self::DefaultId && self::$idCounter > 0)
		{
			$this->id = sprintf('%s-%d', $this->id, self::$idCounter++);
		}
	}

	public function getItems()
	{
		
	}

	public function getId()
	{
		return $this->id;
	}

}
