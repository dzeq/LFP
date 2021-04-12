<?php

namespace App\Tests\Functional\Repository;

use App\Entity\Pokemon;
use Doctrine\ORM\EntityManager;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PokemonRepositoryTest extends KernelTestCase
{
    use RefreshDatabaseTrait;

    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testFind(): void
    {
        $pokemon = $this->entityManager
            ->getRepository(Pokemon::class)
            ->find(6)
        ;

        self::assertInstanceOf(Pokemon::class, $pokemon);
        self::assertSame('a', $pokemon->getName());
    }

    public function testFindByName(): void
    {
        $pokemon = $this->entityManager
            ->getRepository(Pokemon::class)
            ->findOneBy(['name' => 'quibusdam'])
        ;

        self::assertInstanceOf(Pokemon::class, $pokemon);
        self::assertSame(488, $pokemon->getTotal());
    }

    public function testFindAll(): void
    {
        $pokemons = $this->entityManager
            ->getRepository(Pokemon::class)
            ->findAll()
        ;

        self::assertInstanceOf(Pokemon::class, $pokemons[12]);
        self::assertCount(100, $pokemons);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
    }
}
