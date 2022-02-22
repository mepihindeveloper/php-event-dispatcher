<?php

declare(strict_types = 1);

namespace mepihindeveloper\components;

use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Класс Event
 *
 * Реализует логику работы события
 *
 * @package mepihindeveloper\components
 */
class Event implements StoppableEventInterface {
	
	/** @var bool Показывает, должны ли слушатели события учитывать событие */
	private bool $isPropagationStopped = false;
	
	/**
	 * Останавливает работу (распространение) события
	 *
	 * @return void
	 */
	public function stopPropagation(): void {
		$this->isPropagationStopped = true;
	}
	
	/**
	 * @inheritDoc
	 */
	public function isPropagationStopped(): bool {
		return $this->isPropagationStopped;
	}
}