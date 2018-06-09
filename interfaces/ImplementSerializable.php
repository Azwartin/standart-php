<?php

/**
 * Class implements Serializable interface. It's allow to serialize/unserialize instance to/from string
*/
class Container implements Serializable
{
    public $propertyA;
    public $propertyB;
    public $propertyC;

    public function __construct(array $properties) 
    {
        $this->load($properties);
    }

    public function load(array $properties) 
    {
        if (count($properties) < 3) {
            throw new BadMethodCallException('Properties must contains more then 3 element\'s');
        }

        list($this->propertyA, $this->propertyB, $this->propertyC) = $properties;
    } 

    public function serialize() 
    {    
        return serialize([
            $this->propertyA,
            $this->propertyB,
            $this->propertyC,
        ]);
    }

    public function unserialize($data) 
    {
        $data = unserialize($data);
        if (is_array($data)) {
            $this->load($data);
        } else {
            throw new BadMethodCallException("Data is incorrect");
        }
    }
}

//For example only. You should to implement definition and logic (side effects) in different files in real code
$container = new Container(['string', [1,2,3], 212]);
//save state into variable
$serialized = serialize($container);
//change container
$container = ['it', 'is', 'changed'];
print_r($container);
//load state
$container = unserialize($serialized);
print_r($container);
