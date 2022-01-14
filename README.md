# php-configuration

![release](https://img.shields.io/github/v/release/mepihindeveloper/php-configuration?label=version)
[![Packagist Version](https://img.shields.io/packagist/v/mepihindeveloper/php-configuration)](https://packagist.org/packages/mepihindeveloper/php-configuration)
[![PHP Version Require](http://poser.pugx.org/mepihindeveloper/php-configuration/require/php)](https://packagist.org/packages/mepihindeveloper/php-configuration)
![license](https://img.shields.io/github/license/mepihindeveloper/php-configuration)

![build](https://github.com/mepihindeveloper/php-configuration/actions/workflows/php.yml/badge.svg?branch=development)
[![codecov](https://codecov.io/gh/mepihindeveloper/php-configuration/branch/development/graph/badge.svg?token=36PP7VKHKG)](https://codecov.io/gh/mepihindeveloper/php-configuration)

Компонент для работы с конфигурацией (настройками) приложения, модулей и компонентов

# Структура

```
src/
--- interfaces/
--- Configuration.php
```

В директории `interfaces` хранятся необходимые интерфейсы, которые необходимо имплементировать в при реализации
собственного класса `Configuration`.

Класс `Configuration` реализует интерфейс `ConfigurationInterface` для управления конфигурацией (настройками)
приложения, модулей и компонентов.

# Доступные методы

| Метод                         | Аргументы                          | Возвращаемые данные | Исключения               | Описание                                                                                                                          |
|-------------------------------|------------------------------------|---------------------|--------------------------|-----------------------------------------------------------------------------------------------------------------------------------|
| __construct(array $settings)  | $settings Массив настроек          |                     |                          | Конструктор                                                                                                                       |
| getSettings(): array          |                                    | array               |                          | Возвращает массив настроек                                                                                                        |
| setSettings(array $settings)  | $settings Настройки [key => value] | void                |                          | Устанавливает настройку                                                                                                           |
| getSettingsByKey(string $key) | $key Ключ                          | mixed               | InvalidArgumentException | Возвращает настройки по ключу. Здесь могут быть как отдельные настройки, так и массив настроек (например, для какой-то категории) |
| hasKey(string $key)           | $key Ключ                          | bool                |                          | Проверяет наличие ключа в настройках                                                                                              |

# Контакты

Вы можете связаться со мной в социальной сети ВКонтакте: [ВКонтакте: Максим Епихин](https://vk.com/maximepihin)

Если удобно писать на почту, то можете воспользоваться этим адресом: mepihindeveloper@gmail.com

Мой канал на YouTube, который посвящен разработке веб и игровых
проектов: [YouTube: Максим Епихин](https://www.youtube.com/channel/UCKusRcoHUy6T4sei-rVzCqQ)

Поддержать меня можно переводом на Яндекс.Деньги: [Денежный перевод](https://yoomoney.ru/to/410012382226565)
