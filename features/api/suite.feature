@suite
Feature: CRUD functionality for the Suite, available via JSON Api
    In order to Create, Read, Update, Delete the Suite
    As a Developer
    I wan to be able to Create, Read, Update, Delete the Suite via JSON Api

    Background:
        Given there are Suites with the following details:
            | name        |
            | Suite A     |
            | Calendar    |
            | Empty Suite |

    @api
    Scenario: Get only one suite - read action
        Given I send a "GET" request to "/api/suites/1"
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 1,
    "name": "Suite A"
}
"""

    @api
    Scenario: Get a collection of all suites - list action
        Given I send a "GET" request to "/api/suites"
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
[
    {
        "id": 1,
        "name": "Suite A"
    },
    {
        "id": 2,
        "name": "Calendar"
    },
    {
        "id": 3,
        "name": "Empty Suite"
    }
]
"""

    @api
    Scenario: Add a new Suite - create action
        When I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "POST" request to "/api/suites" with body:
"""
{
    "name": "New Suite"
}
"""
        Then the response status code should be 201
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 4,
    "name": "New Suite"
}
"""

    @api
    Scenario: Update an existing Suite - update all properties action - PUT
        When I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "PUT" request to "/api/suites/1" with body:
"""
{
    "name": "Suite A, version 2"
}
"""
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 1,
    "name": "Suite A, version 2"
}
"""

    @api
    Scenario: Update an existing Suite - update selected properties action - PATCH
        When I add "Content-Type" header equal to "application/json"
        And I add "Accept" header equal to "application/json"
        And I send a "PATCH" request to "/api/suites/1" with body:
"""
{
    "name": "Suite A, version 3"
}
"""
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
    "id": 1,
    "name": "Suite A, version 3"
}
"""

    @api
    Scenario: Delete an existing Suite - delete action
        Given I send a "GET" request to "/api/suites/1"
        Then the response status code should be 200
        When I send a "DELETE" request to "/api/suites/1"
        Then the response status code should be 204
        When I send a "GET" request to "/api/suites/1"
        Then the response status code should be 404
