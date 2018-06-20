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

interface RendererInterface
{

	public function setOwner(RendererAwareInterface $owner);

	public function getOwner();

	public function render($view = 'index', $data = []);
}
