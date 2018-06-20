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

use Maslosoft\Staple\Interfaces\RequestInterface;

/**
 *
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class DirectoryRequest extends HttpRequest implements RequestInterface
{

	/**
	 * 
	 * @var string
	 */
	private $path = '';

	public function __construct($path)
	{
		$this->path = $path;
	}

	public function getPath()
	{
		return $this->path;
	}

}
