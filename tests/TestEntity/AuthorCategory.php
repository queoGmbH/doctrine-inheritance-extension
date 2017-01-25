<?php

namespace BiteCodes\DoctrineInheritanceExtension\Tests\TestEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="author_category")
 */
class AuthorCategory extends BaseCategory
{
}