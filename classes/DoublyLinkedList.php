<?php

//functionalities of a doubly linked list

$list = new SplDoublyLinkedList();

$i = 10;
/*unshift 90, 80, 70 */
/*push 9,8,7,...0 */
while ($i-- > 0) {
    $list->unshift($i * 10);
    $list->push($i);
}

/*ends with 0 starts with 9*/
echo $list->top() . ' ' . $list->bottom() . "\n";

/*go from top to bottom*/
$list->rewind();
$i = count($list);
while($list->valid()) {
    echo $list->key() . "\t" . $list->current() . "\t\n";
    $list->next();
}

/*go from bottom to top*/
$list->rewind();
while($list->valid()) {
    echo $list->key() . "\t" . $list->current() . "\t\n";
    $list->prev();
}

while (count($list) > 0) {
    echo "Unshift " . $list->shift() . "\t Pop " . $list->pop() . "\t\n";
}