<?php
ini_set('display_errors', 1); 
ini_set('log_errors', 1); 
error_reporting(E_ALL);


//require_once ("include/debug.inc.php");
//include ("include/PDOConnectionFactory.class.php");
//
//echo "1";
//
//$conn = PDOConnectionFactory::getConnection();
//$sql	= "SELECT * FROM login";
//$stmt	= $conn->query($sql);
//
//echo "STMT: " . $stmt;

// foreach($stmt as $row) {
// 	echo $row['senha'];
// }

// if (class_exists('PDO')) {
// 	echo "done";
// }else {
// 	echo "none";
// }


/**
 * A typical Singleton in PHP
 *
 */
//class Singleton 
//{       
//        /**
//         * Static instance
//         * 
//         * @var SingletonRegistry
//         */
//        private static $_instance;
//        
//        /**
//         * Private constructor
//         *
//         */
//        private function __construct()
//        {}
//        
//        /**
//         * Get the single instance
//         *
//         * @return Singleton
//         */
//        public static function getInstance()
//        {
//                if(self::$_instance === null)
//                {
                        //First and only construction.
//                        self::$_instance = new self();
//                }
//                return self::$_instance;
//        }
//        
//        /**
//         * Disallow cloning
//         *
//         */
//        private function __clone()
//        {}
//}
//
//$singleton = Singleton::getInstance();


/**
 * Abstract Cache supertype
 *
 */
//abstract class Cache
//{
//        /**
//         * Instantiation flag
//         *
//         * @var bool
//         */
//    private static $instantiated = false;
//    
//    /**
//     * Constructor
//     * 
//     * @final
//     * @return void
//     *
//     */
//    final public function __construct()
//    {
//        if(self::$instantiated)
//        {
//            throw new Exception('There can be only one cache.');
//
//        }
//        $this->init();
//        
//        self::$instantiated = true;
//    }
//    
//    /**
//     * Initialization hook for child classes
//     *
//     */
//    abstract public function init();
//}


class User
{

	private static $instance;
	
	public static function person() {
		if(self::$instance === null) {
			//self::$instance = new __CLASS__;
			echo "tata";	
		}
		return self::$instance;
	}

}

//$oUser1 = User::singleton();
//$oUser2 = User::singleton();
//$oUser3 = User::singleton();



?>