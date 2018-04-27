@deck @card
Feature: CRUD functionality for the Deck with relations to the Cards, available via JSON Api
    In order to Create, Read, Update, Delete the Deck
    As a Developer
    I wan to be able to Create, Read, Update, Delete the Deck with relations to the Cards, via JSON Api

    Background:
        Given there are Decks with the following details:
            | name          |
            | Welcome       |
            | Untitled      |
            | Information   |
            | 2018 - 04     |
            | Project Cards |
        Given there are Cards with the following details:
            | question                  | answer                     | deck        |
            | Front Card                | Back Card                  | Welcome     |
            | How are you?              | I'm fine.                  | Welcome     |
            | What colour do you like?  | I like the red cherry.     | Welcome     |
            | What project is the this? | This is the Cards Project. | Information |

    @api
    Scenario: Add a new Deck and then a new Card assign to this deck - create action
        Given I send a "POST" request to "/api/decks" with body:
"""
{
    "name": "New Deck"
}
"""
        Then the response status code should be 201
        And the JSON should be equal to:
"""
{
    "id": 6,
    "name": "New Deck",
    "suites": [],
    "cards": []
}
"""
        When I send a "POST" request to "/api/cards" with body:
"""
{
    "question": "Where are you?",
    "answer": "I'm here.",
    "deck": 6
}
"""
        Then the response status code should be 201
        And the JSON should be equal to:
"""
{
    "id": 5,
    "question": "Where are you?",
    "answer": "I'm here.",
    "deck": 6
}
"""
        Then I send a "GET" request to "/api/decks/6"
        And the JSON should be equal to:
"""
{
    "id": 6,
    "name": "New Deck",
    "suites": [],
    "cards": [
        5
    ]
}
"""

    @api
    Scenario: Update an existing Deck - delete Card form Deck - action PATCH
        Given I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "PATCH" request to "/api/decks/1" with body:
"""
{
    "cards": [
        2,
        3
    ]
}
"""
        Then the response status code should be 200
        And the JSON should be equal to:
"""
{
    "id": 1,
    "name": "Welcome",
    "suites": [],
    "cards": [
      2,
      3
    ]
}
"""
#    When I send a "GET" request to "/api/cards/1"
#    Then the response status code should be 404
#    todo: delete Card
