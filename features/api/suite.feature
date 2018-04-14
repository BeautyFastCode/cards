@suite
Feature: CRUD functionality for the Suite, available via JSON Api
    In order to Create, Read, Update, Delete the Suite
    As a Customer
    I wan to be able to Create, Read, Update, Delete the Suite via JSON Api

    @api
    Scenario: Get only one suite - read action
        Given I send a "GET" request to "/api/suites/1"
        Then the response status code should be 200
        And the response should be in JSON
        And the header "Content-Type" should be equal to "application/json"
        And the JSON should be equal to:
"""
{
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


#    @api
#    Scenario: Add a new Suite, create action
#        When I add "Content-Type" header equal to "application/json"
#        And I add "Accept" header equal to "application/json"
#        And I send a "POST" request to "/api/suites" with parameters:
#            | name | New Suite |
#
##        And I send a "POST" request to "/api/suites" with body:
##"""
##"name": "New Suite"
##"""
#        Then the response status code should be 200
#        And the response should be in JSON
#        And the header "Content-Type" should be equal to "application/json"
#        And the JSON should be equal to:
#"""
#{
#    "name": "Suite A"
#}
#"""
