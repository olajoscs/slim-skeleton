<?php

/** @var \Slim\App $app */

use App\Core\Config;
use OlajosCs\QueryBuilder\Contracts\Connection;

$container = $app->getContainer();

/**
 * Config beállítása
 *
 * @param \Slim\Container $container
 *
 * @return Config
 */
$container[Config::class] = function(\Slim\Container $container) {
    $configArray = include __DIR__ . '/../config/config.php';

    return new Config($configArray);
};


/**
 * DB kapcsolat beállítása
 *
 * @param \Slim\Container $container
 *
 * @return Connection
 *
 * @throws \OlajosCs\QueryBuilder\Exceptions\InvalidDriverException
 * @throws \Interop\Container\Exception\ContainerException
 */
$container[Connection::class] = function($container) {
    $configArray = $container->get(Config::class)->get('database');

    // TODO: QueryBuilder default config class
    $config = new class($configArray) implements \OlajosCs\QueryBuilder\Config
    {
        private $config;

        public function __construct(array $configArray)
        {
            $this->config = $configArray;
        }

        public function getHost()
        {
            return $this->config['host'];
        }


        public function getUser()
        {
            return $this->config['username'];
        }


        public function getPassword()
        {
            return $this->config['password'];
        }


        public function getDatabase()
        {
            return $this->config['database'];
        }


        public function getOptions()
        {
            return $this->config['options'] ?: [];
        }


        public function getDatabaseType()
        {
            return $this->config['type'];
        }
    };

    $pdo = new \OlajosCs\QueryBuilder\PDO($config);
    $connectionFactory = new \OlajosCs\QueryBuilder\ConnectionFactory();

    return $connectionFactory->create($pdo);
};
