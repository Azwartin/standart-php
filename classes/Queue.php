<?php

$queue = new SplQueue();

//FIFO
$i = 0;
while ($i < 10) {
    $t = "Customer $i";
    echo "Arrived $t \n";
    $queue->enqueue("Customer $i");
    $i++;
}

while($i-- > 0) {
    echo 'Departed ' . $queue->dequeue() . "\n";
}