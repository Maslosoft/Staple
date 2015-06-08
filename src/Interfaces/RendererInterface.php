<?php

namespace Maslosoft\Staple\Interfaces;

interface RendererInterface
{

	public function setOwner(RendererAwareInterface $owner);

	public function getOwner();

	public function render($view = 'index', $data = []);
}
