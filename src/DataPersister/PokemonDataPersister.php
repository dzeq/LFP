<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Pokemon;
use App\Service\PokemonService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PokemonDataPersister implements ContextAwareDataPersisterInterface
{
    private EntityManagerInterface $em;
    private ?Request $request;
    private PokemonService $pokemonService;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $request,
        PokemonService $pokemonService
    ) {
        $this->em = $entityManager;
        $this->request = $request->getCurrentRequest();
        $this->pokemonService = $pokemonService;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Pokemon;
    }

    public function persist($data, array $context = []): void
    {
        // Set the updatedAt value if it's not a POST request
        if ($this->request->getMethod() !== 'POST') {
            $data->setUpdatedAt(new \DateTime());
        }

        //calculate or recalculate total property
        $data->setTotal($this->pokemonService->calculateTotal($data));

        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data, array $context = []): void
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}
