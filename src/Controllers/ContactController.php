<?php

    namespace App\Controllers;

    use Exception;
    use Swift_SmtpTransport;
    use Swift_Mailer;
    use Swift_Message;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;

    /**
     * Class ContactController
     * @package App\Controllers
     */
    class ContactController extends MainController
    {
        /**
         * @var
         */
        private $errors = "";

        /**
         * @return string
         * @throws LoaderError
         * @throws RuntimeError
         * @throws SyntaxError
         */
        public function defaultMethod() {
            $this->checkContactForm();

            if (empty($this->errors) && $this->errors === "") {
                $this->sendMethod();
                $this->setSessionData("success", ["Message envoyé ! Une copie vous a également été envoyée !"]);
                $this->redirect("home");
            }

            $this->redirect("home");
        }

        /**
         * méthode pour l'envoie d'un mail par swiftmailer
         * @return mixed
         */
        private function sendMethod()
        {
            // Création du transport
            $transport = (new Swift_SmtpTransport())
                ->setHost(MAIL_HOST)
                ->setPort(MAIL_PORT)
                ->setUsername(MAIL_USERNAME)
                ->setPassword(MAIL_PASS)
                ;

            // Création du mailer utilisant le transport
            $mailer = new Swift_Mailer($transport);

            // Création du message
            $message = (new Swift_Message())
                ->setFrom([MAIL_FROM => "Gael Dedenis Portfolio"])
                ->setTo([MAIL_TO => "Gael Dedenis - Portfolio", htmlspecialchars($this->post["mail"]) => htmlspecialchars($this->post["nom"])])
                ->setSubject(htmlspecialchars($this->post["subject"]))
                ->setBody(htmlspecialchars($this->post["message"]))
                ;

            // envoie du mail
            return $mailer->send($message);
        }

        /**
         * check les données envoyer au formulaire de contact.
         */
        private function checkContactForm() {
            $this->unsetSessionData("erreur");

            if (empty(trim($this->post["nom"])) || strlen(trim($this->post["nom"])) < 4 || !preg_match("/^[a-zA-Z-]+$/", $this->post["nom"])) {
                $this->setSessionData("erreur", ["Merci de renseigner un nom valide dans le formulaire de contact ! (minimum 4 lettres)"]);
                return $this->errors = "Erreur nom !";
            }

            if (empty(trim($this->post["mail"])) || !filter_var($this->post["mail"], FILTER_VALIDATE_EMAIL)) {
                $this->setSessionData("erreur", ["Merci de renseigner un mail valide dans le formulaire de contact !"]);
                return $this->errors = "Erreur mail !";
            }

            if (empty(trim($this->post["subject"]))) {
                $this->setSessionData("erreur", ["Merci de renseigner un sujet valide dans le formulaire de contact ! (caractères AlphaNumérique seulement)"]);
                return $this->errors = "Erreur sujet !";
            } 

            if (empty(trim($this->post["message"]))) {
                $this->setSessionData("erreur", ["Merci de remplir la partie message dans le formulaire de contact !"]);
                return $this->errors = "Erreur message !";
            }
        }
    }