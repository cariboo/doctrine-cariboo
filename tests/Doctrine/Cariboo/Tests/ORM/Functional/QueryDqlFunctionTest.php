<?php

namespace Doctrine\Tests\ORM\Functional;

use Doctrine\Tests\Models\Company\CompanyManager;

require_once __DIR__ . '/../../TestInit.php';

/**
 * Functional Query tests.
 *
 * @author robo
 */
class QueryDqlFunctionTest extends \Doctrine\Tests\OrmFunctionalTestCase
{
    protected function setUp()
    {
        $this->useModelSet('company');
        parent::setUp();

        $this->generateFixture();
    }

    /**
     * @group DDC-1014
     */
    public function testDateDiff()
    {
        $query = $this->_em->createQuery("SELECT DATE_DIFF(CURRENT_TIMESTAMP(), DATE_ADD(CURRENT_TIMESTAMP(), 10, 'day')) AS diff FROM Doctrine\Tests\Models\Company\CompanyManager m");
        $arg = $query->getArrayResult();

        $this->assertEquals(-10, $arg[0]['diff'], "Should be roughly -10 (or -9)", 1);

        $query = $this->_em->createQuery("SELECT DATE_DIFF(DATE_ADD(CURRENT_TIMESTAMP(), 10, 'day'), CURRENT_TIMESTAMP()) AS diff FROM Doctrine\Tests\Models\Company\CompanyManager m");
        $arg = $query->getArrayResult();

        $this->assertEquals(10, $arg[0]['diff'], "Should be roughly 10 (or 9)", 1);
    }

    /**
     * @group DDC-1014
     */
    public function testDateAdd()
    {
        $arg = $this->_em->createQuery("SELECT DATE_ADD(CURRENT_TIMESTAMP(), 10, 'day') AS add FROM Doctrine\Tests\Models\Company\CompanyManager m")
                ->getArrayResult();

        $this->assertTrue(strtotime($arg[0]['add']) > 0);

        $arg = $this->_em->createQuery("SELECT DATE_ADD(CURRENT_TIMESTAMP(), 10, 'month') AS add FROM Doctrine\Tests\Models\Company\CompanyManager m")
                ->getArrayResult();

        $this->assertTrue(strtotime($arg[0]['add']) > 0);
    }

    /**
     * @group DDC-1014
     */
    public function testDateSub()
    {
        $arg = $this->_em->createQuery("SELECT DATE_SUB(CURRENT_TIMESTAMP(), 10, 'day') AS add FROM Doctrine\Tests\Models\Company\CompanyManager m")
                ->getArrayResult();

        $this->assertTrue(strtotime($arg[0]['add']) > 0);

        $arg = $this->_em->createQuery("SELECT DATE_SUB(CURRENT_TIMESTAMP(), 10, 'month') AS add FROM Doctrine\Tests\Models\Company\CompanyManager m")
                ->getArrayResult();

        $this->assertTrue(strtotime($arg[0]['add']) > 0);
    }

    protected function generateFixture()
    {
        $manager1 = new CompanyManager();
        $manager1->setName('Roman B.');
        $manager1->setTitle('Foo');
        $manager1->setDepartment('IT');
        $manager1->setSalary(100000);

        $manager2 = new CompanyManager();
        $manager2->setName('Benjamin E.');
        $manager2->setTitle('Foo');
        $manager2->setDepartment('HR');
        $manager2->setSalary(200000);

        $manager3 = new CompanyManager();
        $manager3->setName('Guilherme B.');
        $manager3->setTitle('Foo');
        $manager3->setDepartment('Complaint Department');
        $manager3->setSalary(400000);

        $manager4 = new CompanyManager();
        $manager4->setName('Jonathan W.');
        $manager4->setTitle('Foo');
        $manager4->setDepartment('Administration');
        $manager4->setSalary(800000);

        $this->_em->persist($manager1);
        $this->_em->persist($manager2);
        $this->_em->persist($manager3);
        $this->_em->persist($manager4);
        $this->_em->flush();
        $this->_em->clear();
    }
}
