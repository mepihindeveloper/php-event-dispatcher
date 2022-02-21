<?php

declare(strict_types = 1);

namespace mepihindeveloper\components;

use mepihindeveloper\components\exceptions\EventNotFoundException;
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
	public function addListener(ListenerInterface $listener, string $eventType = self::DEFAULT_EVENT_TYPE):self {
		$this->listeners[$eventType][] = $listener;
		
		return $this;
	}
	
	/**
	 * Получает слушателей события
	 *
	 * @param string $eventType Тип события
	 *
	 * @return array Массив слушателей события
	 */
	public function getListenersForEventType(string $eventType):array {
		return $this->hasEventType($eventType) ? $this->listeners[$eventType] : [];
	}
	
	/**
	 * Удаляет слушателей события
	 *
	 * @param string $eventType Тип события
	 *
	 * @return $this
	 * @throws EventNotFoundException
	 */
	public function removeListenersByEventType(string $eventType = self::DEFAULT_EVENT_TYPE): self {
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
	public function clearListeners():self {
		$this->listeners = [];
		
		return $this;
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
	 * @inheritDoc
	 */
	public function getListenersForEvent(object $event): iterable {
		return $this->getListenersForEventType(get_class($event));
	}
	
	/**
	 * Получает всех слушателей всех событий
	 *
	 * @return array Массив всех слушателей всех события
	 */
	public function getListeners():array {
		return $this->listeners;
	}
}