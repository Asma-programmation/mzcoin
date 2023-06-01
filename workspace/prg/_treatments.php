<?php
// Classe bibliothèque contenant les attributs et les méthodes nécessaires aux traitements
class _treatments
{
    private static $pdo = NULL;

    // Tableau contenant la liste des chaînes de caractères nécessaires aux traitements
    private static $strings = array(
        "connected"  => "3c9939b506a3e610ad27b1ea882951cf", 
        "captcha"    => "334b51540327677035688566f9e0f7b1",
        "saltkey1"   => "35599e273c89e2e190968c2d2b39ca11",
        "saltkey2"   => "05510083da4439f71c39b61f7a6311f0",
        "saltkey3"   => "a3390c7844b3fcb89e4d725647ff7611",
        "connection" => "mysql:host=localhost;dbname=mzcoindb",
        "user"       => "root",
        "password"   => "",
        "online_connection" => "mysql:host=localhost;dbname=id20600172_mzcoindb",
        "online_user" => "id20600172_mzcuser",
        "online_password" => "@lgeriA011111954"
    ); 

    // Méthode pour déclancher une exception (erreur)
    public static function throw_exception($msg) 
    {
        throw new Exception($msg);
    }

    // Méthode pour traiter une exception (erreur)
    public static function treat_exception($exception, $code, $level)
    {
        $_SESSION[self::$strings["connected"]] = NULL;
        session_destroy();
        session_regenerate_id();
        self::display_message($exception->getMessage(), $code, $level);
    }
    
    public static function generate_jeton()
    {
     //TODO
     //Code pour générer le jeton
    }

    public static function generate_reference()
    {
        return substr(md5(date("Y-m-d H:i:s.u")), 2, 8);
    }
    
    public static function generate_code($length)
    {
        $code = "";
        $code = substr(sprintf("%u", crc32(date("Y-m-d H:i:s.u"))), 0, $length);
        return $code;
        // exemple($length == 16) : 2798 7643 8067 8932
    }

    // Méthode pour afficher un message
    public static function display_message($message, $code, $level)
    {
        $path = "";

        for($i = 0; $i < $level; $i++)
        {
            $path .= '../';
        }

        $path .= "message.php?cd=".$code."&msg=".$message;
        header("location: ".$path);
    }

    // Méthode pour générer un objet PDO
    private static function generate_pdo()
    {
        $pdo = NULL;
        
        try 
        {
            $pdo = ($_SERVER['SERVER_NAME'] === 'localhost') ? // Si on est en localhost
                    new PDO(self::$strings["connection"], // Créer un objet PDO avec les coordonnées local
                            self::$strings["user"], 
                            self::$strings["password"], 
                            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')) : // Sinon si on est en ligne
                    new PDO(self::$strings["online_connection"], // Créer un objet PDO avec les coordonnées de l'hébergeur
                            self::$strings["online_user"], 
                            self::$strings["online_password"], 
                            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        } 
        catch (Exception $exception) 
        {
            self::treat_exception($exception, 0, 1);
        }

        return $pdo;
    }

    public static function get_last_insert_id() {
        return self::$pdo->lastInsertId();
    }

    // Méthode pour récupérer une chaîne de caractères
    public static function get_string($name)
    {
        $constante = "";

        try 
        {
            $constante = (isset(self::$strings[$name])) ? 
                        self::$strings[$name] : 
                        self::throw_exception("ERREUR : CONSTANTE MANQUANTE !!!");
        } 
        catch (Exception $exception) 
        {
            self::treat_exception($exception, 0, 1);
        }

        return $constante;
    }

    // Méthode pour exécuter une commande SQL
    public static function execute_command($cmd, $params)
    {
        $pdo = NULL;
        $stmt = NULL;

        try
        {
            $pdo = self::generate_pdo();
            $stmt = $pdo->prepare($cmd);
         
            if(isset($params))
            {
                foreach($params as $p)
                {
                    $stmt->bindParam($p["label"], $p["value"]); 
                }
            }

            $stmt->execute();
        } 
        catch (Exception $exception)
        {
            self::treat_exception($exception, 0, 1);
        }

        return $stmt;
    }
}