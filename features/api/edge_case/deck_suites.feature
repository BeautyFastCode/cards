@deck @suite
Feature: Edge cases for Deck data with relations to the Suite
    In order to eliminate bad Deck and Suite data
    As a developer
    I need to ensure Deck and Suite data meets expected criteria

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

    @api @edge_case
    Scenario: Suite Id must be numeric (Suite assigned to Deck)
        Given I send a "POST" request to "/api/decks" with body:
"""
{
    "name": "New Deck",
    "suites": [
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
            "suites": {
                "errors": [
                    "This value is not valid."
                ]
            },
            "cards": []
        }
    }
}
"""

    @api @edge_case
    Scenario: Suite Id must be positive (Suite assigned to Deck)
        Given I send a "POST" request to "/api/decks" with body:
"""
{
    "name": "New Deck",
    "suites": [
        -1
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
            "suites": {
                "errors": [
                    "This value is not valid."
                ]
            },
            "cards": []
        }
    }
}
"""

    @api @edge_case
    Scenario: Suite Id must be exist (Suite assigned to Deck)
        Given I send a "POST" request to "/api/decks" with body:
"""
{
    "name": "New Deck",
    "suites": [
        4,
        6
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
            "suites": {
                "errors": [
                    "This value is not valid."
                ]
            },
            "cards": []
        }
    }
}
"""

    @api @edge_case
    Scenario: Suite Id must be unique (Suite assigned to Deck)
        Given I send a "POST" request to "/api/decks" with body:
"""
{
    "name": "New Deck",
    "suites": [
        2,
        2
    ]
}
"""
#        Then the response status code should be 500
# todo:
