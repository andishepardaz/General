<?php
namespace foundationphp;
class OCI {
    protected $user = "system";
    protected $password = "data1111224";
    protected $database = "192.168.137.15:1521/GENERAL";

    protected function connect(){
        $conn = oci_connect($this->user,$this->password,$this->database);
        return $conn;
    }
    public function select($column,$table,$ID,$IDvalue){
        $query = oci_parse($this->connect(),"SELECT $column FROM $table WHERE $ID = '$IDvalue'");
        oci_execute($query);
        oci_close($this->connect());
    }
    public function selectALL($column,$table){
        $query = oci_parse($this->connect(),"SELECT $column FROM $table");
        oci_execute($query);
		oci_close($this->connect());
    }
	public function selectInnerJoin($column1,$column2,$table1,$table2,$ID1,$ID2,$ID,$IDvalue){
		$query = oci_parse($this->connect(),"SELECT $column1,$column2 FROM $table1 INNER JOIN $table2 ON $table1.$ID1 = $table2.$ID2 WHERE $ID = '$IDvalue'");
		oci_execute($query);
		oci_close($this->connect());
	}
    public function insert($table,$column,$columnValue){
        $query = oci_parse($this->connect(),"INSERT INTO $table($column)  VALUES ('$columnValue')");
        oci_execute($query);
        oci_close($this->connect());
    }
    public function update($table,$column,$columnValue,$ID,$IDvalue){
        $query = oci_parse($this->connect(),"UPDATE $table SET $column = '$columnValue' Where $ID = '$IDvalue'");
        oci_execute($query);
        oci_close($this->connect());
    }
	public function updateDate($table,$column,$ID,$IDvalue){
		$query = oci_parse($this->connect(),"UPDATE $table SET $column = CURRENT_TIMESTAMP(0) WHERE $ID = '$IDvalue'");
		oci_execute($query);
		oci_close($this->connect());
	}
    public function updatefile($table,$column,$columnValue,$ID,$IDvalue){
        $query = oci_parse($this->connect(),"UPDATE $table SET $column = utl_raw.cast_to_raw('$columnValue') WHERE $ID = '$IDvalue'");
        oci_execute($query);
        oci_close($this->connect());
    }
	public function deleteALL($table){
		$query = oci_parse($this->connect(),"DELETE FROM $table");
		oci_execute($query);
		oci_close($this->connect());
	}
	public function delete($table,$ID,$IDvalue){
		$query = oci_parse($this->connect(),"DELETE FROM $table WHERE $ID = '$IDvalue'");
		oci_execute($query);
		oci_close($this->connect());
	}
	public function deleteDate($table,$column,$columnValue){
		$query = oci_parse($this->connect(),"DELETE FROM $table WHERE $column <= '$columnValue'");
		oci_execute($query);
		oci_close($this->connect());
	}
	public function query($parse){
		$query = oci_parse($this->connect(),$parse);
		oci_execute($query);
		oci_close($this->connect());
	}
	public function fetchRow($column,$table,$ID,$IDvalue){
		$query = oci_parse($this->connect(),"SELECT $column FROM $table WHERE $ID = '$IDvalue'");
		oci_execute($query);
		$checkcode = oci_fetch_row($query);
		return $checkcode;
		oci_close($this->connect());
	}
	public function fetchRowNull($column,$table,$ID){
		$query = oci_parse($this->connect(),"SELECT $column FROM $table WHERE $ID IS NULL");
		oci_execute($query);
		$checkcode = oci_fetch_row($query);
		return $checkcode;
		oci_close($this->connect());
	}
	public function fetchArray($column1,$column2,$table1,$table2,$ID1,$ID2,$ID,$IDvalue){
		$query = oci_parse($this->connect(),"SELECT $column1,$column2 FROM $table1 INNER JOIN $table2 ON $table1.$ID1 = $table2.$ID2 WHERE $ID = '$IDvalue'");
		oci_execute($query);
		$row = oci_fetch_array($query);
		return $row;
		oci_close($this->connect());
	}
	public function fetchDel($column,$table,$ID,$IDvalue){
		$query = oci_parse($this->connect(),"SELECT $column FROM $table WHERE $ID <= '$IDvalue'");
		oci_execute($query);
		$row = oci_fetch_array($query);
		$rec = $row[$column];
		return $rec;
		oci_close($this->connect());
	}
	public function fetchRowAssoc(&$row,$column,$table,$ID,$IDvalue){
		$query = oci_parse($this->connect(),"SELECT $column FROM $table WHERE $ID = '$IDvalue'");
		oci_execute($query);
		$checkcode = oci_fetch_row($query);
		$row = oci_fetch_assoc($query);
		return $checkcode;
		oci_close($this->connect());
	}
		public function fetchRow2($column,$table,$ID1,$ID1value,$ID2,$ID2value){
		$query = oci_parse($this->connect(),"SELECT $column FROM $table WHERE $ID1 = '$ID1value' AND $ID2 = '$ID2value'");
		oci_execute($query);
		$checkcode = oci_fetch_row($query);
		return $checkcode;
		oci_close($this->connect());
	}
} 
?>