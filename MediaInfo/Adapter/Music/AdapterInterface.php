<?php

namespace Nass600\MediaInfoBundle\MediaInfo\Adapter\Music;

/**
 * AdapterInterface
 *
 * @package Nass600MediaInfoBundle
 * @subpackage Adapter
 * @author Ignacio Velázquez Gómez <ivelazquez85@gmail.com>
 * @copyright Ignacio Velázquez Gómez
 */
interface AdapterInterface {
    /**
     * Gets the album informations from webservices
     *
     * @param array $parameters
     * @return mixed
     */
    public function getAlbumInfo(array $parameters);
}
