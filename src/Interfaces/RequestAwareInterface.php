<?php

namespace Maslosoft\Staple\Interfaces;

interface RequestAwareInterface extends RendererAwareInterface, ProcessorAwareInterface
{

	public function getExtensions();
}
