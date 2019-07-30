<?php

namespace Shevsky\Discount4Review\Domain\Wa\TemplateBuilderPersistence;

use Shevsky\Discount4Review\Domain\Wa\Env\Env;
use Shevsky\Discount4Review\Persistence\Template\ITemplate;
use Shevsky\Discount4Review\Persistence\Template\ITemplateBuilder;
use Shevsky\Discount4Review\Service\SettingsService;

abstract class TemplateBuilder implements ITemplateBuilder
{
	protected $template;
	protected $settings_service;
	protected $env;

	private $dependencies = [];

	/**
	 * @param ITemplate $template
	 * @param SettingsService $settings_service
	 * @param Env $env
	 */
	public function __construct(ITemplate $template, SettingsService $settings_service, Env $env)
	{
		$this->template = $template;
		$this->settings_service = $settings_service;
		$this->env = $env;
	}

	/**
	 * @param mixed[] $dependencies
	 */
	public function pushDependencies(array $dependencies)
	{
		$this->dependencies = array_merge($this->dependencies, $dependencies);
	}

	/**
	 * @param mixed[] $vars
	 */
	abstract public function build(array $vars = []);

	public function render()
	{
		return $this->template->render();
	}
}