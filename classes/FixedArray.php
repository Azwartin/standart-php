<?php

/**
 * SplFixedArray works as array, but it has fixed length and allows only integer as keys (indexes).
 * It requires less memory and works faster than common array
*/

for ($i = 10; $i < 100000000; $i *= 10) {
    $totals = test($i);
    echo "Size $i \n";
    printTestResult($totals);
}

function test(int $size) : SplFixedArray 
{
    //Start array tests
    $memoryUsage = memory_get_usage();
    $arr = [];
    list($arrReadTime, $arrWriteTime, $arrMemoryUsage) = testStruct($size, $arr, $memoryUsage);
    $arr = null;
    //Start spl tests
    $memoryUsage = memory_get_usage();
    $arr = new SplFixedArray($size);
    list($fixedArrReadTime, $fixedArrWriteTime, $fixedArrMemoryUsage) = testStruct($size, $arr, $memoryUsage);
    $arr = null;

    //Memory to mb 
    $arrMemoryUsage /= 1024 * 1024;
    $fixedArrMemoryUsage /= 1024 * 1024;
    $totals = new SplFixedArray(3);
    $totals[0] = [$arrReadTime, $fixedArrReadTime];
    $totals[1] = [$arrWriteTime, $fixedArrWriteTime];
    $totals[2] = [$arrMemoryUsage, $fixedArrMemoryUsage];
    return $totals;
}

function testStruct(int $testLength, $struct, int $memoryBefore) : array
{
    $memoryUsage = $memoryBefore;
    $start = microtime(true);
    for ($i = 0; $i < $testLength; $i++) {
        $struct[$i] = $i;
    }

    $writeTime = microtime(true) - $start;
    $start = microtime(true);
    for ($i = 0; $i < $testLength; $i++) {
        $t = $struct[$i];
    }

    $readTime = microtime(true) - $start;
    $memoryUsage = memory_get_usage() - $memoryUsage;
    return [$readTime, $writeTime, $memoryUsage];
}

function printTestResult(Iterator $totals) 
{
    printf("%-12s %-12s %-12s %-12s %-12s\n", 'Array', 'Fixed Array', 'Differnce', 'In Percent', 'Which better');
    foreach ($totals as $total) {
        $arr = round($total[0], 6); $fixed = round($total[1], 6);
        printf("%-12s %-12s %-12s %-12s %-12s\n", $arr, $fixed, abs($arr - $fixed),
         (round((max($arr, $fixed) / min($arr, $fixed)), 6) - 1), ($arr < $fixed ? 'Array' : 'SplFixedArray'));
    }
}