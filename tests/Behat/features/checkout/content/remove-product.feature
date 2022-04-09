Feature: add-product
  As a user anonymous
  I want check that I can remove products from my cart

  Background:
    Given the fixtures file "global-fixtures.yaml" is loaded
  
  Scenario: Check that removing a product that doesn't exist doesn't do anything
    When I send a "POST" request to "/checkout/content/remove" with body:
    """
    {
      "productSku": "{{ normal_product.sku }}"
    }
    """
    Then the response status code should be "200"
      And the response value "content.lines" should be empty:    

  Scenario: Check that an existing line is deleted correctly
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
    When I send a "POST" request to "/checkout/content/remove" with body:
    """
    {
      "productSku": "{{ normal_product.sku }}"
    }
    """
    Then the response status code should be "200"
      And the response value "content.lines" should be empty:    