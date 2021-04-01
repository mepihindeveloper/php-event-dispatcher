<?php

namespace mepihindeveloper\components\interfaces;

use InvalidArgumentException;

/**
 * Интерфейс ConfigurationInterface
 *
 * Декларирует методы обязательные для реализации компонента Configuration
 *
 * @package mepihindeveloper\components\interfaces
 */
interface ConfigurationInterface {
	
	/**
	 * Возвращает массив настроек
	 *
	 * @return array
	 */
	public function getSettings(): array;
	
	/**
	 * Устанавливает настройку
	 *
	 * @param array $settings Настройки [key => value]
	 */
	public function setSettings(array $settings): void;
	
	/**
	 * Возвращает настройки по ключу.
	 * Здесь могут быть как отдельные настройки, так и массив настроек (например, для какой-то категории)
	 *
	 * @param string $key Ключ
	 *
	 * @return mixed
	 *
	 * @throws InvalidArgumentException
	 */
	public function getSettingsByKey(string $key);
	
	/**
	 * Проверяет наличие ключа в настройках
	 *
	 * @param string $key Ключ
	 *
	 * @return bool
	 */
	public function hasKey(string $key): bool;
}