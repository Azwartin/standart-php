<?php

/**
 * Class implements IteratorAggregate interface. It's allow use function "count" on instances of the class 
 * It's allow iterate on instance in other words.
 * It seem's like Iterator but Iterator logic implements in another class
 * 
*/
class Container implements IteratorAggregate
{
    /**
     * @var int[] $list 
    */
    protected $list;

    public function add(int $number) 
    {
        $this->list[] = $number;
    }

    /**
     * Create an external iterator
    */
    public function getIterator()
    {
        return new ArrayIterator($this->list);
    }
}

//For example only. You should to implement definition and logic (side effects) in different files in real code

$list = new Container();
$list->add(1); $list->add(2); $list->add(3);

foreach($list as $key => $value) {
    echo "$key \t $value \t\n";
}