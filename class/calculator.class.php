<?php

class Calculator{
	//Database parameters
	private $conn;
	private $table = 'data';

	//Task from field on table,like a '1x3,2x6,9x10,...etc'
	//We get this with AJAX after click
	public $task;

	//Database columns
	private $factor1;
	private $factor2;
	private $operation;
	private $result;
	private $operation_date;

	//Class constructor
	public function __construct($db){
		$this->conn = $db;
	}
	//Function for calculate two factors and return result to field in table
	public function calculate($task){
		$this->task = $task;
		$factors = explode("x", $this->task);
		if(sizeof($factors) == 2) echo (int)$factors[0]*(int)$factors[1];
		self::saveToDatabase($factors[0],$factors[1]);
	}
	//When user click at field in table,save to database,make a 'log'
	private function saveToDatabase($f1,$f2){
		$this->factor1 = (int)$f1;
		$this->factor2 = (int)$f2;
		$this->operation = "*";
		$this->result = $this->factor1*$this->factor2;
		$this->operation_date = date("Y-m-d H:i:s");
		$sql = "INSERT INTO {$this->table} VALUES(null,{$this->factor1},{$this->factor2},'{$this->operation}',{$this->result},'{$this->operation_date}')";
		mysqli_query($this->conn,$sql);

	}
	//Function for drawing table 
	public function drawMeTable(){
		echo "<table class='table table-striped table-responsive'>";
		for($row=0;$row<=10;$row++){
			echo "<tr>";
			if($row != 0) echo "<th class='info'>{$row}</th>";
			else echo "<th class='info'>&nbsp;</th>";
			for($column=0;$column<=10;$column++){
				if($column != 0 && $row == 0) echo "<th class='info'>{$column}</th>";
				elseif ($column != 0) echo "<td>{$row} x {$column}</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}
	//Function for showing logs
	public function showMeLogs(){
		$sql = "SELECT id,factor1,factor2,result,operation_date FROM {$this->table} ORDER BY id DESC";
		$result = mysqli_query($this->conn,$sql);
    	//Table header
    	echo "<thead><tr>";
    	echo "<th>ID</th>";
    	echo "<th>Factor 1</th>";
    	echo "<th>Factor 2</th>";
    	echo "<th>Result</th>";
    	echo "<th>Date</th>";
    	echo "</tr></thead>";

    	//Table body
    	echo "<tbody>";
    	while($row = mysqli_fetch_assoc($result)) {
    		echo "<tr><td>{$row['id']}</td>";
    		echo "<td>{$row['factor1']}</td>";
    		echo "<td>{$row['factor2']}</td>";
    		echo "<td>{$row['result']}</td>";
    		echo "<td>{$row['operation_date']}</td></tr>";
    	}
    	echo "</tbody>";
	}
}


?>