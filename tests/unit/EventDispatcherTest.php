<?php

use Codeception\Test\Unit;
use mepihindeveloper\components\Event;
use mepihindeveloper\components\EventDispatcher;
use mepihindeveloper\components\interfaces\ListenerInterface;
use mepihindeveloper\components\ListenerProvider;
use Psr\EventDispatcher\StoppableEventInterface;

class EventDispatcherTest extends Unit {
	
	/**
	 * @var UnitTester
	 */
	protected $tester;
	protected ?EventDispatcher $dispatcher;
	protected ?ListenerProvider $listenerProvider;
	protected ?Event $eventOne;
	protected ?ListenerInterface $listenerEventOne;
	
	public function testGetListenerProvider() {
		$this->assertInstanceOf(ListenerProvider::class, $this->dispatcher->getListenerProvider());
	}
	
	public function testDispatch() {
		$event = $this->dispatcher->dispatch($this->eventOne);
		$this->assertInstanceOf(Event::class, $event);
	}
	
	public function testDispatchStopped() {
		$this->eventOne->stopPropagation();
		$event = $this->dispatcher->dispatch($this->eventOne);
		$this->assertInstanceOf(Event::class, $event);
		$this->assertTrue($event->isPropagationStopped());
	}
	
	protected function _before() {
		$this->eventOne = new class extends Event { };
		$this->listenerEventOne = new class implements ListenerInterface {
			
			public function process(StoppableEventInterface $event) {
				echo "Я " . get_class($this) . " слушаю событие " . get_class($event) . PHP_EOL;
			}
		};
		$this->listenerProvider = $this->make(ListenerProvider::class);
		$this->listenerProvider->addListenerForEventType($this->listenerEventOne, get_class($this->eventOne));
		$this->dispatcher = new EventDispatcher($this->listenerProvider);
	}
	
	// tests

	protected function _after() {
		$this->listenerProvider = null;
		$this->dispatcher = null;
		$this->eventOne = null;
		$this->listenerEventOne = null;
	}
}