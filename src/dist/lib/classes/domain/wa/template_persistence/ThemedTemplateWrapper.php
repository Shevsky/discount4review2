<?php

namespace Shevsky\Discount4Review\Domain\Wa\TemplatePersistence;

use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Domain\Wa\AssetPersistence\CSSAsset;
use Shevsky\Discount4Review\Domain\Wa\AssetPersistence\JSAsset;
use Exception;

class ThemedTemplateWrapper extends Template
{
	private $template;

	public function __construct(ThemedTemplate $template)
	{
		$this->template = $template;
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	protected function getPath()
	{
		$path = Context::getPluginPath()
			. "templates/container/{$this->template->getName()}.{$this->template->getExtension()}";
		if (!file_exists($path))
		{
			throw new Exception("Не найден шаблон для обертки \"{$this->template->getName()}\"");
		}

		return $path;
	}

	/**
	 * @return JSAsset[]
	 */
	public function getJS()
	{
		return $this->template->getJS();
	}

	/**
	 * @return CSSAsset[]
	 */
	public function getCSS()
	{
		return $this->template->getCSS();
	}

	/**
	 * @return bool
	 */
	public function exists()
	{
		try
		{
			$this->getPath();

			return true;
		}
		catch (Exception $e)
		{
			return false;
		}
	}

	/**
	 * @return string
	 */
	public function read()
	{
		return $this->template->read();
	}

	/**
	 * @param string $value
	 */
	public function write($value)
	{
		$this->template->write($value);
	}

	/**
	 * @param mixed[] $vars
	 */
	public function assign(array $vars)
	{
		parent::assign($vars);

		$this->template->assign($vars);
	}

	/**
	 * @return string
	 */
	public function render()
	{
		$this->preRender();

		return parent::render();
	}

	private function preRender()
	{
		$this->template->enable_js = false;
		$this->template->enable_css = false;

		$this->assign(
			[
				'template' => $this->template->render(),
			]
		);
	}
}