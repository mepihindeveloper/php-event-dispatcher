# php-event-dispatcher

![release](https://img.shields.io/github/v/release/mepihindeveloper/php-event-dispatcher?label=version)
[![Packagist Version](https://img.shields.io/packagist/v/mepihindeveloper/php-event-dispatcher)](https://packagist.org/packages/mepihindeveloper/php-event-dispatcher)
[![PHP Version Require](http://poser.pugx.org/mepihindeveloper/php-event-dispatcher/require/php)](https://packagist.org/packages/mepihindeveloper/php-event-dispatcher)
![license](https://img.shields.io/github/license/mepihindeveloper/php-event-dispatcher)

![build](https://github.com/mepihindeveloper/php-event-dispatcher/actions/workflows/php.yml/badge.svg?branch=development)
[![codecov](https://codecov.io/gh/mepihindeveloper/php-event-dispatcher/branch/development/graph/badge.svg?token=36PP7VKHKG)](https://codecov.io/gh/mepihindeveloper/php-event-dispatcher)

Компонент для работы с событиями и слушателями

# Структура

```
src/
--- exceptions/
------ EventNotFoundException.php
------ ListenerNotFoundException
--- interfaces/
------ ListenerInterface.php
--- Event.php
--- EventDispatcher.php
--- ListenerProvider.php
```

В директории `interfaces` хранятся необходимые интерфейсы, которые необходимо имплементировать в при реализации 
собственного класса `Listener`. Класс `Listener` выступает в качестве слушателя события и должен реализовать метод
`process`. В директории `exceptions` хранятся необходимые исключения. Исключение `EventNotFoundException` необходимо
для идентификации ошибки поиска события (когда событие не было найдено), аналогично и для `ListenerNotFoundException`.

Класс `Event` реализует само событие. Собственные события должны наследоваться от класса `Event`.

Класс `EventDispatcher` реализует диспетчер событий, который работает через `ListenerProvider`, выступая посредником.

Класс `ListenerProvider` реализует поставщика слушателей, где происходят все операции со слушателями и событиями.

Примерная реализация событий и слушателей:

```php
<?php

declare(strict_types = 1);

use mepihindeveloper\components\Event;
use mepihindeveloper\components\EventDispatcher;
use mepihindeveloper\components\interfaces\ListenerInterface;
use mepihindeveloper\components\ListenerProvider;
use Psr\EventDispatcher\StoppableEventInterface;

require_once __DIR__ . '/vendor/autoload.php';

class Event1 extends Event { }

class Event2 extends Event { }

class Event1Listener1 implements ListenerInterface {
	public function process(StoppableEventInterface $event) {
		echo "Я " . get_class($this) . " слушаю событие " . get_class($event) . PHP_EOL;
	}
}

class Event2Listener1 implements ListenerInterface {
	public function process(StoppableEventInterface $event) {
		echo "Я " . get_class($this) . " слушаю событие " . get_class($event) . PHP_EOL;
	}
}

class Event2Listener2 implements ListenerInterface {
	public function process(StoppableEventInterface $event) {
		echo "Я " . get_class($this) . " слушаю событие " . get_class($event) . PHP_EOL;
	}
}

class AllEventsListener implements ListenerInterface {
	public function process(StoppableEventInterface $event) {
		echo "Я " . get_class($this) . " слушаю событие " . get_class($event) . PHP_EOL;
	}
}

$event1 = new Event1;
$event2 = new Event2;
$event1Listener1 = new Event1Listener1;
$event2Listener1 = new Event2Listener1;
$event2Listener2 = new Event2Listener2;
$allEventsListener = new AllEventsListener;

$listenerProvider = new ListenerProvider;
$listenerProvider
	->addListenerForEventType($event1Listener1, Event1::class)
	->addListenerForEventType($event2Listener1, Event2::class)
	->addListenerForEventType($event2Listener2, Event2::class)
	->addListenerForEventType($allEventsListener);

$dispatcher = new EventDispatcher($listenerProvider);
$dispatcher->dispatch($event1);
$dispatcher->dispatch($event2);
```


# Доступные методы

## Event

| Метод                | Аргументы | Возвращаемые данные | Исключения | Описание                                        |
|----------------------|-----------|---------------------|------------|-------------------------------------------------|
| stopPropagation      |           | void                |            | Останавливает работу (распространение) события  |
| isPropagationStopped |           | bool                |            | См. Psr\EventDispatcher\StoppableEventInterface |

## EventDispatcher

| Метод                                                    | Аргументы                    | Возвращаемые данные       | Исключения             | Описание                               |
|----------------------------------------------------------|------------------------------|---------------------------|------------------------|----------------------------------------|
| __construct(ListenerProviderInterface  $listenerProvider | Провайдер слушателей событий | void                      |                        |                                        |
| dispatch(object $event)                                  | Объект события               | bool                      | EventNotFoundException | Отправляет событие слушателям          |
| getListenerProvider                                      |                              | ListenerProviderInterface |                        | Получает провайдера слушателей событий |

## ListenerProvider

| Метод                                                                                                  | Аргументы                                         | Возвращаемые данные | Исключения                                        | Описание                                          |
|--------------------------------------------------------------------------------------------------------|---------------------------------------------------|---------------------|---------------------------------------------------|---------------------------------------------------|
| addListenerForEventType(ListenerInterface $listener, string $eventType = self::DEFAULT_EVENT_TYPE)     | $listener -   Слушатель; $eventType - Тип события | ListenerProvider    |                                                   | Добавляет слушателя                               |
| removeListenerFromEventType(ListenerInterface $listener, string $eventType = self::DEFAULT_EVENT_TYPE) | $listener -   Слушатель; $eventType - Тип события | ListenerProvider    | EventNotFoundException; ListenerNotFoundException | Удаляет слушателя события                         |
| hasListenerInEventType(ListenerInterface $listener, string $eventType = self::DEFAULT_EVENT_TYPE)      | $listener -   Слушатель; $eventType - Тип события | bool                | EventNotFoundException                            | Проверяет наличие слушателя в событии             |
| hasEventType(string $eventType = self::DEFAULT_EVENT_TYPE)                                             | Тип события                                       | bool                |                                                   | Проверяет наличие типа события                    |
| removeListenersForEventType(string $eventType = self::DEFAULT_EVENT_TYPE)                              | Тип события                                       | ListenerProvider    | EventNotFoundException                            | Удаляет слушателей события                        |
| removeListeners                                                                                        |                                                   | ListenerProvider    |                                                   | Удаляет всех слушателей всех событий              |
| getListenersForEvent(object $event)                                                                    | См. Psr\EventDispatcher\ListenerProviderInterface | iterable            | EventNotFoundException                            | См. Psr\EventDispatcher\ListenerProviderInterface |
| getListenersForEventType(string $eventType)                                                            | Тип события                                       | array               | EventNotFoundException                            | Получает слушателей события                       |
| getListeners                                                                                           |                                                   | array               |                                                   | Получает всех слушателей всех событий             |

# Контакты

Вы можете связаться со мной в социальной сети ВКонтакте: [ВКонтакте: Максим Епихин](https://vk.com/maximepihin)

Если удобно писать на почту, то можете воспользоваться этим адресом: mepihindeveloper@gmail.com

Мой канал на YouTube, который посвящен разработке веб и игровых
проектов: [YouTube: Максим Епихин](https://www.youtube.com/channel/UCKusRcoHUy6T4sei-rVzCqQ)

Поддержать меня можно переводом на Яндекс.Деньги: [Денежный перевод](https://yoomoney.ru/to/410012382226565)
