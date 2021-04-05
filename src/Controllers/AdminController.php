<?php

    namespace App\Controllers;

    use App\Models\Factory\ModelsFactory;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;

    /**
     * Class AdminController
     * @package App\Controller
     */
    class AdminController extends MainController {

        /**
         * @return string
         * @throws LoaderError
         * @throws RuntimeError
         * @throws SyntaxError
         */
        public function defaultMethod() {
            if ($this->getUser() === false) {
                $this->redirect("auth");
            }
            $allProjects = ModelsFactory::getModel("Projects")->listData();
            $mailUser    = (string) $this->session["user"]["mail"];
            $user        = ModelsFactory::getModel("Users")->readData($mailUser, "mail");

            return $this->render("admin.twig", ["projects" => $allProjects, "user" => $user]);
        }
    }