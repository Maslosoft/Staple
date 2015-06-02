<?php

namespace Maslosoft\Staple\Request;

use Maslosoft\Staple\Interfaces\RequestAwareInterface;
use Maslosoft\Staple\Interfaces\RequestInterface;
use Maslosoft\Staple\Renderers\ErrorRenderer;

class HttpRequest implements RequestInterface
{

	public function dispatch(RequestAwareInterface $owner)
	{
		$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$basePath = $this->_sanitizePath($owner, $urlPath);
		$path = '';
		foreach ($owner->getExtensions() as $ext)
		{
			// Check for file
			$path = $this->_getFilename($basePath, $ext);
			if (false !== $path)
			{
				break;
			}

			// Check for index if folder like url
			$path = $this->_getFilename(sprintf('%s/index.%s', $basePath, $ext), $ext);
			if (false !== $path)
			{
				break;
			}
		}

		if (empty($path))
		{
			return (new ErrorRenderer('404', 'File not found'))->setBasePath($owner->getRootPath())->render();
		}

		$extRegexp = preg_quote($ext);

		// Remove extension for view
		$view = preg_replace("~$extRegexp$~", '', basename($path));

		$renderer = $owner->getRenderer();
		$renderer->setBasePath($owner->getRootPath());
		return $renderer->render($view);
	}

	/**
	 * Get filename
	 * @param string $path
	 * @param string $ext
	 * @return boolean|string
	 */
	private function _getFilename($path, $ext)
	{
		$extRegexp = preg_quote($ext);
		if (preg_match("~$extRegexp$~", $path))
		{
			if (file_exists($path))
			{
				return $path;
			}
		}
		return false;
	}

	/**
	 * Sanitize path. Remove double slashes and trailing slash.
	 * @param RequestAwareInterface $owner
	 * @param string $urlPath
	 * @return string
	 */
	private function _sanitizePath(RequestAwareInterface $owner, $urlPath)
	{
		$path = sprintf("%s/%s/%s", $owner->getRootPath(), $owner->getContentPath(), $urlPath);
		$patterns = [
			'~/+~' => '/',
			'~/$~' => ''
		];
		return preg_replace(array_keys($patterns), array_values($patterns), $path);
	}

}
