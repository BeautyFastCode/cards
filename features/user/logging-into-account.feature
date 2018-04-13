@customer-login
Feature: Log in to the Cards
    In order to learn curses and cards
    As a Visitor
    I want to be able to log in to the Cards

    Background:
        Given I am on "http://127.0.0.1:8000/"

    @ui
    Scenario: Log in with email and password from Home page
        Given I follow "Log In"
        And I am on "/login"
        Then I should see "Log in to Cards." in the "h1" element
        When I fill in "username" with "john.smith@gmail.com"
        And I fill in "password" with "john1234"
        And I press "Log In"
        Then I should be on "/dashboard"

    @ui
    Scenario: Log in with username and password from Home page
        Given I follow "Log In"
        And I am on "/login"
        Then I should see "Log in to Cards." in the "h1" element
        When I fill in "username" with "John"
        And I fill in "password" with "john1234"
        And I press "Log In"
        Then I should be on "/dashboard"

    @ui
    Scenario: Log in from create account page
        Given I am on "/sign-up"
        And I should see "Create a Cards Account." in the "h1" element
        And I should see "or login to your account"
        When I follow "or login to your account"
        Then I should be on "/login"
        And I should see "Log in to Cards." in the "h1" element

    @ui
    Scenario: Log in from reset password page
        Given I am on "/forgot"
        And I should see "Reset Your Cards Password." in the "h1" element
        And I should see "or you can try logging in again"
        When I follow "or you can try logging in again"
        Then I should be on "/login"
        And I should see "Log in to Cards." in the "h1" element
