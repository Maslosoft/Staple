<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Renderers;

use Maslosoft\Staple\Interfaces\RendererInterface;

/**
 * AbstractRender
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
abstract class AbstractRenderer
{

	/**
	 * Base path
	 * @var string
	 */
	private $_basePath = '';

	/**
	 * Set base path
	 * @param string $path
	 * @return RendererInterface
	 */
	public function setBasePath($path)
	{
		$this->_basePath = $path;
		return $this;
	}

	/**
	 * Get base path
	 * @return string
	 */
	public function getBasePath()
	{
		return $this->_basePath;
	}

}
