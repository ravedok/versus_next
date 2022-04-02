Feature: remove-product
  As a user anonymous
  I want remove products from cart

  Background:
    Given the fixtures file "global-fixtures.yaml" is loaded
  
  Scenario: Check returns a not found error when we remove a product that does not exist
    When I send a "POST" request to "/checkout/content/reduce" with body:
    """
    {
      "productSku": "{{ product_tactical_sp.sku }}",
      "units": {{ product_tactical_sp.stored.stock }}
    }
    """
    Then the response status code should be "200"
    Then the response content should include:
    """
    {
      "content": {
        "lines": []
      }
    }
    """

  Scenario: Check that we removed a unit from an existing product
    Given The session variable "cart" contain:
    """
      {
        "lines": [{
          "productId": "{{ product_tactical_sp.id }}",
          "units": 3
        }]
      }
    """
    When I send a "POST" request to "/checkout/content/reduce" with body:
    """
    {
      "productSku": "{{ product_tactical_sp.sku }}",
      "units": 2
    }
    """
    Then The response status code should be "200"
    Then The response content should include:
    """
    {
      "content": {
        "lines": [
          {
            "product": {
              "id": "{{ product_tactical_sp.id }}"              
            },
            "units": 1
          }
        ]
      }
    }
    """

    Scenario: Check that when reducing the units of a line to zero or less it is eliminated
    Given The session variable "cart" contain:
    """
      {
        "lines": [{
          "productId": "{{ product_tactical_sp.id }}",
          "units": 1
        }]
      }
    """
    When I send a "POST" request to "/checkout/content/reduce" with body:
    """
    {
      "productSku": "{{ product_tactical_sp.sku }}",
      "units": 1
    }
    """
    Then the response status code should be "200"
    Then the response value "content.lines" should be empty:    