<?php
namespace Rarst\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Stream\Stream;

/**
 * @method array getCoreVersionCheck()
 * @method array getCoreCredits()
 * @method array getThemesInfo()
 * @method array getPluginsInfo()
 * @method array getDownloads()
 * @method array getCoreChecksums()
 * @method array getImporters()
 * @method array getCoreBrowseHappy()
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

    public static function toObject(array $array)
    {
        return (object) $array;
    }

    public static function maybeToArray($input)
    {
        return is_object($input) ? get_object_vars($input) : $input;
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

        return $this->getCoreVersionCheck($args);
    }

    public function getCredits($version = null)
    {
        // TODO compare version to be >=3.2
        return $this->getCoreCredits(empty( $version ) ? [ ] : [ 'version' => $version ]);
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
        $response = $this->getThemesInfo([ 'request' => [ 'slug' => $slug ] ]);

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

    public function getThemeFeatureList()
    {
        return $this->getThemesInfo([ 'action' => 'feature_list' ]);
    }

    public function getPlugin($slug)
    {
        return $this->getPluginsInfo([ 'slug' => $slug ]);
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

        return $this->getDownloads($args);
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
        return $this->getCoreChecksums([ 'version' => $version, 'locale' => $locale ]);
    }

    public function getBrowserUpdate($useragent)
    {
        $response = $this->getCoreBrowseHappy([ 'useragent' => $useragent ]);

        return $response['body'];
    }
}
