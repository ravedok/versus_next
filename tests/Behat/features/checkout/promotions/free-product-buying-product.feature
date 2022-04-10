Feature: free-product-buying-product
  As a user anonymous
  I want to check that the gift products are added correctly

  Background:
    Given the fixtures file "promotions/free-product-buying-product.fixtures.yaml" is loaded
  
  Scenario: Check apply promotions
    Given The session variable "cart" contain:
    """
      {
        "lines": [{
          "productId": "{{ normal_product_with_offer.id }}",
          "type": "NORMAL",
          "units": 2
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
              "id": "{{ normal_product_with_offer.id }}"             
            },
            "offer": {
              "amount": 7.12,
              "previous": 169.9,
              "type": "AMOUNT"
            },
            "units": 2,
            "price": 162.78,
            "total": 325.55
          },
          {
            "product": {
              "id": "{{ normal_product.id }}"
            },
            "units": 2,
            "price": 0
          }
        ]
      },
      "total": 325.55
    }
    """