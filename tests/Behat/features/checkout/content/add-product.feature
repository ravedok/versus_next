Feature: add-product
  As a user anonymous
  I want check checkout content

  Background:
    Given the fixtures file "global-fixtures.yaml" is loaded
  
  Scenario: Check successful when adding max units
    When I send a "POST" request to "/checkout/content/add" with body:
    """
    {
      "productSku": "{{ normal_product.sku }}",
      "units": {{ normal_product.stored.stock}}
    }
    """
    Then the response status code should be "200"
    Then the response content should include:
    """
    {
      "content": {
        "lines": [
          {
            "product": {
              "id": "{{ normal_product.id }}"              
            },
            "units": {{ normal_product.stored.stock }}
          }
        ]
      }
    }
    """
  Scenario: Check fail when adding more units than available
    Given The session variable "cart" contain:
    """
      {
        "lines": [{
          "productId": "{{ normal_product.id }}",
          "type": "NORMAL",
          "units": 1
        }]
      }
    """
    When I send a "POST" request to "/checkout/content/add" with body:
    """
    {
      "productSku": "{{ normal_product.sku }}",
      "units": {{ normal_product.stored.stock}}
    }
    """
    Then the response status code should be "400"
    

  
