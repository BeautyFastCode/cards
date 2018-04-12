@customer-registration
Feature: Registering new account
    In order to know and learn courses
    As a Visitor
    I need to be able to create an account in the Cards

    Background:
        Given I am on "http://127.0.0.1:8000/"

    @ui
    Scenario: Registering a new account from Home page
        Given I follow "Sign Up"
        And I am on "/sign-up"
        Then I should see "Create a Cards Account." in the "h1" element
        When I fill in "username" with "John Smith"
        And I fill in "email" with "john.smith@gmail.com"
        And I fill in "password" with "john1234"
        And I press "Create New Account"
        Then I should see "New account has been successfully created." in the "h1" element

    @ui
    Scenario: Registering a new account from Login page
        Given I am on "/login"
        When I follow "or create an account."
        Then I should see "Create a Cards Account." in the "h1" element
        When I fill in "username" with "John Smith"
        And I fill in "email" with "john.smith@gmail.com"
        And I fill in "password" with "john1234"
        And I press "Create New Account"
        Then I should see "New account has been successfully created." in the "h1" element
