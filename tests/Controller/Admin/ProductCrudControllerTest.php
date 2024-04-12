<?php
namespace App\Tests\Controller\Admin;

use App\Entity\Product;
use App\Tests\BaseKernelTest;
use App\Controller\Admin\ProductCrudController;

class ProductCrudControllerTest extends BaseKernelTest {

    public function testCreateProduct(): void {
        $productCrudController = new ProductCrudController();

        $createdEntity = $productCrudController->createEntity(Product::class);

        $this->assertInstanceOf(Product::class, $createdEntity);
    }

    public function testUpdateProduct(): void {
        $product = new Product();
        $product->setEan('1234');
        $product->setUrlKey('url-key');
        $product->setPrice(1234);

        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $productRepo = $entityManager->getRepository(Product::class);

        $productCrudController = new ProductCrudController();
        $productCrudController->updateEntity($entityManager, $product);

        $updatedProduct = $productRepo->find($product->getId());

        $this->assertSame('1234',$updatedProduct->getEan());
        $this->assertSame(1234,$updatedProduct->getPrice());
    }
}