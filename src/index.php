<?php
/*
 * Copyright (c) 2024 Ueppy S.R.L.
 */

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use ProxyManager\Configuration;
use ProxyManager\FileLocator\FileLocator;
use ProxyManager\GeneratorStrategy\FileWriterGeneratorStrategy;

require_once __DIR__ . '/../vendor/autoload.php';

class Repository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, 'anything');
    }
}

$initializer = function () {
    return true;
};


$proxiesDirectory = __DIR__ . '/var/cache/aaaa/';
@mkdir($proxiesDirectory, recursive: true);

$config = new Configuration();
$config->setGeneratorStrategy(new FileWriterGeneratorStrategy(new FileLocator($proxiesDirectory)));
$config->setProxiesTargetDir($proxiesDirectory);
\spl_autoload_register($config->getProxyAutoloader());
$factory = new \ProxyManager\Factory\LazyLoadingValueHolderFactory($config);
$proxy   = $factory->createProxy(Repository::class, $initializer, ['skipDestructor' => true]);
echo '1';

die;
