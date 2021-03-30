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
            if ($this->getUser()) {
                $this->redirect("auth");
            }

            $allProjects = ModelsFactory::getModel("Projects")->listData();

            return $this->render("admin.twig", ["projects" => $allProjects]);
        }
    }