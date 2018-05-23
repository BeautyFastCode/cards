@card @deck
Feature: Edge cases for Card data with relations to the Deck
    In order to eliminate bad Card and Deck data
    As a developer
    I need to ensure Card and Deck data meets expected criteria

    Background:
        Given there are Decks with the following details:
            | name        |
            | Welcome     |
            | Untitled    |
            | Information |
        Given there are Cards with the following details:
            | question                  | answer                     | deck        |
            | Front Card                | Back Card                  | Welcome     |
            | How are you?              | I'm fine.                  | Welcome     |
            | What colour do you like?  | I like the red cherry.     | Welcome     |
            | What project is the this? | This is the Cards Project. | Information |

    @api @edge_case
    Scenario: The Property deck must be not null
        Given I send a "POST" request to "/api/cards" with body:
"""
{
    "question": "Who I am?",
    "answer": "I'm super card."
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
          "question": [],
          "answer": [],
          "deck": {
              "errors": [
                  "This value should not be null."
              ]
          }
      }
  }
}
"""

    @api @edge_case
    Scenario: Deck Id must be numeric (Deck assigned to Card)
        Given I send a "POST" request to "/api/cards" with body:
"""
{
    "question": "Who I am?",
    "answer": "I'm super card.",
    "deck": "abc"

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
          "question": [],
          "answer": [],
          "deck": {
              "errors": [
                  "This value is not valid."
              ]
          }
      }
  }
}
"""

    @api @edge_case
    Scenario: Deck Id must be positive (Deck assigned to Card)
    """
{
    "question": "Who I am?",
    "answer": "I'm super card.",
    "deck": -1

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
          "question": [],
          "answer": [],
          "deck": {
              "errors": [
                  "This value is not valid."
              ]
          }
      }
  }
}
"""

    @api @edge_case
    Scenario: Deck Id must be exist (Deck assigned to Card)
    """
{
    "question": "Who I am?",
    "answer": "I'm super card.",
    "deck": 99

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
          "question": [],
          "answer": [],
          "deck": {
              "errors": [
                  "This value is not valid."
              ]
          }
      }
  }
}
"""
