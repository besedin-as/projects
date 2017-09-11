<?php
namespace Models;

use Silex\Application;

interface InterfaceUserModel {

    /**
     *
     * @param $first_name first_name of new user
     * @param $last_name last_name of new user
     * @param $patronymic patronymic of new user
     * @param $direction direction of new user
     * @param $education education of new user
     * @param $science_degree science_degree of new user
     * @param $email email of new user
     * @param $phone phone of new user
     * @param $add_contacts add_contacts of new user
     * @param $place_work place_work of new user
     * @param $password password of new user
     *
     * @return bool
     */
    public function registerUser($first_name, $last_name, $patronymic, $direction, $education, $science_degree, $email, $phone, $add_contacts, $place_work, $password);


    /**
     *
     * @param $first_name first_name of user
     * @param $last_name last_name of user
     * @param $patronymic patronymic of user
     * @param $direction direction of user
     * @param $education education of user
     * @param $science_degree science_degree of user
     * @param $email email of user
     * @param $phone phone of user
     * @param $add_contacts add_contacts of user
     * @param $place_work place_work of user
     *
     * @return bool
     */
    public function updateUser($first_name, $last_name, $patronymic, $direction, $education, $science_degree, $email, $phone, $add_contacts, $place_work);


    /**
     *
     * @param $password password of user
     *
     * @return bool
     */
    public function updatePassword($password);


    /**
     *
     * @param $confirmation confirmation of user
     * @param $email email of user
     *
     * @return bool
     */
    public function updateConfirmation($confirmation, $email);

    /**
     *
     * @param $id id of user
     *
     * @return $email
     */
    public function getEmail($id);

    /**
     *
     * @param $email email of user
     *
     * @return $password
     */
    public function getPassword($email);


    /**
     *
     * @param $id id of user
     *
     * @return $confirmation
     */
    public function getConfirmation($id);


    /**
     *
     * @param $email
     * @param $password
     *
     * @return id of user details
     */
    public function getDataLogin($email, $password);

}