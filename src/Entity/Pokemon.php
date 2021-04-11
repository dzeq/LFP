<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PokemonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"pokemon:read"}},
 *     denormalizationContext={"groups"={"pokemon:write"}}
 * )
 * @ORM\Entity(repositoryClass=PokemonRepository::class)
 */
class Pokemon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"pokemon:read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     * @Groups({"pokemon:read", "pokemon:write"})
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     * @Groups({"pokemon:read", "pokemon:write"})
     */
    private string $type1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"pokemon:read", "pokemon:write"})
     */
    private ?string $type2 = null;

    /**
     * @ORM\Column(type="integer", length=255)
     *
     * @Groups({"pokemon:read"})
     */
    private int $total;

    /**
     * @ORM\Column(type="integer", length=255)
     *
     * @Assert\NotBlank
     * @Groups({"pokemon:read", "pokemon:write"})
     */
    private int $hp;

    /**
     * @ORM\Column(type="integer", length=255)
     *
     * @Assert\NotBlank
     * @Groups({"pokemon:read", "pokemon:write"})
     */
    private int $attack;

    /**
     * @ORM\Column(type="integer", length=255)
     *
     * @Assert\NotBlank
     * @Groups({"pokemon:read", "pokemon:write"})
     */
    private int $defense;

    /**
     * @ORM\Column(type="integer", length=255)
     *
     * @Assert\NotBlank
     * @Groups({"pokemon:read", "pokemon:write"})
     */
    private int $spAtk;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank
     * @Groups({"pokemon:read", "pokemon:write"})
     */
    private int $spDef;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank
     * @Groups({"pokemon:read", "pokemon:write"})
     */
    private int $speed;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank
     * @Groups({"pokemon:read", "pokemon:write"})
     */
    private int $generation;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Assert\NotNull()
     * @Groups({"pokemon:read", "pokemon:write"})
     */
    private bool $isLegendary;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups({"pokemon:read"})
     */
    private ?\DateTime $updatedAt = null;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({"pokemon:read"})
     */
    private \DateTime $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType1(): ?string
    {
        return $this->type1;
    }

    public function setType1(string $type1): self
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?string
    {
        return $this->type2;
    }

    public function setType2(?string $type2): self
    {
        $this->type2 = $type2;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return int
     */
    public function getHp(): int
    {
        return $this->hp;
    }

    /**
     * @param int $hp
     */
    public function setHp(int $hp): void
    {
        $this->hp = $hp;
    }

    /**
     * @return int
     */
    public function getAttack(): int
    {
        return $this->attack;
    }

    /**
     * @param int $attack
     */
    public function setAttack(int $attack): void
    {
        $this->attack = $attack;
    }

    /**
     * @return int
     */
    public function getDefense(): int
    {
        return $this->defense;
    }

    /**
     * @param int $defense
     */
    public function setDefense(int $defense): void
    {
        $this->defense = $defense;
    }

    /**
     * @return int
     */
    public function getSpAtk(): int
    {
        return $this->spAtk;
    }

    /**
     * @param int $spAtk
     */
    public function setSpAtk(int $spAtk): void
    {
        $this->spAtk = $spAtk;
    }

    /**
     * @return int
     */
    public function getSpDef(): int
    {
        return $this->spDef;
    }

    /**
     * @param int $spDef
     */
    public function setSpDef(int $spDef): void
    {
        $this->spDef = $spDef;
    }

    /**
     * @return int
     */
    public function getSpeed(): int
    {
        return $this->speed;
    }

    /**
     * @param int $speed
     */
    public function setSpeed(int $speed): void
    {
        $this->speed = $speed;
    }

    /**
     * @return int
     */
    public function getGeneration(): int
    {
        return $this->generation;
    }

    /**
     * @param int $generation
     */
    public function setGeneration(int $generation): void
    {
        $this->generation = $generation;
    }

    /**
     * @return bool
     */
    public function getIsLegendary(): bool
    {
        return $this->isLegendary;
    }

    /**
     * @param bool $isLegendary
     */
    public function setIsLegendary(bool $isLegendary): void
    {
        $this->isLegendary = $isLegendary;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
