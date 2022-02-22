<?php

declare(strict_types = 1);

namespace mepihindeveloper\components\interfaces;

use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Интерфейс ListenerInterface
 *
 * Декларирует методы обязательные для реализации компонента Listener
 *
 * @package mepihindeveloper\components\interfaces
 */
interface ListenerInterface {
	
	/**
	 * Выполняет действие слушателя
	 *
	 * @return mixed
	 */
	public function process(StoppableEventInterface $event);
}