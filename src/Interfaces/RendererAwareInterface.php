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

namespace Maslosoft\Staple\Interfaces;

interface RendererAwareInterface
{

	/**
	 * @param $filename
	 * @return RendererInterface
	 */
	public function getRenderer($filename): RendererInterface;

	public function getRootPath(): string;

	public function getContentPath(): string;

	public function getLayoutPath(): string;

	public function setLayoutPath($layoutPath): void;
}
