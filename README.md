# WakaTime PHP API

[![Build Status](https://travis-ci.org/mabasic/wakatime-php-api.svg)](https://travis-ci.org/mabasic/wakatime-php-api) [![Latest Stable Version](https://poser.pugx.org/mabasic/wakatime-php-api/v/stable.svg)](https://packagist.org/packages/mabasic/wakatime-php-api) [![Total Downloads](https://poser.pugx.org/mabasic/wakatime-php-api/downloads.svg)](https://packagist.org/packages/mabasic/wakatime-php-api) [![Latest Unstable Version](https://poser.pugx.org/mabasic/wakatime-php-api/v/unstable.svg)](https://packagist.org/packages/mabasic/wakatime-php-api) [![License](https://poser.pugx.org/mabasic/wakatime-php-api/license.svg)](https://packagist.org/packages/mabasic/wakatime-php-api)

**WakaTime API for PHP**

This is a PHP package for WakaTime API. It offers all the methods from [WakaTime API](https://wakatime.com/api) plus some additional methods for total hours logged.

## Planned Features

- [ ] OAuth 2.0 authentication

## Installation

Add to your `composer.json`:

```
"mabasic/wakatime-php-api": "~1.0"
```

or type this from command line: 

```
composer require "mabasic/wakatime-php-api=~1.0"
```

Then run `composer dump-autoload`.

## Usage

```
<?php

use GuzzleHttp\Client as Guzzle;
use Mabasic\WakaTime\WakaTime;

$wakatime = new WakaTime(new Guzzle);
$wakaTime->setApiKey($your_api_key_for_wakatime);
```

You can get your Api Key from your [settings page](https://wakatime.com/settings).
 
> Be sure to set your Api Key before using any of the methods because you will get an Exception.
 
## Methods

### Official methods

#### currentUser

```
$wakatime->currentUser()
```

See: https://wakatime.com/api#users-current for details.

#### dailySummary

```
$wakatime->dailySummary($startDate, $endDate, $project = null)
```

See: https://wakatime.com/api#summary-daily for details.

### Additional methods

#### getHoursLoggedFor

```
$wakatime->getHoursLoggedFor($startDate, $endDate, $project = null)
```

Calculates hours logged for a specific period. 
_You can optionally specify a project._

> `$startDate` must be lower than `$endDate`

**Example:**

```
$startDate = '11/21/2014';
$endDate = '12/21/2014';

$hours = $wakaTime->getHoursLoggedFor($startDate, $endDate);
```

### getHoursLoggedForLast

```
public function getHoursLoggedForLast($period, $project = null)
```

Calculates hours logged in last xy days, months. 
_You can optionally specify a project._

**Example:**

```
$hours = $wakaTime->getHoursLoggedForLast('7 days');
```

### getHoursLoggedForToday

```
public function getHoursLoggedForToday($project = null)
```

Returns hours logged today. 
_You can optionally specify a project._

### getHoursLoggedForYesterday

```
public function getHoursLoggedForYesterday($project = null)
```

Returns hours logged yesterday. 
_You can optionally specify a project._

### getHoursLoggedForLast7Days

```
public function getHoursLoggedForLast7Days($project = null)
```

Basic users can only see data for maximum 7 days. Become a Premium user to preserve all data history. 
_You can still use any method as long as it is under 7 days._

### getHoursLoggedForLast30Days

```
public function getHoursLoggedForLast30Days($project = null)
```

Calculates hours logged for last 30 days in history.
_You can optionally specify a project._

### getHoursLoggedForThisMonth

```
public function getHoursLoggedForThisMonth($project = null)
```

Calculates hours logged for this month.
_You can optionally specify a project._

### getHoursLoggedForLastMonth

```
public function getHoursLoggedForLastMonth($project = null)
```

Calculates hours logged for last month.
_You can optionally specify a project._

---

## Testing instructions

For testing purposes set these environment variables before running tests:

On windows use:

```
setx WAKATIME_API_KEY xyz
setx WAKATIME_PROJECT xyz
```

On Linux use:

```
export WAKATIME_API_KEY=xyz
export WAKATIME_PROJECT=xyz
```

_Of course replace `xyz` with correct values._