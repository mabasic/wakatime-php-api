# WakaTime PHP API

[![Build Status](https://travis-ci.org/mabasic/wakatime-php-api.svg)](https://travis-ci.org/mabasic/wakatime-php-api) [![Latest Stable Version](https://poser.pugx.org/mabasic/wakatime-php-api/v/stable.svg)](https://packagist.org/packages/mabasic/wakatime-php-api) [![Total Downloads](https://poser.pugx.org/mabasic/wakatime-php-api/downloads.svg)](https://packagist.org/packages/mabasic/wakatime-php-api) [![Latest Unstable Version](https://poser.pugx.org/mabasic/wakatime-php-api/v/unstable.svg)](https://packagist.org/packages/mabasic/wakatime-php-api) [![License](https://poser.pugx.org/mabasic/wakatime-php-api/license.svg)](https://packagist.org/packages/mabasic/wakatime-php-api)

**WakaTime API for PHP**

This is a PHP package for WakaTime API. It supports resource endpoints from [WakaTime API](https://wakatime.com/developers) with additional helper methods for hours logged.

If you are using [Laravel](http://laravel.com/) check out [WakaTime Reports and Laravel](http://laravelista.com/posts/wakatime-reports-and-laravel/).

If you find that some resource endpoints are missing feel free to send me a PR. *(Be sure to include tests for your code)*

## Installation

Type this from command line:

```php
composer require mabasic/wakatime-php-api
```

## Usage

```php
<?php

use GuzzleHttp\Client as Guzzle;
use Mabasic\WakaTime\WakaTime;

$wakatime = new WakaTime(new Guzzle, $your_api_key_for_wakatime);
```

You can get your Api Key from your [settings page](https://wakatime.com/settings).

## Resource Endpoints

#### Users

```php
$wakatime->currentUser()

// or

$wakatime->users('username');
```

See: https://wakatime.com/developers/#users for details.

#### Summaries

```php
$wakatime->summaries($startDate, $endDate, $project = null)
```

See: https://wakatime.com/developers/#summaries for details.

#### Stats

```php
$wakatime->stats($range, $project = null)
```

See: https://wakatime.com/developers/#stats for details.

#### Heartbeats

```php
$date = '01/22/2016';

$wakatime->heartbeats($date);
```

See: https://wakatime.com/developers#heartbeats for details.

## Helper methods aka Reports aka Shortcuts

#### getHoursLoggedFor

```php
$wakatime->getHoursLoggedFor($startDate, $endDate, $project = null)
```

Calculates hours logged for a specific period.
_You can optionally specify a project._

> `$startDate` must be lower than `$endDate`

**Example:**

```php
$startDate = '11/21/2014';
$endDate = '12/21/2014';

$hours = $wakaTime->getHoursLoggedFor($startDate, $endDate);
```

#### getHoursLoggedForLast

```php
public function getHoursLoggedForLast($period, $project = null)
```

Calculates hours logged in last xy days, months.
_You can optionally specify a project._

**Example:**

```php
$hours = $wakaTime->getHoursLoggedForLast('7 days');
```

#### getHoursLoggedForToday

```php
public function getHoursLoggedForToday($project = null)
```

Returns hours logged today.
_You can optionally specify a project._

#### getHoursLoggedForYesterday

```php
public function getHoursLoggedForYesterday($project = null)
```

Returns hours logged yesterday.
_You can optionally specify a project._

#### getHoursLoggedForLast7Days

```php
public function getHoursLoggedForLast7Days($project = null)
```

Basic users can only see data for maximum 7 days. Become a Premium user to preserve all data history.
_You can still use any method as long as it is under 7 days._

#### getHoursLoggedForLast30Days

```php
public function getHoursLoggedForLast30Days($project = null)
```

Calculates hours logged for last 30 days in history.
_You can optionally specify a project._

#### getHoursLoggedForThisMonth

```php
public function getHoursLoggedForThisMonth($project = null)
```

Calculates hours logged for this month.
_You can optionally specify a project._

#### getHoursLoggedForLastMonth

```php
public function getHoursLoggedForLastMonth($project = null)
```

Calculates hours logged for last month.
_You can optionally specify a project._

---

## For developers only

Copy `.env.example` file to `.env` and set your api key and project name before running tests with:

```
vendor/bin/phpunit
```
