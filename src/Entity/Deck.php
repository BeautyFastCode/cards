<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * The deck entity.
 *
 * @ORM\Table(name="decks")
 * @ORM\Entity(repositoryClass="App\Repository\DeckRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Deck extends BaseEntity implements \JsonSerializable
{
    /**
     * The name of an deck.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\Length(min=6, max=64)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * What cards are assigned to this deck.
     * One Deck has Many Cards.
     *
     * @var Collection
     *
     * @OneToMany(targetEntity="Card", mappedBy="deck", cascade={"persist", "remove"})
     */
    private $cards;

    /**
     * To which suites this deck is assigned.
     * Many Decks has Many Suites.
     *
     * @var Collection
     *
     * @ManyToMany(targetEntity="Suite", mappedBy="decks")
     */
    private $suites;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->suites = new ArrayCollection();
        $this->cards = new ArrayCollection();
    }

    /**
     * Returns name.
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets name.
     *
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
     * Adds card.
     *
     * @param Card $card
     *
     * @return Deck
     */
    public function addCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            return $this;
        }

        $this->cards->add($card);
        $card->setDeck($this);

        return $this;
    }

    /**
     * Removes card.
     *
     * @param Card $card
     *
     * @return Deck
     */
    public function removeCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            return $this;
        }

        $this->cards->removeElement($card);

        return $this;
    }

    /**
     * Returns all cards.
     *
     * @return Collection
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    /**
     * Returns only cards Ids.
     *
     * @return array
     */
    public function getCardsIds(): array
    {
        $cardsIds = [];

        if (!$this->cards->isEmpty()) {
            /** @var Card $card */
            foreach ($this->getCards() as $card) {
                $cardsIds[] = $card->getId();
            }
        }

        return $cardsIds;
    }

    /**
     * Adds suite.
     *
     * @param Suite $suite
     *
     * @return Deck
     */
    public function addSuite(Suite $suite): self
    {
        if ($this->suites->contains($suite)) {
            return $this;
        }

        $this->suites->add($suite);
        $suite->addDeck($this);

        return $this;
    }

    /**
     * Removes suite.
     *
     * @param Suite $suite
     *
     * @return Deck
     */
    public function removeSuite(Suite $suite): self
    {
        if (!$this->suites->contains($suite)) {
            return $this;
        }

        $this->suites->removeElement($suite);
        $suite->removeDeck($this);

        return $this;
    }

    /**
     * Returns all suites.
     *
     * @return Collection
     */
    public function getSuites(): Collection
    {
        return $this->suites;
    }

    /**
     * Returns only suites Ids.
     *
     * @return array
     */
    public function getSuitesIds(): array
    {
        $suitesIds = [];

        if (!$this->suites->isEmpty()) {
            /** @var Suite $suite */
            foreach ($this->getSuites() as $suite) {
                $suitesIds[] = $suite->getId();
            }
        }

        return $suitesIds;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'suites' => $this->getSuitesIds(),
            'cards' => $this->getCardsIds(),
        ];
    }
}
