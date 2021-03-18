<?php
class Kriteria
{

	private $conn;
	private $table_name = "wp_kriteria";

	public $id;
	public $kt;
	public $kp;
	public $tp;
	public $nab;
	public $nib;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	function insert()
	{
		$query = "insert into " . $this->table_name . " values(null,?,?,?)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->kt);
		$stmt->bindParam(2, $this->tp);
		$stmt->bindParam(3, $this->kp);

		if ($stmt->execute()) {
			$last_id = $this->conn->lastInsertId();
			foreach ($this->nab as $key => $n) {
				$query1 = "insert into wp_macam values(null,?,?,?)";
				//print"last id : ".$last_id;
				$stmt1 = $this->conn->prepare($query1);
				$stmt1->bindParam(1, $last_id);
				$stmt1->bindParam(2, $n);
				$stmt1->bindParam(3, $this->nib[$key]);
				$stmt1->execute();
			}
			return true;
		} else {
			return false;
		}
	}

	function readAll()
	{

		$query = "SELECT e.*, GROUP_CONCAT(d.nama_macam separator ', ') as macam, GROUP_CONCAT(d.nilai separator ', ') as nilai
		FROM wp_kriteria e JOIN wp_macam d ON e.id_kriteria = d.id_kriteria GROUP BY e.id_kriteria ORDER BY id_kriteria ASC";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	function countAll()
	{

		$query = "SELECT * FROM " . $this->table_name . " ORDER BY id_kriteria ASC";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt->rowCount();
	}

	function readOne()
	{

		$query = "SELECT * FROM " . $this->table_name . " WHERE id_kriteria=? LIMIT 0,1";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->id = $row['id_kriteria'];
		$this->kt = $row['nama_kriteria'];
		$this->kp = $row['pertanyaan'];
		$this->tp = $row['tipe_kriteria'];
	}


	// update the product
	function update()
	{

		$query = "UPDATE 
					" . $this->table_name . " 
				SET 
					nama_kriteria = :kt,
					tipe_kriteria = :tp,
					pertanyaan = :kp
				WHERE
					id_kriteria = :id";

		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(':kt', $this->kt);
		$stmt->bindParam(':tp', $this->tp);
		$stmt->bindParam(':kp', $this->kp);
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	// delete the product
	function delete()
	{

		$query = "DELETE FROM " . $this->table_name . " WHERE id_kriteria = ?";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);

		if ($result = $stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	function hapusell($ax)
	{

		$query = "DELETE FROM " . $this->table_name . " WHERE id_kriteria in $ax";

		$stmt = $this->conn->prepare($query);

		if ($result = $stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
}
