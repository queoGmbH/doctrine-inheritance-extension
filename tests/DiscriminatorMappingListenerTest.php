<?php

namespace Queo\DoctrineInheritanceExtension\Tests;

use Queo\DoctrineInheritanceExtension\Tests\TestEntity\AuthorCategory;
use Queo\DoctrineInheritanceExtension\Tests\TestEntity\BaseCategory;
use Queo\DoctrineInheritanceExtension\Tests\TestEntity\PostCategory;
use Queo\DoctrineInheritanceExtension\Tests\TestHelper\TestCase;

class DiscriminatorMappingListenerTest extends TestCase
{
    /** @test */
    public function it_adds_child_entity_to_the_discriminator_mapping()
    {
        $metadata = $this->em->getClassMetadata(BaseCategory::class);

        $this->assertEquals([
            'author_category' => AuthorCategory::class,
            'post_category'   => PostCategory::class,
        ], $metadata->discriminatorMap);
    }
}
