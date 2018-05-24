<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * The card entity.
 *
 * @ORM\Table(name="cards")
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Card extends BaseEntity implements \JsonSerializable
{
    /**
     * The question an user is responding to.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(min=6, max=255)
     */
    private $question;

    /**
     * The correct answer to the question.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(min=6, max=255)
     */
    private $answer;

    /**
     * To which deck this card is assigned.
     * Many Cards have One Deck.
     *
     * @var Deck
     *
     * @ManyToOne(targetEntity="Deck", inversedBy="cards")
     * @JoinColumn(name="deck_id", referencedColumnName="id", nullable=false)
     *
     * @Assert\NotNull()
     */
    private $deck;

    /**
     * Returns question.
     *
     * @return null|string
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * Sets question.
     *
     * @param null|string $question
     *
     * @return Card
     */
    public function setQuestion(?string $question): self
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Returns answer.
     *
     * @return null|string
     */
    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    /**
     * Sets answer.
     *
     * @param null|string $answer
     *
     * @return Card
     */
    public function setAnswer(?string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Returns deck.
     *
     * @return null|Deck
     */
    public function getDeck(): ?Deck
    {
        return $this->deck;
    }

    /**
     * Sets deck.
     *
     * @param Deck $deck
     *
     * @return Card
     */
    public function setDeck(Deck $deck): Card
    {
        $this->deck = $deck;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        $deckId = null;

        if (null !== $this->deck) {
            $deckId = $this->deck->getId();
        }

        return [
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
            'deck' => $deckId,
        ];
    }
}
