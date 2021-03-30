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
                    $check = $this->checkLogUser();

                    if (!$check) {
                        return $this->render("auth.twig", ["erreurs" => "mail et/ou mot de passe invalide !"]);
                    } else {
                        $this->setSession(
                            $this->user["id"],
                            $this->user["mail"]
                        );
                        $this->redirect("home");
                    }
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
         * Action: remplit la session avec les données de l'utilisateur.
         * @param int $id
         * @param string $pseudo
         * @param string $mail
         * @param string $status
         */
        private function setSession(int $id, string $mail) {
            $_SESSION["user"] = [
                "id"     => $id,
                "mail"  => $mail,

            ];
        }

        /**
         * @return string
         * @throws LoaderError
         * @throws RuntimeError
         * @throws SyntaxError
         */
        public function logoutMethod() {
            if($this->getUser()) {
                $this->unsetSession();
                $this->redirect("auth");
            }
            $this->redirect("auth");

        }

        /**
         * @return void
         */
        private function unsetSession() {
            $_SESSION["user"] = [];
        }

    }