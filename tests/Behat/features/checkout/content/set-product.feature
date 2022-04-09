Feature: set-product
  As a user anonymous
  I want to assign lines to the cart

  Background:
    Given the fixtures file "global-fixtures.yaml" is loaded
  
  Scenario: I verify that when assigning a cart with zero lines, it returns the empty cart
    When I send a "POST" request to "/checkout/content/set" with body:
    """
    {
      "productSku": "{{ normal_product.sku }}",
      "units": 0
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

  Scenario: I verify that when assigning a product to an empty cart it creates it    
    When I send a "POST" request to "/checkout/content/set" with body:
    """
    {
      "productSku": "{{ normal_product.sku }}",
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
              "id": "{{ normal_product.id }}"              
            },
            "units": 2
          }
        ]
      }
    }
    """

  Scenario: I verify that assigning an existing product to a cart modifies it
    Given The session variable "cart" contain:
    """
      {
        "lines": [{
          "productId": "{{ normal_product.id }}",
          "type": "NORMAL",
          "units": 3
        }]
      }
    """
    When I send a "POST" request to "/checkout/content/set" with body:
    """
    {
      "productSku": "{{ normal_product.sku }}",
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
              "id": "{{ normal_product.id }}"              
            },
            "units": 2
          }
        ]
      }
    }
    """