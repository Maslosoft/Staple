<?php

namespace Maslosoft\Staple\Interfaces;

interface RendererInterface
{
	public function setBasePath($path);
	public function render();
}