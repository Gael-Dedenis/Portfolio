<?php

    namespace App;

    use Twig\Environment;
    use Twig\Loader\FilesystemLoader;
    use Twig\Extension\DebugExtension;
    use App\Controllers\Extensions\ExtensionTwig;

    /**
     * Class Router
     * @package App
     */
    class Router
    {
        /**
         * @var Environment
         */
        private $twig = null;

        /**
         * Controller par défaut.
         * @var string
         */
        private $controller = DEFAULT_CONTROLLER ;

        /**
         * Methode par défaut.
         * @var string
         */
        private $method = DEFAULT_METHOD ;

        /**
         * Constructeur de la class Router.
         */
        public function __construct() {
            $this->setEnvironment();
            $this->parseUrl();
            $this->setController();
            $this->setMethod();
        }

        /**
         * Mise en place de l'environnement twig et de ses composants.
         * @return mixed|void
         */
        private function setEnvironment() {
            $this->twig = new Environment(new FilesystemLoader("../src/Views"), array(
                "cache" => false,
                'debug' => true
            ));
            $this->twig->addGlobal("session", $_SESSION);
            $this->twig->addExtension(new \Twig\Extension\DebugExtension());
            $this->twig->addExtension(new ExtensionTwig());
        }

        /**
         * Analyse l'URL pour appeler le controller demander ainsi que la méthode sélectionnée.
         * @return mixed|void
         */
        private function parseUrl() {
            $access = filter_input(INPUT_GET, "access");
            if (!isset($access)) {
                $access = "home";
            }
            $access           = explode("!", $access);
            $this->controller = $access[0];
            $this->method     = count($access) == 1 ? "default" : $access[1];
        }

        /**
         * Créer les requêtes vers les controllers.
         * @return mixed|void
         */
        private function setController() {
            $this->controller = ucfirst(\strtolower($this->controller)) . "Controller";
            $this->controller = DEFAULT_PATH . $this->controller;

            if (!class_exists($this->controller)) {
                $this->controller = DEFAULT_PATH . DEFAULT_CONTROLLER;
            }
        }

        /**
         * Créer les requêtes pour les méthodes.
         * @return mixed|void
         */
        private function setMethod() {
            $this->method = strtolower($this->method) . "Method";

            if (!method_exists($this->controller, $this->method)) {
                $this->method = DEFAULT_METHOD;
            }
        }

        /**
         * Créer l'objet Controller et l'appel.
         * @return mixed|void
         */
        public function run() {
            $this->controller = new $this->controller($this->twig);
            $response         = call_user_func([$this->controller, $this->method]);

            print_r(filter_var($response));
        }
    }