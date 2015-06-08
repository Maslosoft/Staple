<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Renderers;

/**
 * PassThroughRenderer
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class PassThroughRenderer extends AbstractRenderer implements \Maslosoft\Staple\Interfaces\RendererInterface
{

	private $_fileName = '';

	public function __construct($fileName)
	{
		$this->_fileName = $fileName;
	}

	public function render($view = 'index', $data = [])
	{
		$fileName = empty($this->_fileName) ? $view : $this->_fileName;
		header("X-Sendfile: $fileName");
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($fileName));
		header('Pragma: public');
		header('Content-Length: ' . filesize($fileName));
		return file_get_contents($fileName);
	}

}
