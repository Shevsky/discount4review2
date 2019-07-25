<?php

namespace Shevsky\Discount4Review\Domain\Wa\TemplatePersistence;

use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Persistence\Access\ITheme;
use waFiles;

abstract class ThemedTemplate extends Template
{
	private $theme;

	/**
	 * @param ITheme $theme
	 */
	public function __construct(ITheme $theme)
	{
		$this->theme = $theme;
	}

	/**
	 * @return string
	 */
	abstract public function getName();

	/**
	 * @return string
	 */
	abstract public function getExtension();

	/**
	 * @return string
	 */
	abstract protected function getSourceTemplate();

	/**
	 * @return string
	 */
	abstract protected function getThemeTemplate();

	/**
	 * @return string
	 */
	private function getSourcePath()
	{
		if ($this->getExtension() === 'html')
		{
			return Context::getPluginPath() . "templates/{$this->getSourceTemplate()}";
		}
		elseif ($this->getExtension() === 'css')
		{
			return Context::getPluginPath() . "css/{$this->getSourceTemplate()}";
		}

		return null;
	}

	/**
	 * @return string
	 */
	private function getThemePath()
	{
		return $this->theme->getPath() . '/' . $this->getThemeTemplate();
	}

	/**
	 * @return bool
	 */
	private function hasThemeTemplate()
	{
		return file_exists($this->getThemePath());
	}

	/**
	 * @return string
	 */
	protected function getPath()
	{
		if ($this->hasThemeTemplate())
		{
			return $this->getThemePath();
		}
		else
		{
			return $this->getSourcePath();
		}
	}

	/**
	 * @param string $value
	 */
	public function write($value)
	{
		$path = $this->getThemePath();

		$this->theme->setFile($path, $value);
		waFiles::write($path, $value);
	}
}