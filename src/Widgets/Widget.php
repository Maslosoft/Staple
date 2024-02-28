<?php

namespace Maslosoft\Staple\Widgets;

use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\MiniView\MiniView;

abstract class Widget
{
	public array $options = [];
	public array $items = [];

	/**
	 * View
	 * @var MiniView
	 */
	protected MiniView $mv;

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

	/**
	 * Get view instance
	 * Used by items
	 * @return MiniView
	 */
	public function getView(): MiniView
	{
		return $this->mv;
	}
}