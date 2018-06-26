<?php
/**
 * Worker do this, Chief generate
 * 
 * @property string $description
 * @property int $priority
*/
class Job 
{
    protected $description;
    protected $priority;

    public function __construct(string $description, int $priority = 0)
    {
        $this->priority = $priority;
        $this->description = $description;
    }

    public function getDescription() : string 
    {
        return $this->description;
    }

    public function getPriority() : int 
    {
        return $this->priority;
    }
}
/**
 * Worker can get job from queue. He wants to do the important task at first
*/
class Worker 
{
    /**
     * @var string $name
    */
    protected $name;
    /**
     * @var SplPriorityQueue $queue
    */
    protected $queue;

    public function __construct(string $name, SplPriorityQueue $queue)
    {
        $this->name = $name;
        $this->queue = $queue;
    }

    public function handle() 
    {
        if ($this->queue->isEmpty()) {
            echo "Worker $this->name: I have not any job now \n";
        } else {
            /* @var Job $job */
            $job = $this->queue->extract();
            echo "Worker $this->name: I complete " . $job->getDescription() . ' with priority ' . $job->getPriority() . "\n";
        }
    }
}

/**
 * Chief generate task and set it priority
*/
class Chief
{
    /**
     * @var string $name
    */
    protected $name;
    /**
     * @var SplPriorityQueue $queue
    */
    protected $queue;

    public function __construct(string $name, SplPriorityQueue $queue)
    {
        $this->name = $name;
        $this->queue = $queue;
    }

    public function generate()
    {
        $job = new Job("from chief $this->name: " . rand(1000, 9999), rand(0, 10));
        echo "Chief $this->name create new task:" . $job->getDescription() . ' with priority ' . $job->getPriority() . "\n";
        $this->queue->insert($job, $job->getPriority());
    }
}

/**
 * SplPriorityQueue is a prioritized queue based on max heap
*/
$queue = new SplPriorityQueue();

$chief = new Chief('Tom', $queue);
$workers = [new Worker('Bob', $queue), new Worker('Alice', $queue)];

echo "At the morning: \n";

$i = 0; $taskCount = 12;
while ($i++ < $taskCount) {
    $chief->generate();
}

echo "\nStart working \n";
$i = 0; $dayTickCount = $taskCount + 1;
while ($i++ < $dayTickCount) {
    $workers[rand(0,1)]->handle();
} 
