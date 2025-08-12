<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Redis extends BaseConfig
{
    public function __construct(
        public null|string $host = null,
        public null|int $port = null,
        public null|string $password = null,
        public null|int $database = null

    ) {
        parent::__construct();

        $this->host ??= env('redis.host', 'redis');
        $this->port ??= env('redis.port', 6379);
        $this->password ??= env('redis.password', '');
        $this->database ??= env('redis.database', (ENVIRONMENT === 'production') ? 1 : 0);
    }
}