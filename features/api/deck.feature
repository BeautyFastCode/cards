@deck
Feature: CRUD functionality for the Deck, available via JSON Api
    In order to Create, Read, Update, Delete the Deck
    As a Developer
    I wan to be able to Create, Read, Update, Delete the Deck via JSON Api

    Background:
        Given there are Decks with the following details:
            | name          |
            | Welcome       |
            | Untitled      |
            | Information   |
            | 2018 - 04     |
            | Project Cards |
        Given there are Suites with the following details:
            | name        | decks                             |
            | Suite A     | Welcome, Untitled, Information    |
            | Calendar    | Welcome, 2018 - 04, Project Cards |
            | Empty Suite |                                   |
        Given there are Cards with the following details:
            | question                  | answer                     | deck        |
            | Front Card                | Back Card                  | Welcome     |
            | How are you?              | I'm fine.                  | Welcome     |
            | What colour do you like?  | I like the red cherry.     | Welcome     |
            | What project is the this? | This is the Cards Project. | Information |

    @api
    Scenario: Get only one deck - read action
        Given I send a "GET" request to "/api/decks/1"
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 1,
    "name": "Welcome",
    "suites": [
        1,
        2
    ],
    "cards": []
}
"""
# todo: "cards": [1,2,3]

    @api
    Scenario: Get a collection of all decks - list action
        Given I send a "GET" request to "/api/decks"
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
[
  {
      "id": 1,
      "name": "Welcome",
      "suites": [
          1,
          2
      ],
      "cards": [
          1,
          2,
          3
      ]
  },
  {
      "id": 2,
      "name": "Untitled",
      "suites": [
          1
      ],
      "cards": []
  },
  {
      "id": 3,
      "name": "Information",
      "suites": [
          1
      ],
      "cards": [
          4
      ]
  },
  {
      "id": 4,
      "name": "2018 - 04",
      "suites": [
          2
      ],
      "cards": []
  },
  {
      "id": 5,
      "name": "Project Cards",
      "suites": [
          2
      ],
      "cards": []
  }
]
"""

    @api
    Scenario: Add a new Deck - create action
        Given I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "POST" request to "/api/decks" with body:
"""
{
    "name": "New Deck"
}
"""
        Then the response status code should be 201
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 6,
    "name": "New Deck",
    "suites": [],
    "cards": []
}
"""

    @api
    Scenario: Update an existing Deck - update all properties - action PUT
        Given I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "PUT" request to "/api/decks/1" with body:
"""
{
    "name": "Deck A, version 2",
    "suites": [
      3
    ],
    "cards": [
      1,
      3
    ]
}
"""
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 1,
    "name": "Deck A, version 2",
    "suites": [
      3
    ],
    "cards": [
      1,
      3
    ]
}
"""

    @api
    Scenario: Update an existing Deck - update selected properties - action PATCH
        Given I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "PATCH" request to "/api/decks/1" with body:
"""
{
    "name": "Deck A, version 3"
}
"""
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 1,
    "name": "Deck A, version 3",
    "suites": [
      1,
      2
    ],
    "cards": [
      1,
      2,
      3
    ]
}
"""

    @api
    Scenario: Delete an existing Deck and Cards, without deleting Suite - delete action
        Given I send a "GET" request to "/api/decks/1"
        Then the response status code should be 200
        When I send a "DELETE" request to "/api/decks/1"
        Then the response status code should be 204
        When I send a "GET" request to "/api/decks/1"
        Then the response status code should be 404
        When I send a "GET" request to "/api/cards/1"
        Then the response status code should be 404
        When I send a "GET" request to "/api/cards/2"
        Then the response status code should be 404
        When I send a "GET" request to "/api/cards/3"
        Then the response status code should be 404
        When I send a "GET" request to "/api/suites/1"
        Then the response status code should be 200
        And the JSON should be equal to:
"""
{
    "id": 1,
    "name": "Suite A",
    "decks": [
        2,
        3
    ]
}
"""
