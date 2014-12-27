<?php
namespace Rarst\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Stream\Stream;

/**
 * @method array getImporters()
 */
class WporgClient extends GuzzleClient
{
    public static function getClient(Client $client = null, Description $description = null, array $config = [ ])
    {
        if (empty( $client )) {
            $client = new Client();
        }

        if (empty( $description )) {
            $description = new Description(WporgService::getDescription());
        }

        return new self($client, $description, $config);
    }

    public function getSalt()
    {
        $command  = $this->getCommand('getSalt');
        $response = $this->execute($command);
        /** @var Stream $body */
        $body = $response['body'];

        return $body->getContents();
    }

    public function getStats($type)
    {
        $command = $this->getCommand('getStats', [ 'type' => $type ]);

        return $this->execute($command);
    }

    public function getUpdates($version = null, $locale = null)
    {
        $args = [ ];

        if (! empty( $version )) {
            $args['version'] = $version;
        }

        if (! empty( $locale )) {
            $args['locale'] = $locale;
        }

        $command = $this->getCommand('getCoreVersionCheck', $args);

        return $this->execute($command);
    }

    public function getCredits($version = null)
    {
        // TODO compare version to be >=3.2
        $args    = empty( $version ) ? [ ] : [ 'version' => $version ];
        $command = $this->getCommand('getCoreCredits', $args);

        return $this->execute($command);
    }

    public function getTranslations($version = null)
    {
        // TODO compare version to be >=4.0
        $args = [ 'type' => 'core' ];

        if (! empty( $version )) {
            $args['version'] = $version;
        }

        $command = $this->getCommand('getTranslations', $args);

        return $this->execute($command);
    }

    public function getTheme($slug)
    {
        $command  = $this->getCommand('getThemesInfo', [ 'request' => [ 'slug' => $slug ] ]);
        $response = $this->execute($command);

        return $response['body'];
    }

    public function getThemeTranslations($slug, $version = null)
    {
        $args = [ 'type' => 'themes', 'slug' => $slug ];

        if (! empty( $version )) {
            $args['version'] = $version;
        }

        $command = $this->getCommand('getTranslations', $args);

        return $this->execute($command);
    }

    public function getPlugin($slug)
    {
        $command = $this->getCommand('getPluginsInfo', [ 'slug' => $slug ]);

        return $this->execute($command);
    }

    public function getPluginStats($slug)
    {
        $command = $this->getCommand('getStats', [ 'type' => 'plugin', 'slug' => $slug ]);

        return $this->execute($command);
    }

    public function getPluginDownloads($slug, $limit = null)
    {
        $args = [ 'slug' => $slug ];
        if (! empty( $limit )) {
            $args['limit'] = (int) $limit;
        }
        $command = $this->getCommand('getDownloads', $args);

        return $this->execute($command);
    }

    public function getPluginTranslations($slug, $version = null)
    {
        $args = [ 'type' => 'plugins', 'slug' => $slug ];

        if (! empty( $version )) {
            $args['version'] = $version;
        }

        $command = $this->getCommand('getTranslations', $args);

        return $this->execute($command);
    }

    public function getChecksums($version, $locale = 'en_US')
    {
        $args    = [ 'version' => $version, 'locale' => $locale ];
        $command = $this->getCommand('getCoreChecksums', $args);

        return $this->execute($command);
    }
}
