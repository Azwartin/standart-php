<?php

/**
 * Interfaces SplSubject, SplObserver for Observer pattern
*/
class Subject implements SplSubject 
{
    /**
     * @var SplObserver[] $observers
    */
    protected $observers;

    public function __construct() 
    {
        $this->observers = [];
    }

    public function attach(SplObserver $observer) 
    {
        $this->observers[$this->getObserverHash($observer)] = $observer;
    }

    public function detach(SplObserver $observer)
    {
        unset($this->observers[$this->getObserverHash($observer)]);
    }

    public function notify()
    {
        foreach($this->observers as $observer) 
        {
            $observer->update($this);
        }
    }

    protected function getObserverHash($observer) 
    {
        return spl_object_hash($observer);
    }

    public function getTimestamp(): int 
    {
        return time();
    }
}

class Observer implements SplObserver 
{
    /**
     * @var int $timestamp
    */
    protected $timestamp;
    /**
     * @var string $name
    */
    protected $name;

    public function __construct(string $name) 
    {
        $this->name = $name;
    }

    public function update($subject) 
    {
        $this->timestamp = $subject->getTimestamp();
        $this->show();
    }

    public function show() 
    {
        echo "{$this->name} {$this->timestamp}\n";
    }
}

//For example only. You should to implement definition and logic (side effects) in different files in real code

$observerA = new Observer('A');
$observerB = new Observer('B');

$subject = new Subject();
$subject->attach($observerA); $subject->attach($observerB);
$subject->notify();
sleep(1);
$subject->detach($observerA);
$subject->notify();