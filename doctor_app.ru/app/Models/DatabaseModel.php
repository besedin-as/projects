<?php
namespace Models;

use Silex\Application;
use Doctrine\DBAL\Connection;

class DatabaseModel {
    public $queryBuilder;

    protected $db;

    public function __construct(Connection $db) {
        $this->db = $db;
        $this->queryBuilder = $this->db->createQueryBuilder();
    }

}
