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

	public function render($view = 'index', $data = []): string
	{
		$message = $this->_code;
		if (!empty($this->_message))
		{
			$message .= ": $this->_message";
		}
		header("HTTP/1.0 $this->_code");
		$owner = $this->getOwner();
		assert($owner !== null);
		$path = sprintf('%s/%s/_%s.php', $owner->getRootPath(), $owner->getContentPath(), $this->_code);
		if (file_exists($path))
		{
			$mv = new MiniView($this, $owner->getRootPath());
			$mv->setViewsPath($owner->getContentPath());
			return $mv->render(sprintf('_%s', $this->_code), [
						'code' => $this->_code,
						'message' => $this->_message
							], true);
		}
		return <<<HTML
		<h1>$message</h1>
HTML;
	}

}
