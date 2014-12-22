@api
Feature: List posts by author and date range
    In order to consult posts 
    As a anonymous user
    I need to be able to list and filter posts by date range and author

    Scenario: Listing post with no filter
        Given there are posts in database
        When I go to /api/posts"
        Then I should see the json description of all the existing posts in database

    Scenario: Listing post from one author
        Given there are post from AuthoName
        When I go to /api/posts?author=AuthorName
        Then I should see an json description of all and only the posts in database from AuthorName

    Scenario: Listing post posted since a peculiar date
        Given there are post with date are more recent that ThisDate
        When I go to /api/posts?from="ThisDate"
        Then I should see an empty json description of all and only the posts in database posted since ThisDate

    Scenario: Listing post posted until a peculiar date
        Given there are post with date are previous to that ThisDate
        When I go to /api/posts?to="ThisDate"
        Then I should see an empty json description of all and only the posts in database posted untl ThisDate

    Scenario: Listing post posted with several criteria
        Given there are post with date between that ThisDate and ThatDate and author being AuthorName
        When I go to /api/posts?from="ThisDate"&to="ThatDate"&from=AuthorName
        Then I should see an empty json description of all and only the posts in database posted between ThisDate and ThatDate by  AuthorName