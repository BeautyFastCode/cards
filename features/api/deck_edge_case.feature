@deck
Feature: Edge cases for Deck data
    In order to eliminate bad Deck data
    As a developer
    I need to ensure Deck data meets expected criteria

    Background:
        Given there are Decks with the following details:
            | name        |
            | Welcome     |
            | Information |
            | 2018 - 04   |

    @api @edge_case
    Scenario: Must have a non-blank name property
        Given I send a "POST" request to "/api/decks" with body:
"""
{
    "name": ""
}
"""
        Then the response status code should be 400
        And the JSON should be equal to:
"""
{
    "status": "error",
    "errors": {
      "children": {
          "name": {
              "errors": [
                  "This value should not be blank."
              ]
          }
      }
    }
}
"""
    @api @edge_case
    Scenario: Must have a least 6 characters in name property
        Given I send a "POST" request to "/api/decks" with body:
"""
{
    "name": "deck"
}
"""
        Then the response status code should be 400
        And the JSON should be equal to:
"""
{
    "status": "error",
    "errors": {
      "children": {
          "name": {
              "errors": [
                  "This value is too short. It should have 6 characters or more."
              ]
          }
      }
    }
}
"""

    @api @edge_case
    Scenario: Must have a max 64 characters in name property
        Given I send a "POST" request to "/api/decks" with body:
"""
{
    "name": "This Deck name is definitely too long. Lorem ipsum dolor site am."
}
"""
        Then the response status code should be 400
        And the JSON should be equal to:
"""
{
    "status": "error",
    "errors": {
      "children": {
          "name": {
              "errors": [
                  "This value is too long. It should have 64 characters or less."
              ]
          }
      }
    }
}
"""

    @api @edge_case
    Scenario: Deck Id must be numeric
        Given I send a "GET" request to "/api/decks/abc"
        Then the response status code should be 404

    @api @edge_case
    Scenario: Deck Id must be positive
        Given I send a "GET" request to "/api/decks/-1"
        Then the response status code should be 404

    @api @edge_case
    Scenario: Deck Id must be exist
        Given I send a "GET" request to "/api/decks/1000"
        Then the response status code should be 404
