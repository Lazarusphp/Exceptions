<?php
namespace LazarusPhp\ExceptionHandler;

use App\System\Core\Functions;
use LogicException;
use Throwable;

class ExceptionDispatcher
{
    private array $listeners = [];
    private static array $registeredListeners = [];

    public function __construct()
    {
        // Count Registered Listeners

        // Loop Registered Listeners

        // Create new Listener 

    }

    public function add(string|array $listener)
    {
        if(is_string($listener))
        {
            $this->listeners[] = $listener;
        }
        else
        {
            $this->listeners = $listener;
        }
    }

    public  function autoloadListeners()
    {
        if(count(self::$registeredListeners)){
            foreach(self::$registeredListeners as $key => $listener)
            {
                if(!array_key_exists($listener,$this->listeners)){
                    echo $listener . "Added" . "<br>";
                    $this->add($listener);
                }
                else
                {
                    echo "$listener already Exists";
                }
            }
        }
    }

    public static function registerListener(string $listener):void
    {
        if(is_string($listener))
        {
            self::$registeredListeners[] = $listener;
        }
        elseif(is_array($listener))
        {
            self::$registeredListeners = $listener;
        }
        else
        {
            throw new LogicException("Request Parameter must be a string or array");
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