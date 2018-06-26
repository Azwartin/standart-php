<?php

/**
 * 
*/
class Job
{
    /* @var int $id */
    protected $id;

    public function __construct(int $id) 
    {
        $this->id = $id;
    }

    public function getID() : int
    {
        return $this->id;
    }
}

/**
 * Broken generator. Sometime it returns old object
*/
class BrokenGenerator
{
    /* @var stdClass[] */
    protected static $generated;

    protected static $count = 0;

    public static function generate() : Job
    {
        if (rand(0,10) > 5 && !empty(self::$generated)) {
            return self::$generated[rand(0, count(self::$generated) - 1)];
        }

        return self::trueGenerate();
    }

    public static function trueGenerate() : Job
    {
        $obj = new Job(++self::$count);
        self::$generated[] = $obj;
        return $obj;
    }
}

/**
 * We can use SplObjectStorage for identify objects
*/
$storage = new SplObjectStorage();
$testCount = 100; $i = 0; 
while ($i++ < $testCount) {
    $obj = BrokenGenerator::generate();
    $hash = $storage->getHash($obj);
    if ($storage->contains($obj)) {
        echo 'Already saved ' . $hash . "\n";
    } else {
        $storage->attach($obj);
        echo 'Add new item ' . $hash . "\n";
    }
}

echo "\nGenerator create " . $testCount . ' items. Count uniq is ' . count($storage) . "\n"; 

//We can iterate over storage
foreach ($storage as $key => $job) {
    /* @var Job $job */
    echo "\nKey: $key " . $job->getID() . "\n";
}

/**
 * We can use SplObjectStorage as map object -> data 
*/
$storage->removeAll($storage);//clear
$keys = [BrokenGenerator::trueGenerate(), BrokenGenerator::trueGenerate(), BrokenGenerator::trueGenerate()];
$storage[$keys[0]] = 123;
$storage[$keys[1]] = [1, 2, 3];
$storage[$keys[2]] = "Test string";

foreach ($keys as $job) {
    /* @var Job $job */
    echo "Job ID " . $job->getID() . "\n";
    print_r($storage[$job]);
    echo "\n";
}
