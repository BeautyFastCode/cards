@suite
Feature: CRUD functionality for the Suite, available via Api
    In order to Create, Read, Update, Delete the Suite
    As a Customer
    I wan to be able to Create, Read, Update, Delete the Suite via Api

    @api
    Scenario: Get a list of all suites
        Given I send a "GET" request to "/api/suites"
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
[
    {
        "name": "Suite A"
    },
    {
        "name": "Calendar"
    },
    {
        "name": "Empty Suite"
    }
]
"""
