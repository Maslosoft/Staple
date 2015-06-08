<?php

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
