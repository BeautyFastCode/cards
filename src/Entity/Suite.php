<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="suites")
 * @ORM\Entity(repositoryClass="App\Repository\SuiteRepository")
 */
class Suite implements \JsonSerializable
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
     * Many Suites has Many Decks.
     *
     * @var ArrayCollection
     *
     * @ManyToMany(targetEntity="Deck", inversedBy="suites")
     * @JoinTable(name="suites_decks")
     */
    private $decks;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->decks = new ArrayCollection();
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
     * @return Suite
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param Deck $deck
     *
     * @return Suite
     */
    public function addDeck(Deck $deck): Suite
    {
        $this->decks[] = $deck;

        return $this;
    }

    /**
     * @param Deck $deck
     *
     * @return Suite
     */
    public function removeDeck(Deck $deck): Suite
    {
        $this->decks->removeElement($deck);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDecks(): ArrayCollection
    {
        return $this->decks;
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
