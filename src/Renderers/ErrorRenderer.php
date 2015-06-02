<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Renderers;

use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Interfaces\RendererInterface;

/**
 * ErrorRenderer
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ErrorRenderer extends AbstractRenderer implements RendererInterface
{

	private $_code = 404;
	private $_message = '';

	public function __construct($code, $message = '')
	{
		$this->_code = $code;
		$this->_message = $message;
	}

	public function render($view = 'index')
	{
		$message = $this->_code;
		if (!empty($this->_message))
		{
			$message .= ": $this->_message";
		}
		$path = sprintf('%s/_%d.php', $this->getBasePath(), $this->_code);
		if (file_exists($path))
		{
			return (new MiniView($this, $this->getBasePath()))->render(sprintf('_%s', $this->_code), [
						'code' => $this->_code,
						'message' => $this->_message
							], true);
		}
		return <<<HTML
		<h1>$message</h1>
HTML;
	}

}
