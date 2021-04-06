<?php

    namespace App\Controllers;

    use App\Models\Factory\ModelsFactory;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;

    /**
     * Class HomeController
     * appel la page Home
     * @package App\Controllers
     */
    class HomeController extends MainController {

    /**
     * Rendu de la vue Home
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod() {
        return $this->render("home.twig", ["lastProjects" => $this->getLastProjects()]);
    }

    /**
     * @return array|mixed
     */
    private function getLastProjects() {
        return array_reverse(ModelsFactory::getModel("Projects")->listData());
    }
}