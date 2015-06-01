<?php

namespace Maslosoft\Staple\Interfaces;

interface RendererAwareInterface
{

	/**
	 * @return RendererInterface
	 */
	public function getRenderer($filename);
}
