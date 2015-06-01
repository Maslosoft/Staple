<?php

namespace Maslosoft\Staple;

use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\Staple\Interfaces\RendererInterface;
use Maslosoft\Staple\Interfaces\RequestAwareInterface;
use Maslosoft\Staple\Interfaces\RequestInterface;
use Maslosoft\Staple\Renderers\HtmlRenderer;
use Maslosoft\Staple\Renderers\MdRenderer;
use Maslosoft\Staple\Renderers\NullRenderer;
use Maslosoft\Staple\Renderers\PhpMdRenderer;
use Maslosoft\Staple\Renderers\PhpRenderer;

class Staple implements RequestAwareInterface
{

	const BootstrapName = '_bootstrap.php';

	/**
	 * Version number holder
	 * @var string
	 */
	private static $_version;

	/**
	 * Renderers configuration. Keys are file extensions,
	 * values are renderers class name or configuration supported by EmbeDi.
	 *
	 * For available configuration options see renderer class.
	 *
	 * Example configuration:
	 * ```
	 * public $renderers = [
	 * 		'php' => PhpRenderer::class,
	 * 		'php.md' => PhpMdRenderer::class,
	 * 		'md' => [
	 * 			'class' => MdRenderer::class,
	 * 			'extension' => 'mkd'
	 * 		],
	 * 		'html' => [
	 * 			'class' => HtmlRenderer::class,
	 * 			'extension' => 'htm'
	 * 		],
	 * 	];
	 * ```
	 * @var mixed[]
	 */
	public $renderers = [
		'php' => PhpRenderer::class,
		'php.md' => PhpMdRenderer::class,
		'md' => MdRenderer::class,
		'html' => HtmlRenderer::class,
	];
	public $preProcessors = [
	];
	public $postProcessors = [
	];

	/**
	 * Root path of website
	 * @var string
	 */
	private $_rootPath = '';

	/**
	 * DI container
	 * @var EmbeDi
	 */
	private $_di = null;

	public function __construct()
	{
		$this->_di = new EmbeDi();
	}

	public function setRootPath($path)
	{
		$this->_rootPath = $path;
	}

	public function getRootPath()
	{
		return $this->_rootPath;
	}

	public function getVersion()
	{
		if (null === self::$_version)
		{
			self::$_version = require __DIR__ . '/version.php';
		}
		return self::$_version;
	}

	/**
	 * Get renderer
	 * @param string $fileName
	 * @return RendererInterface
	 */
	public function getRenderer($fileName)
	{
		$renderers = $this->renderers;
		$keys = array_map('strlen', array_keys($renderers));
		array_multisort($keys, SORT_DESC, $renderers);
		foreach ($renderers as $extension => $config)
		{
			$ext = preg_quote($extension);
			if (preg_match("~$ext$~", $fileName))
			{
				return $this->_di->apply($config);
			}
		}
// Fallback to null renderer if not found
		return new NullRenderer;
	}

	public function getExtensions()
	{
		return array_keys($this->renderers);
	}

	public function handle(RequestInterface $request)
	{
		return $request->dispatch($this);
	}

}
