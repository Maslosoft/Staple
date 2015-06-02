<?php

namespace Maslosoft\Staple\Interfaces;

interface RequestAwareInterface extends RendererAwareInterface
{

	public function getExtensions();

	public function getRootPath();

	public function getContentPath();
}
