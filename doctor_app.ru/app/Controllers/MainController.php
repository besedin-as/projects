<?php
namespace Controllers;

use Models\InterfaceDirectionModel;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Models\InterfaceUserModel;

class MainController {
    protected $userModel;
    protected $directionModel;

    public function __construct(InterfaceUserModel $userModel, InterfaceDirectionModel $directionModel) {
        $this->userModel = $userModel;
        $this->directionModel = $directionModel;
    }

    public function index(Application $app) {
        if (null === $id = $app['session']->get('id')) {
            return $app->redirect('/user/login');
        }

        $update = false;
        if (!empty($_POST['first_name'])) {
            if (isset($_POST['first_name'])) $first_name = $_POST['first_name'];
            if (isset($_POST['last_name'])) $last_name = $_POST['last_name'];
            if (isset($_POST['patronymic'])) $patronymic = $_POST['patronymic'];
            if (isset($_POST['direction'])) $direction = $this->directionModel->getId($_POST['direction']);
            if (isset($_POST['education'])) $education = $_POST['education'];
            if (isset($_POST['science_degree'])) $science_degree = $_POST['science_degree'];
            if (isset($_POST['phone'])) $phone = $_POST['phone'];
            if (isset($_POST['add_contacts'])) $add_contacts = $_POST['add_contacts'];
            if (isset($_POST['place_work'])) $place_work = $_POST['place_work'];
            $email = $this->userModel->getEmail($id);
            $update = $this->userModel->updateUser($first_name, $last_name, $patronymic, $direction, $education, $science_degree,
                $email, $phone, $add_contacts, $place_work);
        }

        if ($update) {
            return $app->redirect($app["url_generator"]->generate("index.index"));
        }
        return $app['twig']->render('index.twig', array(
            'directions'=>$this->directionModel->getAllDirections()
        ));

    }


}