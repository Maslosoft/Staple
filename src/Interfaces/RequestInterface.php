<?php

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
