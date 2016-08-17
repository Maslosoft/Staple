<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/staple
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @link http://maslosoft.com/staple/
 */

namespace Maslosoft\Staple;

use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\Staple\Interfaces\PostProcessorInterface;
use Maslosoft\Staple\Interfaces\PreProcessorInterface;
use Maslosoft\Staple\Interfaces\RendererExtensionInterface;
use Maslosoft\Staple\Interfaces\RendererInterface;
use Maslosoft\Staple\Interfaces\RequestAwareInterface;
use Maslosoft\Staple\Interfaces\RequestInterface;
use Maslosoft\Staple\Processors\Post\TemplateApplier;
use Maslosoft\Staple\Processors\Pre\CascadingDataJsonExtractor;
use Maslosoft\Staple\Processors\Pre\DataJsonExtractor;
use Maslosoft\Staple\Processors\Pre\TagExtractor;
use Maslosoft\Staple\Processors\Pre\ViewJsonExtractor;
use Maslosoft\Staple\Renderers\ErrorRenderer;
use Maslosoft\Staple\Renderers\HtmlRenderer;
use Maslosoft\Staple\Renderers\MdRenderer;
use Maslosoft\Staple\Renderers\PassThroughRenderer;
use Maslosoft\Staple\Renderers\PhpMdRenderer;
use Maslosoft\Staple\Renderers\PhpRenderer;
use Maslosoft\Staple\Renderers\ThumbRenderer;

/**
 * @method Staple fly() Get staple flyweight instance
 */
class Staple implements RequestAwareInterface
{

	use \Maslosoft\EmbeDi\Traits\FlyTrait;

	const DefaultInstanceId = '.';
	const BootstrapName = '_bootstrap.php';
	const ContentPath = '_content';
	const LayoutPath = '_layout';

	/**
	 * Version number holder
	 * @var string
	 */
	private static $version;

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
		'md.php' => PhpMdRenderer::class,
		'md' => MdRenderer::class,
		'html' => HtmlRenderer::class,
		'thumb.jpg' => ThumbRenderer::class,
		'thumb.gif' => ThumbRenderer::class,
		'thumb.png' => ThumbRenderer::class,
		'jpg' => PassThroughRenderer::class,
		'gif' => PassThroughRenderer::class,
		'png' => PassThroughRenderer::class,
		'svg' => PassThroughRenderer::class,
		'pdf' => PassThroughRenderer::class,
	];
	public $preProcessors = [
		DataJsonExtractor::class,
		CascadingDataJsonExtractor::class,
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
	private $rootPath = '';

	/**
	 * Relative path to content files. This defaults to `_content`
	 * @var string
	 */
	private $contentPath = self::ContentPath;

	/**
	 * Relative path to layout files. This defaults to `_layout`
	 * @var string
	 */
	private $layoutPath = self::LayoutPath;

	/**
	 * DI container
	 * @var EmbeDi
	 */
	private $di = null;

	/**
	 *
	 * @param string $rootPath
	 */
	public function __construct($rootPath = '')
	{
		$this->di = EmbeDi::fly();
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
			$post[] = $this->di->apply($config);
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
			$pre[] = $this->di->apply($config);
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
		$this->rootPath = $path;
		return $this;
	}

	/**
	 * Get root path. Will try to autodetect if empty.
	 * @return string
	 */
	public function getRootPath()
	{
		// Guess if empty
		if (empty($this->rootPath))
		{
			$this->rootPath = __DIR__ . '../../../../';
		}
		return $this->rootPath;
	}

	public function getContentPath($absolute = false)
	{
		if ($absolute)
		{
			return sprintf('%s/%s', $this->getRootPath(), $this->contentPath);
		}
		return $this->contentPath;
	}

	public function setContentPath($contentPath)
	{
		$this->contentPath = $contentPath;
		return $this;
	}

	public function getLayoutPath()
	{
		return $this->layoutPath;
	}

	public function setLayoutPath($layoutPath)
	{
		$this->layoutPath = $layoutPath;
		return $this;
	}

	/**
	 * Get current staple version
	 * @return string
	 */
	public function getVersion()
	{
		if (null === self::$version)
		{
			self::$version = require __DIR__ . '/version.php';
		}
		return self::$version;
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
			$matches = [];
			$ext = preg_quote($extension);
			if (preg_match("~$ext$~i", $fileName, $matches))
			{
				$renderer = $this->di->apply($config);
				/* @var $renderer RendererInterface */
				if ($renderer instanceof RendererExtensionInterface)
				{
					// Use $matches[0] here to ensure extension letters case
					$renderer->setExtension($matches[0]);
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
