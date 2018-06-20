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
				], true);
	}

}
