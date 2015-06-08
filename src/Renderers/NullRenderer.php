<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Renderers;

use Maslosoft\Staple\Interfaces\RendererInterface;

/**
 * NullRenderer
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class NullRenderer extends AbstractRenderer implements RendererInterface
{

	public function render($view = 'index', $data = [])
	{
		return '';
	}

}
