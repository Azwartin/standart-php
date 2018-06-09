<?php

/**
 * Class implements RecursiveIterator interface. 
 * Use it when you have Iterator in Iterator in Iterator ... in one object and you want iterate over its as one
 * For example you can get N records from DB/API, iterate its, 
 * check that next N records exist in hasChildren, get next N in getChildren - repeat 
*/
class Container implements RecursiveIterator 
{
    /**
     * @var int[] $list 
    */
    protected $list;
    /**
     * @var Container $child
    */
    protected $child;
    /**
     * @var int $pointer - current position of iterator over iterator
    */
    protected $pointer;
    /**
     * @var Container $cur
    */
    protected $cur;

    public function __construct() 
    {
        $this->list = [];
        $this->rewind();
    }

    public function append(int $value) 
    {
        $this->list[] = $value;
    }

    /**
     * Returns the current element
    */
    public function current() : ?int 
    {
        return $this->cur->list[$this->cur->pointer] ?? null;
    }

    /**
     * Returns the current pointer
    */
    public function key() : int
    {
        return $this->cur->pointer;
    }

    /**
     * Move pointer to next element
    */
    public function next() 
    {
        $this->cur->pointer++;
        if (!isset($this->cur->list[$this->cur->pointer]) && $this->cur->hasChildren()) {
            $this->cur = $this->cur->getChildren();
            $this->cur->rewind();
        }
    }

    /**
     * Move pointer to the start of list
    */
    public function rewind() 
    {
        $this->cur = $this;
        $this->pointer = 0;
    }

    /**
     * Check current pointer validity
    */
    public function valid() : bool 
    {
        return isset($this->cur->list[$this->cur->pointer]) || $this->cur->hasChildren();
    }

    public function getChildren() 
    {
        return $this->child;
    }

    public function hasChildren() 
    {
        return (bool) $this->child;
    }

    public function setChild(Container $child) 
    {
        $this->child = $child;
    }
}

//For example only. You should to implement definition and logic (side effects) in different files in real code

$list2 = new Container();
$list2->append(7); $list2->append(8); $list2->append(9);

$list1 = new Container();
$list1->append(4); $list1->append(5); $list1->append(6);

$list0 = new Container();
$list0->append(1); $list0->append(2); $list0->append(3);

$list2->setChild($list0); $list1->setChild($list2); $list0->setChild($list1);//circle

foreach($list0 as $key => $value) {
    echo "$key \t $value \t\n";
}