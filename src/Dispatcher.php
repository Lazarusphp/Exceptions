<?php
namespace LazarusPhp\Exceptions;

use LogicException;
use Throwable;

class Dispatcher
{
    private array $listeners = [];
    private static array $registeredListeners = [];
    
    public function __construct()
    {  
     }

    public function add(?array $listener=null):void
    {

        if($listener === null || count($listener) ===0) 
        {
            throw new LogicException("Parameter Cannot be empty");
        }

        if(count($listener) === 1)
        {
            $this->listeners[] = $listener[0];
        }
        else
        {
            $this->listeners = $listener;
        }
    }



    public function autoloadListeners()
    {
        if(count(self::$registeredListeners)){
            foreach(self::$registeredListeners as $key => $listener)
            {
                $this->add($listener);
            }
        }
    }

    public static function registerListener(?array $listener=null):void
    {

        switch($listener)
        {
            case (count($listener) === 0): throw new LogicException("Parameter must have a value");
            break;
            case ($listener ===null): throw new LogicException("Parameter Must hold an Array Value");
            break;
            case ($listener === 1) : self::$registeredListeners[] = $listener[0];
            break;
            default:self::$registeredListeners = $listener;
        }

        
    }

    public function dispatch(Throwable $e)
    {
        foreach($this->listeners as $listener)
       { 
        //Convert to Object When Written as a String
            if(is_string($listener)){
                if(class_exists($listener))
                {
                    $listener =  new $listener();
                }
                else
                {
                    throw new LogicException("Class Must Exist");
                }
            }
            
            // Validate the class is an object 
            if(is_object($listener)){

            // Validate the Method Exists
                if(method_exists($listener,"support"))
                {
                    // Send Dispatch Support Request
                    if($listener->support($e)){
                        // Load Handle
                        $listener->handle($e);
                        return;
                    }
                }
                else
                {
                    // Throw logic Exception if the method Doesnt Exist
                    throw new LogicException("Support Method Must exist");
                }
            }
            else
            {
                // Throw Logic Exception if the called Class is not an object
                throw new LogicException("Listener Must be an Object");
            }
        }
        
        // Set Http Response Code
        http_response_code(500);
        echo "Unhandled Exception". $e->getMessage();
    }

    public function __destruct()
    {
        $this->listeners = [];
        self::$registeredListeners = [];
    }


}