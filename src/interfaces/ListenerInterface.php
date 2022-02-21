<?php

declare(strict_types = 1);

namespace mepihindeveloper\components\interfaces;

use Psr\EventDispatcher\StoppableEventInterface;

interface ListenerInterface {
	
	/**
	 * Выполняет действие слушателя
	 *
	 * @return mixed
	 */
	public function process(StoppableEventInterface $event);
}