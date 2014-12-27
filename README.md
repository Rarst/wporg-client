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

### Secret keys & salts

```php
$secret = $wporgClient->getSalt();
```

### Stats

```php
$wordpress = $wporgClient->getStats('wordpress');
$php       = $wporgClient->getStats('php');
$mysql     = $wporgClient->getStats('mysql');
```

### Core updates

```php
$latest_updates = $wporgClient->getUpdates();
$updates_for    = $wporgClient->getUpdates('4.0', 'en_US');
```

### Credits

```php
$credits = $wporgClient->getCredits('4.1');
```

### Translations

```php
$translations = $wporgClient->getTranslations('4.1');
```

### Themes

```php
$theme        = $wporgClient->getTheme('twentyfifteen');
$translations = $wporgClient->getThemeTranslations('twentyfifteen', '1.0');
// TODO updates
// TODO featured
```

### Plugins

```php
$plugin       = $wporgClient->getPlugin('hello-dolly');
$stats        = $wporgClient->getPluginStats('hello-dolly');
$downloads    = $wporgClient->getPluginDownloads('hello-dolly', 7);
$translations = $wporgClient->getPluginTranslations('akismet', '3.0');
// TODO updates
```

### Popular importers

```php
$importers = $wporgClient->getImporters();
```

### Core checksums

```php
$checksums = $wporgClient->getChecksums('4.1', 'en_US');
```

### Editor TODO

```php
// TODO
```

### Browse happy TODO

```php
// TODO
```

## License information

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