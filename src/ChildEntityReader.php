<?php

namespace BiteCodes\DoctrineInheritanceExtension;

use BiteCodes\DoctrineInheritanceExtension\Annotation\ChildEntity;
use Doctrine\Common\Annotations\AnnotationReader;

class ChildEntityReader
{
    public static function getMapping($classes)
    {
        $reader = new AnnotationReader();
        $classes = (array)$classes;
        $mappings = [];

        foreach ($classes as $class) {
            $class = new \ReflectionClass($class);

            /** @var ChildEntity $childEntityAnnotation */
            if (null !== $childEntityAnnotation = $reader->getClassAnnotation($class, ChildEntity::class)) {
                $parent = $childEntityAnnotation->parent;

                if (!class_exists($parent)) {
                    throw new ChildEntityAnnotationException(
                        sprintf("Parent class \"%s\" does not exist", $parent)
                    );
                }

                $mappings[$parent][$childEntityAnnotation->name] = $class->getName();
            }
        }

        return $mappings;
    }
}