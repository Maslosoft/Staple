<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Renderers;

use Maslosoft\Staple\Interfaces\RendererInterface;

/**
 * MdRenderer
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class MdRenderer extends AbstractRenderer implements RendererInterface
{

	/**
	 * Extension used for markdown files
	 * @var string
	 */
	public $extension = 'md';

	public function render($view = 'index')
	{
		return (new \ParseDown)->text(sprintf('%s/%s/%s'), $this->getBasePath(), $view, $this->extension);
	}

}
