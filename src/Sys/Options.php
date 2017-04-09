<?php
namespace App\Sys;
class Options
{
    /**
     * @var null|\PDO
     */
    private static $_pdo = null;
    private static $_cache = null;

//    public static function getInstance(){
//        if()
//
//    }

    /**
     * Constructor
     */
    public function __construct()
    {
        if(empty(self::$_pdo))
            self::$_pdo = DataBase::connect();
    }

    /**
     * Add option/value pair to the options database table.
     * It does nothing if the option already exists.
     * @param $option      string $option option name, must not contain upper case, use underscore to seperate words
     * @param $value
     * @throws \Exception
     * @return void
     */
    public function addOption($option,$value)
    {
        //trim string
        $option = trim($option);
        //check no upper case
        if(strtolower($option)!=$option)
            throw new \Exception("The option name {$option} can not contain upper case, use underscore instead.");
        if($this->_isExist($option))
            throw new \Exception("The option {$option} exist");
        $this->_insert($option,$value);
    }

    /**
     * This function will delete option/value pair specifed by $option key
     *
     * @param $option
     * @throws \Exception
     */
    public function deleteOption($option)
    {
        $option = trim($option);
        if(!$this->_isExist($option))
            throw new \Exception("The option {$option} does not exists");
        if(isset(self::$_cache[$option]))
            unset(self::$_cache[$option]);
        $this->_delete($option);
    }

    /**
     * Update an existing option.
     * It does nothing if the option already exists.
     *
     * @param $option     string $option option name, must not contain upper case, use underscore to seperate words
     * @param $value      string $value value to be updated
     * @throws \Exception
     * @return              void
     */
    public function updateOption($option,$value)
    {
        //trim string
        $option = trim($option);
        if(!$this->_isExist($option))
            throw new \Exception("The option {$option} does not exists");
        self::$_cache[$option] =$value;
        //check option exsit
        $this->_update( self::$_cache[$option],$option);
    }

    /**
     * If option does not exist, or no value is associated with it,
     * FALSE will be returned.
     * @param $option
     * @return bool
     */
    public function readOption($option)
    {
        //trim string
        $option = trim($option);
        if(!isset(self::$_cache[$option])) {
            if (!$this->_isExist($option))
                throw new \Exception("The option {$option} does not exists");
            self::$_cache[$option] = $this->_read($option);
        }
        return self::$_cache[$option];
    }


    private function _delete($option="")
    {
        $result = false;
        $sql = "DELETE FROM options WHERE name= :option";
        try{
            $stmt = self::$_pdo->prepare($sql);
            $stmt->bindValue('option', $option, \PDO::PARAM_STR);
            if($stmt->execute())
                $result = true;
        }catch (\Exception $e){
            $msg ='['.basename(__FILE__).':'.__LINE__." ] Error {$e->getMessage()} in {$sql} at {$e->getFile()}:{$e->getLine()}";
            error_log($msg);
        }
        return $result;
    }

    private function _read($option)
    {
        $result = false;
        $sql = "SELECT `value` FROM options WHERE name = :option LIMIT 1";
        try{
            $stmt = self::$_pdo->prepare($sql);
            $stmt->bindValue('option', $option, \PDO::PARAM_STR);
            if($stmt->execute() and $stmt->rowCount()){
                $res = $stmt->fetch(\PDO::FETCH_OBJ);
                $result =  $res->value;
            }
        }catch (\Exception $e){
            $msg ='['.basename(__FILE__).':'.__LINE__." ] Error {$e->getMessage()} in {$sql} at {$e->getFile()}:{$e->getLine()}";
            error_log($msg);
        }
        return $result;
    }

    private function _insert($option, $value)
    {
        $result = false;
        $sql = "INSERT INTO options(`name`,`value`) VALUES(:name, :value) ";
        try{
            $stmt = self::$_pdo->prepare($sql);
            $stmt->bindValue('name', $option, \PDO::PARAM_STR);
            $stmt->bindValue('value', $value, \PDO::PARAM_STR);
            if($stmt->execute() )
                $result =  true;
        }catch (\Exception $e){
            $msg ='['.basename(__FILE__).':'.__LINE__." ] Error {$e->getMessage()} in {$sql} at {$e->getFile()}:{$e->getLine()}";
            error_log($msg);
        }
        return $result;
    }

    private function _update($value,$option)
    {
        $result =  false;
        $sql = "UPDATE options  SET value = :value WHERE name=:name ";
        try{
            $stmt = self::$_pdo->prepare($sql);
            $stmt->bindValue('name', $option, \PDO::PARAM_STR);
            $stmt->bindValue('value', $value, \PDO::PARAM_STR);
            if($stmt->execute() )
                $result =  true;
        }catch (\Exception $e){
            $msg ='['.basename(__FILE__).':'.__LINE__." ] Error {$e->getMessage()} in {$sql} at {$e->getFile()}:{$e->getLine()}";
            error_log($msg);
        }
        return $result;
    }

    private function _isExist($option)
    {
        $sql = "SELECT count(*) as total FROM options WHERE name =:name";
        $result = false;
        try{
            $stmt = self::$_pdo->prepare($sql);
            $stmt->bindValue('name', $option,\PDO::PARAM_STR);
            if($stmt->execute() && $stmt->rowCount()>0){
                $res = $stmt->fetch(\PDO::FETCH_OBJ);
                $result =  ($res->total>0)?true:false;
            }
        }catch (\Exception $e){
            $msg ='['.basename(__FILE__).':'.__LINE__." ] Error {$e->getMessage()} in {$sql} at {$e->getFile()}:{$e->getLine()}";
            error_log($msg);
        }
        return $result;
    }
}