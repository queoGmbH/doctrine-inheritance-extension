<?php

namespace Queo\DoctrineInheritanceExtension\Tests;

use Queo\DoctrineInheritanceExtension\ChildEntityReader;
use Queo\DoctrineInheritanceExtension\Tests\TestEntity\BaseCategory;
use Queo\DoctrineInheritanceExtension\Tests\TestEntity\PostCategory;
use Queo\DoctrineInheritanceExtension\Tests\TestHelper\TestCase;

class ChildEntityReaderTest extends TestCase
{
    /** @test */
    public function it_returns_a_mapping_of_all_parents_with_their_child_entities()
    {
        $classes = $this->em->getConfiguration()->getMetadataDriverImpl()->getAllClassNames();

        $this->assertEquals([
            BaseCategory::class => [
                'post_category' => PostCategory::class,
            ],
        ], ChildEntityReader::getMapping($classes));
    }
}

