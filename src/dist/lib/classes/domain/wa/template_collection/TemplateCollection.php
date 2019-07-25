<?php

namespace Shevsky\Discount4Review\Domain\Wa\TemplateCollection;

use Shevsky\Discount4Review\Domain\Wa\Env\Env;
use Shevsky\Discount4Review\Domain\Wa\TemplateDomain\MyOrderTemplate;
use Shevsky\Discount4Review\Persistence\Template\ITemplate;
use Shevsky\Discount4Review\Persistence\Template\ITemplateCollection;
use Exception;

class TemplateCollection implements ITemplateCollection
{
	private $env;
	private $templates = [];

	/**
	 * @param Env $env
	 */
	public function __construct(Env $env)
	{
		$this->env = $env;
	}

	private function getTheme()
	{
		return $this->env->getCurrentTheme();
	}

	/**
	 * @param string $name
	 * @return ITemplate
	 * @throws Exception
	 */
	public function getTemplate($name)
	{
		if (!isset($this->templates[$name]))
		{
			$args = [
				$this->getTheme()
			];

			if ($name === 'my_order')
			{
				$this->templates[$name] = new MyOrderTemplate(...$args);
			}
			else
			{
				throw new Exception("Неизвестный шаблон \"{$name}\"");
			}
		}

		return $this->templates[$name];
	}
}