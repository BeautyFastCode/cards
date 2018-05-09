<?php

namespace spec\App\Entity;

use App\Entity\Deck;
use App\Entity\Suite;
use Doctrine\Common\Collections\Collection;
use JsonSerializable;
use PhpSpec\ObjectBehavior;

class SuiteSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Suite::class);
    }

    function it_have_id_property()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_have_name_property()
    {
        $this->getName()->shouldReturn(null);

        $this->setName('Suite')->shouldReturn($this);
        $this->getName()->shouldReturn('Suite');
    }

    function it_adds_a_deck_to_the_suite(Deck $deck)
    {
        // Expectations
        $deck->addSuite($this)->shouldBeCalledTimes(1);

        $this->addDeck($deck)->shouldReturn($this);
    }

    function it_adds_a_deck_to_the_suite_2(Deck $deck, Deck $anotherDeck)
    {
        // Expectations
        $deck->addSuite($this)->shouldBeCalledTimes(1);
        $anotherDeck->addSuite($this)->shouldBeCalledTimes(1);

        $this->addDeck($deck)->shouldReturn($this);

        // Adds the same deck
        $this->addDeck($deck)->shouldReturn($this);

        // Another
        $this->addDeck($anotherDeck)->shouldReturn($this);
    }

    function it_checks_whether_it_has_this_deck(Deck $deck)
    {
        // Expectations
        $deck->addSuite($this)->shouldBeCalledTimes(1);

        $this->hasDeck($deck)->shouldReturn(false);

        $this->addDeck($deck)->shouldReturn($this);
        $this->hasDeck($deck)->shouldReturn(true);
    }

    function it_removes_a_deck_from_the_suite(Deck $deck)
    {
        // Expectation
        $deck->addSuite($this)->shouldBeCalledTimes(1);
        $deck->removeSuite($this)->shouldBeCalledTimes(1);

        $this->addDeck($deck)->shouldReturn($this);
        $this->removeDeck($deck)->shouldReturn($this);
    }

    function it_gets_all_decks_from_the_suite()
    {
        $this->getDecks()->shouldImplement(Collection::class);
    }

    function it_gets_all_decks_ids_from_the_suite(Deck $deck)
    {
        $this->getDecksIds()->shouldReturn([]);

        // Expectations
        $deck->addSuite($this)->shouldBeCalledTimes(1);
        $deck->getId()->shouldBeCalledTimes(1);

        $this->addDeck($deck)->shouldReturn($this);

        $this->getDecksIds()->shouldReturn([0]);
    }

    function it_gets_all_decks_ids_from_the_suite_2(Deck $deck, Deck $anotherDeck)
    {
        $this->getDecksIds()->shouldReturn([]);

        // Expectations
        $deck->addSuite($this)->shouldBeCalledTimes(1);
        $deck->getId()->shouldBeCalledTimes(1);
        $anotherDeck->addSuite($this)->shouldBeCalledTimes(1);
        $anotherDeck->getId()->shouldBeCalledTimes(1);

        //
        $this->addDeck($deck)->shouldReturn($this);
        $this->addDeck($anotherDeck)->shouldReturn($this);

        $this->getDecksIds()->shouldReturn([
            0,
            0,
        ]);
    }

    function it_is_json_serializable()
    {
        $this->shouldImplement(JsonSerializable::class);
    }

    function it_returns_object_as_an_array()
    {
        $this->jsonSerialize()->shouldHaveKey('id');
        $this->jsonSerialize()->shouldHaveKey('name');
        $this->jsonSerialize()->shouldHaveKey('decks');
    }
}
