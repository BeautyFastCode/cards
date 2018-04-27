@suite
Feature: Edge cases for Suite data
    In order to eliminate bad Suite data
    As a developer
    I need to ensure Suite data meets expected criteria

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
    Scenario: Must have a non-blank name property
        Given I send a "POST" request to "/api/suites" with body:
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
          },
          "decks": []
      }
    }
}
"""

    @api @edge_case
    Scenario: Must have a least 6 characters in name property
        Given I send a "POST" request to "/api/suites" with body:
"""
{
    "name": "suite"
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
          },
      "decks": []
      }
    }
}
"""

    @api @edge_case
    Scenario: Must have a max 64 characters in name property
        Given I send a "POST" request to "/api/suites" with body:
"""
{
    "name": "This Suite name is definitely too long. Lorem ipsum dolor sit am."
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
          },
      "decks": []
      }
    }
}
"""

    @api @edge_case
    Scenario: Suite Id must be numeric
        Given I send a "GET" request to "/api/suites/abc"
        Then the response status code should be 404

    @api @edge_case
    Scenario: Suite Id must be positive
        Given I send a "GET" request to "/api/suites/-1"
        Then the response status code should be 404

    @api @edge_case
    Scenario: Suite Id must be exist
        Given I send a "GET" request to "/api/suites/1000"
        Then the response status code should be 404

    @api @edge_case
    Scenario: The Suite property must be exist
        Given I send a "POST" request to "/api/suites" with body:
"""
{
    "name": "New Suite",
    "surprise": "Hello"
}
"""
        Then the response status code should be 400
        And the JSON should be equal to:
"""
{
    "status": "error",
    "errors": {
      "errors": [
          "This form should not contain extra fields."
      ],
      "children": {
          "name": [],
          "decks": []
      }
    }
}
"""
