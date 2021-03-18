<?php
class Macam{
	
	private $conn;
	private $table_name = "wp_macam";
	
	public $id;
	public $idk;
	public $nab;
	public $nib;
	
	public function __construct($db){
		$this->conn = $db;
	}
	
	function insert(){
		
		$query = "insert into ".$this->table_name." values(null,?,?,?)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->idk);
		$stmt->bindParam(2, $this->nab);
		$stmt->bindParam(3, $this->nib);
		
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
		
	}
	
	function readAll(){

		$query = "SELECT * FROM ".$this->table_name." ORDER BY id_macam ASC";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		
		return $stmt;
	}

	function readByKriteria(){

		$query = "SELECT * FROM ".$this->table_name." WHERE id_kriteria=? ORDER BY id_macam ASC";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1,$this->idk);
		$stmt->execute();
		
		return $stmt;
	}

	function countAll(){

		$query = "SELECT * FROM ".$this->table_name." ORDER BY id_macam ASC";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		
		return $stmt->rowCount();
	}
	
	function readOne(){
		
		$query = "SELECT * FROM " . $this->table_name . " WHERE id_macam=? LIMIT 0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$this->id = $row['id_macam'];
		$this->kt = $row['nama_macam'];
		$this->tp = $row['nama_macam'];
	}
	
	// update the product
	function update(){

		$query = "UPDATE 
					" . $this->table_name . " 
				SET 
					nama_macam = :nab,
					nilai = :nib
				WHERE
					id_macam = :id";

		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(':nab', $this->nab);
		$stmt->bindParam(':nib', $this->nib);
		$stmt->bindParam(':id', $this->id);
		
		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// delete the product
	function delete(){
	
		$query = "DELETE FROM " . $this->table_name . " WHERE id_macam = ?";
		
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);

		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	function hapusell($ax){
	
		$query = "DELETE FROM " . $this->table_name . " WHERE id_kriteria in $ax";
		
		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
}
?>