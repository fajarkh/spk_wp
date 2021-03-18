<?php
class Alternatif
{

	private $conn;
	private $table_name = "wp_alternatif";

	public $id;
	public $kt;
	public $ktd;

	public $post_id;
	public $vektor_v;
	public $vektor_s;
	public $post_title;
	public $post_desc;
	public $post_image;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	function insert()
	{

		$query = "insert into " . $this->table_name . " values(null,1,0,?,?,0,0)";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->kt);
		$stmt->bindParam(2, $this->ktd);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	function readAll()
	{

		$query = "SELECT * FROM " . $this->table_name . " ORDER BY id_alternatif ASC";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	function readAllAdmin()
	{

		$query = "SELECT r.id_alternatif, p.id_user , a.nama_alternatif, GROUP_CONCAT(m.nama_macam separator ', ') as macam, a.vektor_s, a.vektor_v FROM wp_rangking r
		INNER JOIN wp_alternatif a ON a.id_alternatif = r.id_alternatif
		INNER JOIN wp_macam m ON r.id_kriteria = m.id_kriteria AND r.nilai_rangking = m.nilai
		INNER JOIN wp_pengguna p ON a.id_pengguna = p.id_user WhERE p.id_user = 1
		GROUP BY r.id_alternatif ASC";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	function readByRekomendasi()
	{

		$query = "SELECT r.id_alternatif, p.id_user , a.nama_alternatif, GROUP_CONCAT(m.nama_macam separator ', ') as macam, a.vektor_s, a.vektor_v FROM wp_rangking r
		INNER JOIN wp_alternatif a ON a.id_alternatif = r.id_alternatif
		INNER JOIN wp_macam m ON r.id_kriteria = m.id_kriteria AND r.nilai_rangking = m.nilai
		INNER JOIN wp_pengguna p ON a.id_pengguna = p.id_user WhERE p.id_user = 1 AND a.id_berita = ?
		GROUP BY r.id_alternatif ASC";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->post_id);
		$stmt->execute();

		return $stmt;
	}

	function listRekomendasi()
	{

		$query = "SELECT r.id_alternatif, p.id_user , a.nama_alternatif, GROUP_CONCAT(m.nama_macam separator ', ') as macam, a.vektor_s, a.vektor_v FROM wp_rangking r
		INNER JOIN wp_alternatif a ON a.id_alternatif = r.id_alternatif
		INNER JOIN wp_macam m ON r.id_kriteria = m.id_kriteria AND r.nilai_rangking = m.nilai
		INNER JOIN wp_pengguna p ON a.id_pengguna = p.id_user WhERE p.id_user = 1 AND a.id_berita = 0
		GROUP BY r.id_alternatif ASC";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	function readAllByUser($idUser)
	{

		$query = "SELECT * FROM " . $this->table_name . "  WHERE id_pengguna = " . $idUser . " ORDER BY id_alternatif ASC";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	function countAll()
	{

		$query = "SELECT * FROM " . $this->table_name . " ORDER BY id_alternatif ASC";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt->rowCount();
	}

	function readOne()
	{

		$query = "SELECT * FROM " . $this->table_name . " WHERE id_alternatif=? LIMIT 0,1";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->id = $row['id_alternatif'];
		$this->kt = $row['nama_alternatif'];
	}

	// update the product
	function update()
	{

		$query = "UPDATE 
					" . $this->table_name . " 
				SET 
					nama_alternatif = :kt
				WHERE
					id_alternatif = :id";

		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(':kt', $this->kt);
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	function resetIdBerita()
	{

		$query = "UPDATE 
						" . $this->table_name . " 
					SET 
						id_berita = 0
					WHERE
						id_alternatif = :id";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $this->id);
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	// delete the product
	function delete()
	{

		$query = "DELETE FROM " . $this->table_name . " WHERE id_alternatif = ?";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	function hapusell($ax)
	{

		$query = "DELETE FROM " . $this->table_name . " WHERE id_alternatif in $ax";

		$stmt = $this->conn->prepare($query);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	//old function rekomedasi
	function readRekomendasi($idUser)
	{

		$query = "SELECT * FROM " . $this->table_name . " WHERE id_pengguna = " . $idUser . " ORDER BY vektor_v DESC LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	//old function rekomedasi
	function readRekomendasi2($idUser)
	{

		$query = "SELECT * FROM " . $this->table_name . " WHERE id_pengguna = " . $idUser . " ORDER BY vektor_v DESC LIMIT 1,3";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	function userRekomendasi()
	{
		$query = "SELECT b.post_id, b.post_title, b.post_desc, b.post_image, a.vektor_v, a.id_alternatif FROM  wp_alternatif a INNER Join wp_berita AS b On b.post_id = a.id_berita 
		WHERE a.vektor_s = ? GROUP BY a.vektor_v, a.id_alternatif, b.post_id ORDER BY a.vektor_v DESC LIMIT 0,1";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->vektor_s);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->post_id = $row['post_id'];
		$this->post_title = $row['post_title'];
		$this->post_desc = $row['post_desc'];
		$this->post_image = $row['post_image'];
		$this->vektor_v = $row['vektor_v'];

		$this->id = $row['id_alternatif'];
	}

	function readRincianKriteria($id)
	{
		$query = "SELECT k.nama_kriteria, m.nama_macam AS pilihan_kriteria FROM wp_rangking r
		INNER JOIN wp_kriteria k ON k.id_kriteria = r.id_kriteria
		INNER JOIN wp_alternatif a ON a.id_alternatif = r.id_alternatif
		INNER JOIN wp_macam m ON r.id_kriteria = m.id_kriteria AND r.nilai_rangking = m.nilai
		WhERE a.id_alternatif = ?";

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $id);
		$stmt->execute();

		return $stmt;
	}

	function listRankRekomendasi($vektor_v)
	{
		$query = "SELECT b.post_id, b.post_title FROM  wp_alternatif a INNER Join wp_berita AS b On b.post_id = a.id_berita 
		WHERE a.vektor_v <= ? GROUP BY a.vektor_v, b.post_id ORDER BY a.vektor_v DESC";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $vektor_v);

		$stmt->execute();

		return $stmt;
	}

	function analisaWP($idUser)
	{
		$stmt_alternatif = $this->readAllByUser($idUser);
		include_once '../includes/rangking.inc.php';
		$rangking = new Rangking($this->conn);

		while ($row1 = $stmt_alternatif->fetch(PDO::FETCH_ASSOC)) {

			$row1['nama_alternatif'];
			$a = $row1['id_alternatif'];
			$stmt_rangkingr = $rangking->readR($a);
			while ($rowr = $stmt_rangkingr->fetch(PDO::FETCH_ASSOC)) {
				$b = $rowr['id_kriteria'];
				$tipe = $rowr['tipe_kriteria'];
				$bobot = $rowr['hasil_bobot'];

				if ($tipe == 'benefit') {
					$nor = pow($rowr['nilai_rangking'], $bobot);
				} else {
					$nor = pow($rowr['nilai_rangking'], -$bobot);
				}

				$rangking->ia = $a;
				$rangking->ik = $b;
				$rangking->nn4 = $nor;
				$rangking->normalisasi1();
			}


			$stmthasil = $rangking->readHasil1($a);
			$hasil = $stmthasil->fetch(PDO::FETCH_ASSOC);
			$hasil['bbn'];
			$rangking->has1 = $hasil['bbn'];
			$rangking->hasil1();

			$stmtmax = $rangking->readMax();
			$maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
			$hasil['bbn'] / $maxnr['mnr1']; //hasil vector v
			$rangking->has2 = $hasil['bbn'] / $maxnr['mnr1'];
			$rangking->hasil2();
		}
		return true;
	}
}
