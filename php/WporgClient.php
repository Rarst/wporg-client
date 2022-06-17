<?php
namespace Rarst\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Result;

/**
 * @method array getCoreVersionCheck()
 * @method array getCoreCredits()
 * @method Result getThemesInfo(array $arguments)
 * @method Result getPluginsInfo(array $arguments)
 * @method array getDownloads()
 * @method array getCoreChecksums()
 * @method array getImporters()
 * @method Result getCoreBrowseHappy(array $arguments)
 * @method array getEvents(array $arguments = [])
 */
class WporgClient extends GuzzleClient
{
    protected $disabledFields = [
        'description'     => false,
        'requires'        => false,
        'tested'          => false,
        'compatibility'   => false,
        'rating'          => false,
        'num_ratings'     => false,
        'ratings'         => false,
        'downloaded'      => false,
        'last_updated'    => false,
        'added'           => false,
        'homepage'        => false,
        'sections'        => false,
        'downloadlink'    => false,
        'tags'            => false,
        'donate_link'     => false,
        'active_installs' => false,
    ];

    protected function getRequestFields($fields)
    {
        return is_array($fields) ? array_merge($this->disabledFields, array_fill_keys($fields, true)) : [];
    }

    public static function getClient(Client $client = null, Description $description = null, array $config = [ ])
    {
        if (empty( $client )) {
            $client = new Client();
        }

        if (empty( $description )) {
            $description = new Description(WporgService::getDescription());
        }

        return new self($client, $description, null, null, null, $config);
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

    public function getTheme($slug, $fields = null)
    {
        $response = $this->getThemesInfo([
            'request' => [
                'slug'   => $slug,
                'fields' => $this->getRequestFields($fields)
            ]
        ]);

        return $response->toArray();
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
        return $this->getThemesInfo([ 'action' => 'feature_list' ])->toArray();
    }

    public function getThemesBy($type, $value, $page = 1, $perPage = 10, $fields = null)
    {
        $response = $this->getThemesInfo([
            'action'  => 'query_themes',
            'request' => [
                $type      => $value,
                'page'     => $page,
                'per_page' => $perPage,
                'fields'   => $this->getRequestFields($fields),
            ],
        ]);

        return $response->toArray();
    }

    public function getPlugin($slug, $fields = null)
    {
        $response = $this->getPluginsInfo([
            'action'  => 'plugin_information',
            'request' => [
                'slug'   => $slug,
                'fields' => $this->getRequestFields($fields),
            ]
        ]);

        return $response->toArray();
    }

    public function getPluginStats($slug)
    {
        $command = $this->getCommand('getStats', [ 'type' => 'plugin', 'slug' => $slug ]);

        return $this->execute($command);
    }

    /**
     * @param string   $slug  Plugin slug.
     * @param null|int $limit Number of days to retrieve, maximum 730.
     *
     * @return array
     */
    public function getPluginDownloads($slug, $limit = null)
    {
        $args = [ 'slug' => $slug ];

        if (! empty($limit)) {
            $limit         = (int)$limit;
            $args['limit'] = $limit > 730 ? 730 : $limit;
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

    public function getPluginsBy($type, $value, $page = 1, $perPage = 10, $fields = null)
    {
        $response = $this->getPluginsInfo([
            'action'  => 'query_plugins',
            'request' => [
                $type      => $value,
                'page'     => $page,
                'per_page' => $perPage,
                'fields'   => $this->getRequestFields($fields),
            ],
        ]);

        return $response->toArray();
    }

    public function getHotTags($number = 100)
    {
        $response = $this->getPluginsInfo([
            'action'  => 'hot_tags',
            'request' => [ 'number' => $number ], // Number currently broken in API.
        ]);

        return $response->toArray();
    }

    public function getChecksums($version, $locale = 'en_US')
    {
        return $this->getCoreChecksums([ 'version' => $version, 'locale' => $locale ]);
    }

    public function getBrowser($useragent)
    {
        return $this->getCoreBrowseHappy([ 'useragent' => $useragent ])->toArray();
    }
}
