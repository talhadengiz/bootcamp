<?php

// procedurel
function login(){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)
        && $username==='volkan' && $password==='demo'
    ){
        $_SESSION['isLogged'] = 1;
        $_SESSION['user'] = [
                'name'=>'volkan',
            'lastname'=>'sengul'
        ];
    } else {
        // ....
    }
}

// functional
function user(){
    return [
            'name'=>'volkan',
        'lastname'=>'sengul'
    ];
}

function validate($formElm){
    // email
    // url
    // phone
    // tckimlik
    return !empty($formElm);
}

function createSession(){
    $_SESSION['isLogged'] = true;
    $_SESSION['user'] = user();
}

function doLogin(){
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (validate($username) && validate($password) &&
    $username==='volkan' && $password==='demo'){
        createSession();
    }
}

// object oriented
class Validation {

    public function readPostData($name){
        return $_POST[$name];
    }

    public function validate(...$elements){
        foreach($elements as $elm){
            if (empty( $this->readPostData($elm) )){
                return false;
            }
        }
        return true;
    }
}

class ValidationExtra extends Validation {

    public function emailValidate(){
        // regex check
    }
}

class Employee extends User {

    private $department;


}

class User {

    private $id;
    private $username;
    private $name;
    private $lastname;

    public function setData($data){
        $this->id = $data['id'];
        $this->username = $data['username'];
        $this->name = $data['name'];
        $this->lastname = $data['lastname'];
    }

    public function __get($name)
    {
        if (isset( $this->$name )){
            return $this->$name;
        } else {
            return null;
        }
    }

    public function __set($name, $value)
    {
        if (isset( $this->$name )){
            $this->$name = $value;
        }
    }

}

class Db {
    private $row;

    public function __construct()
    {
        $this->row = new User();
    }

    public function fetch($username, $password){
        if ($username==='volkan' && $password==='demo'){
            $data = [
                    'id'=>4,
                    'username'=>'volkansengul',
                    'name'=>'volkan',
                'lastname'=>'sengul'
            ];
            return $data;
        } else {
            return null;
        }
    }
}

class Auth {

    private $validation;
    private $db;

    public function __construct(){
        $this->validation = new Validation();
        $this->db = new Db();
    }

    private function getFormData(){

    }

    public function login(){
        $isValid = $this->validation->validate('username', 'password');
        if ($isValid){
            $data = $this->db->fetch($_POST['username'], $_POST['password']);

            if ($data!==null){

                $_SESSION['isLogged'] = true;
                $_SESSION['user'] = $data;

                return ['login'=>true, 'data'=>$data];
            } else {
                return [
                        'login'=>false
                ];
            }
        } else {
            return [
                    'login'=>false
            ];
        }

    }

}

$auth = new Auth();
$login = $auth->login();

$user = new User();

if ($login['login']===true){
    $user->setData($login['data']);
}

?>

<form action="/" method="post">
    <input type="text" name="username" value="volkan"
           placeholder="Kullanıcı Adı Girin" /><br />
    <input type="password" name="password" value="demo"
           placeholder="Şifrenizi Girin" /><br />
    <input type="submit" />
</form>




































