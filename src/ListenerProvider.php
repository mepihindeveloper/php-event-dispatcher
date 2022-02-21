<?php

declare(strict_types = 1);

namespace mepihindeveloper\components;

use mepihindeveloper\components\exceptions\EventNotFoundException;
use mepihindeveloper\components\exceptions\ListenerNotFoundException;
use mepihindeveloper\components\interfaces\ListenerInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Класс ListenerProvider
 *
 * Реализует логику работы провайдера слушателей событий
 */
class ListenerProvider implements ListenerProviderInterface {
	
	/** @var string Тип события по умолчанию */
	public const DEFAULT_EVENT_TYPE = '*';
	/** @var array Слушатели событий */
	private array $listeners = [];
	
	/**
	 * Добавляет слушателя
	 *
	 * @param ListenerInterface $listener Слушатель
	 * @param string $eventType Тип события
	 *
	 * @return $this
	 */
	public function addListenerForEventType(ListenerInterface $listener, string $eventType = self::DEFAULT_EVENT_TYPE): self {
		$this->listeners[$eventType][] = $listener;
		
		return $this;
	}
	
	/**
	 * Удаляет слушателя события
	 *
	 * @param ListenerInterface $listener Слушатель
	 * @param string $eventType Тип события
	 *
	 * @return $this
	 * @throws EventNotFoundException
	 * @throws ListenerNotFoundException
	 */
	public function removeListenerFromEventType(ListenerInterface $listener, string $eventType = self::DEFAULT_EVENT_TYPE): self {
		if (!$this->hasListenerInEventType($listener, $eventType)) {
			throw new ListenerNotFoundException("Слушатель " . get_class($listener) . " не найден в событии " . $eventType);
		}
		
		$eventListeners = $this->listeners[$eventType];
		$listenerClass = get_class($listener);
		
		foreach ($eventListeners as $index => $eventListener) {
			if (get_class($eventListener) === $listenerClass) {
				unset($this->listeners[$eventType][$index]);
				break;
			}
		}
		
		return $this;
	}
	
	/**
	 * Проверяет наличие слушателя в событии
	 *
	 * @param ListenerInterface $listener Слушатель
	 * @param string $eventType Тип события
	 *
	 * @return bool
	 * @throws EventNotFoundException
	 */
	public function hasListenerInEventType(ListenerInterface $listener, string $eventType = self::DEFAULT_EVENT_TYPE): bool {
		if (!$this->hasEventType($eventType)) {
			throw new EventNotFoundException("Событие $eventType не было инициализировано");
		}
		
		$eventListeners = $this->listeners[$eventType];
		$listenerClass = get_class($listener);
		
		foreach ($eventListeners as $eventListener) {
			if (get_class($eventListener) === $listenerClass) {
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Проверяет наличие типа события
	 *
	 * @param string $eventType Тип события
	 *
	 * @return bool
	 */
	public function hasEventType(string $eventType = self::DEFAULT_EVENT_TYPE): bool {
		return array_key_exists($eventType, $this->listeners);
	}
	
	/**
	 * Удаляет слушателей события
	 *
	 * @param string $eventType Тип события
	 *
	 * @return $this
	 * @throws EventNotFoundException
	 */
	public function removeListenersForEventType(string $eventType = self::DEFAULT_EVENT_TYPE): self {
		if (!$this->hasEventType($eventType)) {
			throw new EventNotFoundException("Событие $eventType не было инициализировано");
		}
		
		unset($this->listeners[$eventType]);
		
		return $this;
	}
	
	/**
	 * Удаляет всех слушателей всех событий
	 *
	 * @return $this
	 */
	public function removeListeners(): self {
		$this->listeners = [];
		
		return $this;
	}
	
	/**
	 * @inheritDoc
	 */
	public function getListenersForEvent(object $event): iterable {
		return $this->getListenersForEventType(get_class($event));
	}
	
	/**
	 * Получает слушателей события
	 *
	 * @param string $eventType Тип события
	 *
	 * @return array Массив слушателей события
	 */
	public function getListenersForEventType(string $eventType): array {
		if (!$this->hasEventType($eventType)) {
			throw new EventNotFoundException("Событие $eventType не было инициализировано");
		}
		
		return $this->listeners[$eventType];
	}
	
	/**
	 * Получает всех слушателей всех событий
	 *
	 * @return array Массив всех слушателей всех события
	 */
	public function getListeners(): array {
		return $this->listeners;
	}
}