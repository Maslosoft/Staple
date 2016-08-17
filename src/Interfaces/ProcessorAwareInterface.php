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
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
interface ProcessorAwareInterface
{

	/**
	 * @return PreProcessorInterface[]
	 */
	public function getPreProcessors();

	/**
	 * @return PostProcessorInterface[]
	 */
	public function getPostProcessors();
}
