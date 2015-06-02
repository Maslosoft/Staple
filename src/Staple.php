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
	const ContentPath = '_content';

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
	public $preRender = [
	];
	public $postRender = [
	];

	/**
	 * Absolute root path of website.
	 * This should be path where your main index file resides.
	 * @var string
	 */
	private $_rootPath = '';

	/**
	 * Relative path to content files. This defaults to `_content`
	 * @var string
	 */
	private $_contentPath = self::ContentPath;

	/**
	 * DI container
	 * @var EmbeDi
	 */
	private $_di = null;

	/**
	 *
	 * @param string $rootPath
	 */
	public function __construct($rootPath = '')
	{
		$this->_di = new EmbeDi();
		$this->setRootPath($rootPath);
	}

	/**
	 * Set absolute root path
	 * @param string $path
	 * @return Staple
	 */
	public function setRootPath($path)
	{
		$this->_rootPath = $path;
		return $this;
	}

	/**
	 * Get root path. Will try to autodetect if empty.
	 * @return string
	 */
	public function getRootPath()
	{
		// Guess if empty
		if (empty($this->_rootPath))
		{
			$this->_rootPath = __DIR__ . '../../../../';
		}
		return $this->_rootPath;
	}

	public function getContentPath()
	{
		return $this->_contentPath;
	}

	public function setContentPath($contentPath)
	{
		$this->_contentPath = $contentPath;
		return $this;
	}

	/**
	 * Get current staple version
	 * @return string
	 */
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
				$renderer = $this->_di->apply($config);
				/* @var $renderer RendererInterface */
				$renderer->setOwner($this);
				return $renderer;
			}
		}
		// Fallback to null renderer if not found
		return new Renderers\PassThroughRenderer($fileName);
		/**
		 * TODO Change to ErrorRenderer, this should display error code and error message.
		 * TODO Or pass any content as is.
		 * ```
		 * ```
		 */
		new ErrorRenderer(500, sprintf('Unsupported file extension: `%s`', $ext));
	}

	/**
	 * Get supported file extensions, based on `renderers` configuration.
	 * @return string[]
	 */
	public function getExtensions()
	{
		return array_keys($this->renderers);
	}

	/**
	 * Handle request. This is entry point for staple.
	 * @param RequestInterface $request
	 * @return string
	 */
	public function handle(RequestInterface $request)
	{
		return $request->dispatch($this);
	}

}
