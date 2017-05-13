<?php

namespace Nass600\MediaInfoBundle\MediaInfo\DataTransformer\Music;

class LastFMDataTransformer extends MusicDataTransformerAbstract {
    /**
     * @inheritdoc
     */
    public function transform($data) {
        if (isset($data->error)) {
            throw new \Exception($data->message);
        }
        $album = $data->album;
        $this->setArtist(trim($album->artist));
        $this->setTitle(trim($album->name));
        $image1 = (array) $album->image[4]; //'mega'
        $this->setCover($image1['#text']);
        $image2 = (array) $album->image[1]; //'mega'
        $this->setThumbnail($image2['#text']);
        if (isset($album->tracks->track)) {
            foreach ($album->tracks->track as $track) {
                $this->addTrack(trim($track->name), intval($track->duration));
            }
        }

        return $this;
    }
}
