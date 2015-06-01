<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Renderers;

use Parsedown;

/**
 * PhpMdRendere
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class PhpMdRenderer extends PhpRenderer
{

	public function render($view = 'index')
	{
		return (new Parsedown)->text(parent::render($view));
	}

}
