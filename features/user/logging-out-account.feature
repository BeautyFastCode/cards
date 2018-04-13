@customer-logout
Feature: Log out from Cards
    In order to not allow to use my account by anybody
    As a Customer
    I want to be able to logging out

#    Background:
#        Given I log in as the customer with name "John"

    @ui
    Scenario: Log out from the Dashboard
        Given I am on "/dashboard"
        And I should see a ".logged-out" element
        When I follow "Log Out"
        Then I should see "Thanks for using Cards." in the "h1" element
        And I should see "You're all logged out." in the "p" element
        And I should be on "/logged-out"
