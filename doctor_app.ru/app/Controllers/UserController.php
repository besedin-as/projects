<?php
namespace Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Models\InterfaceUserModel;
use Models\InterfaceDirectionModel;


class UserController {
    protected $userModel;
    protected $directionModel;

    public function __construct(InterfaceUserModel $userModel, InterfaceDirectionModel $directionModel) {
        $this->userModel = $userModel;
        $this->directionModel = $directionModel;
    }

    public function login(Application $app, Request $request) {
        $loginForm = self::doLogin($app, $request, $this->userModel);
        if (gettype($loginForm) == 'string') {
            return $app->redirect($app["url_generator"]->generate("index.index"));
        }
        elseif (gettype($loginForm) == 'array') {
            $error = self::doLogin($app, $request, $this->userModel)[2];
            $loginForm = self::doLogin($app, $request, $this->userModel)[1];
            return $app['twig']->render('login.twig', array(
                'error' => $error,
                'loginForm' => $loginForm->createView())
            );
        }
        else {
            return $app['twig']->render('login.twig', array(
                'error' => '',
                'loginForm' => $loginForm->createView())
            );
        }
    }

    public function logout(Application $app) {
        $app['session']->clear();
        return $app->redirect($app["url_generator"]->generate("index.index"));
    }

    public function reminder(Application $app, Request $request) {
        $reminderForm = $app['user_forms']->getRemindForm();
        $reminderForm->handleRequest($request);
        $data = $reminderForm->getData();
        if (empty($data['email'])) {
            return $app['twig']->render('reminder.twig', array(
                'reminderForm' => $reminderForm->createView())
            );
        }
        else {
            $password = $this->generate_password(10);
            $this->userModel->updatePassword($password);
            mail($data['email'], "Doctor's app", "Ваш пароль: ".$password);
            return $app->redirect($app["url_generator"]->generate("user.login"));
        }
    }

    public function register(Application $app) {
        $register = false;
        if (!empty($_POST['first_name'])) {
            if (isset($_POST['first_name'])) $first_name = $_POST['first_name'];
            if (isset($_POST['last_name'])) $last_name = $_POST['last_name'];
            if (isset($_POST['patronymic'])) $patronymic = $_POST['patronymic'];
            if (isset($_POST['direction'])) $direction = $this->directionModel->getId($_POST['direction']);
            if (isset($_POST['education'])) $education = $_POST['education'];
            if (isset($_POST['science_degree'])) $science_degree = $_POST['science_degree'];
            if (isset($_POST['email'])) $email = $_POST['email'];
            if (isset($_POST['phone'])) $phone = $_POST['phone'];
            if (isset($_POST['add_contacts'])) $add_contacts = $_POST['add_contacts'];
            if (isset($_POST['place_work'])) $place_work = $_POST['place_work'];
            $password = $this->generate_password(10);
            $register = $this->userModel->registerUser($first_name, $last_name, $patronymic, $direction, $education, $science_degree,
                $email, $phone, $add_contacts, $place_work, $password);
        }

        if ($register) {
            $app['session']->set('email', $email);
            mail($email, "Doctor's app", "Ваш пароль: ".$password."\n"."Подтверждение аккаунта: http://doctor_app.ru/user/confirmation");
            return $app['twig']->render('confirm_email.twig');
        }
        return $app['twig']->render('register.twig', array(
            'directions'=>$this->directionModel->getAllDirections()
        ));
    }

    static function doLogin(Application $app, Request $request, InterfaceUserModel $userModel) {
        $form = $app['user_forms']->getLoginForm();
        $form->handleRequest($request);
        $data = $form->getData();
        $user = $userModel->getDataLogin($data['email'], $data['password']);

        if (!$user && !empty($data['email'])) {
            return array(1=>$app['user_forms']->getLoginForm(), 2=>"Неправильно введены email или пароль!");
        }
        elseif (!$user) {
            return $app['user_forms']->getLoginForm();
        }
        else {
            $app['session']->set('id', $user['id']);
            return $user;
        }

    }

    public function confirmation(Application $app) {
        $email = $app['session']->get('email');
        $this->userModel->updateConfirmation('true', $email);
        $app['session']->clear();
        return $app['twig']->render('confirmation.twig');
    }

    function generate_password($number) {
        $arr = array('a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z',
            '1','2','3','4','5','6',
            '7','8','9','0','.',',',
            '(',')','[',']','!','?',
            '&','^','%','@','*','$',
            '<','>','/','|','+','-',
            '{','}','`','~');

        $pass = "";
        for($i = 0; $i < $number; $i++) {
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        return $pass;
    }

}