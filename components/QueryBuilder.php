<?php
use app\config\DB;

namespace app\components;

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
        //SELECT column_name(s)FROM table1 LEFT JOIN table2 ON table1.column_name = table2.column_name;
        if(!$this->isStringClean($this->tableName) || !$this->isStringClean($otherTableName) || !$this->isStringClean($firstTableField) || !$this->isStringClean($otherTableField)){
            //echo 1;
            //var_dump($this->tableName);
            return false;
        }
        $this->sql .= "SELECT column_names FROM ". $this->tableName. " LEFT JOIN ". $otherTableName. " ON ". $this->tableName. ".". $firstTableField. "=". $otherTableName. ".". $otherTableField. ";";
        return $this->sql;
    }
    
	public function isStringClean($str)
	{
		$alphabet = "abcdefghijklmnopqrstuvwxyz1234567890_";
		$strLen = strlen($str);
		$strLenX = strlen($alphabet);
		
		if($strLen >= 128) {
			return false;
		}
		$str = utf8_encode(strtolower($str));
		
		for($i = 0; $i < $strLen; $i++) {
			$myError = true;
			
			for($x = 0; $x < $strLenX; $x++) {
				if($str[$i] == $alphabet[$x]) {
					$myError = false;
					break;
				}
			}
			
			if($myError) {
				return false;
			}
		}
		return true;
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
    
    public function compose($limit = 0){
        $fieldStr = "";
        $conditionStr = "";
        $fieldVals = "";
        $fieldParams = "";
        if(!$this->isStringClean($this->tableName)){
            //echo 1;
            //var_dump($this->tableName);
            return false;
        }
        switch($this->queryType){
            case "insert":{
                //INSERT INTO table_name (column1, column2, column3, ... VALUES (value1, value2, value3, ...);
                $this->sql = "INSERT INTO ". $this->tableName. " (";
                //. $fieldStr. ") ". "VALUES (";
                $this->fieldValues = [];
                foreach($this->data as $fieldName => $fieldValue){
                    if(!$this->isStringClean($fieldName) || !$this->isStringClean($fieldValue)){
                        //echo 2;
                        return false;
                    }
                    $fieldStr .= $fieldName. ",";
                    $fieldVals .= "?,";
                    
                    if(is_string($fieldValue)){
                        $fieldParams .= "s";
                    } else if(is_int($fieldValue)){
                        $fieldParams .= "i";
                    } else if(is_float($fieldValue) || is_double($fieldValue)){
                        $fieldParams .= "d";
                    } else {
                        //echo 3;
                        return false;
                    }
                    $this->fieldValues[] = $fieldValue;
                }
                $fieldStr = rtrim($fieldStr,", ");
                $fieldVals = rtrim($fieldVals,", ");
                array_splice($this->fieldValues, 0, 0, [$fieldParams]);
                $this->sql .= $fieldStr. ") VALUES (". $fieldVals. ");";
                break;
            }
            case "update":{
                //UPDATE table_name SET column1 = value1, column2 = value2, ... WHERE condition;
                $this->sql = "UPDATE ". $this->tableName. " SET (";
                $this->fieldValues = [];
                foreach($this->data as $fieldName => $fieldValue){
                    //echo $fieldName;
                    if(!$this->isStringClean($fieldName) || !$this->isStringClean($fieldValue)){
                        //echo 2;
                        return false;
                    }
                    $fieldStr .= $fieldName. " = ?, ";
                    
                    //$fieldVals .= "?,";
                    
                    if(is_string($fieldValue)){
                        $fieldParams .= "s";
                    } else if(is_int($fieldValue)){
                        $fieldParams .= "i";
                    } else if(is_float($fieldValue) || is_double($fieldValue)){
                        $fieldParams .= "d";
                    } else {
                        //echo 3;
                        return false;
                    }
                    $this->fieldValues[] = $fieldValue;
                }
                foreach($this->updateCondition as $conditionName => $conditionValue){
                    if(!$this->isStringClean($conditionName) || !$this->isStringClean($conditionName)){
                        //echo 2;
                        return false;
                    }
                    $conditionStr .= $conditionName. " = ". $conditionValue. ", ";
                }
                $fieldStr = rtrim($fieldStr,", ");
                $conditionStr = rtrim($conditionStr,", ");
                //$fieldVals = rtrim($fieldVals,", ");
                array_splice($this->fieldValues, 0, 0, [$fieldParams]);
                $this->sql .= $fieldStr. ") WHERE (". $conditionStr. ");";
                break;
            }
            case "delete":{  
                //DELETE FROM table_name WHERE condition;
                $this->sql = "DELETE FROM ". $this->tableName. " WHERE (";
                //$this->deleteCondition = [];
                foreach($this->deleteCondition as $conditionName => $conditionValue){
                    if(!$this->isStringClean($conditionName) || !$this->isStringClean($conditionName)){
                        //echo 2;
                        return false;
                    }
                    $conditionStr .= $conditionName. " = ". $conditionValue. ", ";
                }
                //$fieldStr = rtrim($fieldStr,", ");
                $conditionStr = rtrim($conditionStr,", ");
                //$fieldVals = rtrim($fieldVals,", ");
                array_splice($this->fieldValues, 0, 0, [$fieldParams]);
                $this->sql .= $conditionStr. ");";
                break;
            }
            case "select":{ 
                //SELECT * FROM table_name;
                //var_dump($this->leftJoin("reciever", "id", "number"));
                $this->sql .= "SELECT * FROM ". $this->tableName;
                if(count($this->wheres) > 0){
                    $whereSql = " WHERE (";
                    foreach($this->wheres as $whereBlock){
                        if($whereSql != " WHERE ("){
                            $whereSql .= " OR (";
                        }
                        foreach($whereBlock as $whereItem){
                            if(!$this->isStringClean($whereItem[1]) || !$this->isStringClean($whereItem[2])){
                                //echo 2;
                                return false;
                            }
                            $whereSql .= $whereItem[1]. " ".$whereItem[0]. " ".$whereItem[2]. " AND "; 
                        }
                        $whereSql = rtrim($whereSql," AND ");
                        $whereSql .= ")";
                    }
                    $this->sql .= $whereSql;
                } 
                break;
            }
            
        }
        if($limit > 0) {
            $this->sql = " LIMIT ". $limit;
        }
        $this->sql .=  ";";
        return $this->sql;
    }
    
    public function execute(){
        $id = 0;
        $this->compose();
        $mysqli = new mysqli(DB::host, DB::user, DB::pw, DB::name);
        $stmt = $mysqli->prepare($this->sql);
        call_user_func_array([$stmt, 'bind_result'], $this->refValues($this->fieldValues));
        $id = $stmt->execute();
        if($this->queryType == "insert"){
            $id = $stmt->insert_id;
        }
        $stmt->close();
		$mysqli->close();
		return $id;
    }
    
    public function query(){
        $dataFromDB = [];
        $this->compose(1);
        $mysqli = new mysqli(DB::host, DB::user, DB::pw, DB::name);
        $stmt = $mysqli->prepare($this->sql);
        $stmt->execute();
        $dataFromDB = $stmt->fetch();
        $stmt->close();
		$mysqli->close();
		return $dataFromDB;
    }
    
    public function queryAll(){
        $dataFromDB = [];
        $this->compose();
        $mysqli = new mysqli(DB::host, DB::user, DB::pw, DB::name);
        $stmt = $mysqli->prepare($this->sql);
        $stmt->execute();
        while($row = $stmt->fetch()){
            $dataFromDB[] = $row;
        }
        $stmt->close();
		$mysqli->close();
		return $dataFromDB;
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
        $instance->updateCondition = $condition; 
        $instance->queryType = "update";
        return $instance;
    }
    
    public function delete($tableName, $condition){
        $instance = new QueryBuilder($tableName); 
        $instance->deleteCondition = $condition; 
        $instance->queryType = "delete";
        return $instance;
    }
}

?>