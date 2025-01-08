<?php

/**
 * Created by PhpStorm.
 * User: mimidots
 * Date: 6/5/2018
 * Time: 6:33 PM
 */
namespace App\Models;

use App\Bootstrap\Database;

class UsersModel extends Model {

    // static function getAll(){
    //     return json_encode([]);
    // }

    // static function add(){}

    // static function delete(){}

    private $id;
    private $name;
    private $email;
    private $password;
    private $cities_id; // FK ke table cities
    private $city;
    private $created_at;
    private $updated_at;

    // Konstruktor
    public function __construct($name, $email, $password, $cities_id, $city, $created_at = null, $updated_at = null, $id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->cities_id = $cities_id;
        $this->city = $city;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Menyimpan data user baru ke database
    public function save() {
        $pdo = Database::getConnection();
        if ($this->id) {
            // Jika id ada, maka lakukan update
            $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, password = :password, cities_id = :cities_id, city = :city, updated_at = NOW() WHERE id = :id");
            $stmt->execute([
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'cities_id' => $this->cities_id,
                'city' => $this->city
            ]);
        } else {
            // Jika id tidak ada, maka lakukan insert
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, cities_id, city, created_at, updated_at) VALUES (:name, :email, :password, :cities_id, :city, NOW(), NOW())");
            $stmt->execute([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'cities_id' => $this->cities_id,
                'city' => $this->city
            ]);
        }
    }

    // Mencari user berdasarkan email
    public static function findByEmail($email) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($user) {
            return new self($user['name'], $user['email'], $user['password'], $user['cities_id'], $user['city'], $user['created_at'], $user['updated_at'], $user['id']);
        }
        return null;
    }

    // Fungsi untuk mendapatkan semua pengguna
    public static function getAllUsers() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM users");
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $userObjects = [];
        foreach ($users as $user) {
            $userObjects[] = new self($user['name'], $user['email'], $user['password'], $user['cities_id'], $user['city'], $user['created_at'], $user['updated_at'], $user['id']);
        }
        return $userObjects;
    }
}