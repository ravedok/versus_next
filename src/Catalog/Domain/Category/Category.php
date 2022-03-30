<?php

namespace VS\Next\Catalog\Domain\Category;

use VS\Next\Catalog\Domain\Category\CategoryId;
use VS\Next\Catalog\Domain\Category\CategoryName;


class Category
{
    private CategoryId $id;
    private CategoryName $name;

    public function __construct(CategoryId $id, CategoryName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): CategoryId
    {
        return $this->id;
    }

    public function getName(): CategoryName
    {
        return $this->name;
    }

    public function setName(CategoryName $name): self
    {
        $this->name = $name;

        return $this;
    }
}
