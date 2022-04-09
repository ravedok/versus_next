Feature: promotion-product-percent
  As a user anonymous
  I want to check that the percentage discount promotions are applied correctly to the product

  Background:
    Given the fixtures file "promotions/product-percent.fixtures.yaml" is loaded
  
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
              "amount": 20,
              "previous": 169.9,
              "type": "PERCENT"
            },
            "units": 2,
            "price": 135.92,
            "total": 271.84
          }
        ]
      }
    }
    """