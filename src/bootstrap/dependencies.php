<?php

/** @var \Slim\App $app */

use App\Core\Config;
use OlajosCs\QueryBuilder\ConnectionConfig;
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

    $config = new class($configArray) extends ConnectionConfig
    {
        public function __construct(array $config)
        {
            $this->host         = $config['host'];
            $this->user         = $config['username'];
            $this->password     = $config['password'];
            $this->database     = $config['database'];
            $this->options      = $config['options'] ?: [];
            $this->databaseType = $config['type'];
        }
    };

    $pdo = new \OlajosCs\QueryBuilder\PDO($config);
    $connectionFactory = new \OlajosCs\QueryBuilder\ConnectionFactory();

    return $connectionFactory->create($pdo);
};
