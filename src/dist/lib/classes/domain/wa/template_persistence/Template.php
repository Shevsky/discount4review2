<?php

namespace Shevsky\Discount4Review\Domain\Wa\TemplatePersistence;

use Shevsky\Discount4Review\Domain\Wa\AssetPersistence\CSSAsset;
use Shevsky\Discount4Review\Domain\Wa\AssetPersistence\JSAsset;
use Shevsky\Discount4Review\Persistence\Template\ITemplate;
use waFiles;
use waSmarty3View;

abstract class Template implements ITemplate
{
	public $enable_js = true;
	public $enable_css = true;

	private $view;

	/**
	 * @return string
	 */
	abstract protected function getPath();

	/**
	 * @return waSmarty3View
	 */
	protected function getView()
	{
		if (!isset($this->view))
		{
			$this->view = new waSmarty3View(wa());
		}

		return $this->view;
	}

	/**
	 * @return JSAsset[]
	 */
	public function getJS()
	{
		return [];
	}

	/**
	 * @return CSSAsset[]
	 */
	public function getCSS()
	{
		return [];
	}

	/**
	 * @return string
	 */
	public function read()
	{
		return file_get_contents($this->getPath());
	}

	/**
	 * @param string $value
	 */
	public function write($value)
	{
		waFiles::write($this->getPath(), $value);
	}

	/**
	 * @param mixed[] $vars
	 */
	public function assign(array $vars)
	{
		$this->getView()->assign($vars);
	}

	/**
	 * @return string
	 */
	public function render()
	{
		$this->preRender();

		return $this->getView()->fetch($this->getPath());
	}

	private function preRender()
	{
		$assets = [];

		if ($this->enable_js)
		{
			$assets['js'] = [];
			$js_assets = $this->getJS();

			foreach ($js_assets as $js_asset)
			{
				$assets['js'][] = $js_asset->getFullUrl();
			}
		}

		if ($this->enable_css)
		{
			$assets['css'] = [];
			$css_assets = $this->getCSS();

			foreach ($css_assets as $css_asset)
			{
				$assets['css'][] = $css_asset->getFullUrl();
			}
		}

		$this->assign(
			[
				'assets' => $assets,
			]
		);
	}
}