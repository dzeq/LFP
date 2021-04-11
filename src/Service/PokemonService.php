<?php

namespace App\Service;

use App\Entity\Pokemon;

class PokemonService
{
    public function calculateTotal(Pokemon $pokemon): int
    {
        return $pokemon->getAttack() + $pokemon->getHp() + $pokemon->getDefense() + $pokemon->getSpAtk() + $pokemon->getSpDef() + $pokemon->getSpeed();
    }
}