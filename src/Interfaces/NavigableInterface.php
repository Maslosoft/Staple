<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
