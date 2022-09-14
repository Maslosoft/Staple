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

namespace Maslosoft\Staple\Helpers;

use Maslosoft\Staple\Interfaces\ProcessorAwareInterface;
use Maslosoft\Staple\Interfaces\RendererAwareInterface;
use Maslosoft\Staple\Interfaces\RendererInterface;
use Maslosoft\Staple\Models\RequestItem;
use Maslosoft\Staple\Staple;
use UnexpectedValueException;

/**
 * AbstractWalker
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class AbstractWalker implements RendererAwareInterface,
		ProcessorAwareInterface
{

	/**
	 * Staple instance
	 * @var Staple
	 */
	protected $staple = null;

	/**
	 * Scanning path
	 * @var string
	 */
	protected $path = '';

	/**
	 * Base path, as set in constructor
	 * @var string
	 */
	protected $basePath = '';

	/**
	 * Path relative to base path
	 * @var string
	 */
	protected $relativePath = '';

	/**
	 * Root item instance
	 * @var RequestItem
	 */
	protected $item = null;

	public function __construct($path = '', Staple $staple = null)
	{
		if ($staple)
		{
			$this->staple = $staple;
		}
		else
		{
			$this->staple = Staple::fly();
		}
		if (empty($path))
		{
			$path = $this->staple->getContentPath(true);
		}
		$this->path = realpath(rtrim($path, '/\\'));
		if (empty($this->path))
		{
			throw new UnexpectedValueException("Path `$path` does not exists");
		}
		$this->basePath = $this->path;
		$this->item = new RequestItem;
	}

	public function getContentPath(): string
	{
		return $this->staple->getContentPath();
	}

	public function getLayoutPath(): string
	{
		return $this->staple->getLayoutPath();
	}

	public function getPostProcessors(): array
	{
		return $this->staple->getPostProcessors();
	}

	public function getPreProcessors(): array
	{
		return $this->staple->getPreProcessors();
	}

	public function getRenderer($filename): RendererInterface
	{
		return $this->staple->getRenderer($filename);
	}

	public function getRootPath(): string
	{
		return $this->staple->getRootPath();
	}

	public function setLayoutPath($layoutPath): void
	{
		$this->staple->setLayoutPath($layoutPath);
	}

}
