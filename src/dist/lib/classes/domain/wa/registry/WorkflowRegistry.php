<?php

namespace Shevsky\Discount4Review\Domain\Wa\Registry;

use Exception;
use Shevsky\Discount4Review\Persistence\IFactory;
use Shevsky\Discount4Review\Persistence\Order\IOrderAction;
use Shevsky\Discount4Review\Persistence\Order\IOrderState;
use shopWorkflow;
use shopWorkflowAction;
use shopWorkflowState;
use waException;

class WorkflowRegistry
{
	private $factory;
	private $state_registry = [];
	private $action_registry = [];
	private $is_states_filled = false;
	private $is_actions_filled = false;
	private $workflow;

	/**
	 * @param IFactory $factory
	 */
	public function __construct(IFactory $factory)
	{
		$this->factory = $factory;
		$this->workflow = new shopWorkflow();
	}

	/**
	 * @param string $id
	 * @return IOrderState
	 * @throws Exception
	 */
	public function getStateById($id)
	{
		if (!isset($this->state_registry[$id]))
		{
			try
			{
				/**
				 * @var shopWorkflowState $workflow_state
				 */
				$workflow_state = $this->workflow->getStateById($id);
				$this->state_registry[$id] = $this->buildState($workflow_state);
			}
			catch (waException $e)
			{
				throw new Exception($e->getMessage());
			}
		}

		return $this->state_registry[$id];
	}

	/**
	 * @return IOrderState[]
	 */
	public function getStates()
	{
		if ($this->is_states_filled)
		{
			return array_values(
				$this->state_registry
			);
		}

		$workflow_states = $this->workflow->getAllStates();
		foreach ($workflow_states as $id => $workflow_state)
		{
			/**
			 * @var shopWorkflowState $workflow_state
			 */
			$this->state_registry[$id] = $this->buildState($workflow_state);
		}

		$this->is_states_filled = true;

		return array_values($this->state_registry);
	}

	/**
	 * @param string $id
	 * @return IOrderAction
	 */
	public function getActionById($id)
	{
		if (!isset($this->action_registry[$id]))
		{
			/**
			 * @var shopWorkflowAction $workflow_action
			 */
			$workflow_action = $this->workflow->getActionById($id);
			$this->action_registry[$id] = $this->buildAction($workflow_action);
		}

		return $this->action_registry[$id];
	}

	/**
	 * @return IOrderAction[]
	 */
	public function getActions()
	{
		if ($this->is_actions_filled)
		{
			return array_values(
				$this->action_registry
			);
		}

		$workflow_actions = $this->workflow->getAllActions();
		foreach ($workflow_actions as $id => $workflow_action)
		{
			/**
			 * @var shopWorkflowAction $workflow_action
			 */
			$this->action_registry[$id] = $this->buildAction($workflow_action);
		}

		$this->is_actions_filled = true;

		return array_values($this->action_registry);
	}

	/**
	 * @param shopWorkflowState $workflow_state
	 * @return IOrderState
	 */
	private function buildState(shopWorkflowState $workflow_state)
	{
		$style = $workflow_state->getOption('style');

		return $this->factory->createOrderState(
			[
				'id' => $workflow_state->id,
				'name' => $workflow_state->getName(),
				'color' => isset($style['color']) ? $style['color'] : '',
				'icon' => $workflow_state->getOption('icon'),
			]
		);
	}

	/**
	 * @param shopWorkflowAction $workflow_action
	 * @return IOrderAction
	 */
	private function buildAction(shopWorkflowAction $workflow_action)
	{
		return $this->factory->createOrderAction(
			[
				'id' => $workflow_action->id,
				'name' => $workflow_action->getName(),
			]
		);
	}
}