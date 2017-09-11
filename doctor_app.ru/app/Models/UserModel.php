<?php
namespace Models;

use Silex\Application;
use Models\DatabaseModel;
use Doctrine\DBAL\Connection;
require_once "DatabaseModel.php";
require_once "InterfaceUserModel.php";

class UserModel extends DatabaseModel implements InterfaceUserModel {

    public function registerUser($first_name, $last_name, $patronymic, $direction, $education, $science_degree, $email,
                                 $phone, $add_contacts, $place_work, $password) {
        $stmt = $this->queryBuilder
            ->insert('users')
            ->setValue('first_name', '?')
            ->setValue('last_name', '?')
            ->setValue('patronymic', '?')
            ->setValue('direction', '?')
            ->setValue('education', '?')
            ->setValue('science_degree', '?')
            ->setValue('email', '?')
            ->setValue('phone', '?')
            ->setValue('add_contacts', '?')
            ->setValue('place_work', '?')
            ->setValue('password', '?')
            ->setParameter(0, $first_name)
            ->setParameter(1, $last_name)
            ->setParameter(2, $patronymic)
            ->setParameter(3, $direction)
            ->setParameter(4, $education)
            ->setParameter(5, $science_degree)
            ->setParameter(6, $email)
            ->setParameter(7, $phone)
            ->setParameter(8, $add_contacts)
            ->setParameter(9, $place_work)
            ->setParameter(10, $password);
        $stmt = $stmt->execute();

        if ($stmt) {
            return true;
        }
    }

    public function updateUser($first_name, $last_name, $patronymic, $direction, $education, $science_degree, $email,
                                 $phone, $add_contacts, $place_work) {
        $stmt = $this->queryBuilder
            ->update('users')
            ->set('first_name', '?')
            ->set('last_name', '?')
            ->set('patronymic', '?')
            ->set('direction', '?')
            ->set('education', '?')
            ->set('science_degree', '?')
            ->set('phone', '?')
            ->set('add_contacts', '?')
            ->set('place_work', '?')
            ->where('email = ?')
            ->setParameter(0, $first_name)
            ->setParameter(1, $last_name)
            ->setParameter(2, $patronymic)
            ->setParameter(3, $direction)
            ->setParameter(4, $education)
            ->setParameter(5, $science_degree)
            ->setParameter(6, $phone)
            ->setParameter(7, $add_contacts)
            ->setParameter(8, $place_work)
            ->setParameter(9, $email);
        $stmt = $stmt->execute();

        if ($stmt) {
            return true;
        }
    }

    public function getEmail($id) {
        $stmt = $this->queryBuilder
            ->select('email')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $id);
        $stmt = $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getPassword($email) {
        $stmt = $this->queryBuilder
            ->select('password')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $email);
        $stmt = $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function updatePassword($password) {
        $stmt = $this->queryBuilder
            ->update('users')
            ->set('password', '?')
            ->setParameter(0, $password);
        $stmt = $stmt->execute();

        if ($stmt) {
            return true;
        }
    }

    public function getConfirmation($id) {
        $stmt = $this->queryBuilder
            ->select('confirmation')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $id);
        $stmt = $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function updateConfirmation($confirmation, $email) {
        $stmt = $this->queryBuilder
            ->update('users')
            ->set('confirmation', '?')
            ->where('email = ?')
            ->setParameter(0, $confirmation)
            ->setParameter(1, $email);
        $stmt = $stmt->execute();

        if ($stmt) {
            return true;
        }
    }

    public function getDataLogin($email, $password) {
        $stmt = $this->queryBuilder
            ->select('id')
            ->from('users')
            ->where('email = ? and password = ?')
            ->setParameter(0, $email)
            ->setParameter(1, $password);
        $stmt = $stmt->execute();
        return $stmt->fetchColumn();
    }
//
//    public function getUser($username) {
//        $stmt = $this->queryBuilder
//            ->select('username', 'email')
//            ->from('users')
//            ->where('username = ?')
//            ->setParameter(0, $username);
//        $stmt = $stmt->execute();
//        return $stmt->fetch();
//    }
//
//    public function getAllUsers() {
//        $stmt = $this->queryBuilder
//            ->select('*')
//            ->from('users');
//
//        $stmt = $stmt->execute();
//        return $stmt->fetchAll();
//    }

}