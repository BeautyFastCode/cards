@suite
Feature: CRUD functionality for the Suite, available via JSON Api
    In order to Create, Read, Update, Delete the Suite
    As a Developer
    I wan to be able to Create, Read, Update, Delete the Suite via JSON Api

    Background:
        Given there are Decks with the following details:
            | name          |
            | Welcome       |
            | Untitled      |
            | Information   |
            | 2018 - 04     |
            | Project Cards |
        Given there are Suites with the following details:
            | name        | decks                          |
            | Suite A     | Welcome, Untitled, Information |
            | Calendar    | 2018 - 04, Project Cards       |
            | Empty Suite |                                |

    @api
    Scenario: Get only one suite - read action
        Given I send a "GET" request to "/api/suites/1"
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 1,
    "name": "Suite A",
    "decks": [
        1,
        2,
        3
    ]
}
"""

    @api
    Scenario: Get a collection of all suites - list action
        Given I send a "GET" request to "/api/suites"
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
[
    {
        "id": 1,
        "name": "Suite A",
        "decks": [
            1,
            2,
            3
        ]
    },
    {
        "id": 2,
        "name": "Calendar",
        "decks": [
            4,
            5
        ]
    },
    {
        "id": 3,
        "name": "Empty Suite",
        "decks": []
    }
]
"""

    @api
    Scenario: Add a new Suite - create action
        When I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "POST" request to "/api/suites" with body:
"""
{
    "name": "New Suite"
}
"""
        Then the response status code should be 201
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 4,
    "name": "New Suite",
    "decks": []
}
"""

    @api
    Scenario: Add a new Suite with the Deck assigned - create action
        When I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "POST" request to "/api/suites" with body:
"""
{
    "name": "New Suite",
        "decks": [
            3,
            5
        ]
}
"""
        Then the response status code should be 201
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 4,
    "name": "New Suite",
        "decks": [
            3,
            5
        ]
}
"""

    @api
    Scenario: Update an existing Suite - update all properties action - PUT
        When I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "PUT" request to "/api/suites/1" with body:
"""
{
    "name": "Suite A, version 2",
    "decks": [
        1,
        4
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
    "name": "Suite A, version 2",
    "decks": [
        1,
        4
    ]
}
"""

    @api
    Scenario: Update an existing Suite - update selected properties action - PATCH
        When I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "PATCH" request to "/api/suites/1" with body:
"""
{
    "name": "Suite A, version 3"
}
"""
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 1,
    "name": "Suite A, version 3",
    "decks": [
        1,
        2,
        3
    ]
}
"""

    @api
    Scenario: Delete an existing Suite without deleting Deck - delete action
        Given I send a "GET" request to "/api/suites/1"
        Then the response status code should be 200
        When I send a "DELETE" request to "/api/suites/1"
        Then the response status code should be 204
        When I send a "GET" request to "/api/suites/1"
        Then the response status code should be 404
        When I send a "GET" request to "/api/decks/1"
        Then the response status code should be 200
        And the JSON should be equal to:
"""
{
    "id": 1,
    "name": "Welcome",
    "suites": []
}
"""
