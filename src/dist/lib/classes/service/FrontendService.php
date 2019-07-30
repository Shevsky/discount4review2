<?php

namespace Shevsky\Discount4Review\Service;

use Shevsky\Discount4Review\Domain\Wa\Env\Env;
use Shevsky\Discount4Review\Domain\Wa\TemplateBuilderDomain\MyOrderTemplateBuilder;
use Shevsky\Discount4Review\Domain\Wa\TemplateDomain\MyOrderTemplate;
use Shevsky\Discount4Review\Domain\Wa\TemplatePersistence\ThemedTemplate;
use Shevsky\Discount4Review\Domain\Wa\TemplatePersistence\ThemedTemplateWrapper;
use Shevsky\Discount4Review\Persistence\Template\ITemplate;
use Exception;

class FrontendService
{
	private $settings_service;
	private $env;

	/**
	 * @param SettingsService $settings_service
	 * @param Env $env
	 */
	public function __construct(SettingsService $settings_service, Env $env)
	{
		$this->settings_service = $settings_service;
		$this->env = $env;
	}

	/**
	 * @param mixed $params
	 * @return string
	 * @throws Exception
	 */
	public function renderMyOrder(array $params)
	{
		$template = $this->wrapTemplate(new MyOrderTemplate($this->env));
		$builder = new MyOrderTemplateBuilder($template, ...$this->getBuilderArgs());

		$builder->build(
			[
				'params' => $params,
			]
		);

		return $builder->render();
	}

	/**
	 * @param ITemplate $template
	 * @return ITemplate
	 * @throws Exception
	 */
	private function wrapTemplate(ITemplate $template)
	{
		/**
		 * @var ThemedTemplate $template
		 */
		$wrapper = new ThemedTemplateWrapper($template);
		if ($wrapper->exists())
		{
			return $wrapper;
		}

		return $template;
	}

	/**
	 * @return mixed[]
	 */
	private function getBuilderArgs()
	{
		return [
			$this->settings_service,
			$this->env,
		];
	}
}