<?php

/**
 * Class implements ArrayAccess interface. It's allow to provide accessing objects as arrays. 
*/
class Container implements ArrayAccess 
{
    protected $propertyA;
    protected $propertyB;
    protected $propertyC;

    public function __construct() 
    {
        $this->propertyA = 0;
        $this->propertyB = 0;
        $this->propertyC = 0;
    }
    
    /**
     * Checks that offset exists
    */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * Returns element at offset
    */
    public function offsetGet($offset) 
    {
        return $this->$offset ?? null;
    }

    /**
     * Unset element by offset
    */
    public function offsetUnset($offset) 
    {
        throw new BadMethodCallException('Can\'t unset any elements in Container');
    }

    public function offsetSet($offset, $value) 
    {
        if ($this->offsetExists($offset)) {
            $this->$offset = $value;
        } else {
            throw new BadMethodCallException('Offset is incorrect');
        }
    }
}

//For example only. You should to implement definition and logic (side effects) in different files in real code

$container = new Container();
if (isset($container['propertyA'])) {
    $container['propertyA'] = 'A';
    echo $container['propertyA'];
    //unset($container['propertyA']); throws exception
}