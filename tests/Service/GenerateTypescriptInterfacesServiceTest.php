<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\GenerateTypescriptInterfacesService;
use PHPUnit\Framework\TestCase;
use stdClass;

class GenerateTypescriptInterfacesServiceTest extends TestCase{
    
    public function testCanScanEntities(): void {
        $scanEntities = new \ReflectionMethod(GenerateTypescriptInterfacesService::class,'scanEntities');

        $scannedEntities = $scanEntities->invoke(new GenerateTypescriptInterfacesService());

        $this->assertNotEmpty($scannedEntities);
    }

    public function testCanGetClassProperties(): void {
        $getClassProperties = new \ReflectionMethod(GenerateTypescriptInterfacesService::class,'getClassProperties');

        $properties = $getClassProperties->invoke(new GenerateTypescriptInterfacesService(),new TestClass());

        $this->assertNotEmpty($properties);
    }

    public function testCanPrepareTypescriptInterface(): void {
        $prepareTypescriptInterface = new \ReflectionMethod(GenerateTypescriptInterfacesService::class,'prepareTypescriptInterface');

        $preparedTypescriptInterface = $prepareTypescriptInterface->invoke(new GenerateTypescriptInterfacesService(),new TestClass());

        $expectedInterface = <<<'TS'
        export interface TestClass {
            id: number;
            name: string;
        }
        TS;
        $expectedInterface = str_replace("\r", '', $expectedInterface);
 
        $this->assertEquals($expectedInterface, $preparedTypescriptInterface);
    }
}

