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

interface RendererInterface
{

	public function setOwner(RendererAwareInterface $owner);

	public function getOwner();

	public function render($view = 'index', $data = []);
}
