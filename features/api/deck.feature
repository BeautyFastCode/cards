@deck
Feature: CRUD functionality for the Deck, available via JSON Api
    In order to Create, Read, Update, Delete the Deck
    As a Developer
    I wan to be able to Create, Read, Update, Delete the Deck via JSON Api

    Background:
        Given there are Decks with the following details:
            | name        |
            | Welcome     |
            | Information |
            | 2018 - 04   |
    
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
    "name": "Welcome"
}
"""
        
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
        "name": "Welcome"
    },
    {
        "id": 2,
        "name": "Information"
    },
    {
        "id": 3,
        "name": "2018 - 04"
    }
]
"""
        
    @api
    Scenario: Add a new Deck - create action
        When I add "Content-Type" header equal to "application/json"
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
    "id": 4,
    "name": "New Deck"
}
"""
        
    @api
    Scenario: Delete an existing Deck - delete action
        Given I send a "GET" request to "/api/decks/1"
        Then the response status code should be 200
        When I send a "DELETE" request to "/api/decks/1"
        Then the response status code should be 204
        When I send a "GET" request to "/api/decks/1"
        Then the response status code should be 404
