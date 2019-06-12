<?php
namespace app\components;

use app\config\DB;

class QueryBuilder {
    public $tableName;
    public $data = [];
    public $wheres = [];
    public $queryType;
    private $whereIndex = 0;
    private $sql = "";
    private $updateCondition = [];
    private $deleteCondition = [];
    private $fieldValues = [];
    private $fieldParams = "";

    function __construct($tableName){
        $this->tableName = $tableName;
    }

    public function select($tableName){
        $instance = new QueryBuilder($tableName); 
        $instance->tableName = $tableName;
        $instance->queryType = "select";
        return $instance; 
    }
    
    public function addWhere($operator, $fieldName, $fieldValue){
        if(!isset($this->wheres[$this->whereIndex]) || !is_array($this->wheres[$this->whereIndex])){
            $this->wheres[$this->whereIndex] = [];
        }
        $this->wheres[$this->whereIndex][] = [$operator, $fieldName, $fieldValue];
        return $this;
    }
    
    public function orWhere($operator, $fieldName, $fieldValue){
        $this->whereIndex++;
        if(!isset($this->wheres[$this->whereIndex]) || !is_array($this->wheres[$this->whereIndex])){
            $this->wheres[$this->whereIndex] = [];
        }
        $this->wheres[$this->whereIndex][] = [$operator, $fieldName, $fieldValue];
        return $this;
    }
    
    public function leftJoin($otherTableName, $firstTableField, $otherTableField){
        if(!Helper::isStringClean($this->tableName) || !Helper::isStringClean($otherTableName) || !Helper::isStringClean($firstTableField) || !Helper::isStringClean($otherTableField)){
            return false;
        }
        $this->sql .= "SELECT column_names FROM {$this->tableName} LEFT JOIN {$otherTableName} ON {$this->tableName}.{$firstTableField}={$otherTableName}.{$otherTableField};";
        return $this->sql;
    }

