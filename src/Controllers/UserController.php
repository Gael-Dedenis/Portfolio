<?php

    namespace App\Controllers;

    use App\Models\Factory\ModelsFactory;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;

    /**
     * Class UserController
     * @package App\Controller
     */
    class UserController extends MainController
    {
        /**
         * Redirige sur le formulaire d'auth
         * @return string
         * @throws LoaderError
         * @throws RuntimeError
         * @throws SyntaxError
        */
        public function defaultMethod() {
            $this->redirect("auth");
        }

        /**
         * @return string
         * @throws LoaderError
         * @throws RuntimeError
         * @throws SyntaxError
        */
        public function modifyMethod() {
            if ($this->getUser() === false) {
                $this->redirect("auth");
            }
            $user    = ModelsFactory::getModel("Users")->readData($this->session["user"]["id"]);
            $newData = [];

            if (!empty($this->post)) {
                if (isset($this->post["mail"])) {
                    $newData["mail"] = $this->post["mail"];
                    unset($_SESSION["user"]["mail"]);
                    $_SESSION["user"]["mail"] = $newData["mail"];
                }
                if (isset($this->post["oldpass"]) && isset($this->post["pass"]) === isset($this->post["pass_confirm"])) {
                    if (password_verify($this->post["oldpass"], $user["pass"])) {
                        $newData["pass"] = password_hash ($this->post["pass"], PASSWORD_DEFAULT);
                    }
                }
                ModelsFactory::getModel("Users")->updateData($this->session["user"]["id"], $newData);

                $this->redirect("admin");
            }

        }

    }