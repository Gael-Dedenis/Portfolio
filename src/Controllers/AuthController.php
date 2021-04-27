<?php

    namespace App\Controllers;

    use App\Models\Factory\ModelsFactory;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;

    /**
     * class AuthController
     * @package App\Controllers
     */
    class AuthController extends MainController {

        /**
         * @var mixed|null
         */
        private $user = null;

        /**
         * Formulaire de connection.
         * @return string
         * @throws LoaderError
         * @throws RuntimeError
         * @throws SyntaxError
        */
        public function defaultMethod() {
            if (!$this->getUser()) {
                if (!empty($this->post["mail"]) && !empty($this->post["pass"])) {
                    $this->authentification();
                }
                return $this->render("auth.twig");
            }
            $this->redirect("home");
        }

        /**
         * Action: méthode vérifiant les logins de l'utilisateur grâce à son mail et mdp.
         * @param string $mail
         * @param string $pass
         * @return array
        */
        private function checkLogUser() {
            $this->user = ModelsFactory::getModel("Users")->readData($this->post["mail"], "mail");

            if (empty($this->user)) {
                return false;
            }

            return password_verify($this->post["pass"], $this->user["pass"]);
        }

        /**
         * Action: check le mail et le mdp pour connecter l'utilisateur.
         * @return string
         */
        private function authentification() {
            $check = $this->checkLogUser();

            if (!$check) {
                return $this->render("auth.twig", ["erreurs" => "mail et/ou mot de passe invalide !"]);
            }
            $this->setSession(
                $this->user["id"],
                $this->user["mail"]
            );
            $this->redirect("home");
        }


        /**
         * Action: remplit la session avec les données de l'utilisateur.
         * @param int $id
         * @param string $pseudo
         * @param string $mail
         * @param string $status
         */
        private function setSession(int $id, string $mail) {
            $data = [
                "id"   => $id,
                "mail" => $mail
            ];

            $this->setSessionData("user", $data);
        }

        /**
         * @return string
         * @throws LoaderError
         * @throws RuntimeError
         * @throws SyntaxError
         */
        public function logoutMethod() {
            if($this->getUser()) {
                $this->unsetSessionData("user");
                $this->redirect("auth");
            }
            $this->redirect("auth");
        }

    }