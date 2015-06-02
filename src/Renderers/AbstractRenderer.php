<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Renderers;

use Maslosoft\Staple\Interfaces\RendererAwareInterface;
use Maslosoft\Staple\Interfaces\RendererInterface;

/**
 * AbstractRender
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
abstract class AbstractRenderer
{

	/**
	 * Owner
	 * @var RendererAwareInterface
	 */
	private $_owner = null;

	/**
	 * Set owner
	 * @param RendererAwareInterface $owner
	 * @return RendererInterface
	 */
	public function setOwner(RendererAwareInterface $owner)
	{
		$this->_owner = $owner;
		return $this;
	}

	/**
	 * Get owner
	 * @return RendererAwareInterface
	 */
	public function getOwner()
	{
		return $this->_owner;
	}

}
