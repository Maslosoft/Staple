<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Processors\Post;

use Maslosoft\Staple\Interfaces\PostProcessorInterface;

/**
 * TemplateApplier
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class TemplateApplier implements PostProcessorInterface
{

	public $template = 'main';

	public function decorate(&$content, $data)
	{
		$content = sprintf("DRAFT OF %s and %s %s", __CLASS__, PostProcessorInterface::class, $content);
		$content = "<html><head><title>{$data['title']}</title></head><body>$content</body></html>";
	}

}
