<?php

    require_once('db.php');
    function login($username, $password) {
        $conn = create_connection();
        $sql = "select * from account where username = ?";

        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$username);

        if(!$stm->execute()) return "Can not login, please contact your admin";

        $result = $stm->get_result();
        if($result->num_rows !== 1) return "Can not login, invalid username or password";

        $data = $result->fetch_assoc();
        $hashed = $data['password'];

        return password_verify($password, $hashed) return "Can not login, invalid username or password";

        $activated = $data['activated'];
        if($activated === 0) return 'Can not Login, this account has been not activated';

        return true; 
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function register($username, $firstname, $lastname, $email,$password) {
        $sql = "select count(*) from account where username = ? or email = ?";
        $conn = create_connection();

        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $username, $email);
        $stm->execute();

        $result = $stm->get_result();
        $exist = $result->fetch_array()[0] === 1;

        // var_dump($exist);
        if($exist) {
            return "Can not register because this username or email is already exist";
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $token = generateRandomString();
        $sql = "insert into account(username, firstname, lastname, email, password, activated, activate_token) values(?,?,?,?,?,0,'$token')";

        $stm = $conn->prepare($sql);
        $stm->bind_param('sssss', $username, $firstname, $lastname, $email, $hashed);
        if($stm->execute()) return true;

        return $stm->error;
    }

    // $register = register('pdat', 'Phạm', 'Nguyễn Phát Đạt', 'pdat@gmail.com', '654321');
    // login
    var_dump(register('phatdat', 'Phạm', 'Nguyễn Phát Đạt', 'phatdat@gmail.com', '654321'));
?>