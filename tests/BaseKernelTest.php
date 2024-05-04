<?php 
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BaseKernelTest extends KernelTestCase {
    protected function setUp(): void
    {
        parent::setUp();

        $this->bootKernel();
        $this->markTestIncomplete();
    }
}