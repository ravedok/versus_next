<?php

namespace VS\Next\Catalog\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\Exception\ProductNotFoundException;

/** 
 * @extends ServiceEntityRepository<Product>
 */
class ProductDoctrineRepository extends ServiceEntityRepository implements ProductRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findOneById(ProductId $id): ?Product
    {
        return parent::find($id->value());
    }

    public function findOneBySku(string $sku): ?Product
    {
        return parent::findOneBy(['sku' => $sku]);
    }

    public function findOneBySkuOrFail(string $sku): Product
    {
        $product = parent::findOneBy(['sku' => $sku]);

        if (!$product) {
            throw new ProductNotFoundException;
        }

        return $product;
    }
}
