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
	 * @var RendererAwareInterface|null
	 */
	private ?RendererAwareInterface $_owner = null;

	/**
	 * Set owner
	 * @param RendererAwareInterface $owner
	 */
	public function setOwner(RendererAwareInterface $owner): void
	{
		$this->_owner = $owner;
	}

	/**
	 * Get owner
	 * @return RendererAwareInterface|null
	 */
	public function getOwner(): ?RendererAwareInterface
	{
		return $this->_owner;
	}

}
