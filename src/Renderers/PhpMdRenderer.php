<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Renderers;

use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Interfaces\RendererInterface;
use Parsedown;

/**
 * PhpMdRenderer
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class PhpMdRenderer extends AbstractRenderer implements RendererInterface
{

	public $extension = 'php.md';

	public function render($view = 'index', $data = [])
	{
		$mv = new MiniView($this);
		$fileName = sprintf('%s/%s/%s.%s', $this->getOwner()->getRootPath(), $this->getOwner()->getContentPath(), $view, $this->extension);
		$content = $mv->renderFile($fileName, $data, true);
		return (new Parsedown)->text($content);
	}

}
