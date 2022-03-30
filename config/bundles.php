<?php

return [    
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    VS\Next\Catalog\Infrastructure\VSNextCatalogBundle::class => ['all' => true],
    VS\Next\Checkout\Infrastructure\VSNextCheckoutBundle::class => ['all' => true],
    VS\Next\Shared\Infrastructure\VSNextSharedBundle::class => ['all' => true]
];
