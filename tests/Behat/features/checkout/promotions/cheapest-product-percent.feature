Feature: cheapest-product-percent
  As a user anonymous
  I want to check that the discount is applied to the cheapest product

  Background:
    Given the fixtures file "promotions/cheapest-product.fixtures.yaml" is loaded
  
  Scenario: Check apply promotions
    Given The session variable "cart" contain:
    """
      {
        "lines": [{
          "productId": "{{ normal_product_with_offer.id }}",
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
              "id": "{{ normal_product_with_offer.id }}"             
            },
            "offer": {
              "amount": 30,
              "previous": 169.9,
              "type": "PERCENT"
            },
            "units": 1,
            "price": 118.93
          },
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
            "price": 162.78
          }
        ]
      }
    }
    """