<?php
namespace Usps\lib;

/**
 *  @author Matiullah 
 *  Email: mati_ullah31@yahoo.com
 */

abstract class Usps
{
    /**
     * @var string
     */
    public static $apiUserName;
     /**
     * @var string
     */
    public static $apiPassword;

    /**
     * @var string
     */
    public static $apiUspsPermit;

    /**
     * @var string
     */
    public static $apiBase = 'https://secure.shippingapis.com/ShippingAPI.dll';

    /**
     * @var string
     */
    public static $apiVersion = "1";

    /**
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     * get the API User Name
     *
     * @return string
     */
    public static function getApiUserName()
    {
        return self::$apiUserName;
    }

 /**
     * set the API User Name
     *
     * @param string $apiUserName
     */
    public static function setApiUserName($apiUserName)
    {
        self::$apiUserName = $apiUserName;
    }

    /**
     * set the API Password
     *
     * @param string $apiPassword
     */
    public static function setApiPassword($apiPassword)
    {
        self::$apiPassword = $apiPassword;
    }

    /**
     * get the API Password
     *
     * @param string $apiPassword
     */
    public static function getApiPassword()
    {
        return self::$apiPassword;
    }

    /**
     * set the API Password
     *
     * @param string $apiPassword
     */
    public static function setApiPermit($apiUspsPermit)
    {
        self::$apiUspsPermit = $apiUspsPermit;
    }

    /**
     * get the API Password
     *
     * @param string $apiPassword
     */
    public static function getApiPermit()
    {
        return self::$apiUspsPermit;
    }

    /**
     * get the API base URL
     *
     * @return string
     */
    public static function getApiBase()
    {
        return self::$apiBase;
    }

    /**
     * set the API base URL
     *
     * @param string $apiBase
     */
    public static function setApiBase($apiBase)
    {
        self::$apiBase = $apiBase;
    }

    /**
     * get the API version
     *
     * @return string
     */
    public static function getApiVersion()
    {
        return self::$apiVersion;
    }

    /**
     * set the API version
     *
     * @param $apiVersion
     */
    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = $apiVersion;
    }
}
