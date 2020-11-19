<?php
class Login
{
    private $conn;
    private $table_name = "wp_pengguna";

    public $user;
    public $email;
    public $password;
    public $first_name;
    public $last_name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login()
    {
        $user = $this->checkCredentials();
        if ($user) {
            $this->user = $user;
            if (!isset($_SESSION)) {
                session_start();
            }
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
        $encrypted_password = md5(($this->password));
        $stmt->bindParam(1, $this->email);
        $stmt->bindParam(2, $encrypted_password);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $submitted_pass = $encrypted_password;
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

    public function register()
    {
        $query = "INSERT INTO " . $this->table_name . " (id_user,first_name,last_name,username,email,password,level)";
        $query .= " VALUES (null,:first_name,:last_name,:username,:email,:password,0)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':first_name', htmlspecialchars(strip_tags($this->first_name)), PDO::PARAM_STR);
        $stmt->bindValue(':last_name', htmlspecialchars(strip_tags($this->last_name)), PDO::PARAM_STR);
        $stmt->bindValue(':username', $this->randoms_username($this->first_name . ' ' . $this->last_name));
        $stmt->bindValue(':email', htmlspecialchars(strip_tags($this->email)), PDO::PARAM_STR);
        $stmt->bindValue(':password', md5($this->password));

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function randoms_username($string)
    {
        $pattern = " ";
        $firstPart = strstr(strtolower($string), $pattern, true);
        $secondPart = substr(strstr(strtolower($string), $pattern, false), 0, 3);
        $nrRand = rand(0, 100);

        $username = $firstPart . $secondPart . $nrRand;
        return $username;
    }
}
