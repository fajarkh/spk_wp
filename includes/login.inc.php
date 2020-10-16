<?php
class Login
{
    private $conn;
    private $table_name = "wp_pengguna";

    public $user;
    public $email;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login()
    {
        $user = $this->checkCredentials();
        if ($user) {
            $this->user = $user;
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['level'] = $user['level'];
            return true;
        }
        return false;
    }

    protected function checkCredentials()
    {
        $stmt = $this->conn->prepare('SELECT * FROM ' . $this->table_name . ' WHERE email=? and password=? ');
        $stmt->bindParam(1, $this->email);
        $stmt->bindParam(2, $this->password);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $submitted_pass = $this->password;
            if ($submitted_pass == $data['password']) {
                if ($data['level'] == 1) {
                    echo "<script>window.location=('admin/dashboard.php')</script>";
                }
                if ($data['level'] == 0) {
                    echo "<script>window.location=('pengunjung/dashboard.php')</script>";
                }
                return $data;
            } else {
                return false;
            }
        }
        return false;
    }

    public function getUser()
    {
        return $this->user;
    }
}
