<?php

/*
 * This file is part of the EE\CustomerioBundle
 *
 * (c) Thomas Olivier <thomas@explee.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EE\CustomerioBundle\Services;

use EE\CustomerioBundle\Services\

/**
 * The main Customerio service
 */
class Customerio
{

    private $apiKey;
    private $siteId;
    private $dataCenter;
    private $ssl;

    /**
     * Initializes Customerio
     *
     * @param string $apiKey Customerio api_key
     * @param string $siteId Customerio site_id
     */
    public function __construct($apiKey, $siteId, $ssl = true)
    {
        $this->apiKey = $apiKey;
        $this->siteId = $siteId;
        $this->ssl = $ssl;

        $base = 'https://track.customer.io/api/v1/customers/';

        if (!function_exists('curl_init')) {
            throw new \Exception('This bundle needs the cURL PHP extension.');
        }
    }

    public function identify($customerId, $options)
    {
        $method = 'PUT';
        $endpoint = $base . $customerId . '/';

        $this->makeRequest($endpoint, $method, $options);
    }

    public function track($customerId, $options)
    {
        $method = 'POST';
        $endpoint = $base . $customerId . '/events';

        $this->makeRequest($endpoint, $method, $options);
    }

    private function makeRequest($endpoint, $method, $options)
    {

        $session = curl_init();

        curl_setopt($session, CURLOPT_URL, $endpoint);
        curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_VERBOSE, 1);
        curl_setopt($session, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($session, CURLOPT_POSTFIELDS, http_build_query($options));
        curl_setopt($session, CURLOPT_USERPWD, $this->siteId . ":" . $this->apiKey);

        if (in_array($method, array('PUT', 'GET')))
        {
            curl_setopt($session, CURLOPT_HTTPGET, 1);
        }

        if ($this->ssl)
        {
            curl_setopt($session, CURLOPT_SSL_VERIFYPEER, true);
        }

        $response = curl_exec($session);
        curl_close($session);

        return $response;

    }

    /**
     * Get Customerio api key
     *
     * @return string
     */
    public function getAPIkey()
    {
        return $this->apiKey;
    }

    /**
     * Getter for siteId
     *
     * @return mixed
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * Setter for siteId
     *
     * @param mixed $siteId Value to set
     *
     * @return self
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
        return $this;
    }

    /**
     * get mailing list id
     *
     * @return string $siteId
     */
    public function getDatacenter()
    {
        return $this->dataCenter;
    }
}
