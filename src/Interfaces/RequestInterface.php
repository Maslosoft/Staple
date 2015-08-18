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

interface RequestInterface
{

	/**
	 * Dispath request
	 * @param RequestAwareInterface $owner
	 * @return string
	 */
	public function dispatch(RequestAwareInterface $owner);
}
