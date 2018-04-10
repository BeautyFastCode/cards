@homepage
Feature: Viewing the homepage
    In order to read about the Card project
    As a Visitor
    I want to be able to view homepage

    @ui
    Scenario: Viewing the homepage, header area
        Given I browse to page 'http://127.0.0.1:8000/'
        And I see logo in navigation bar
        And I see link 'Log In'
        And I see link 'Sign Up'

#    @ui
#    Scenario: Viewing the homepage, sections area
#        Given I browse to page 'http://127.0.0.1:8000/'
#        And I see section 'cover'
#        And I see section 'benefits'
#        And I see section 'showcase'
#        And I see section 'counters'
#        And I see section 'suites'
#        And I see section 'subscribe'
#        And I see section 'start-learning'
#
#    @ui
#    Scenario: Viewing the homepage, footer area
#        Given I browse to page 'http://127.0.0.1:8000/'
#        And I see logo in footer
#        And I see copyright text in footer
