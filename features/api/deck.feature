@deck
Feature: CRUD functionality for the Deck, available via JSON Api
    In order to Create, Read, Update, Delete the Deck
    As a Developer
    I wan to be able to Create, Read, Update, Delete the Deck via JSON Api

    Background:
        Given there are Decks with the following details:
            | name        |
            | Welcome     |
            | Information |
            | 2018 - 04   |
    
    @api
    Scenario: Get only one deck - read action
