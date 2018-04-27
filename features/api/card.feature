@card
Feature: CRUD functionality for the Card, available via JSON Api
    In order to Create, Read, Update, Delete the Card
    As a Developer
    I wan to be able to Create, Read, Update, Delete the Card via JSON Api

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
    Scenario: Get only one card - read action
        Given I send a "GET" request to "/api/cards/1"
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 1,
    "question": "Front Card",
    "answer": "Back Card",
    "deck": 1
}
"""

    @api
    Scenario: Get a collection of all cards - list action
        Given I send a "GET" request to "/api/cards"
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
[
  {
      "id": 1,
      "question": "Front Card",
      "answer": "Back Card",
      "deck": 1
  },
  {
      "id": 2,
      "question": "How are you?",
      "answer": "I'm fine.",
      "deck": 1
  },
  {
      "id": 3,
      "question": "What colour do you like?",
      "answer": "I like the red cherry.",
      "deck": 1
  },
  {
      "id": 4,
      "question": "What project is the this?",
      "answer": "This is the Cards Project.",
      "deck": 3
  }
]
"""

    @api
    Scenario: Add a new Card - create action
        When I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "POST" request to "/api/cards" with body:
"""
{
    "question": "Where are you?",
    "answer": "I'm here.",
    "deck": 1
}
"""
        Then the response status code should be 201
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 5,
    "question": "Where are you?",
    "answer": "I'm here.",
    "deck": 1
}
"""

    @api
    Scenario: Update an existing Card - update all properties - action PUT
        When I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "PUT" request to "/api/cards/1" with body:
"""
{
    "question": "Super Front Card",
    "answer": "Super Back Card",
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
    "question": "Super Front Card",
    "answer": "Super Back Card",
    "deck": 2
}
"""

    @api
    Scenario: Update an existing Card - update selected properties - action PATCH
        When I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "PATCH" request to "/api/cards/1" with body:
"""
{
    "answer": "Only the answer has changed."
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
    "answer": "Only the answer has changed.",
    "deck": 1
}
"""
