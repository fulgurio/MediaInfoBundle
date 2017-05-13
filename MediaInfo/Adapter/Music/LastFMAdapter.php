<?php

namespace Nass600\MediaInfoBundle\MediaInfo\Adapter\Music;

use Nass600\MediaInfoBundle\MediaInfo\Adapter\AbstractAdapter;
use Nass600\MediaInfoBundle\MediaInfo\DataTransformer\Music\LastFMDataTransformer;

/**
 * LastFMAdapter
 *
 * @package Nass600MediaInfoBundle
 * @subpackage Adapter
 * @author Ignacio Velázquez Gómez <ivelazquez85@gmail.com>, Vincent Guerard <v.guerard@fulgurio.net>
 * @copyright Ignacio Velázquez Gómez
 */
class LastFMAdapter extends AbstractAdapter implements AdapterInterface {
    const API_URL = 'http://ws.audioscrobbler.com/2.0/';

    const SEARCH_FUNCTION = 'lookup';

    const GET_FUNCTION = 'album.getInfo';


    /**
     * Get album info
     *
     * @param array $parameters
     * @return array
     */
    public function getAlbumInfo(array $parameters) {
        $this->setParameter('method', self::GET_FUNCTION);
        $this->setParameter('api_key', isset($this->config['lastFM']['api_key']) ? $this->config['lastFM']['api_key'] : null);
        $this->setParameter('autocorrect', '1');
        $this->setParameter('format', 'json');

        foreach ($parameters as $key => $value) {
            $this->setParameter($key, $value);
        }

        $data = $this->getFeed(self::API_URL . '?' . $this->getHttpParameters());

        $transformer = new LastFMDataTransformer();

        return $transformer->transform(json_decode($data))->getData();
    }
}
