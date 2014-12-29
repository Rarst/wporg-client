# WPorg Client

WPorg Client is a standalone HTTP client for public [WordPress.org API](http://codex.wordpress.org/WordPress.org_API).

It aims to provide consistent centralized experience and is independent from WordPress core.

Client is currently considered unstable and is based on Guzzle Services beta.

## Installation

```bash
composer require rarst/wporg-client:dev-master
```

```php
$wporgClient = \Rarst\Guzzle\WporgClient::getClient();
```

## Examples

### Core

```php
$updates      = $wporgClient->getUpdates();
$updatesFor   = $wporgClient->getUpdates('4.0', 'en_US');
$translations = $wporgClient->getTranslations('4.1');
$credits      = $wporgClient->getCredits('4.1');
$checksums    = $wporgClient->getChecksums('4.1', 'en_US');
```

### Themes

```php
$theme        = $wporgClient->getTheme('twentyfifteen');
$translations = $wporgClient->getThemeTranslations('twentyfifteen', '1.0');
$featureList  = $wporgClient->getThemeFeatureList();
```

### Plugins

```php
$plugin       = $wporgClient->getPlugin('hello-dolly');
$pluginFields = $wporgClient->getPlugin('hello-dolly', [ 'last_updated' ]);
$stats        = $wporgClient->getPluginStats('hello-dolly');
$downloads    = $wporgClient->getPluginDownloads('hello-dolly', 7);
$translations = $wporgClient->getPluginTranslations('akismet', '3.0');
$importers    = $wporgClient->getImporters();
```

### Other

#### Stats

```php
$wordpress    = $wporgClient->getStats('wordpress');
$php          = $wporgClient->getStats('php');
$mysql        = $wporgClient->getStats('mysql');
```

#### Secret keys & salts

```php
$secret       = $wporgClient->getSalt();
```

#### Browse happy

```php
$browser      = $wporgClient->getBrowser('Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.17');
```

## License

```
Licenses: MIT
Dependencies:
  guzzlehttp/command           0.7.0    MIT
  guzzlehttp/guzzle            5.1.0    MIT
  guzzlehttp/guzzle-services   0.5.0    MIT
  guzzlehttp/ringphp           1.0.5    MIT
  guzzlehttp/streams           3.0.0    MIT
  react/promise                v2.1.0   MIT
```