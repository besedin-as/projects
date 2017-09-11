<?php
namespace Models;

use Silex\Application;

interface InterfaceDirectionModel {

    /**
     *
     *
     *
     * @return array of direction
     */
    public function getAllDirections();

    /**
     *
     * @param $direction
     *
     *
     * @return $id
     */
    public function getId($direction);
}
