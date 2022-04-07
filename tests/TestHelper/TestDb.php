<?php

namespace Queo\DoctrineInheritanceExtension\Tests\TestHelper;

use Queo\DoctrineInheritanceExtension\ChildEntityReader;
use Queo\DoctrineInheritanceExtension\DiscriminatorMappingListener;
use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Configuration;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class TestDb
{
    /**
     * @var Configuration
     */
    private $doctrineConfig;

    /**
     * @var array
     */
    private $connectionOptions;

    /**
     * @var EventManager
     */
    private $evm;

    /**
     * @param string $annotationPath
     * @param string $proxyDir
     * @param string $proxyNamespace
     */
    public function __construct($annotationPath, $proxyDir, $proxyNamespace)
    {
        $cache = new FilesystemAdapter();

        $config = new Configuration();
        $config->setMetadataCache($cache);
        $config->setQueryCache($cache);
        $config->setMetadataDriverImpl(
            $config->newDefaultAnnotationDriver([$annotationPath], false)
        );
        $config->setProxyDir($proxyDir);
        $config->setProxyNamespace($proxyNamespace);
        $config->setAutoGenerateProxyClasses(true);

        $this->connectionOptions = [
            'driver' => 'pdo_sqlite',
            'path'   => ':memory:',
        ];

        $this->doctrineConfig = $config;

        $this->evm = new EventManager();
        $this->evm->addEventListener(
            Events::loadClassMetadata,
            new DiscriminatorMappingListener(
                ChildEntityReader::getMapping($config->getMetadataDriverImpl()->getAllClassNames())
            )
        );
    }

    /**
     * @return EntityManager
     */
    public function createEntityManager()
    {
        $em = EntityManager::create(
            $this->connectionOptions,
            $this->doctrineConfig,
            $this->evm
        );
        $this->createSchema($em);

        return $em;
    }

    /**
     * @param EntityManager $em
     */
    private function createSchema(EntityManager $em)
    {
        $tool = new SchemaTool($em);
        $tool->createSchema($em->getMetadataFactory()->getAllMetadata());
    }
}