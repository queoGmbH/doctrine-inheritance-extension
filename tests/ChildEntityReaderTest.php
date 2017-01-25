<?php

namespace BiteCodes\DoctrineInheritanceExtension\Tests;

use BiteCodes\DoctrineInheritanceExtension\ChildEntityReader;
use BiteCodes\DoctrineInheritanceExtension\Tests\TestEntity\BaseCategory;
use BiteCodes\DoctrineInheritanceExtension\Tests\TestEntity\PostCategory;
use BiteCodes\DoctrineInheritanceExtension\Tests\TestHelper\TestCase;

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

