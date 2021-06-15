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

            $this->user    = ModelsFactory::getModel("Users")->readData($this->session["user"]["id"]);
            $this->newData = [];

            if (!empty($this->post)) {

                $this->newData["mail"] = $this->changeMail();
                $this->newData["pass"] = $this->changePassword();

                $this->setNewData();

                $this->redirect("admin");
            }

        }

        /**
         * Action: retourne le mail si il est passer en donnée.
         * @return string
         */
        private function changeMail() {
            if (isset($this->post["mail"]) && !empty($this->post["mail"])) {
                unset($_SESSION["user"]["mail"]);
                $_SESSION["user"]["mail"] = $this->post["mail"];

                return $this->post["mail"];
            }
        }

        /**
         * Action: retourne si le mdp si l'ancien correspond et que le nouveau mot de passe est taper et confirmer, le nouveau mdp hasher.
         * @return string
         */
        private function changePassword() {
            if (!empty($this->post["oldpass"]) && $this->post["pass"] === $this->post["pass_confirm"]) {
                if (password_verify($this->post["oldpass"], $this->user["pass"])) {
                    return password_hash ($this->post["pass"], PASSWORD_DEFAULT);
                }
            }
        }

        /**
         * Action: modifie les données dans la bdd en fonction du type passé (mail ou pass).
         */
        private function setNewData() {
            $typeOfData = "";
            $dataToChange = [];

            if(!empty($this->newData["mail"])) {
                $typeOfData           = "mail";
                $dataToChange["mail"] = $this->newData["mail"];
            }

            if(!empty($this->newData["pass"])) {
                $typeOfData           = "pass";
                $dataToChange["pass"] = $this->newData["pass"];
            }

            switch ($typeOfData) {
                case "mail":
                    ModelsFactory::getModel("Users")->updateData($this->session["user"]["id"], $dataToChange);
                    break;

                case "pass":
                    ModelsFactory::getModel("Users")->updateData($this->session["user"]["id"], $dataToChange);
                    break;
            }
        }

    }