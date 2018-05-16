@suite @deck
Feature: CRUD functionality for the Suite with with relations to the Decks, available via JSON Api
    In order to Create, Read, Update, Delete the Suite
    As a Developer
    I wan to be able to Create, Read, Update, Delete the Suite with relations to the Decks, via JSON Api

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
    Scenario: Update Deck assigned to the Suite - action PATCH
        When I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "PATCH" request to "/api/suites/3" with body:
"""
{
    "name": "Not that empty Suite",
    "decks": [
        1,
        2,
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
    "id": 3,
    "name": "Not that empty Suite",
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
        And the JSON should be equal to:
"""
{
    "status": "error",
    "errors": "Not found entity Suite with id='1'."
}
"""
        When I send a "GET" request to "/api/decks/1"
        Then the response status code should be 200
        And the JSON should be equal to:
"""
{
    "id": 1,
    "name": "Welcome",
    "suites": [],
    "cards": []
}
"""
