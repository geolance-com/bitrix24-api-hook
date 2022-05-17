# Bitrix24 API library

A PHP library for the Bitrix24 REST API

## Installation

Run from the command line:

```bash
composer require fomvasss/bitrix24-api-hook
```

## Usage

### Prepare Bitrix24
1. Register on https://www.bitrix24.com/ (if you do not hava account) and confirm account
2. Get your Btrix-domain (ex.: https://your-domain.bitrix24.ru, https://your-example.bitrix24.ru,...) after register
3. Login and create a webhook for the desired action: Applications → WebHuck → Add WebHook (Приложения → Вебхуки → Добавить вебхук).
4. After building the webhuk you will get a example url: `https://your-domen.bitrix24.ru/rest/13/9cybrkhzxxf28zl4/profile/`

In this class you need use next params: base URL, user ID, secret password (token)
- base URL - `https://your-domen.bitrix24.ru` 
- user ID - `13`
- password - `9cybrkhzxxf28zl4`

### Use PHP class
```php
<?php
$b24 = new \Fomvasss\Bitrix24ApiHook\Bitrix24('https://testhipertin.bitrix24.ru', 13, '9cybrkhzxxf28zl4');

// see "crm.lead.add"
$b24->crmLeadAdd([
	"fields" => [
		'TITLE' => 'New contacts fomr',
		'NAME' => 'Bob Dilan',
		'EMAIL' => [
			['VALUE' => 'bob@app.com',],
		],
		'PHONE' => [
			['VALUE' => '+74563214561']
		],
		'COMMENTS' => 'Hello World',
		'UF_CRM_1554454898781' => 'Kiev',
	],
	'params' => ["REGISTER_SONET_EVENT" => "Y"],
]);
```
All methods see in Bitrix24 documentation

## Links
- [Bitrix24 API documentation - Russian](http://dev.1c-bitrix.ru/rest_help/)
- [Bitrix24 API documentation - English](https://training.bitrix24.com/rest_help/)
- [Bitrix24 - useful article about API](https://gettotop.ru/crm/bitrix24-lidy-s-sajta-avtomaticheskoe-sozdanie-lidov/#-24)