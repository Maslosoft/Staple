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

namespace Maslosoft\Staple;

use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\Staple\Interfaces\PostProcessorInterface;
use Maslosoft\Staple\Interfaces\PreProcessorInterface;
use Maslosoft\Staple\Interfaces\RendererInterface;
use Maslosoft\Staple\Interfaces\RequestAwareInterface;
use Maslosoft\Staple\Interfaces\RequestInterface;
use Maslosoft\Staple\Processors\Post\TemplateApplier;
use Maslosoft\Staple\Processors\Pre\DataJsonExtractor;
use Maslosoft\Staple\Processors\Pre\TagExtractor;
use Maslosoft\Staple\Processors\Pre\ViewJsonExtractor;
use Maslosoft\Staple\Renderers\ErrorRenderer;
use Maslosoft\Staple\Renderers\HtmlRenderer;
use Maslosoft\Staple\Renderers\MdRenderer;
use Maslosoft\Staple\Renderers\PassThroughRenderer;
use Maslosoft\Staple\Renderers\PhpMdRenderer;
use Maslosoft\Staple\Renderers\PhpRenderer;

class Staple implements RequestAwareInterface
{

	const BootstrapName = '_bootstrap.php';
	const ContentPath = '_content';
	const LayoutPath = '_layout';

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
		'jpg' => PassThroughRenderer::class,
		'gif' => PassThroughRenderer::class,
		'png' => PassThroughRenderer::class,
		'svg' => PassThroughRenderer::class,
		'pdf' => PassThroughRenderer::class,
	];
	public $preProcessors = [
		DataJsonExtractor::class,
		ViewJsonExtractor::class,
		TagExtractor::class
	];
	public $postProcessors = [
		TemplateApplier::class
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
	 * Relative path to layout files. This defaults to `_layout`
	 * @var string
	 */
	private $_layoutPath = self::LayoutPath;

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
		$this->_di = EmbeDi::fly();
		$this->setRootPath($rootPath);
	}

	/**
	 * Get Post processors
	 * @return PostProcessorInterface[]
	 */
	public function getPostProcessors()
	{
		$post = [];
		foreach ($this->postProcessors as $config)
		{
			$post[] = $this->_di->apply($config);
		}
		return $post;
	}

	/**
	 * Get Pre Processors
	 * @return PreProcessorInterface[]
	 */
	public function getPreProcessors()
	{
		$pre = [];
		foreach ($this->preProcessors as $config)
		{
			$pre[] = $this->_di->apply($config);
		}
		return $pre;
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

	public function getLayoutPath()
	{
		return $this->_layoutPath;
	}

	public function setLayoutPath($layoutPath)
	{
		$this->_layoutPath = $layoutPath;
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
		if (empty($fileName))
		{
			return (new ErrorRenderer('404', 'File not found'))->setOwner($this);
		}
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
				if ($renderer instanceof Interfaces\RendererExtensionInterface)
				{
					$renderer->setExtension($extension);
				}
				$renderer->setOwner($this);
				return $renderer;
			}
		}
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
