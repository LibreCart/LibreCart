<?php 

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryTest extends TestCase{

    public function testCategoryAssociatedWithProduct() {
        $product = new Product();
        $category = new Category();

        $category->addProduct($product);
        
        $this->assertCount(1, $category->getProducts());
        $this->assertSame($category, $product->getCategories()->first());
    }
}