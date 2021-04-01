<?php

declare(strict_types = 1);

namespace mepihindeveloper\components;

use InvalidArgumentException;
use mepihindeveloper\components\interfaces\ConfigurationInterface;

/**
 * Класс Configuration
 *
 * Класс предназначен для управления конфигурациями (настройками) в приложении. Настройки могут быть как для всего
 * проекта, так и для отдельных модулей и компонентов.
 *
 * @package mepihindeveloper\components
 */
class Configuration implements ConfigurationInterface {
	
	/**
	 * @var array Массив настроек
	 */
	protected array $settings;
	
	/**
	 * Configuration constructor.
	 *
	 * @param array $settings Массив настроек
	 */
	public function __construct(array $settings) {
		$this->settings = $settings;
	}
	
	/**
	 * @inheritDoc
	 */
	public function getSettings(): array {
		return $this->settings;
	}
	
	/**
	 * @inheritDoc
	 */
	public function setSettings(array $settings): void {
		$this->settings = array_merge($this->settings, $settings);
	}
	
	/**
	 * @inheritDoc
	 */
	public function getSettingsByKey(string $key) {
		if (!$this->hasKey($key)) {
			throw new InvalidArgumentException("Ключ {$key} отсутствует.");
		}
		
		return $this->settings[$key];
	}
	
	/**
	 * @inheritDoc
	 */
	public function hasKey(string $key): bool {
		return array_key_exists($key, $this->settings);
	}
}