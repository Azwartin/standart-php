<?php

/**
 * Stored sorted users from max to min
 * Operator Insert keeps order
 * SplMaxHeap and SplMinHeap work similarly
 * 
*/
class MaxHeap extends SplHeap 
{
    protected function compare($a, $b) : int 
    {
        return $a['rating'] - $b['rating'];
    }
}

$heap = new MaxHeap();
$i = 0;
while ($i++ < 5) {
    $user = [
        'name' => "User $i",
        'rating' => rand(1, 1000) 
    ];

    $heap->insert($user);
}

while(!$heap->isEmpty()) {
    print_r($heap->extract());
}
