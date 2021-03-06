@card
Feature: Edge cases for Card data
    In order to eliminate bad Card data
    As a developer
    I need to ensure Card data meets expected criteria

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
    Scenario: It can be null in the question or in the response property
        Given I send a "POST" request to "/api/cards" with body:
"""
{
    "deck": 1
}
"""
        Then the response status code should be 201
        And the JSON should be equal to:
"""
{
    "id": 5,
    "question": null,
    "answer": null,
    "deck": 1
}
"""

    @api @edge_case
    Scenario: Must have a least 6 characters in the question or in the answer property
        Given I send a "POST" request to "/api/cards" with body:
"""
{
    "question": "card",
    "answer": "card",
    "deck": 1

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
            "question": {
                "errors": [
                    "This value is too short. It should have 6 characters or more."
                ]
            },
            "answer": {
                "errors": [
                    "This value is too short. It should have 6 characters or more."
                ]
            },
            "deck": []
        }
    }
}
"""

    @api @edge_case
    Scenario: Must have a max 255 characters in the question or in the answer property
        Given I send a "POST" request to "/api/cards" with body:
"""
{
    "question": "Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab aliquam, architecto consequuntur deleniti dolores eaque eos eveniet expedita facere facilis incidunt iste omnis quaerat quod quos, rem sunt ullam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur ducimus, in iste porro suscipit vel velit veritatis vero! Accusamus beatae, dolorem error eveniet fuga, nobis non numquam perspiciatis provident, rem sapiente sed sunt temporibus totam voluptatibus? Aliquam culpa error esse eveniet molestias placeat quibusdam recusandae voluptas!",
    "answer": "Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab aliquam, architecto consequuntur deleniti dolores eaque eos eveniet expedita facere facilis incidunt iste omnis quaerat quod quos, rem sunt ullam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur ducimus, in iste porro suscipit vel velit veritatis vero! Accusamus beatae, dolorem error eveniet fuga, nobis non numquam perspiciatis provident, rem sapiente sed sunt temporibus totam voluptatibus? Aliquam culpa error esse eveniet molestias placeat quibusdam recusandae voluptas!",
    "deck": 1
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
            "question": {
                "errors": [
                    "This value is too long. It should have 255 characters or less."
                ]
            },
            "answer": {
                "errors": [
                    "This value is too long. It should have 255 characters or less."
                ]
            },
            "deck": []
        }
    }
}
"""

    @api @edge_case
    Scenario: Card Id must be numeric
        Given I send a "GET" request to "/api/cards/abc"
        Then the response status code should be 404

    @api @edge_case
    Scenario: Card Id must be positive
        Given I send a "GET" request to "/api/cards/-1"
        Then the response status code should be 404

    @api @edge_case
    Scenario: Card Id must be exist
        Given I send a "GET" request to "/api/cards/1000"
        Then the response status code should be 404
