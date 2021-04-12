<?php

    namespace App\Controllers;

    use App\Controllers\FilesController;
    use App\Models\Factory\ModelsFactory;
    use Twig\Error\LoaderError;
    use Twig\Error\RuntimeError;
    use Twig\Error\SyntaxError;

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
                    $this->getNewData($this->type = "");
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
        public function modifyMethod()
        {
            if ($this->getUser() === true) {

                if(!empty($this->post)) {
                    $this->getNewData($this->type = "modify");                                                   // On récupère les nouvelles infos
                    ModelsFactory::getModel("Projects")->updateData($this->post["project_id"], $this->projects); // on passe à bd les nouvelles données

                    if ($this->post["oldName_image"] !== $this->post["lien_image"]) {                            // si l'ancien nom et le nouveau sont différent
                    $this->changeNameImage($this->post["oldName_image"], $this->post["lien_image"]);             // on change l'ancien noms de l'image par le nouveau
                    }

                    if (!empty($_FILES)) {                                                                       // si il y a une nouvelle image de transférer on l'enregistre et supprime l'ancienne.
                        unlink($this->post["oldName_image"]);
                        $this->changeImage($this->post["lien_image"]);
                    }
                    $this->redirect("admin");                                                                    // on redirige sur l'admin
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
        private function getNewData(string $type) {

            switch($type) {
                case "modify":
                    $this->projects["titre"]       = addslashes($this->post["titre"]);
                    $this->projects["lien"]        = addslashes($this->post["lien"]);
                    $this->projects["lien_image"]  = addslashes($this->post["lien_image"]);
                    $this->projects["description"] = addslashes($this->post["description"]);
                    return $this->projects;
                    break;

                default:
                    $this->projects["titre"]       = addslashes($this->post["titre"]);
                    $this->projects["lien"]        = addslashes($this->post["lien"]);
                    $this->projects["lien_image"]  = addslashes("../public/images/projets/" . $this->post["lien_image"]);
                    $this->projects["description"] = addslashes($this->post["description"]);
                    return $this->projects;
            }
        }

        /**
         * @param string $folder
         * @param string $fileName
         */
        private function setImage(string $folder, string $fileName = null) {
            $this->uploadFile($folder, $fileName);
        }

        /**
         * @param string $folder
         */
        private function changeImage(string $folder) {
            $this->changeUploadedFile($folder);
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