    public function refValues($arr){
        if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
        {
            $refs = array();
            foreach($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }

    public function composeParams($fieldValues){
        foreach($fieldValues as $fieldValue){
            if(is_string($fieldValue)){
                $this->fieldParams .= "s";
            } else if(is_int($fieldValue)){
                $this->fieldParams .= "i";
            } else if(is_float($fieldValue) || is_double($fieldValue)){
                $this->fieldParams .= "d";
            } else {
                $this->fieldParams .= "s"; // insertis oli nii, k6igis teistes oli "return false;"
            }
        }
    }
    
    public function compose($limit = 0){ // TODO refactoring
        $fieldStr = "";
        $conditionStr = "";
        $fieldVals = "";
        $this->fieldParams = "";
        if(!Helper::isStringClean($this->tableName)){
            return false;
        }
        switch($this->queryType){
            case "insert":{
                $this->sql = "INSERT INTO {$this->tableName} ";
                $this->fieldValues = [];
                foreach($this->data as $fieldName => $fieldValue){
                    if(!Helper::isStringClean($fieldName, 255) || !Helper::isStringClean($fieldValue, 255)){
                        echo "[{$fieldName}] or [{$fieldValue}] is not clean!";
                        return false;
                    }
                    $fieldStr .= $fieldName. ", ";
                    $fieldVals .= "?, ";
                    $this->fieldValues[] = $fieldValue;
                }
                $fieldStr = rtrim($fieldStr,", ");
                $fieldVals = rtrim($fieldVals,", ");
                $this->composeParams($this->fieldValues);
                array_splice($this->fieldValues, 0, 0, [$this->fieldParams]);
                $this->sql .= "({$fieldStr}) VALUES ({$fieldVals})";
                break;
            }
            case "update":{
                $this->fieldValues = [];
                $this->sql = "UPDATE {$this->tableName} SET ";
                foreach($this->data as $fieldName => $fieldValue){
                    if(!Helper::isStringClean($fieldName) || !Helper::isStringClean($fieldValue)){
                        echo "[{$fieldName}] or [{$fieldValue}] is not clean!";
                        return false;
                    }
                    $fieldStr .= "`{$fieldName}` = ?, ";
                    $this->fieldValues[] = $fieldValue;
                }
                $fieldStr = rtrim($fieldStr,", ");
                
                $whereSql = " WHERE (";
                foreach($this->updateCondition as $whereBlock){
                    if($whereSql != " WHERE ("){
                        $whereSql .= " OR (";
                    }
                    foreach($whereBlock as $whereItem){
                        if(!Helper::isStringClean($whereItem[1]) || !Helper::isStringClean($whereItem[2])){
                            echo "[{$whereItem[1]}] or [{$whereItem[2]}] is not clean!";
                            return false;
                        }
                        $whereSql .= "{$whereItem[1]} {$whereItem[0]} ? AND ";
                        $this->fieldValues[] = $whereItem[2];
                    }
                    $whereSql = rtrim($whereSql," AND ");
                    $whereSql .= ")";
                }
                $this->composeParams($this->fieldValues);
                array_splice($this->fieldValues, 0, 0, [$this->fieldParams]);
                $this->sql .= $fieldStr. $whereSql;
                break;
            }
            case "delete":{  
                $this->sql = "DELETE FROM {$this->tableName}";
                $whereSql = " WHERE (";
                foreach($this->deleteCondition as $whereBlock){
                    if($whereSql != " WHERE ("){
                        $whereSql .= " OR (";
                    }
                    foreach($whereBlock as $whereItem){
                        if(!Helper::isStringClean($whereItem[1]) || !Helper::isStringClean($whereItem[2])){
                            echo "[{$whereItem[1]}] or [{$whereItem[2]}] is not clean!";
                            return false;
                        }
                        $whereSql .= "{$whereItem[1]} {$whereItem[0]} ? AND ";
                        $this->fieldValues[] = $whereItem[2]; 
                    }
                    $whereSql = rtrim($whereSql," AND ");
                    $whereSql .= ")";
                }
                $this->composeParams($this->fieldValues);
                array_splice($this->fieldValues, 0, 0, [$this->fieldParams]);
                $this->sql .= $whereSql;
                break;
            }
            case "select":{
                $this->sql .= "SELECT * FROM {$this->tableName}";
                if(count($this->wheres) > 0){
                    $whereSql = " WHERE (";
                    foreach($this->wheres as $whereBlock){
                        if($whereSql != " WHERE ("){
                            $whereSql .= " OR (";
                        }
                        foreach($whereBlock as $whereItem){
                            if(!Helper::isStringClean($whereItem[1]) || !Helper::isStringClean($whereItem[2])){
                                echo "[{$whereItem[1]}] or [{$whereItem[2]}] is not clean!";
                                return false;
                            }
                            $whereSql .= "{$whereItem[1]} {$whereItem[0]} ? AND ";
                            $this->fieldValues[] = $whereItem[2];
                        }
                        $whereSql = rtrim($whereSql," AND ");
                        $whereSql .= ")";
                    }
                    $this->composeParams($this->fieldValues);
                    array_splice($this->fieldValues, 0, 0, [$this->fieldParams]);
                    $this->sql .= $whereSql;
                }
                break;
            }
        }
        if($limit > 0) {
            $this->sql .= " LIMIT ". $limit;
        }
        $this->sql .=  ";";
        return $this->sql;
    }
    
    public function execute(){
        $this->compose();
        $mysqli = new \mysqli(DB::$host, DB::$user, DB::$pw, DB::$name);
        $stmt = $mysqli->prepare($this->sql);
        if(!$stmt){
            echo $mysqli->error;
            exit("Unable to create stmt!");    
        }
        call_user_func_array([$stmt, 'bind_param'], $this->refValues($this->fieldValues));
        $id = $stmt->execute();
        if(!$id){
            exit($stmt->error);    
        } else if($this->queryType == "insert"){
            $id = $stmt->insert_id;
        }
        $stmt->close();
		$mysqli->close();
		return $id;
    }
    
    public function query(){
        $this->compose(1);
        $mysqli = new \mysqli(DB::$host, DB::$user, DB::$pw, DB::$name);
        $stmt = $mysqli->prepare($this->sql);
        if(!$stmt){
            echo $mysqli->error;
            exit("Unable to create stmt!");
        }
        call_user_func_array([$stmt, 'bind_param'], $this->refValues($this->fieldValues));
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $dataFromDb = $row;
        $stmt->free_result();
        $stmt->close();
		$mysqli->close();
		return $dataFromDb;
    }
    
    public function queryAll(){
        $dataFromDb = [];
        $this->compose();
        $mysqli = new \mysqli(DB::$host, DB::$user, DB::$pw, DB::$name);
        $stmt = $mysqli->prepare($this->sql);
        call_user_func_array([$stmt, 'bind_param'], $this->refValues($this->fieldValues));
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
            $dataFromDb[] = $row;
        }
        $stmt->free_result();
        $stmt->close();
        $mysqli->close();
		return $dataFromDb;
    }
    
    public static function insert($tableName, $data){
        $instance = new QueryBuilder($tableName); 
        $instance->data = $data;
        $instance->queryType = "insert";
        return $instance;
    }
    
    public function update($tableName, $data, $condition){
        $instance = new QueryBuilder($tableName); 
        $instance->data = $data;
        $instance->updateCondition[][] = $condition; 
        $instance->queryType = "update";
        return $instance;
    }
    
    public function delete($tableName, $condition){
        $instance = new QueryBuilder($tableName); 
        $instance->deleteCondition[][] = $condition; 
        $instance->queryType = "delete";
        return $instance;
    }
}

?>