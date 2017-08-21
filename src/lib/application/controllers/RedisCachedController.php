<?php
namespace tlcal\application\controllers;


use tlcal\domain\access\RedisAccess;
use vsc\application\controllers\CacheableControllerA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponse;

abstract class RedisCachedController extends CacheableControllerA
{
    /**
     * @var RedisAccess
     */
    private $oRedisAccess;

    public function __construct()
    {
        $this->oRedisAccess = new RedisAccess();
    }

    /**
     * @param HttpRequestA $oRequest
     * @return string
     */
    protected function generateKey(HttpRequestA $oRequest)
    {
        return $oRequest->getUri();
    }

    /**
     * @param $key
     * @param HttpResponseA $default
     * @return HttpResponseA
     */
    protected function get($key, $default = null)
    {
        /** @var HttpResponse $oResponse */
        $oResponse = unserialize($this->oRedisAccess->get($key));
        if (!is_null($oResponse)) {
            return $oResponse;
        }
        return $default;
    }

    /**
     * @param $key
     * @return bool
     */
    protected function has($key)
    {
        return $this->oRedisAccess->has($key);
    }

    /**
     * @param $key
     * @param HttpResponseA $value
     * @return bool
     */
    protected function set($key, HttpResponseA $value)
    {
        $this->oRedisAccess->set($key, serialize($value));
    }

    /**
     * @param HttpRequestA $oRequest
     * @param ProcessorA $oProcessor
     * @returns HttpResponseA
     */
    public function getResponse(HttpRequestA $oRequest, $oProcessor = null) {
        $key = $this->generateKey($oRequest);
        $oResponse = $this->get($key);
        if (!HttpResponse::isValid($oResponse)) {
            $oResponse = parent::getResponse($oRequest, $oProcessor);
            if (!($oResponse->isRedirect() || $oResponse->isError())) {
                $this->addCacheHeaders($oRequest, $this->getView()->getModel(), $oResponse);
            }
            $this->set($key, $oResponse);
        }
        return $oResponse;
    }
}
