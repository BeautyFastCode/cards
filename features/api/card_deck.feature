@card @deck
Feature: CRUD functionality for the Card with relations to the Deck, available via JSON Api
    In order to Create, Read, Update, Delete the Card
    As a Developer
    I wan to be able to Create, Read, Update, Delete the Card with relations to the Deck, via JSON Api

    Background:
        Given there are Decks with the following details:
            | name        |
            | Welcome     |
            | Untitled    |
            | Information |
        Given there are Cards with the following details:
            | question                  | answer                     | deck        |
            | Front Card                | Back Card                  | Welcome     |
            | How are you?              | I'm fine.                  | Welcome     |
            | What colour do you like?  | I like the red cherry.     | Welcome     |
            | What project is the this? | This is the Cards Project. | Information |

    @api
    Scenario: Change the Deck assigned to the Card - action PATCH
        When I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "PATCH" request to "/api/cards/1" with body:
"""
{
    "deck": 2
}
"""
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 1,
    "question": "Front Card",
    "answer": "Back Card",
    "deck": 2
}
"""
        When I send a "GET" request to "/api/cards/1"
        Then the response status code should be 200
        And the JSON should be equal to:
"""
{
    "id": 1,
    "question": "Front Card",
    "answer": "Back Card",
    "deck": 2
}
"""

    @api
    Scenario: Delete an existing Card without deleting Deck - delete action
        Given I send a "GET" request to "/api/cards/1"
        Then the response status code should be 200
        When I send a "DELETE" request to "/api/cards/1"
        Then the response status code should be 204
        When I send a "GET" request to "/api/cards/1"
        Then the response status code should be 404
        When I send a "GET" request to "/api/decks/1"
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
