<?php 
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class BaseKernelTest extends KernelTestCase {
    protected function setUp(): void
    {
        parent::setUp();

        $this->bootKernel();

        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $entityManager->getConnection()->setNestTransactionsWithSavepoints(true);
        $entityManager->beginTransaction();
    }

    protected function tearDown(): void
    {
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');

        if ($entityManager->getConnection()->isTransactionActive()) {
            $entityManager->rollback();
        }

        $entityManager->close();
        parent::tearDown();
    }

    public function testCanConnectToDatabase() {
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');

        $connection = $entityManager->getConnection();

        $this->assertNotEmpty($connection->fetchAllAssociative('SELECT 1'));
    }
}