<?php

use Codeception\Test\Unit;
use mepihindeveloper\components\Event;
use mepihindeveloper\components\exceptions\EventNotFoundException;
use mepihindeveloper\components\exceptions\ListenerNotFoundException;
use mepihindeveloper\components\interfaces\ListenerInterface;
use mepihindeveloper\components\ListenerProvider;
use Psr\EventDispatcher\StoppableEventInterface;

class ListenerProviderTest extends Unit {
	
	/**
	 * @var UnitTester
	 */
	protected $tester;
	protected ?ListenerProvider $listenerProvider;
	protected ?Event $eventOne;
	protected ?Event $eventTwo;
	protected ?ListenerInterface $listenerEventOne;
	protected ?ListenerInterface $listenerEventTwo;
	
	public function testAddListenerForEventType() {
		$this->listenerProvider->addListenerForEventType($this->listenerEventOne, get_class($this->eventOne));
		$this->assertArrayHasKey(get_class($this->eventOne), $this->listenerProvider->getListeners());
		
		$eventListeners = $this->listenerProvider->getListenersForEventType(get_class($this->eventOne));
		$listenerClass = get_class($this->listenerEventOne);
		
		foreach ($eventListeners as $eventListener) {
			if (get_class($eventListener) === $listenerClass) {
				$this->assertTrue(get_class($eventListener) === $listenerClass);
			}
		}
		
		return $this->listenerProvider;
	}
	
	/**
	 * @depends testAddListenerForEventType
	 */
	public function testHasEventType($listenerProvider) {
		$listenerProvider->addListenerForEventType($this->listenerEventOne, get_class($this->eventOne));
		$this->assertTrue($listenerProvider->hasEventType(get_class($this->eventOne)));
	}
	
	/**
	 * @depends testAddListenerForEventType
	 */
	public function testHasListenerInEventTypeWithException($listenerProvider) {
		$this->expectException(EventNotFoundException::class);
		$listenerProvider->hasListenerInEventType($this->listenerEventOne, get_class($this->eventTwo));
	}
	
	/**
	 * @depends testAddListenerForEventType
	 */
	public function testHasListenerInEventTypeWithTrue($listenerProvider) {
		$this->assertTrue($listenerProvider->hasListenerInEventType($this->listenerEventOne, get_class($this->eventOne)));
	}
	
	/**
	 * @depends testAddListenerForEventType
	 */
	public function testHasListenerInEventTypeWithFalse($listenerProvider) {
		$this->assertFalse($listenerProvider->hasListenerInEventType($this->listenerEventTwo, get_class($this->eventOne)));
	}
	
	/**
	 * @depends testAddListenerForEventType
	 */
	public function testGetListeners($listenerProvider) {
		$this->assertNotEmpty($listenerProvider->getListeners());
	}
	
	/**
	 * @depends testAddListenerForEventType
	 */
	public function testGetListenersForEventType($listenerProvider) {
		$this->assertNotEmpty($listenerProvider->getListenersForEventType(get_class($this->eventOne)));
	}
	
	/**
	 * @depends testAddListenerForEventType
	 */
	public function testGetListenersForEventTypeWithException($listenerProvider) {
		$this->expectException(EventNotFoundException::class);
		$listenerProvider->getListenersForEventType('test2');
	}
	
	/**
	 * @depends testAddListenerForEventType
	 */
	public function testGetListenersForEvent($listenerProvider) {
		$this->assertNotEmpty($listenerProvider->getListenersForEvent($this->eventOne));
	}
	
	/**
	 * @depends testAddListenerForEventType
	 */
	public function testGetListenersForEventWithException($listenerProvider) {
		$this->expectException(EventNotFoundException::class);
		$listenerProvider->getListenersForEventType(get_class($this->eventTwo));
	}
	
	/**
	 * @depends testAddListenerForEventType
	 */
	public function testRemoveListenersForEventTypeWithExecption($listenerProvider) {
		$this->expectException(EventNotFoundException::class);
		$listenerProvider->removeListenersForEventType(get_class($this->eventTwo));
	}
	
	/**
	 * @depends testAddListenerForEventType
	 */
	public function testRemoveListenersForEventType($listenerProvider) {
		$listenerProvider->removeListenersForEventType(get_class($this->eventOne));
		$this->assertArrayNotHasKey(get_class($this->eventOne), $listenerProvider->getListeners());
	}
	
	public function testRemoveListenerFromEventTypeWithException() {
		$this->listenerProvider->addListenerForEventType($this->listenerEventOne, get_class($this->eventOne));
		$this->expectException(ListenerNotFoundException::class);
		$this->listenerProvider->removeListenerFromEventType($this->listenerEventTwo, get_class($this->eventOne));
	}
	
	public function testRemoveListenerFromEventType() {
		$this->listenerProvider->addListenerForEventType($this->listenerEventOne, get_class($this->eventOne));
		$this->listenerProvider->removeListenerFromEventType($this->listenerEventOne, get_class($this->eventOne));
		$this->assertFalse($this->listenerProvider->hasListenerInEventType($this->listenerEventOne, get_class($this->eventOne)));
	}
	
	/**
	 * @depends testAddListenerForEventType
	 */
	public function testRemoveListeners($listenerProvider) {
		$listenerProvider->removeListeners();
		$this->assertEmpty($listenerProvider->getListeners());
	}
	
	protected function _before() {
		$this->listenerProvider = $this->make(ListenerProvider::class);
		$this->eventOne = new class extends Event { };
		$this->eventTwo = new class extends Event { };
		$this->listenerEventOne = new class implements ListenerInterface {
			
			public function process(StoppableEventInterface $event) {
				echo "Я " . get_class($this) . " слушаю событие " . get_class($event) . PHP_EOL;
			}
		};
		$this->listenerEventTwo = new class implements ListenerInterface {
			
			public function process(StoppableEventInterface $event) {
				echo "Я " . get_class($this) . " слушаю событие " . get_class($event) . PHP_EOL;
			}
		};
	}
	
	// tests
	
	protected function _after() {
		$this->listenerProvider = null;
		$this->eventOne = null;
		$this->eventTwo = null;
		$this->listenerEventOne = null;
		$this->listenerEventTwo = null;
	}
}