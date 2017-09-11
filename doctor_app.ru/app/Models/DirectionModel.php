<?php
namespace Models;

use Silex\Application;
use Models\DatabaseModel;
use Doctrine\DBAL\Connection;
require_once "DatabaseModel.php";
require_once "InterfaceDirectionModel.php";

class DirectionModel extends DatabaseModel implements InterfaceDirectionModel {

    public function getAllDirections() {
        $stmt = $this->queryBuilder
            ->select('*')
            ->from('med_dir');

        $stmt = $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getId($direction) {
        $stmt = $this->queryBuilder
            ->select('id')
            ->from('med_dir')
            ->where('direction = ?')
            ->setParameter(0, $direction);
        $stmt = $stmt->execute();
        return $stmt->fetchColumn();
    }
//    public function getId($username) {
//        $stmt = $this->queryBuilder
//            ->select('id')
//            ->from('users')
//            ->where('username = ?')
//            ->setParameter(0, $username);
//        $stmt = $stmt->execute();
//        return $stmt->fetchColumn();
//    }
}