<?php
/**
 * Interacción de los usuarios con la aplicación
 */
class BipherUsuario
{
    /**
    * The database object
    * @var object
    */
    private $_db;
    /**
    * Chequea un database object y lo crea si no lo encuentra
    * @param object $db
    * @return void
    */
    public function __construct($db=NULL)
    {
        if(is_object($db))
        {
            $this->_db = $db;
        }
        else
        {
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
            $this->_db = new PDO($dsn, DB_USER, DB_PASS);
        }
    }
    /**
	* Chequea los datos y loguea al usuario
	* @return boolean -- TRUE, exito; FALSE, error	*
	*/
	public function accountLogin()
	{
		$sql = "SELECT username FROM usuarios WHERE username=:user AND password=MD5(:pass) LIMIT 1";
		try
		{
			$stmt = $this->_db->prepare($sql);
			$stmt->bindParam(":user", $_POST['username'], PDO::PARAM_STR);
			$stmt->bindParam(":pass", $_POST['password'], PDO::PARAM_STR);
			$stmt->execute();
			if($stmt->rowCount()==1)
			{
				$_SESSION['username'] = htmlentities($_POST['username'], ENT_QUOTES);
				$_SESSION['LoggedIn'] = 1;
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		catch(PDOException $e)
		{
			return FALSE;
		}
	}
}
?>
