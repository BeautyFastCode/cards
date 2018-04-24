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
