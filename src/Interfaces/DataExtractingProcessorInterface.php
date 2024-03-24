<?php

namespace Maslosoft\Staple\Interfaces;

interface DataExtractingProcessorInterface
{
	public function getData(RendererAwareInterface $owner, $filename, $view);
}