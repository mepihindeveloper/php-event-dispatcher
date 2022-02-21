<?php

declare(strict_types = 1);

use mepihindeveloper\components\Event;
use mepihindeveloper\components\EventDispatcher;
use mepihindeveloper\components\interfaces\ListenerInterface;
use mepihindeveloper\components\ListenerProvider;
use Psr\EventDispatcher\StoppableEventInterface;

require_once __DIR__ . '/vendor/autoload.php';

class Event1 extends Event {

}

class Event2 extends Event {

}

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

$event1 = new Event1();
$event2 = new Event2();

$listenerProvider = new ListenerProvider();
$listenerProvider
	->addListener(new Event1Listener1, Event1::class)
	->addListener(new Event2Listener1, Event2::class)
	->addListener(new Event2Listener2, Event2::class)
	->addListener(new AllEventsListener);

$dispatcher = new EventDispatcher($listenerProvider);
$dispatcher->dispatch($event1);
$dispatcher->dispatch($event2);