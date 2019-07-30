<?php

namespace Shevsky\Discount4Review\Domain\Wa\TemplatePersistence;

use Shevsky\Discount4Review\Context\Context;
use Shevsky\Discount4Review\Domain\Wa\Env\Env;
use waFiles;

abstract class ThemedTemplate extends Template
{
	private $env;

	/**
	 * @param Env $env
	 */
	public function __construct(Env $env)
	{
		$this->env = $env;
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
		return $this->env->getCurrentTheme()->getPath() . '/' . $this->getThemeTemplate();
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

		$this->env->getCurrentTheme()->setFile($path, $value);
		waFiles::write($path, $value);
	}
}