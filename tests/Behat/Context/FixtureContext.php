<?php

namespace VS\Next\Tests\Behat\Context;

use Doctrine\DBAL\Connection;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Fidry\AliceDataFixtures\LoaderInterface;
use PhpParser\Node\Expr\Instanceof_;
use VS\Next\Tests\Behat\Context\SharedContextTrait;

class FixtureContext implements Context
{
    use SharedContextTrait;

    /** @var LoaderInterface */
    private $loader;

    /** @var string */
    private $fixturesBasePath;

    /**
     * @var array Will contain all fixtures in an array with the fixture
     *            references as key
     */
    private $fixtures;

    private ManagerRegistry $doctrine;

    public function __construct(
        ManagerRegistry $doctrine,
        LoaderInterface $loader,
        string $fixturesBasePath
    ) {
        $this->doctrine = $doctrine;
        $this->loader = $loader;
        $this->fixturesBasePath = $fixturesBasePath;



        /** @var Connection[] $connections */
        $connections = $doctrine->getConnections();

        foreach ($connections as $connection) {
            if (get_class($connection->getDriver()->getDatabasePlatform()) !== SqlitePlatform::class) {
                throw new \RuntimeException(sprintf(
                    'Fixtures must be loaded in an sqlite database, current database driver is %s,
                there must be an issue with test configuration.',
                    $connection->getDriver()->getDatabasePlatform()::class
                ));
            }
        }

        /** @var ObjectManager[] $managers */
        $managers = $doctrine->getManagers(); // Note that currently, FidryAliceDataFixturesBundle does not support multiple managers

        foreach ($managers as $manager) {
            if ($manager instanceof EntityManagerInterface) {
                $schemaTool = new SchemaTool($manager);
                $schemaTool->dropDatabase();
                $schemaTool->createSchema($manager->getMetadataFactory()->getAllMetadata());
            }
        }
    }

    /**
     * @Given the fixtures file :fixturesFile is loaded
     */
    public function theFixturesFileIsLoaded(string $fixturesFile): void
    {
        $this->fixtures = $this->loader->load([$this->fixturesBasePath . $fixturesFile]);

        foreach ($this->doctrine->getManagers() as $manager) {
            if ($manager instanceof EntityManagerInterface) {
                $manager->clear();
            }
        }

        $this->sharingContext->merge($this->fixtures);
    }
}
