Feature: checkout-data
  As a user anonymous
  I want check checkout content

  Background:
    Given the fixtures file "global-fixtures.yaml" is loaded
  
  Scenario: check that an empty session returns an empty cart    
    When I send a "GET" request to "/checkout"
    Then the response status code should be "200"
      And the response value "content.lines" should be empty:    
  Scenario: Check successful
    Given The session variable 'cart' contain:
      """
      {
        "lines": [{
          "productId": "{{ normal_product.id }}",
          "units": 2
        },{
          "productId": "{{ normal_product_with_offer.id }}",
          "units": 1
        }]
      }
    """
    When I send a "GET" request to "/checkout"
    Then the response status code should be "200"
    Then the response content should include:
    """
    {
      "content": {
        "lines": [{
            "product": {
              "id": "{{ normal_product.id }}"
            },
            "units": 2,
            "total": 59.8
          },{
            "product": {
              "id": "{{ normal_product_with_offer.id }}"
            },
            "units": 1,
            "total": 120
          }]
      },
      "total": 179.8
    }
    """

