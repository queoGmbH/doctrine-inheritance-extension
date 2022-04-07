<?php

namespace Queo\DoctrineInheritanceExtension\Tests\TestEntity;

use Queo\DoctrineInheritanceExtension\Annotation\ChildEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="post_category")
 * @ChildEntity(parent="Queo\DoctrineInheritanceExtension\Tests\TestEntity\BaseCategory", name="post_category")
 */
class PostCategory extends BaseCategory
{
}