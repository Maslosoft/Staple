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

namespace Maslosoft\Staple\Request;

use Maslosoft\Staple\Helpers\RequestHandler;
use Maslosoft\Staple\Interfaces\RequestAwareInterface;
use Maslosoft\Staple\Interfaces\RequestInterface;

class HttpRequest implements RequestInterface
{

	private $handler = null;

	/**
	 * Request path
	 * @var string
	 */
	private $path = null;

	/**
	 * Return true if is secure connection
	 * @return bool
	 */
	public function isSecure()
	{
		return isset($_SERVER['HTTPS']) && (strcasecmp($_SERVER['HTTPS'], 'on') === 0 || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
	}

	/**
	 * Get current website host name
	 * @return boolean|string
	 */
	public function getHost()
	{
		if (isset($_SERVER['HTTP_HOST']))
		{
			return $_SERVER['HTTP_HOST'];
		}
		if (isset($_SERVER['SERVER_NAME']))
		{
			return $_SERVER['SERVER_NAME'];
		}
		return false;
	}

	/**
	 * Enforce secure connection
	 */
	public function forceSecure()
	{
		if (!$this->isSecure())
		{
			$url = sprintf('https://%s%s', $this->getHost(), $_SERVER['REQUEST_URI']);
			header("Location: $url", true, 301);
		}
	}

	public function dispatch(RequestAwareInterface $owner)
	{
		$path = null;
		$view = null;
		$urlPath = $this->getPath();
		$basePath = sprintf('%s/%s/%s', $owner->getRootPath(), $owner->getContentPath(), $this->_sanitizeUrl($urlPath));
		$this->resolve($owner, $path, $view);
		$this->handler = new RequestHandler;
		return $this->handler->handle($owner, $basePath, $path, $view);
	}

	public function canHandle(RequestAwareInterface $owner)
	{
		$path = null;
		$view = null;
		$this->resolve($owner, $path, $view);
		return $view || $path;
	}

	public function getFileName(RequestAwareInterface $owner)
	{
		$path = null;
		$view = null;
		$this->resolve($owner, $path, $view);
		return $path;
	}

	public function getData()
	{
		return $this->handler ? $this->handler->getData() : [];
	}

	/**
	 * Request path, will auto detect if not set.
	 * @return string
	 */
	public function getPath()
	{
		if (null === $this->path)
		{
			$this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		}
		return $this->path;
	}

	/**
	 * Set request path. If not set, it will take from $_SERVER vars
	 * @param string $path
	 * @return static
	 */
	public function setPath($path)
	{
		$this->path = $path;
		return $this;
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

	private function resolve($owner, &$path, &$view)
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
					return;
				}
			}
		}
	}

}
