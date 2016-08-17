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

namespace Maslosoft\Staple\Interfaces;

interface RendererAwareInterface
{

	/**
	 * @return RendererInterface
	 */
	public function getRenderer($filename);

	public function getRootPath();

	public function getContentPath();

	public function getLayoutPath();

	public function setLayoutPath($layoutPath);
}
