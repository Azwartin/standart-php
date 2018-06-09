<?php

/**
 * Class implements SeekableIterator interface. 
 * It's allow use "foreach" on instances of the class and seek to any position
 * It's allow iterate on instance in other words
*/
class Container implements SeekableIterator 
{
    /**
     * @var int[] $list
    */
    protected $list;

    /**
     * @var int $pointer - current position of iterator
    */
    protected $pointer;

    public function __construct() 
    {
        $this->list = [];
        $this->rewind();
    }

    public function add(int $number) 
    {
        $this->list[] = $number;
    }

    /**
     * Returns the current element
    */
    public function current() : ?int 
    {
        return $this->list[$this->pointer] ?? null;
    }

    /**
     * Returns the current pointer
    */
    public function key() : int
    {
        return $this->pointer;
    }

    /**
     * Move pointer to next element
    */
    public function next() 
    {
        $this->pointer++;
    }

    /**
     * Move pointer to the start of list
    */
    public function rewind() 
    {
        $this->pointer = 0;
    }

    /**
     * Check current pointer validity
    */
    public function valid() : bool 
    {
        return isset($this->list[$this->pointer]);
    }

    public function seek($pointer) 
    {
        if (!isset($this->list[$pointer])) {
            throw new OutOfBoundsException("Incorrect position $pointer");
        }

        $this->pointer = $pointer;
    }
}

//For example only. You should to implement definition and logic (side effects) in different files in real code

$list = new Container();
$list->add(1); $list->add(2); $list->add(3);

foreach($list as $key => $value) {
    echo "$key \t $value \t\n";
}