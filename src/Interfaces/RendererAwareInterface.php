<?php

/**
 * This software package is licensed under `AGLP, Commercial` license[s].
 *
 * @package maslosoft/staple
 * @license AGLP, Commercial
 *
 * @copyright Copyright (c) Peter Maselkowski <pmaselkowski@gmail.com>
 *
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
