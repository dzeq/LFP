<?php

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Pokemon;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class PokemonTest extends ApiTestCase
{
    // This trait provided by HautelookAliceBundle will take care of refreshing the database content to a known state before each test
    use RefreshDatabaseTrait;

    private const ARTIKODIN = [
        'name' => 'Artikodin',
        'type1' => 'vol',
        'type2' => 'glace',
        'hp' => 130,
        'attack' => 100,
        'defense' => 100,
        'spAtk' => 100,
        'spDef' => 100,
        'speed' => 100,
        'generation' => 1,
        'isLegendary' => true,
    ];

    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/api/pokemon');

        // Assert http response is 200
        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        // Assert we have our 100 fakes pokemon
        self::assertJsonContains([
            '@context' => '/api/contexts/Pokemon',
            '@id' => '/api/pokemon',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 100,
            'hydra:view' => [
                '@id' => '/api/pokemon?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/api/pokemon?page=1',
                'hydra:last' => '/api/pokemon?page=4',
                'hydra:next' => '/api/pokemon?page=2',
            ],
        ]);

        // Asset we have 30 pokemon for a full page (page1 here)
        self::assertCount(30, $response->toArray()['hydra:member']);

        self::assertMatchesResourceCollectionJsonSchema(Pokemon::class);
    }

    public function testCreatePokemon(): void
    {
        $response = static::createClient()->request('POST', '/api/pokemon', ['json' => self::ARTIKODIN]);

        self::assertResponseStatusCodeSame(201);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonContains(array_merge(self::ARTIKODIN, [
            '@context' => '/api/contexts/Pokemon',
            '@type' => 'Pokemon',
        ]));
        self::assertRegExp('~^/api/pokemon/\d+$~', $response->toArray()['@id']);
        self::assertMatchesResourceItemJsonSchema(Pokemon::class);
    }

    public function testCreateInvalidPokemon(): void
    {
        $response = static::createClient()->request('POST', '/api/pokemon', ['json' => ['name' => 'null']]);

        self::assertResponseStatusCodeSame(422);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        //check if we have a nice error message
        self::assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'hydra:title' => 'An error occurred',
            'hydra:description' => "type1: This value should not be blank.\nhp: This value should not be blank.\nattack: This value should not be blank.\ndefense: This value should not be blank.\nspAtk: This value should not be blank.\nspDef: This value should not be blank.\nspeed: This value should not be blank.\ngeneration: This value should not be blank.\nisLegendary: This value should not be null.",
        ]);
    }

    public function testUpdatePokemon(): void
    {
        $client = static::createClient();

        //Disable reboot to keep having Artikodin in this test
        $client->disableReboot();
        $client->request('POST', '/api/pokemon', ['json' => self::ARTIKODIN]);

        // findIriBy allows to retrieve the IRI of a pokemon by searching for some of its properties.
        $iri = $this->findIriBy(Pokemon::class, ['name' => self::ARTIKODIN['name']]);

        $client->request('PUT', $iri, ['json' => [
            'name' => 'artikodindon',
            'isLegendary' => false,
            'defense' => 16,
        ]]);

        self::assertResponseIsSuccessful();
        //check if name the name of our legendary pokemon changed to Artikodindon
        self::assertJsonContains([
            '@id' => $iri,
            'name' => 'artikodindon',
            'isLegendary' => false,
            'defense' => 16,
        ]);
    }

    public function testDeletePokemon(): void
    {
        $client = static::createClient();

        //Disable reboot to keep having Artikodin in this test
        $client->disableReboot();
        $client->request('POST', '/api/pokemon', ['json' => self::ARTIKODIN]);

        //Assert that we have Artikodin in base
        self::assertNotNull(
            static::$container->get('doctrine')->getRepository(Pokemon::class)->findOneBy(['name' => self::ARTIKODIN['name']])
        );

        // findIriBy allows to retrieve the IRI of a pokemon by searching for some of its properties.
        $iri = $this->findIriBy(Pokemon::class, ['name' => self::ARTIKODIN['name']]);

        $client->request('DELETE', $iri);

        self::assertResponseStatusCodeSame(204);
        //Assert that we dont have Artikodin in base
        self::assertNull(
            static::$container->get('doctrine')->getRepository(Pokemon::class)->findOneBy(['name' => self::ARTIKODIN['name']])
        );
    }
}
