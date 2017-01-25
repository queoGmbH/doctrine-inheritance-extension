<?php

namespace BiteCodes\DoctrineInheritanceExtension;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\DiscriminatorMap;

class DiscriminatorMappingListener
{
    /**
     * @var array
     */
    private $mapping;

    /**
     * @var AnnotationReader
     */
    private $reader;

    public function __construct()
    {
        $this->reader = new AnnotationReader();
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        if (!$this->mapping) {
            $classes = $args->getEntityManager()->getConfiguration()->getMetadataDriverImpl()->getAllClassNames();
            $this->mapping = ChildEntityReader::getMapping($classes);
        }

        $metadata = $args->getClassMetadata();
        $class = $metadata->getReflectionClass();

        if ($class === null) {
            $class = new \ReflectionClass($metadata->getName());
        }

        /** @var DiscriminatorMap $discMapAnnotation */
        if (isset($this->mapping[$class->getName()]) && $discMapAnnotation = $this->reader->getClassAnnotation($class,
                DiscriminatorMap::class)
        ) {
            $metadata->setDiscriminatorMap($this->mapping[$class->getName()]);
        }
    }
}
