Feature: checkout-data
  As a user anonymous
  I want check checkout content

  Background:
    Given the fixtures file "global-fixtures.yaml" is loaded
  
  Scenario: Check successful
    Given The session variable 'cart' contain:
      """
      {
        "lines": [{
          "productId": "{{ product_tactical_sp.id }}",
          "units": 3
        }]
      }
    """
    When I send a "GET" request to "/checkout"
    Then the response status code should be "200"
    Then the response content should include:
    """
    {
      "content": {
        "lines": [
          {
            "product": {
              "id": "{{ product_tactical_sp.id }}"              
            },
            "units": 3
          }
        ]
      }
    }
    """

