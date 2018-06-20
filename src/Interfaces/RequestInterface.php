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

interface RequestInterface
{

	/**
	 * Dispath request
	 * @param RequestAwareInterface $owner
	 * @return string
	 */
	public function dispatch(RequestAwareInterface $owner);
}
