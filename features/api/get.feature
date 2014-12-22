@api
Feature: Get Post By Id
    In order to consult information from a post
    As a anonymous user
    I need to be able to get post content from its id

    Scenario: Retrieving data from a valid id
        Given there is a post whose id is Thisid in database
        When I go to/api/post/id
        Then I should see the json description of it including the content, the author and the date       

    Scenario: Retrieving data from a unkown id
        Given there is no post whose id is Thisid in database
        When I go to/api/post/id
        Then I should see an empty json description 
