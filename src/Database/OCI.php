<?php
namespace Database;


class OCI {
    protected $user = "system";
    protected $password = "data1111224";
    protected $database = "192.168.137.15:1521/GENERAL";

    protected function connect(){
        $conn = oci_connect($this->user,$this->password,$this->database);
        return $conn;
    }
    public function select($column,$table,$ID,$IDvalue){
        $query = oci_parse($this->connect(),"SELECT $column FROM $table WHERE $ID = $IDvalue");
        oci_execute($query);
        oci_close($this->connect());
    }
    public function selectALL($column,$table){
        $query = oci_parse($this->connect(),"SELECT $column FROM $table");
        oci_execute($query);
		oci_close($this->connect());
    }
    public function insert($table,$column,$columnValue){
        $query = oci_parse($this->connect(),"INSERT INTO $table($column)  VALUES ($columnValue)");
        oci_execute($query);
        oci_close($this->connect());
    }
    public function update($table,$column,$columnValue,$ID,$IDvalue){
        $query = oci_parse($this->connect(),"UPDATE $table SET $column = $columnValue Where $ID = $IDvalue");
        oci_execute($query);
        oci_close($this->connect());
    }
    public function updatefile($table,$column,$columnValue,$ID,$IDvalue){
        $query = oci_parse($this->connect(),"UPDATE $table SET $column = utl_raw.cast_to_raw($columnValue) WHERE $ID = $IDvalue");
        oci_execute($query);
        oci_close($this->connect());
    }
	public function fetchRow($column,$table,$ID,$IDvalue){
		$query = oci_parse($this->connect(),"SELECT $column FROM $table WHERE $ID = $IDvalue");
		oci_execute($query);
		$checkcode = oci_fetch_row($query);
		return $checkcode;
		oci_close($this->connect());
	}
	public function fetchRowAssoc(&$row,$column,$table,$ID,$IDvalue){
		$query = oci_parse($this->connect(),"SELECT $column FROM $table WHERE $ID = $IDvalue");
		oci_execute($query);
		$checkcode = oci_fetch_row($query);
		$row = oci_fetch_assoc($query);
		return $checkcode;
		oci_close($this->connect());
	}
		public function fetchRow2($column,$table,$ID1,$ID1value,$ID2,$ID2value){
		$query = oci_parse($this->connect(),"SELECT $column FROM $table WHERE $ID1 = $ID1value AND $ID2 = $ID2value");
		oci_execute($query);
		$checkcode = oci_fetch_row($query);
		return $checkcode;
		oci_close($this->connect());
	}
} 
?>