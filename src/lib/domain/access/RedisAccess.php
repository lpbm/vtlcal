<?php
namespace tlcal\domain\access;
use Predis;

class RedisAccess
{
    /**
     * @var Predis\Client
     */
    private $connection;

    public function __construct()
    {
        $this->connection = new Predis\Client('tcp://127.0.0.1:6379', ['exceptions' => false]);
    }

    public function get($key)
    {
        if (is_null($this->connection)) {
            return null;
        }
        return $this->connection->get($key);
    }

    public function has($key)
    {
        return !is_null($this->connection) && !is_null($this->connection->get($key));
    }

    public function set($key, $value, $ttl = null)
    {
        if (is_null($this->connection)) {
            return null;
        }
        return $this->connection->set($key, $value, null, $ttl);
    }
}
