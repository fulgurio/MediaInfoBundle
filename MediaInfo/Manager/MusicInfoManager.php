<?php

namespace Nass600\MediaInfoBundle\MediaInfo\Manager;

/**
 * MusicInfoManager
 *
 * @package Nass600LyricsBundle
 * @subpackage Model
 * @author Ignacio Velázquez Gómez <ivelazquez85@gmail.com>
 * @copyright Ignacio Velázquez Gómez
 */
class MusicInfoManager
{
	protected $adapter;

	public function __construct($adapter, $container)
	{
		$this->adapter = new $adapter;
		$this->adapter->setConfig($container->getParameter('nass600_media_info.config'));
	}

	/**
	 * Gets the lyrics through the adapter API given the track $id and outputs the result in the given $format
	 *
	 * @param string $id
	 * @param string $format
	 * @return mixed
	 */
	public function getAlbumInfo(array $parameters)
	{
		if (!isset($parameters['format']))
		{
			$parameters['format'] = 'json';
		}

		$results = $this->adapter->getAlbumInfo($parameters);

		$errors = $this->hasErrors($results);

		return (!$errors) ? $results : null;
	}

	/**
	 * Checks that response does not contain any errors
	 *
	 * @param $results
	 * @return bool
	 */
	public function hasErrors($results)
	{
		try
		{
			$lyrdb = new \SimpleXMLElement($results);
		}
		catch (\Exception $e)
		{
			return false;
		}

		return ($lyrdb->error->number == null) ? false : true;
	}
}