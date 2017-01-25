<?php

namespace BiteCodes\DoctrineInheritanceExtension\Tests\TestEntity;

use BiteCodes\DoctrineInheritanceExtension\Annotation\ChildEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="post_category")
 * @ChildEntity(parent="BiteCodes\DoctrineInheritanceExtension\Tests\TestEntity\BaseCategory", name="post_category")
 */
class PostCategory extends BaseCategory
{
}