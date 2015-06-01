<?php

namespace Maslosoft\Staple;

use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\Staple\Interfaces\RequestAwareInterface;
use Maslosoft\Staple\Interfaces\RequestInterface;

class Staple implements RequestAwareInterface
{

	public $renderers = [
		'php' => PhpRenderer::class,
		'php.md' => PhpMdRenderer::class,
		'md' => MdRenderer::class,
		''
	];
	private static $_version;
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

	public function getRenderer($fileName)
	{
		$renderers = $this->renderers;
		$keys = array_map('strlen', array_keys($renderers));
		array_multisort($keys, SORT_DESC, $renderers);
		foreach ($renderers as $extension => $config)
		{
			$ext = preg_quote($extension);
			if (preg_match("~$ext$~"))
			{
				/**
				 * TODO Use DI here to allow configurable renderers
				 */
				$this->_di->apply($config);
				return new $config;
			}
		}
	}

	public function getExtensions()
	{
		return array_keys($this->renderers);
	}

	public function handle(RequestInterface $request)
	{
		$request->dispatch($this);
	}

}
