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

namespace Maslosoft\Staple\Interfaces;

/**
 * Implement this interface to denote that renderer is navigable.
 * 
 * This means, that this renderer should be included in menus, 
 * and url handled by this render should be directly visited by user browser.
 *
 * Examples of navigable file types:
 *
 * * php
 * * html
 * * md
 *
 * Examples of **not** navigable files/types (assets):
 *
 * * jpg
 * * png
 * * pdf
 * * error pages
 * 
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
interface NavigableInterface
{
	//put your code here
}
