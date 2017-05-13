MediaInfoBundle
===============

Symfony2 Bundle able to retrieve information about media content such as movies,
 albums, tv shows on th Internet via REST API's of some popular services like 
 LastFM, LyrDB, IMDB, TMDB, MoviePilot
 

Configurations
--------------
First, you need to create account on website :
 - [Amazon](https://partenaires.amazon.fr/)
 - [LastFM](https://www.last.fm/api/account/create)
 
to get API key 

When you get keys, set the config : 
````yaml
# app/config/config.yml
nass600_media_info:
    config:
        amazon:
            secret_key:    XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
            access_key_id: XXXXXXXXXXXXXXXXXXXX
            associate_tag: XXXXXXXXXXX
        lastFM:
            api_key:       XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
````

And choose the adapter to associate to a type of media :
When you get keys, set the config :
 
Using Amazon
````yaml
# app/config/config.yml
nass600_media_info:
    [...]
    provider:
        music:             Nass600\MediaInfoBundle\MediaInfo\Adapter\Music\AmazonAdapter
````

Using LastFM
````yaml
# app/config/config.yml
nass600_media_info:
    [...]
    provider:
        music:             Nass600\MediaInfoBundle\MediaInfo\Adapter\Music\LastFMAdapter
````
