<?php

/**
 * This software package is licensed under `AGLP, Commercial` license[s].
 *
 * @package maslosoft/staple
 * @license AGLP, Commercial
 *
 * @copyright Copyright (c) Peter Maselkowski <pmaselkowski@gmail.com>
 *
 */

namespace Maslosoft\Staple\Request;

use Maslosoft\Staple\Helpers\RequestHandler;
use Maslosoft\Staple\Interfaces\RequestAwareInterface;
use Maslosoft\Staple\Interfaces\RequestInterface;

class HttpRequest implements RequestInterface
{

	public function dispatch(RequestAwareInterface $owner)
	{
		$urlPath = $this->getPath();
		$basePath = sprintf('%s/%s/%s', $owner->getRootPath(), $owner->getContentPath(), $this->_sanitizeUrl($urlPath));
		$path = null;
		$view = null;
		foreach ($owner->getExtensions() as $ext)
		{
			// Check for file
			$path = $this->_getFilename($basePath, $ext);
			$extRegexp = preg_quote($ext);
			if (false !== $path)
			{
				$view = $this->_sanitizeUrl(preg_replace("~\.$extRegexp$~i", '', $urlPath));
				break;
			}

			// Check for index if folder like url
			if (is_dir($basePath))
			{
				$path = $this->_getFilename(sprintf('%s/index.%s', $basePath, $ext), $ext);
				if (false !== $path && file_exists($path))
				{
					$view = $this->_sanitizeUrl(sprintf('%s/%s', $urlPath, preg_replace("~\.$extRegexp$~i", '', basename($path))));
					break;
				}
			}
		}
		return (new RequestHandler)->handle($owner, $basePath, $path, $view);
	}

	protected function getPath()
	{
		return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
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
		if (preg_match("~$extRegexp$~i", $path))
		{
			return $path;
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
