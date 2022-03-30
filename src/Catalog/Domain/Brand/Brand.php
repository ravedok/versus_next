<?php

namespace VS\Next\Catalog\Domain\Brand;

class Brand
{
    private BrandId $id;
    private BrandName $name;

    public function __construct(BrandId $id, BrandName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): BrandId
    {
        return $this->id;
    }

    public function getName(): BrandName
    {
        return $this->name;
    }

    public function setName(BrandName $name): self
    {
        $this->name = $name;

        return $this;
    }
}
