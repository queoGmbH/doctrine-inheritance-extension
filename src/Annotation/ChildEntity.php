<?php

namespace Queo\DoctrineInheritanceExtension\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target("CLASS")
 */
class ChildEntity
{
    /**
     * @var string
     */
    public $parent;

    /**
     * @var string
     */
    public $name;
}