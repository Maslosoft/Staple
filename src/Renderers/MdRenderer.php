<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Renderers;

use Maslosoft\Staple\Interfaces\RendererInterface;
use Parsedown;

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
		$path = sprintf('%s/%s/%s.%s', $this->getOwner()->getRootPath(), $this->getOwner()->getContentPath(), $view, $this->extension);
		$text = file_get_contents($path);
		return (new Parsedown)->text($text);
	}

}
