@suite @deck
Feature: Edge cases for Suite data with relations to the Deck
    In order to eliminate bad Suite and Deck data
    As a developer
    I need to ensure Suite and Deck data meets expected criteria

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

    @api @edge_case
    Scenario: Deck Id must be numeric (Deck assigned to Suite)
        Given I send a "POST" request to "/api/suites" with body:
"""
{
    "name": "New Suite",
    "decks": [
        "a",
        "bcd"
    ]
}
"""
        Then the response status code should be 400
        And the JSON should be equal to:
"""
{
    "status": "error",
    "message": "Form is not valid.",
    "errors": {
        "children": {
            "name": [],
            "decks": {
                "errors": [
                    "This value is not valid."
                ]
            }
        }
    }
}
"""

    @api @edge_case
    Scenario: Deck Id must be positive (Deck assigned to Suite)
        Given I send a "POST" request to "/api/suites" with body:
"""
{
    "name": "New Suite",
    "decks": [
        -1,
        -3
    ]
}
"""
        Then the response status code should be 400
        And the JSON should be equal to:
"""
{
    "status": "error",
    "message": "Form is not valid.",
    "errors": {
        "children": {
            "name": [],
            "decks": {
                "errors": [
                    "This value is not valid."
                ]
            }
        }
    }
}
"""

    @api @edge_case
    Scenario: Deck Id must be exist (Deck assigned to Suite)
        Given I send a "POST" request to "/api/suites" with body:
"""
{
    "name": "New Suite",
    "decks": [
        6,
        7
    ]
}
"""
        Then the response status code should be 400
        And the JSON should be equal to:
"""
{
    "status": "error",
    "message": "Form is not valid.",
    "errors": {
        "children": {
            "name": [],
            "decks": {
                "errors": [
                    "This value is not valid."
                ]
            }
        }
    }
}
"""

    @api @edge_case
    Scenario: Deck Id must be unique (Deck assigned to Suite)
        Given I send a "POST" request to "/api/suites" with body:
"""
{
    "name": "New Suite",
    "decks": [
        1,
        1
    ]
}
"""
        Then the response status code should be 500
