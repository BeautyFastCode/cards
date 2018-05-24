<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Entity;

use App\Entity\Card;
use App\Entity\Deck;
use App\Entity\Traits\BaseEntityInterface;
use App\Entity\Traits\SoftDeletableInterface;
use App\Entity\Traits\TimestampableInterface;
use JsonSerializable;
use PhpSpec\ObjectBehavior;

/**
 * Specification for Card entity.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class CardSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Card::class);
    }

    public function it_have_behaviors()
    {
        $this->shouldImplement(BaseEntityInterface::class);
        $this->shouldImplement(SoftDeletableInterface::class);
        $this->shouldImplement(TimestampableInterface::class);
    }

    public function it_have_question_property()
    {
        $this
            ->getQuestion()
            ->shouldReturn(null);

        $this
            ->setQuestion('How are you?')
            ->shouldReturn($this);

        $this
            ->getQuestion()
            ->shouldReturn('How are you?');
    }

    public function it_have_answer_property()
    {
        $this
            ->getAnswer()
            ->shouldReturn(null);

        $this
            ->setAnswer('I\'m fine')
            ->shouldReturn($this);

        $this
            ->getAnswer()
            ->shouldReturn('I\'m fine');
    }

    public function it_have_deck_property(Deck $deck)
    {
        $this
            ->getDeck()
            ->shouldReturn(null);

        $this
            ->setDeck($deck)
            ->shouldReturn($this);

        $this
            ->getDeck()
            ->shouldReturn($deck);
    }

    public function it_is_json_serializable()
    {
        $this->shouldImplement(JsonSerializable::class);
    }

    public function it_returns_object_as_an_array()
    {
        $this
            ->jsonSerialize()
            ->shouldHaveKey('id');

        $this
            ->jsonSerialize()
            ->shouldHaveKey('question');

        $this
            ->jsonSerialize()
            ->shouldHaveKey('answer');

        $this
            ->jsonSerialize()
            ->shouldHaveKey('deck');
    }

    public function it_returns_object_as_an_array_2(Deck $deck)
    {
        // Expectations
        $deck
            ->getId()
            ->shouldBeCalledTimes(1);

        $this
            ->setDeck($deck)
            ->shouldReturn($this);

        $this
            ->jsonSerialize()
            ->shouldHaveKey('deck');

        // todo:
//        $this->jsonSerialize()->shouldHaveKeyWithValue('deck', $deck);
    }
}
