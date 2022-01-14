<?php

use Codeception\Test\Unit;
use mepihindeveloper\components\Configuration;

class ConfigurationTest extends Unit {
	
	/**
	 * @var UnitTester
	 */
	protected $tester;
	protected ?Configuration $configuration;
	protected array $settings = [
		'lang' => 'ru',
		'debug' => true,
		'database' => [
			'host' => 'localhost',
			'user' => 'root',
			'password' => 123
		]
	];
	
	public function testGetSettings() {
		$this->assertIsArray($this->configuration->getSettings());
	}
	
	public function testSetSettings() {
		$this->configuration->setSettings(['message' => 'test']);
		$this->assertArrayHasKey('message', $this->configuration->getSettings());
	}
	
	public function testHasKey() {
		$this->assertTrue($this->configuration->hasKey('lang'));
	}
	
	public function testHasNotKey() {
		$this->assertFalse($this->configuration->hasKey('message'));
	}
	
	public function testGetSettingsByKey() {
		$this->assertSame('ru', $this->configuration->getSettingsByKey('lang'));
	}
	
	public function testGetSettingsByKeyWithException() {
		$this->expectException(InvalidArgumentException::class);
		$this->configuration->getSettingsByKey('message');
	}
	
	protected function _before() {
		$this->configuration = new Configuration($this->settings);
	}
	
	// tests

	protected function _after() {
		$this->configuration = null;
	}
}