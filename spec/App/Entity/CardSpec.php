<?php

namespace spec\App\Entity;

use App\Entity\Card;
use App\Entity\Deck;
use JsonSerializable;
use PhpSpec\ObjectBehavior;

class CardSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Card::class);
    }

    function it_have_id_property()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_have_question_property()
    {
        $this->getQuestion()->shouldReturn(null);

        $this->setQuestion('How are you?')->shouldReturn($this);
        $this->getQuestion()->shouldReturn('How are you?');
    }

    function it_have_answer_property()
    {
        $this->getAnswer()->shouldReturn(null);

        $this->setAnswer('I\'m fine')->shouldReturn($this);
        $this->getAnswer()->shouldReturn('I\'m fine');
    }

    function it_have_deck_property(Deck $deck)
    {
        $this->getDeck()->shouldReturn(null);

        $this->setDeck($deck)->shouldReturn($this);
        $this->getDeck()->shouldReturn($deck);
    }

    function it_is_json_serializable()
    {
        $this->shouldImplement(JsonSerializable::class);
    }

    function it_returns_object_as_an_array()
    {
        $this->jsonSerialize()->shouldHaveKey('id');
        $this->jsonSerialize()->shouldHaveKey('question');
        $this->jsonSerialize()->shouldHaveKey('answer');
        $this->jsonSerialize()->shouldHaveKey('deck');
    }

    function it_returns_object_as_an_array_2(Deck $deck)
    {
        // Expectations
        $deck->getId()->shouldBeCalledTimes(1);

        $this->setDeck($deck)->shouldReturn($this);

        $this->jsonSerialize()->shouldHaveKey('deck');
    }
}
