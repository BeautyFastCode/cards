@learning
Feature: Learning course (deck)
    In order to remember new things
    As a Customer
    I want to be able to select and learning course

    @ui
    Scenario: Choose a deck and start learning cards.
        Given I am on "/dashboard"
        And I should see text matching "Suite A"
        And I should see text matching "Welcome Deck"
        When I follow "Welcome Deck"
        Then I should see text matching "Welcome Deck"
        And I should be on "/deck"
        And I should see text matching "Start Learning"
        When I follow "Start Learning"
        Then I should be on "/learn"

    @ui
    Scenario: Learning the cards and view the finish text.
        Given I am on "/learn"
        And I should see text matching "Front Card"
        And I should see text matching "See Answer."
        When I follow "See Answer."
        Then I should see text matching "Back Card"
        And I should see an ".rating" element
        When I follow "Rating"
        Then I should see text matching "How are you?"
        When I follow "See Answer."
        Then I should see text matching "I'm fine."
        When I follow "Rating"
        Then I should see text matching "What colour do you like?"
        When I follow "See Answer."
        Then I should see text matching "I like the red cherry."
        When I follow "Rating"
        Then I should see "You finished the study of this deck." in the "h1" element
