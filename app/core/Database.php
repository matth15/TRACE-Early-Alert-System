<?php


class Database
{

    private $dbcon = null;
    private $stmt = null;
    private static $database = null;

    public function __construct()
    {
        $this->dbcon = new PDO(
            'mysql:dbname=' . Config::get('mysql/DB_DATABASE') . '; 
        host=' . Config::get("mysql/DB_HOST") . '; 
        charset=' . Config::get('mysql/db_charset'),
            Config::get('mysql/DB_USERNAME'),
            Config::get('mysql/DB_PASSWORD')
        );

        $this->dbcon->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //This method for instantiating database object using the Singleton Design pattern.
    public static function open_db()
    {
        if (self::$database === null) {
            self::$database = new Database();
        }

        return self::$database;
    }

    //Prepares a SQL query for execution and assign a statement object to $this->stmt
    public function prepare($query)
    {
        $this->stmt = $this->dbcon->prepare($query);
    }

    //Binds a value to a parameter.
    public function bindValue($param, $value)
    {
        $type = self::getPDOType($value);
        $this->stmt->bindValue($param, $value, $type);
    }

    //Binds variable by reference to a parameter.
    public function bindParam($param, $var)
    {
        $type = self::getPDOType($var);
        $this->stmt->bindParam($param, $var, $type);
    }

    //Executes a prepared stmt
    public function execute($arr = null)
    {
        if ($arr === null)
            return $this->stmt->execute();
        else
            return $this->stmt->execute($arr);
    }

    //To fetch only a single column in form of 0-indexed array.
    public function fetchColumn()
    {
        return $this->stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    //To fetch the result data in form of [0-indexed][key][value] array.
    public function fetchAllAssociative()
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //To fetch Only the next row from the result data in form of [key][value] array.
    public function fetchAssociative()
    {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    //To fetch All the data in form of [0-indexed][an anonymous object with property names that correspond to the column names] array.
    public function fetchAllObject()
    {
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //To fetch Only the next row from the result data in form of an anonymous object with property names that correspond to the column names.
    public function fetchObject()
    {
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    //To fetch All data in form of an array indexed by both column name and 0-indexed column
    public function fetchAllBoth()
    {
        return $this->stmt->fetchAll(PDO::FETCH_BOTH);
    }

    //To fetch Only the next row from the result data in form of an array indexed by both column name and 0-indexed column
    public function fetchBoth()
    {
        return $this->stmt->fetch(PDO::FETCH_BOTH);
    }

    //Returns the ID of the last inserted row or sequence value
    public function lastInsertedId()
    {
        return $this->dbcon->lastInsertId();
    }

    //Start a transaction
    public function beginTransaction()
    {
        $this->dbcon->beginTransaction();
    }

    //Commit a transaction. This method will be called after beginTransaction()
    public function commit()
    {
        $this->dbcon->commit();
    }

    //Rollback a transaction. This method will be called after beginTransaction()
    public function rollBack()
    {
        $this->dbcon->rollBack();
    }

    //Returns the number of rows affected by the last SQL stmt
    public function countRows()
    {
        return $this->stmt->rowCount();
    }

    //Counts the number of rows in a specific table
    public function countAll($table)
    {
        $this->stmt = $this->dbcon->prepare('SELECT COUNT(*) AS count FROM ' . $table);
        $this->execute();
        return (int)$this->fetchAssociative()["count"];
    }

    //Select all rows from a table
    public function getAll($table)
    {
        $this->stmt = $this->dbcon->prepare('SELECT * FROM ' . $table);
        $this->execute();
    }

    //Select a row from a table provided by id(primary key)
    public function getById($table, $id)
    {
        $this->stmt = $this->dbcon->prepare('SELECT * FROM ' . $table . ' WHERE id = :id LIMIT 1');
        $this->bindValue(':id', $id);
        $this->execute();
    }

    //Select a row from a table provided by email
    public function getByEmail($table, $email)
    {
        $this->stmt = $this->dbcon->prepare('SELECT * FROM ' . $table . ' WHERE email = :email LIMIT 1');
        $this->bindValue(':email', $email);
        $this->execute();
    }

    public function getByUserType($table, $email)
    {
        $this->stmt = $this->dbcon->prepare('SELECT * FROM ' . $table . ' WHERE email = :email LIMIT 1');
        $this->bindValue(':email', $email);
        $this->execute();
    }

    //Delete all rows from a table
    public function deleteAll($table)
    {
        $this->stmt = $this->dbcon->prepare('DELETE FROM ' . $table);
        $this->execute();
    }

    //Delete all data from a table provided by id(primary key)
    public function deleteById($table, $id)
    {
        $this->stmt = $this->dbcon->prepare('DELETE FROM ' . $table . ' WHERE id = :id LIMIT 1');
        $this->bindValue(':id', $id);
        $this->execute();
    }


    //Select all rows from a table provided by user id
    public function getByUserId($table, $studentId)
    {
        $this->stmt = $this->dbcon->prepare('SELECT * FROM ' . $table . ' WHERE unique_id = :unique_id');
        $this->bindValue(':unique_id', $studentId);
        $this->execute();
    }

    //Select all rows from a table provided by user email
    public function getByUserEmail($table, $student_email)
    {
        $this->stmt = $this->dbcon->prepare('SELECT * FROM ' . $table . ' WHERE email = :email');
        $this->bindValue(':email', $student_email);
        $this->execute();
    }


    //Determine the PDOType of a passed value.
    private static function getPDOType($value)
    {
        switch ($value) {
            case is_int($value):
                return PDO::PARAM_INT;
            case is_bool($value):
                return PDO::PARAM_BOOL;
            case is_null($value):
                return PDO::PARAM_NULL;
            default:
                return PDO::PARAM_STR;
        }
    }

    //Closing the dbcon.
    public static function close_db()
    {

        if (isset(self::$database)) {
            self::$database->dbcon = null;
            self::$database->stmt = null;
            self::$database = null;
        }
    }
}
