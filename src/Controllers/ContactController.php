<?php

    namespace App\Controllers;

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
        private $mail = [];

        /**
         * @return string
         * @throws LoaderError
         * @throws RuntimeError
         * @throws SyntaxError
         */
        public function defaultMethod()
        {
            if (empty($this->post["message"]))
            {
                $this->redirect("home");
            } else {
                $this->sendMethod();
                $this->redirect("home");
            }

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
                ->setTo([MAIL_TO => "J.forteroche", htmlspecialchars($this->post["mail"]) => htmlspecialchars($this->post["nom"])])
                ->setBody(htmlspecialchars($this->post["message"]))
                ;

            // envoie du mail
            return $mailer->send($message);
        }
    }