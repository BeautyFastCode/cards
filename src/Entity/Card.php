<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="cards")
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card implements \JsonSerializable
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
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(min=6, max=255)
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(min=6, max=255)
     */
    private $answer;

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
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
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
     * @return null|string
     */
    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    /**
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
     * {@inheritdoc}
     */
    function jsonSerialize(): array
    {
        return [
            'id'       => $this->id,
            'question' => $this->question,
            'answer'   => $this->answer,
        ];
    }
}
