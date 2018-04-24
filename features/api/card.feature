@card
Feature: CRUD functionality for the Card, available via JSON Api
    In order to Create, Read, Update, Delete the Card
    As a Developer
    I wan to be able to Create, Read, Update, Delete the Card via JSON Api

    Background:
        Given there are Cards with the following details:
            | question                 | answer                 |
            | Front Card               | Back Card              |
            | How are you?             | I'm fine.              |
            | What colour do you like? | I like the red cherry. |

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
    "answer": "Back Card"
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
        "answer": "Back Card"
    },
    {
        "id": 2,
        "question": "How are you?",
        "answer": "I'm fine."
    },
    {
        "id": 3,
        "question": "What colour do you like?",
        "answer": "I like the red cherry."
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
    "answer": "I'm here."
}
"""
        Then the response status code should be 201
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 4,
    "question": "Where are you?",
    "answer": "I'm here."
}
"""

    @api
    Scenario: Update an existing Card - update all properties action - PUT
        When I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "PUT" request to "/api/cards/1" with body:
"""
{
    "question": "Super Front Card",
    "answer": "Super Back Card"
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
    "answer": "Super Back Card"
}
"""

    @api
    Scenario: Update an existing Card - update selected properties action - PATCH
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
    "answer": "Only the answer has changed."
}
"""

    @api
    Scenario: Delete an existing Card - delete action
        Given I send a "GET" request to "/api/cards/1"
        Then the response status code should be 200
        When I send a "DELETE" request to "/api/cards/1"
        Then the response status code should be 204
        When I send a "GET" request to "/api/cards/1"
        Then the response status code should be 404
