<?php

namespace Queo\DoctrineInheritanceExtension;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\DiscriminatorMap;

class DiscriminatorMappingListener
{
    /**
     * Check if mapping has been initialized
     *
     * @var bool
     */
    private $initialized = false;

    /**
     * @var array
     */
    private $mapping = [];

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        if (!$this->initialized) {
            $classes = $args->getEntityManager()->getConfiguration()->getMetadataDriverImpl()->getAllClassNames();
            $this->mapping = ChildEntityReader::getMapping($classes);
            $this->initialized = true;
        }

        $metadata = $args->getClassMetadata();
        $class = $metadata->getReflectionClass();

        if ($class === null) {
            $class = new \ReflectionClass($metadata->getName());
        }

        if (isset($this->mapping[$class->getName()])) {
            $metadata->setDiscriminatorMap($this->mapping[$class->getName()]);
        }
    }
}
