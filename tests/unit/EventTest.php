<?php

use Codeception\Test\Unit;
use mepihindeveloper\components\Event;

class EventTest extends Unit {
	
	/**
	 * @var UnitTester
	 */
	protected $tester;
	protected ?Event $event;
	
	public function testStopPropagation() {
		$this->assertFalse($this->event->isPropagationStopped());
		$this->event->stopPropagation();
		$this->assertTrue($this->event->isPropagationStopped());
	}
	
	public function testIsPropagationStopped() {
		$this->assertIsBool($this->event->isPropagationStopped());
	}
	
	protected function _before() {
		$this->event = $this->make(Event::class);
	}
	
	protected function _after() {
		$this->event = null;
	}
}