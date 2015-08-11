<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Renderers;

use Maslosoft\Staple\Interfaces\RendererExtensionInterface;
use Maslosoft\Staple\Interfaces\RendererInterface;

/**
 * PassThroughRenderer
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class PassThroughRenderer extends AbstractRenderer implements RendererInterface, RendererExtensionInterface
{

	const DispositionAuto = null;
	const DispositionInline = 'inline';
	const DispositionAttachment = 'attachment';

	private $_extension = '';
	public $disposition = self::DispositionAuto;

	public function render($view = 'index', $data = [])
	{
		$fileName = sprintf('%s/%s/%s.%s', $this->getOwner()->getRootPath(), $this->getOwner()->getContentPath(), $view, $this->_extension);
		$file = '';
		$line = 0;
		if (headers_sent($file, $line))
		{
			throw new \RuntimeException(sprintf('Could not send file, headers already send. Output started in: %s:%s', $file, $line));
		}
		header("X-Sendfile: $fileName");
		header('Content-Description: File Transfer');
		header(sprintf('Content-Type: %s', mime_content_type($fileName)));
		if (!empty($this->disposition))
		{
			header(sprintf('Content-Disposition: %s; filename=%s', $this->disposition, basename($fileName)));
		}
		header('Pragma: public');
		header('Content-Length: ' . filesize($fileName));
		echo file_get_contents($fileName);
		exit;
	}

	public function setExtension($extension)
	{
		$this->_extension = $extension;
	}

}
