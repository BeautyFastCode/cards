<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="decks")
 * @ORM\Entity(repositoryClass="App\Repository\DeckRepository")
 */
class Deck implements \JsonSerializable
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\Length(min=6, max=64)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * Many Decks has Many Suites.
     *
     * @var ArrayCollection
     *
     * @ManyToMany(targetEntity="Suite", mappedBy="decks")
     */
    private $suites;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->suites = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * 
     * @return Deck
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param Suite $suite
     *
     * @return Deck
     */
    public function addSuite(Suite $suite): self
    {
        $this->suites[] = $suite;

        return $this;
    }

    /**
     * @param Suite $suite
     *
     * @return Deck
     */
    public function removeSuite(Suite $suite): self
    {
        $this->suites->removeElement($suite);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSuites(): ArrayCollection
    {
        return $this->suites;
    }

    /**
     * {@inheritdoc}
     */
    function jsonSerialize(): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
        ];
    }
}
