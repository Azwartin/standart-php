<?php

/**
 * Class implements Countable interface. It's allow use function "count" on instances of the class 
 * This example returns count of int in inner list
*/
class Container implements Countable 
{
    /**
     * @var int[] $list 
    */
    protected $list;

    public function add(int $number) 
    {
        $this->list[] = $number;
    }

    public function count() 
    {
        return count($this->list);
    }
}

//For example only. You should to implement definition and logic (side effects) in different files in real code

$list = new Container();
$list->add(1); $list->add(2); $list->add(3);
echo count($list);