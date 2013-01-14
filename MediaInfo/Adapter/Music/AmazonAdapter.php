<?php

namespace Nass600\MediaInfoBundle\MediaInfo\Adapter\Music;

use Nass600\MediaInfoBundle\MediaInfo\Adapter\AbstractAdapter;

/**
 * AmazonAdapter
 */
class AmazonAdapter extends AbstractAdapter implements AdapterInterface
{
    const API_URL = 'http://webservices.amazon.com/AWSECommerceService/AWSECommerceService.wsdl';

    const API_SECURITY_URL = 'http://security.amazonaws.com/doc/2007-01-01/';


    /**
     * Get album info
     *
     * @param array $parameters
     * @return string
     */
    public function getAlbumInfo(array $parameters)
    {
        $parameters['AWSAccessKeyId'] = $this->config['amazon']['access_key_id'];
        $parameters['AssociateTag'] = $this->config['amazon']['associate_tag'];
        $parameters['Request'] = array('ResponseGroup' => 'Images,ItemAttributes,Tracks');
        if (isset($parameters['ASIN']) && trim($parameters['ASIN']) !== '')
        {
            $parameters['Request']['IdType'] = 'ASIN';
            $parameters['Request']['ItemId'] = $parameters['ASIN'];
        }
        else if (isset($parameters['EAN']) && trim($parameters['EAN']) !== '')
        {
            $parameters['Request']['SearchIndex'] = 'Music';
            $parameters['Request']['IdType'] = 'EAN';
            $parameters['Request']['ItemId'] = $parameters['EAN'];
        }
        else
        {
            return $this->getAlbumsList($parameters);
        }
        $res = $this->getClient('ItemLookup')->ItemLookup($parameters);
        if ($res->Items->Request->IsValid == 'True' && isset($res->Items->Item))
        {
            return json_encode($res->Items->Item);
        }
        return json_encode((object)  array('error' => 1, 'message' => 'Album not found'));
    }

    /**
     * Get albums list
     * @param array $parameters
     * @return string
     */
    public function getAlbumsList(array $parameters)
    {
        $parameters['album'] = trim($parameters['album']);
        if ($parameters['album'] !== '')
        {
            $parameters['artist'] = $parameters['artist'];
            $params = array(
                'AWSAccessKeyId' => $this->config['amazon']['access_key_id'],
                'AssociateTag' => $this->config['amazon']['associate_tag'],
                'Request' => array(
                    'SearchIndex' => 'Music',
                    'ResponseGroup' => 'Images,ItemAttributes',
                    'Title' => $parameters['album']
                )
            );
            if ($parameters['artist'] !== '')
            {
                $params['Request']['Artist'] = $parameters['artist'];
            }
            $res = $this->getClient('ItemSearch')->ItemSearch($params);
            if ($res->Items->Request->IsValid === 'True')
            {
                if ($res->Items->TotalResults > 0) {
    //                 'TotalResults' => $res->Items->TotalResults,
    //                 'TotalPages' => $res->Items->TotalPages,
                    return json_encode($res->Items->Item);
                }
            }
            else
            {
                return json_encode((object)  array('error' => 3, 'message' => 'Error in query'));
            }
        }
        return json_encode((object)  array('error' => 1, 'message' => 'Album not found'));
    }

    /**
     * Get AWS client
     *
     * @param string $action
     * @return \SoapClient
     */
    private function getClient($action)
    {
        $time = gmstrftime('%Y-%m-%dT%H:%M:%S.00Z');
        $signature = base64_encode(
                hash_hmac(
                        'sha256',
                        $action . $time,
                        $this->config['amazon']['secret_key'],
                        TRUE
                )
        );
        $client = new \SoapClient(self::API_URL, array('trace' => 1));
        $header_arr = array(
                new \SoapHeader(self::API_SECURITY_URL, 'AWSAccessKeyId', $this->config['amazon']['access_key_id']),
                new \SoapHeader(self::API_SECURITY_URL, 'Timestamp', $time),
                new \SoapHeader(self::API_SECURITY_URL, 'Signature', $signature)
        );
        $client->__setSoapHeaders($header_arr);
        return ($client);
    }


    public function getUrl()
    {
//         return self::API_URL."?{$this->getHttpParameters()}";
    }
}