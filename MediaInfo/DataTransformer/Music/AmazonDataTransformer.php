<?php

namespace Nass600\MediaInfoBundle\MediaInfo\DataTransformer\Music;

class AmazonDataTransformer extends MusicDataTransformerAbstract {
    /**
     * @inheritdoc
     */
    public function transform($data) {
        if (isset($data->error)) {
            throw new \Exception($data->message);
        }
        $album = $data->ItemAttributes;
        if (isset($album->Artist)) {
            $artist = is_array($album->Artist) ? implode(', ', $album->Artist) : $album->Artist;
            $this->setArtist(trim($artist));
        }
        if (isset($album->Title)) {
            $this->setTitle(trim($album->Title));
        }
        if (isset($album->EAN)) {
            $this->setEAN(trim($album->EAN));
        }
        if (isset($album->ReleaseDate)) {
            $this->setReleaseYear(substr($album->ReleaseDate, 0, 4));
        }
        $this->setPublisher(trim($album->Label));
        $this->setCover($data->LargeImage->URL);
        $this->setThumbnail($data->SmallImage->URL);

        if (false === isset($album->NumberOfDiscs) || $album->NumberOfDiscs == 1) {
            if (isset($data->Tracks)) {
                foreach ($data->Tracks->Disc->Track as $track) {
                    $track = (array) $track;
                    $this->addTrack(trim($track['_']));
                }
            }
        }
        else if (isset($data->Tracks->Disc)) {
            foreach ($data->Tracks->Disc as $disc) {
                foreach ($disc->Track as $track) {
                    $track = (array) $track;
                    $this->addTrack(trim($track['_']));
                }
            }
        }

        return $this;
    }
}
