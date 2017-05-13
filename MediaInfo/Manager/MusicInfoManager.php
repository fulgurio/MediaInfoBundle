<?php

namespace Nass600\MediaInfoBundle\MediaInfo\Manager;

use Nass600\MediaInfoBundle\MediaInfo\Adapter\AbstractAdapter;

/**
 * MusicInfoManager
 *
 * @package Nass600MediaInfoBundle
 * @subpackage Manager
 * @author Ignacio Velázquez Gómez <ivelazquez85@gmail.com>
 * @copyright Ignacio Velázquez Gómez
 */
class MusicInfoManager {
    /**
     * @var AbstractAdapter
     */
    protected $adapter;

    /**
     * MusicInfoManager constructor.
     *
     * @param string $adapter
     * @param array $container
     */
    public function __construct($adapter, $config) {
        $this->adapter = new $adapter;
        $this->adapter->setConfig($config);
    }

    /**
     * Gets the music album data through the adapter API given the track $id and outputs the result in the given $format
     *
     * @param array $parameters
     *
     * @return mixed
     */
    public function getAlbumInfo(array $parameters) {
        try {
            return $this->adapter->getAlbumInfo($parameters);
        }
        catch (\Exception $e) {
            echo $e->getMessage();
            // @todo: log
            return null;
        }
    }
}
