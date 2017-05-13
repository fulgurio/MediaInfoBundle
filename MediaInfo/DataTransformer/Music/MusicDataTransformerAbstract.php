<?php
namespace Nass600\MediaInfoBundle\MediaInfo\DataTransformer\Music;

abstract class MusicDataTransformerAbstract {

    private $artist = '';
    private $title = '';
    private $ean = '';
    private $releaseYear = null;
    private $publisher = '';
    private $cover = '';
    private $thumbnail = '';
    private $tracks = array();


    /**
     * Transfort / convert data from API
     *
     * @param mixed $data
     * @return MusicDataTransformerAbstract
     */
    abstract function transform($data);

    /**
     * Get artist name
     *
     * @return string
     */
    final public function getArtist() {
        return $this->artist;
    }

    /**
     * Set artist name
     *
     * @param string $artist
     * @return MusicDataTransformerAbstract
     */
    public function setArtist($artist) {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get album title
     *
     * @return string
     */
    final public function getTitle() {
        return $this->title;
    }

    /**
     * Set album title
     *
     * @param string $title
     * @return MusicDataTransformerAbstract
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     *
     * @return string
     */
    final public function getEAN() {
        return $this->ean;
    }

    /**
     * @param string $ean
     * @return MusicDataTransformerAbstract
     */
    public function setEAN($ean) {
        $this->ean = $ean;

        return $this;
    }

    /**
     * @return number
     */
    final public function getReleaseYear() {
        return $this->releaseYear;
    }

    /**
     * @param number $year
     * @return MusicDataTransformerAbstract
     */
    public function setReleaseYear($year) {
        $this->releaseYear = $year;

        return $this;
    }

    /**
     * @return string
     */
    final public function getPublisher() {
        return $this->publisher;
    }

    /**
     * @param string $publisher
     * @return MusicDataTransformerAbstract
     */
    public function setPublisher($publisher) {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * @return string
     */
    final public function getCover() {
        return $this->cover;
    }

    /**
     * @param string $cover
     * @return MusicDataTransformerAbstract
     */
    public function setCover($cover) {
        $this->cover = $cover;

        return $this;
    }

    /**
     * @return string
     */
    final public function getThumbnail() {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     * @return MusicDataTransformerAbstract
     */
    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get album tracks
     *
     * @return array
     */
    final public function getTracks() {
        return $this->tracks;
    }

    /**
     * Add a track
     *
     * @param string $name
     * @param string $duration
     * @param string $lyrics
     * @return MusicDataTransformerAbstract
     */
    final public function addTrack($name, $duration = null, $lyrics = null) {
        $track = array('name' => $name);
        if ($duration !== null) {
            $track['duration'] = $duration;
        }
        if ($lyrics !== null) {
            $track['lyrics'] = $lyrics;
        }

        $this->tracks[] = $track;

        return $this;
    }

    /**
     * @return array
     */
    final public function getData() {
        return array(
            'artist' => $this->getArtist(),
            'title' => $this->getTitle(),
            'ean' => $this->getEAN(),
            'releaseYear' => $this->getReleaseYear(),
            'publisher' => $this->getPublisher(),
            'cover' => $this->getCover(),
            'thumbnail' => $this->getThumbnail(),
            'tracks' => $this->getTracks()
        );
    }
}
