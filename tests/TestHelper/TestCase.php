<?php

namespace Queo\DoctrineInheritanceExtension\Tests\TestHelper;

use Doctrine\ORM\EntityManager;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var TestDb
     */
    protected $testDb;

    /**
     * @var EntityManager
     */
    protected $em;

    public function setUp(): void
    {
        parent::setUp();

        $here = __DIR__;

        $this->testDb = new TestDb(
            $here . '/../TestEntity',
            $here . '/../TestProxy',
            'Queo\DoctrineInheritanceExtension\Tests\TestEntity'
        );

        $this->em = $this->testDb->createEntityManager();
    }

    protected function seeInDatabase($entity, $criteria)
    {
        $count = $this->getDatabaseCount($entity, $criteria);

        $this->assertGreaterThan(0, $count, sprintf(
            'Unable to find row in database table [%s] that matched attributes [%s].', $entity, json_encode($criteria)
        ));

        return $this;
    }

    protected function seeNotInDatabase($entity, $criteria)
    {
        $count = $this->getDatabaseCount($entity, $criteria);

        $this->assertEquals(0, $count, sprintf(
            'Found row in database table [%s] that matched attributes [%s].', $entity, json_encode($criteria)
        ));

        return $this;
    }

    protected function getDatabaseCount($entity, $criteria)
    {
        $qb = $this->em
            ->createQueryBuilder()
            ->select('COUNT(e)')
            ->from($entity, 'e');

        foreach($criteria as $field => $value) {
            $qb->andWhere("e.{$field} = :{$field}")->setParameter($field, $value);
        }

        return $qb->getQuery()->getSingleScalarResult();
    }
}