@customer-login
Feature: Resetting a password
    In order to login to my account when I forgot my password
    As a Visitor
    I need to be able to reset my password

    @ui @email
    Scenario: Resetting an account password from Login page
        Given I am on "/login"
        And I should see text matching "Forgot your password?"
        When I follow "Forgot your password?"
        Then I should be on "/forgot"
        And I should see "Reset Your Cards Password." in the "h1" element
        When I fill in "email" with "john.smith@gmail.com"
        And I press "Submit"
        Then I should see "The email with reset link should be sent to john.smith@gmail.com." in the "p" element
