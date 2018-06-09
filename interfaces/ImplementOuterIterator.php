<?php

/**
 * Class implements OuterIterator interface. 
 * Use it when you have more then one Iterator in one object and you want iterate over its
 * For example you have three requests to DB/API and you want iterate over as one
*/
class Container implements OuterIterator 
{
    /**
     * @var Iterator[] $list 
    */
    protected $list;

    /**
     * @var int $pointer - current position of iterator over iterator
    */
    protected $pointer;

    public function __construct() 
    {
        $this->list = [];
        $this->rewind();
    }

    public function append(Iterator $iterator) 
    {
        $this->list[] = $iterator;
    }

    /**
     * Returns the current element
    */
    public function current() 
    {
        if (isset($this->list[$this->pointer])) {
            return $this->list[$this->pointer]->current();
        }

        throw new OutOfRangeException("Pointer is out of range");
    }

    /**
     * Returns the current pointer
    */
    public function key()
    {
        if (isset($this->list[$this->pointer])) {
            return $this->list[$this->pointer]->key();
        }

        throw new OutOfRangeException("Pointer is out of range");
    }

    /**
     * Move pointer to next element
    */
    public function next() 
    {
        if (!isset($this->list[$this->pointer])) {
            throw new OutOfRangeException("Pointer is out of range");
        }

        $this->list[$this->pointer]->next();
        //if end of current
        if (!$this->list[$this->pointer]->valid()) {
            //go to next
            $this->pointer++;
            //if exist
            if (isset($this->list[$this->pointer])) {
                //rewind it
                $this->list[$this->pointer]->rewind();
            }
        }
    }

    /**
     * Move pointer to the start of list
    */
    public function rewind() 
    {
        $this->pointer = 0;
        if (isset($this->list[$this->pointer])) {
            $this->list[$this->pointer]->rewind();
        }
    }

    /**
     * Check current pointer validity
    */
    public function valid() : bool 
    {
        return isset($this->list[$this->pointer]) ? 
            ($this->list[$this->pointer]->valid() || $this->hasNext()) : false;
    }

    /**
     * Returns current iterator
    */
    public function getInnerIterator() 
    {
        return $this->list[$this->pointer];
    }

    /**
     * Return flag - has next iterator
    */
    protected function hasNext() 
    {
        return isset($this->list[$this->poiner + 1]);
    }
}

//For example only. You should to implement definition and logic (side effects) in different files in real code

$list = new Container();

$list->append(new ArrayIterator([1, 2, 3]));
$list->append(new ArrayIterator([4, 5, 6]));
$list->append(new ArrayIterator([7, 8, 9]));

foreach($list as $key => $value) {
    $class = get_class($list->getInnerIterator());
    echo "$key \t $value \t $class\t\n";
}