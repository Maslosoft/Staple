<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
