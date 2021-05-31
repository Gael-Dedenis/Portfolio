<?php

    namespace App\Controllers;

    use App\Models\Factory\ModelsFactory;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;

    /**
     * class PortfolioController
     * @package App\Controller
     */
    class PortfolioController extends MainController {
        /**
         * @return array
         * @throws LoaderError
         * @throws RuntimeError
         * @throws SyntaxError
         */
        public function defaultMethod() {
            return json_encode(array_reverse(ModelsFactory::getModel("Projects")->listData()));
        }
    }