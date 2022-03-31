module.exports = (property) => `    
    public function ${property.getterName()}()${
  property.getType() ? ': ' + property.getType() : ''
} 
    {
        return $this->${property.getName()};
    }
`;
