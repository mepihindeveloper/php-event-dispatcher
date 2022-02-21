<?php

declare(strict_types = 1);

namespace mepihindeveloper\components;

use mepihindeveloper\components\interfaces\ListenerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class EventDispatcher implements EventDispatcherInterface {
	
	/** @var ListenerProviderInterface Провайдер слушателей событий */
	private ListenerProviderInterface $listenerProvider;
	
	/**
	 * @param ListenerProviderInterface $listenerProvider Провайдер слушателей событий
	 */
	public function __construct(ListenerProviderInterface $listenerProvider) {
		$this->listenerProvider = $listenerProvider;
	}
	
	/**
	 * @inheritDoc
	 */
	public function dispatch(object $event) {
		if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
			return $event;
		}
		
		$eventListeners = $this->listenerProvider->getListenersForEvent($event);
		$defaultEventListeners = $this->listenerProvider->getListenersForEventType($this->listenerProvider::DEFAULT_EVENT_TYPE);
		$listeners = !empty($defaultEventListeners) ? array_merge($eventListeners, $defaultEventListeners) : $eventListeners;
		
		/** @var ListenerInterface $listener */
		foreach ($listeners as $listener) {
			$listener->process($event);
		}
		
		return $event;
	}
	
	/**
	 * Получает провайдера слушателей событий
	 *
	 * @return ListenerProviderInterface Провайдер слушателей событий
	 */
	public function getListenerProvider(): ListenerProviderInterface {
		return $this->listenerProvider;
	}
}