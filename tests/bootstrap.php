<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

//require __DIR__ . '/../vendor/autoload.php';
//
//AnnotationRegistry::registerAutoloadNamespace('Queo\DoctrineInheritanceExtension\Annotation', __DIR__ . '/../src/Annotation');

$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));