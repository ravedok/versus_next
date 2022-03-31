module.exports = (property) => `    
    public function ${property.setterName()}(${
  property.getType() ? property.getType() + ' ' : ''
}\$${property.getName()}): self
    {
        $this->${property.getName()} = \$${property.getName()};

        return $this;
    }
`;
