<?php

namespace Maslosoft\Staple\Request;

use Maslosoft\Staple\Helpers\RequestHandler;
use Maslosoft\Staple\Interfaces\RequestAwareInterface;
use Maslosoft\Staple\Interfaces\RequestInterface;
use Maslosoft\Staple\Renderers\ErrorRenderer;
use Maslosoft\Staple\Renderers\PassThroughRenderer;

class HttpRequest implements RequestInterface
{

	public function dispatch(RequestAwareInterface $owner)
	{
		$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$basePath = sprintf('%s/%s/%s', $owner->getRootPath(), $owner->getContentPath(), $this->_sanitizeUrl($urlPath));
		$path = null;
		foreach ($owner->getExtensions() as $ext)
		{
			// Check for file
			$path = $this->_getFilename($basePath, $ext);
			$extRegexp = preg_quote($ext);
			if (false !== $path)
			{
				$view = $this->_sanitizeUrl(preg_replace("~\.$extRegexp$~", '', $urlPath));
				break;
			}

			// Check for index if folder like url
			$path = $this->_getFilename(sprintf('%sindex.%s', $basePath, $ext), $ext);
			if (false !== $path)
			{
				$view = $this->_sanitizeUrl(sprintf('%s/%s', $urlPath, preg_replace("~\.$extRegexp$~", '', basename($path))));
				break;
			}
		}

		// Other file extension
		if (empty($path))
		{
			if (file_exists($basePath))
			{
				return (new PassThroughRenderer($basePath))->setOwner($owner)->render();
			}
			else
			{
				return (new ErrorRenderer('404', 'File not found'))->setOwner($owner)->render();
			}
		}

		return (new RequestHandler)->handle($owner, $path, $view);
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
	private function _sanitizeUrl($urlPath)
	{
		$patterns = [
			'~/+~' => '/',
			'~/$~' => '',
			'~^/~' => ''
		];
		return preg_replace(array_keys($patterns), array_values($patterns), $urlPath);
	}

}
