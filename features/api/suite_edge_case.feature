@suite
Feature: Edge cases for Suite data
    In order to eliminate bad Suite data
    As a developer
    I need to ensure Suite data meets expected criteria

    Background:
        Given there are Suites with the following details:
            | name        |
            | Suite A     |
            | Calendar    |
            | Empty Suite |

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
          }
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
          }
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
          }
      }
    }
}
"""
