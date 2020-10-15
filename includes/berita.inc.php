<?php
class Berita
{
    private $conn;
    private $table_name = "wp_berita";
    public $post_author;
    public $post_id;
    public $post_title;
    public $post_desc;
    public $image;
    public $post_date;
    public $year;
    public $month;
    public $post_timestamp;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function insert()
    {
        $stmt = $this->conn->prepare("SHOW TABLE STATUS LIKE 'wp_berita'");
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach ($result as $row)
            $new_id = $row[10];

        $up_filename = $this->image["name"];
        $file_basename = substr($up_filename, 0, strripos($up_filename, '.')); // strip extention
        $file_ext = substr($up_filename, strripos($up_filename, '.')); // strip name
        $post_image = $new_id . $file_ext;

        if (($file_ext != '.png') && ($file_ext != '.jpg') && ($file_ext != '.jpeg') && ($file_ext != '.gif'))
            throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");

        move_uploaded_file($this->image["tmp_name"], "../uploads/" . $post_image);

        $this->post_date = date('Y-m-d');
        $this->post_timestamp = strtotime(date('Y-m-d'));
        $this->year = substr($this->post_date, 0, 4);
        $this->month = substr($this->post_date, 5, 2);


        $query = "INSERT INTO " . $this->table_name . " (post_id,post_author,post_title,post_desc,post_image,post_date,year,month, post_timestamp)";
        $query .= " VALUES(null,:post_author,:post_title,:post_desc,:post_image,:post_date,:year,:month,:post_timestamp)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':post_author', $this->post_author);
        $stmt->bindValue(':post_title', htmlspecialchars(strip_tags($this->post_title), PDO::PARAM_STR));
        $stmt->bindValue(':post_desc', $this->post_desc);
        $stmt->bindValue(':post_image', $post_image, PDO::PARAM_STR);
        $stmt->bindValue(':post_date', $this->post_date);
        $stmt->bindValue(':year', $this->year);
        $stmt->bindValue(':month', $this->month);
        $stmt->bindValue(':post_timestamp', $this->post_timestamp);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function readAll()
    {
        $query = "SELECT wp_berita.*, wp_pengguna.nama_lengkap FROM wp_berita INNER JOIN wp_pengguna ON wp_berita.post_author = wp_pengguna.id_pengguna";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function countAll()
    {

        $query = "SELECT * FROM " . $this->table_name . " ORDER BY post_id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->rowCount();
    }

    function readOne()
    {

        $query = "SELECT * FROM " . $this->table_name . " WHERE post_id=? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->post_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['post_id'];
        $this->post_title = $row['post_title'];
        $this->post_desc = $row['post_desc'];
        $this->image = $row['post_image'];
        $this->post_date = $row['post_date'];
    }

    function update()
    {
        $this->post_date = date('Y-m-d');
        $this->post_timestamp = strtotime(date('Y-m-d'));
        $this->year = substr($this->post_date, 0, 4);
        $this->month = substr($this->post_date, 5, 2);

        if (empty($this->image["name"])) {
            $query = "UPDATE wp_berita SET post_title = :post_title, post_desc = :post_desc,";
            $query .= " post_date = :post_date, year = :year, month = :month, post_timestamp = :post_timestamp WHERE post_id = :post_id;";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':post_id', $this->post_id);
            $stmt->bindValue(':post_title', htmlspecialchars(strip_tags($this->post_title), PDO::PARAM_STR));
            $stmt->bindValue(':post_desc', $this->post_desc);
            $stmt->bindValue(':post_date', $this->post_date);
            $stmt->bindValue(':year', $this->year);
            $stmt->bindValue(':month', $this->month);
            $stmt->bindValue(':post_timestamp', $this->post_timestamp);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            $up_filename = $this->image["name"];
            $file_basename = substr($up_filename, 0, strripos($up_filename, '.'));
            $file_ext = substr($up_filename, strripos($up_filename, '.'));
            $post_image = $this->post_id . $file_ext;

            if (($file_ext != '.png') && ($file_ext != '.jpg') && ($file_ext != '.jpeg') && ($file_ext != '.gif'))
                throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");


            $stmt = $this->conn->prepare("SELECT post_image FROM wp_berita WHERE post_id=?");
            $stmt->execute(array($this->post_id));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $real_path = "../uploads/" . $row['post_image'];
                unlink($real_path);
            }
            move_uploaded_file($_FILES["post_image"]["tmp_name"], "../uploads/" . $post_image);

            $query = "UPDATE wp_berita SET post_title = :post_title, post_desc = :post_desc, post_image = :post_image,";
            $query .= " post_date = :post_date, year = :year, month = :month, post_timestamp = :post_timestamp WHERE post_id = :post_id;";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':post_id', $this->post_id);
            $stmt->bindValue(':post_title', htmlspecialchars(strip_tags($this->post_title), PDO::PARAM_STR));
            $stmt->bindValue(':post_desc', $this->post_desc);
            $stmt->bindValue(':post_image', $post_image, PDO::PARAM_STR);
            $stmt->bindValue(':post_date', $this->post_date);
            $stmt->bindValue(':year', $this->year);
            $stmt->bindValue(':month', $this->month);
            $stmt->bindValue(':post_timestamp', $this->post_timestamp);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    // delete the product
    function delete()
    {

        $query = "DELETE FROM " . $this->table_name . " WHERE post_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->post_id);

        if ($result = $stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function hapusell($ax)
    {

        $query = "DELETE FROM " . $this->table_name . " WHERE post_id in $ax";

        $stmt = $this->conn->prepare($query);

        if ($result = $stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
