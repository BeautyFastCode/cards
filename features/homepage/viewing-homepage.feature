@homepage
Feature: Viewing the homepage
    In order to read about the Card project
    As a Visitor
    I want to be able to view homepage

    @ui
    Scenario: Viewing the homepage, header area
        Given I am on "http://127.0.0.1:8000/"
        And I should see a "body" element
        And I should see a "nav .navbar-brand img" element
        And I should see text matching "Log In"
        And I should see text matching "Sign Up"

    @ui
    Scenario: Viewing the homepage, sections area
        Given I am on "http://127.0.0.1:8000/"
        And I should see a "section.cover" element
        And I should see a "section.benefits" element
        And I should see a "section.showcase" element
        And I should see a "section.counters" element
        And I should see a "section.suites" element
        And I should see a "section.subscribe" element
        And I should see a "section.start-learning" element

    @ui
    Scenario: Viewing the homepage, footer area
        Given I am on "http://127.0.0.1:8000/"
        And I should see a "footer img.logo-w-4" element
        And I should see "All rights reserved." in the "footer" element
