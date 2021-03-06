<?php

    namespace App\Controllers;

    use App\Models\Factory\ModelsFactory;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;
    use Exception;

    /**
     * class ProjectsController
     * @package App\Controllers
     */
    class ProjectsController extends MainController {

        /**
         * @var
        */
        private $projects = [];

        /**
         * On retourne sur la page d'admin pour gérer les projets.
         * @return string
         * @throws LoaderError
         * @throws RuntimeError
         * @throws SyntaxError
         */
        public function defaultMethod() {
            if ($this->getUser() === true) {
                return $this->render("admin.twig");
            }
            $this->redirect("auth");
        }

        /**
         * @return string
         * @throws LoaderError
         * @throws RuntimeError
         * @throws SyntaxError
         */
        public function createMethod() {
            if ($this->getUser() === true) {
                if (!empty($this->post)) {
                    $this->getNewData();
                    ModelsFactory::getModel("Projects")->createData($this->projects);
                    $this->setImage("../public/images/projets/", $this->post["lien_image"]);
                    $this->redirect("admin");
                }

                return $this->render("admin_parts/admin_add.twig");
            }
            $this->redirect("auth");
        }

        /**
         * @return string
         * @throws LoaderError
         * @throws RuntimeError
         * @throws SyntaxError
         */
        public function modifyMethod() {
            if ($this->getUser() === true) {

                if(!empty($this->post)) {
                    $this->getNewData();
                    ModelsFactory::getModel("Projects")->updateData($this->post["project_id"], $this->projects);

                    if ($this->post["oldName_image"] !== $this->post["lien_image"]) {
                        $this->changeNameImage($this->post["oldName_image"], $this->post["lien_image"]);
                    }

                    if (!empty($_FILES)) {
                        $this->changeImage("../public/images/projets/", $this->post["lien_image"]);
                    }

                    $this->redirect("admin");
                }

                $this->projects["selectedProject"]  = ModelsFactory::getModel("Projects")->readData($this->get["id"]);
                return $this->render("admin_parts/admin_modify.twig", ["projectsToModify" => $this->projects["selectedProject"]]);
            }
            $this->redirect("auth");

        }

        /**
         * On récupère les données du nouveau chapitre.
         * @param string type
         * @return array
         */
        private function getNewData() {
            $this->projects["titre"]       = $this->escapeValue($this->post["titre"]);
            $this->projects["lien"]        = $this->escapeValue($this->post["lien"]);
            $this->projects["lien_image"]  = $this->escapeValue($this->post["lien_image"]);
            $this->projects["description"] = $this->escapeValue($this->post["description"]);
        }

        /**
         * @param string $folder
         * @param string $fileName
         */
        private function setImage(string $folder, string $fileName = null) {
            try {
                $this->uploadFile($folder, $fileName);
            }
            catch (Exception $e) {
                return $this->render("admin_parts/admin_add.twig", ["errors" => $e]);
            }
        }

        /**
         * @param string $folder
         */
        private function changeImage(string $folder, string $fileName = null) {
            try {
                unlink("../public/images/projets/" . $this->post["oldName_image"]);
                $this->uploadFile($folder, $fileName);
            }
            catch (Exception $e) {
                $this->projects["selectedProject"]  = ModelsFactory::getModel("Projects")->readData($this->post["project_id"]);

                return $this->render("admin_parts/admin_modify.twig", ["errors" => $e, "projectsToModify" => $this->projects["selectedProject"]]);
            }
        }

        /**
         * @param string $oldName
         * @param string $newName
         */
        private function changeNameImage(string $oldName, string $newName) {
            rename($oldName, $newName);
        }

        /**
         * @return string
         * @throws LoaderError
         * @throws RuntimeError
         * @throws SyntaxError
         */

        public function deleteMethod()
        {
            if ($this->getUser() === true) {
                $this->projects["allProject"] = ModelsFactory::getModel("Projects")->readData($this->post["projectSelect"], "titre");
                ModelsFactory::getModel("Projects")->deleteData($this->projects["allProject"]["id"]);
                $this->redirect("admin");
            }

            $this->redirect("auth");
        }
    
    }