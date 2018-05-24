<?php

declare(strict_types = 1);

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
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * The suite entity.
 *
 * @ORM\Table(name="suites")
 * @ORM\Entity(repositoryClass="App\Repository\SuiteRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Suite extends BaseEntity implements \JsonSerializable
{
    /**
     * The name of an suite.
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
     * What decks are assigned to this suite.
     * Many Suites has Many Decks.
     *
     * @var Collection
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
     * @return Suite
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Checks if the Suite has this deck.
     *
     * @param Deck $deck
     *
     * @return bool
     */
    public function hasDeck(Deck $deck): bool
    {
        if ($this->decks->contains($deck)) {
            return true;
        }

        return false;
    }

    /**
     * Adds deck.
     *
     * @param Deck $deck
     *
     * @return Suite
     */
    public function addDeck(Deck $deck): Suite
    {
        if ($this->hasDeck($deck)) {
            return $this;
        }

        $this->decks->add($deck);
        $deck->addSuite($this);

        return $this;
    }

    /**
     * Removes deck.
     *
     * @param Deck $deck
     *
     * @return Suite
     */
    public function removeDeck(Deck $deck): Suite
    {
        if ($this->hasDeck($deck)) {

            $this->decks->removeElement($deck);
            $deck->removeSuite($this);
        }

        return $this;
    }

    /**
     * Returns all decks.
     *
     * @return Collection
     */
    public function getDecks(): Collection
    {
        return $this->decks;
    }

    /**
     * Returns only decks Ids.
     *
     * @return array
     */
    public function getDecksIds(): array
    {
        $decksIds = [];

        if (!$this->decks->isEmpty()) {

            /** @var Deck $deck */
            foreach ($this->getDecks() as $deck) {
                $decksIds[] = $deck->getId();
            }
        }

        return $decksIds;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'decks' => $this->getDecksIds(),
        ];
    }
}
