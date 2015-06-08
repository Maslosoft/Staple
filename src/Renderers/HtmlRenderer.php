<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Renderers;

/**
 * HtmlRenderer
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class HtmlRenderer extends AbstractRenderer implements \Maslosoft\Staple\Interfaces\RendererInterface
{

	/**
	 * HTML file extension used in temlates
	 * @var string
	 */
	public $extension = 'html';

	public function render($view = 'index', $data = [])
	{
		return file_get_contents(sprintf('%s/%s.%s', $this->getBasePath(), $view, $this->extension));
	}

}
