<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/staple
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @link https://maslosoft.com/staple/
 */

namespace Maslosoft\Staple\Renderers;

use Maslosoft\Staple\Exceptions\NotFoundException;
use Maslosoft\Staple\Interfaces\RendererExtensionInterface;
use Maslosoft\Staple\Interfaces\RendererInterface;
use RuntimeException;
use SplFileInfo;

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
			throw new RuntimeException(sprintf('Could not send file, headers already send. Output started in: %s:%s', $file, $line));
		}
		if (!file_exists($fileName))
		{
			throw new NotFoundException(sprintf('File `%s` not found', $fileName));
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

		$info = new SplFileInfo($fileName);

		header(sprintf('ETag: %s', md5($fileName)));
		header(sprintf('Last-Modified: %s', gmdate('D, d M Y H:i:s \G\M\T', $info->getMTime())));

		// Cache it
		header('Cache-Control: max-age=86400');
		header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));


		echo file_get_contents($fileName);
		exit;
	}

	public function setExtension($extension)
	{
		$this->_extension = $extension;
	}

}
