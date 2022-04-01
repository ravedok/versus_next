Feature: add-product
  As a user anonymous
  I want check checkout content

  Background:
    Given the fixtures file "global-fixtures.yaml" is loaded
  
  Scenario: Check successful when adding max units
    When I send a "POST" request to "/checkout/content/add" with body:
    """
    {
      "productSku": "OZTACTICALSP",
      "units": {{ product_tactical_sp.stored.stock }}
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
              "id": "{{ product_tactical_sp.id }}"              
            },
            "units": {{ product_tactical_sp.stored.stock }}
          }
        ]
      }
    }
    """
  Scenario: Check fail when adding more units than available
    When I send a "POST" request to "/checkout/content/add" with body:
    """
    {
      "productSku": "OZTACTICALSP",
      "units": {{ product_tactical_sp.stored.stock + 1}}
    }
    """
    Then the response status code should be "400"
    

  
