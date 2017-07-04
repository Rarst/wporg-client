# WPorg Client

WPorg Client is a standalone HTTP client for public [WordPress.org API](http://codex.wordpress.org/WordPress.org_API).

It aims to provide consistent centralized experience and is independent from WordPress core.

## Installation

```bash
composer require rarst/wporg-client
```

```php
$wporgClient  = \Rarst\Guzzle\WporgClient::getClient();
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

$popular      = $wporgClient->getThemesBy('browse', 'popular');
$featured     = $wporgClient->getThemesBy('browse', 'featured');
$new          = $wporgClient->getThemesBy('browse', 'new');
$updated      = $wporgClient->getThemesBy('browse', 'updated');
$search       = $wporgClient->getThemesBy('search', 'twenty');
$tagged       = $wporgClient->getThemesBy('tag', 'white');
$authors      = $wporgClient->getThemesBy('author', 'wordpressdotorg');

$featureList  = $wporgClient->getThemeFeatureList();
```

### Plugins

```php
$plugin       = $wporgClient->getPlugin('hello-dolly');
$stats        = $wporgClient->getPluginStats('hello-dolly');
$downloads    = $wporgClient->getPluginDownloads('hello-dolly', 7);
$translations = $wporgClient->getPluginTranslations('akismet', '3.0');

$popular      = $wporgClient->getPluginsBy('browse', 'popular');
$featured     = $wporgClient->getPluginsBy('browse', 'featured');
$new          = $wporgClient->getPluginsBy('browse', 'new');
$updated      = $wporgClient->getPluginsBy('browse', 'updated');
$search       = $wporgClient->getPluginsBy('search', 'dolly');
$tagged       = $wporgClient->getPluginsBy('tag', 'widget');
$authors      = $wporgClient->getPluginsBy('author', 'wordpressdotorg');

$importers    = $wporgClient->getImporters();
$tags         = $wporgClient->getHotTags();
```

### Events

```php
$location     = $wporgClient->getEvents(['location' => 'Seattle']));
$number       = $wporgClient->getEvents(['location' => 'Australia', 'number' => 5]));
$locale       = $wporgClient->getEvents(['timezone' => 'Europe/Berlin', 'locale' => 'de_DE', 'location' => 'Dresden']));
$coordinates  = $wporgClient->getEvents(['latitude' => '51.051', 'longitude' => '13.738']));
$ip           = $wporgClient->getEvents(['ip' => '136.0.16.1']));
$country      = $wporgClient->getEvents(['country' => 'IT']));
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

MIT