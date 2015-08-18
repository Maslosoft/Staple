<?php

/**
 * This software package is licensed under `AGLP, Commercial` license[s].
 *
 * @package maslosoft/staple
 * @license AGLP, Commercial
 *
 * @copyright Copyright (c) Peter Maselkowski <pmaselkowski@gmail.com>
 *
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
