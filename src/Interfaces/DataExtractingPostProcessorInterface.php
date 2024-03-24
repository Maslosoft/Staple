<?php

namespace Maslosoft\Staple\Interfaces;

interface DataExtractingPostProcessorInterface
{
	public function getData(RendererAwareInterface $owner, $filename, $view, &$content);
}