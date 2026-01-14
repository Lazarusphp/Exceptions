<?php
namespace LazarusPhp\ExceptionHandler;

use LogicException;
use Throwable;
class ExceptionDispatcher
{
    private array $listeners;

    public function __construct(array $listeners)
    {
        $this->listeners = $listeners;
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

}