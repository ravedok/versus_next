Feature: checkout-data
  As a user anonymous
  I want check checkout content

  Background:
    Given the fixtures file "global-fixtures.yaml" is loaded
  
  Scenario: Check successful
    When I send a "GET" request to "/checkout"
    Then the response status code should be "200"

