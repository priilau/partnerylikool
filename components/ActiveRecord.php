<?php
namespace app\components;

use app\components\QueryBuilder;
use app\models\BaseModel;
	
class ActiveRecord extends BaseModel {
    public $className;
    public $queryObj = null;

    public static function find(){ 
        $obj = new ActiveRecord();
        $obj->queryObj = QueryBuilder::select(static::tableName());
        $obj->className = get_called_class();
		return $obj;
	}

	public function addWhere($operator, $fieldName, $fieldValue){
        $this->queryObj = $this->queryObj->addWhere($operator, $fieldName, $fieldValue);
        return $this;
	}
	
	public function orWhere($operator, $fieldName, $fieldValue){
        $this->queryObj = $this->queryObj->orWhere($operator, $fieldName, $fieldValue);
        return $this;
	}
	
    public function one(){
        $data = $this->queryObj->query();
        $obj = (new $this->className)->load($data);
        return $obj;
    }
    
    public function all(){
        $objArray = [];
        $data = $this->queryObj->queryAll();
        foreach($data as $row){
            $model = new $this->className;
            $model->load($row);
            $objArray[] = $model;
        }
        return $objArray;
    }

}
?>