<?php

namespace Maslosoft\Staple\Interfaces;

interface RequestInterface
{
	public function dispatch(RequestAwareInterface $owner);
}