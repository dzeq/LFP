<?php

namespace App\Tests\Unit\Service;

use App\Service\PokemonService;
use App\Entity\Pokemon;
use PHPUnit\Framework\TestCase;

class PokemonServiceTest extends TestCase
{
    public function testCalculateTotal(): void
    {
        $pokemonService = new PokemonService();
        $pokemon = new Pokemon();
        $pokemon->setAttack(10);
        $pokemon->setHp(10);
        $pokemon->setSpAtk(10);
        $pokemon->setSpDef(10);
        $pokemon->setDefense(10);
        $pokemon->setSpeed(10);

        $result = $pokemonService->calculateTotal($pokemon);

        self::assertEquals(60, $result);
    }
}
