<?php

namespace Maslosoft\Staple\Interfaces;

interface DataExtractingPreProcessorInterface
{
	public function getData(RendererAwareInterface $owner, $filename, $view);
}