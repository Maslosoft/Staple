<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Processors\Post;

use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Interfaces\PostProcessorInterface;
use Maslosoft\Staple\Interfaces\RendererAwareInterface;

/**
 * TemplateApplier
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class TemplateApplier implements PostProcessorInterface
{

	public $template = 'main';

	public function decorate(RendererAwareInterface $owner, &$content, $data)
	{
		$template = empty($data['template']) ? $this->template : $data['template'];
		$view = new MiniView($this, sprintf('%s/%s', $owner->getRootPath(), $owner->getLayoutPath()));
		$view->setViewsPath('');
		$data['content'] = $content;
		$content = $view->render($template, [
			'data' => (object) $data,
			'view' => $view,
		]);
	}

}
