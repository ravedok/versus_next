<?php

namespace VS\Next\Checkout\Application\Content\ReduceProduct;

use VS\Next\Checkout\Application\Content\Shared\AbstractContentRequest;

class ReduceProductRequest extends AbstractContentRequest
{
    public int $units = 1;

    // /** @param int $units */
    // private function __construct(protected $productSku, protected $reconditioned = false,  protected $units = 1, protected array $options = [])
    // {
    // }

    // /** @return int */
    // public function getUnits()
    // {
    //     return $this->units;
    // }

    // /** @param array<string, mixed> $data */
    // public static function fromArray(array $data): self
    // {
    //     return new self(
    //         $data['productSku'] ?? null,
    //         $data['reconditioned'] ?? false,
    //         $data['units'] ?? 1,
    //         $data['options'] ?? []
    //     );
    // }
}
