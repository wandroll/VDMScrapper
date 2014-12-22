@command
Feature: Update posts in the database
    In order to update posts in database
    As a anonymous user
    I need to be able to import the 200 first posts from the VDM website

    Scenario: Update posts in the database in commandline
        Given that I am in the app root directory
        When I use the terminal to execute "php app/console vdm:import"
        Then It should erase and replace all posts in database from viedemerde.fr 
