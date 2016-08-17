<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/staple
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @link http://maslosoft.com/staple/
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
