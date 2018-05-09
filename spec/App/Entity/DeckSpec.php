<?php

namespace spec\App\Entity;

use App\Entity\Card;
use App\Entity\Deck;
use App\Entity\Suite;
use Doctrine\Common\Collections\Collection;
use JsonSerializable;
use PhpSpec\ObjectBehavior;

class DeckSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Deck::class);
    }

    function it_have_id_property()
    {
        $this->getId()->shouldReturn(null);
    }

    function it_have_name_property()
    {
        $this->getName()->shouldReturn(null);

        $this->setName('Deck')->shouldReturn($this);
        $this->getName()->shouldReturn('Deck');
    }

    function it_adds_a_card_to_the_deck(Card $card)
    {
        // Expectations
        $card->setDeck($this)->shouldBeCalledTimes(1);

        $this->addCard($card)->shouldReturn($this);
    }

    function it_adds_a_card_to_the_deck_2(Card $card, Card $anotherCard)
    {
        // Expectations
        $card->setDeck($this)->shouldBeCalledTimes(1);
        $anotherCard->setDeck($this)->shouldBeCalledTimes(1);

        $this->addCard($card)->shouldReturn($this);

        // Adds the same card
        $this->addCard($card)->shouldReturn($this);

        // Another
        $this->addCard($anotherCard)->shouldReturn($this);
    }

    function it_removes_a_card_from_the_Deck(Card $card)
    {
        $this->removeCard($card)->shouldReturn($this);

        // Expectations
        $card->setDeck($this)->shouldBeCalledTimes(1);

        $this->addCard($card)->shouldReturn($this);
        $this->removeCard($card)->shouldReturn($this);
    }

    function it_gets_all_cards_from_the_deck()
    {
        $this->getCards()->shouldImplement(Collection::class);
    }

    function it_gets_all_cards_ids_from_the_deck(Card $card)
    {
        $this->getCardsIds()->shouldReturn([]);

        // Expectations
        $card->setDeck($this)->shouldBeCalledTimes(1);
        $card->getId()->shouldBeCalledTimes(1);

        $this->addCard($card)->shouldReturn($this);

        $this->getCardsIds()->shouldReturn([0]);
    }

    function it_gets_all_cards_ids_from_the_deck_2(Card $card, Card $anotherCard)
    {
        $this->getCardsIds()->shouldReturn([]);

        // Expectations
        $card->setDeck($this)->shouldBeCalledTimes(1);
        $card->getId()->shouldBeCalledTimes(1);
        $anotherCard->setDeck($this)->shouldBeCalledTimes(1);
        $anotherCard->getId()->shouldBeCalledTimes(1);

        $this->addCard($card)->shouldReturn($this);
        $this->addCard($anotherCard)->shouldReturn($this);

        $this->getCardsIds()->shouldReturn([
            0,
            0,
        ]);
    }

    function it_adds_a_suite_to_the_deck(Suite $suite)
    {
        // Expectations
        $suite->addDeck($this)->shouldBeCalledTimes(1);

        $this->addSuite($suite)->shouldReturn($this);
    }

    function it_adds_a_suite_to_the_deck_2(Suite $suite, Suite $anotherSuite)
    {
        // Expectations
        $suite->addDeck($this)->shouldBeCalledTimes(1);
        $anotherSuite->addDeck($this)->shouldBeCalledTimes(1);

        $this->addSuite($suite)->shouldReturn($this);

        // Adds the same suite
        $this->addSuite($suite)->shouldReturn($this);

        // Another
        $this->addSuite($anotherSuite)->shouldReturn($this);
    }

    function it_removes_a_suite_from_the_Deck(Suite $suite)
    {
        $this->removeSuite($suite)->shouldReturn($this);

        // Expectations
        $suite->addDeck($this)->shouldBeCalledTimes(1);
        $suite->removeDeck($this)->shouldBeCalledTimes(1);

        $this->addSuite($suite)->shouldReturn($this);
        $this->removeSuite($suite)->shouldReturn($this);
    }

    function it_gets_all_suites_from_the_deck()
    {
        $this->getSuites()->shouldImplement(Collection::class);
    }

    function it_gets_all_suites_ids_from_the_deck(Suite $suite)
    {
        $this->getSuitesIds()->shouldReturn([]);

        // Expectations
        $suite->addDeck($this)->shouldBeCalledTimes(1);
        $suite->getId()->shouldBeCalledTimes(1);

        $this->addSuite($suite)->shouldReturn($this);

        $this->getSuitesIds()->shouldReturn([0]);
    }

    function it_gets_all_suites_ids_from_the_deck_2(Suite $suite, Suite $anotherSuite)
    {
        // Expectations
        $suite->addDeck($this)->shouldBeCalledTimes(1);
        $suite->getId()->shouldBeCalledTimes(1);
        $anotherSuite->addDeck($this)->shouldBeCalledTimes(1);
        $anotherSuite->getId()->shouldBeCalledTimes(1);

        $this->addSuite($suite)->shouldReturn($this);
        $this->addSuite($anotherSuite)->shouldReturn($this);

        $this->getSuitesIds()->shouldReturn([
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
        $this->jsonSerialize()->shouldHaveKey('suites');
        $this->jsonSerialize()->shouldHaveKey('cards');
    }
}
