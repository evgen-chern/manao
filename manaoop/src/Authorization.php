<?php

namespace App;

class Authorization
{
    private Database $database;

    private Session $session;
    public function __construct(Database $database, Session $session)
    {
        $this->database = $database;
        $this->session = $session;
    }

    public function register(array $data): bool
    {
        if(empty($data['username'])) {
            throw new AuthorizationException('empty username');
        } else if(strlen($data['username'])<3 || is_numeric($data['username'])){
            throw new AuthorizationException('username must have more than 2 symbols and NOT NUMBERS');
        }

        if(empty($data['login'])) {
            throw new AuthorizationException('empty login');
        } else if(strlen($data['login'])<6){
            throw new AuthorizationException('login must have 6 and more symbols');
        }

        if(empty($data['email'])) {
            throw new AuthorizationException('empty email');
        }

        if(empty($data['password'])) {
            throw new AuthorizationException('empty password');
        } else if(strlen($data['password'])<6){
            throw new AuthorizationException('password must be from 6 symbols ');
        } else if( (!preg_match('/[A-zА-я]+/', ($data['password']))) || ((!preg_match('/[0-9]+/', ($data['password'])))) ){
            throw new AuthorizationException('password must be contain symbols and numbers ');
        }

        if($data['password'] !== $data['password_confirm']) {
            throw new AuthorizationException('password_confirm != password');
        }

        $statement = $this->database->getConnection()->prepare(
            'SELECT * FROM user WHERE email = :email OR login = :login'
        );
        $statement ->execute([
           'email' => $data['email'],
            'login' => $data['login'],
        ]);

        $user = $statement->fetchAll();
        if(!empty($user)) {
            throw new AuthorizationException( 'This login or email exist');
        }

        $statement = $this->database->getConnection()->prepare(
            'INSERT INTO user (username, login, email, password) VALUES (:username, :login, :email, :password)'
        );

        $statement->execute([
            'username' => $data['username'],
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
        ]);

        return true;
    }

    public function login(string $login, $password): bool
    {
        if(empty($login)) {
            throw new AuthorizationException('empty login');
        }
        if(empty($password)) {
            throw new AuthorizationException('empty password');
        }

        $statement = $this->database->getConnection()->prepare(
            'SELECT * FROM user WHERE login = :login'
        );
        $statement->execute([
           'login'=>$login,
        ]);
        $user = $statement->fetch();

        if (empty($user)) {
            throw new AuthorizationException('Login not exist');
        }

        if(password_verify($password, $user['password'])) {
            $this->session->setData('user', [
                'username'=>$user['username'],
                'login'=>$user['login'],
                'email'=>$user['email'],
            ]);
            return true;
        }
        throw new AuthorizationException('Password incorrect');
    }
}