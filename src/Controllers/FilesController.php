<?php

    namespace App\Controllers;

    use Exception;

    /**
     * Class FilesController
     * @package App\Controllers
     */
    abstract class FilesController {
        /**
         * @var
         */
        private $files = null;

        /**
         * FilesController Constructor
         */
        public function __construct() {
            $this->files = filter_var_array($_FILES);
        }

        /**
         * @param string $folder
         * @param string $fileName
         * @return mixed|string 
         */
        protected function uploadFile(string $folder, string $fileName = null, int $maxSize = 500000) {
            if (!isset($this->files) && $this->files["image"]["error"] > 0) {
                throw new Exception("Erreur lors du transfer !");
            }

            if ($this->files["image"]["size"] > $maxSize) {
                throw new Exception("Erreur le poids de l'image est trop lourd !");
            }

            if (!move_uploaded_file($this->files["image"]["tmp_name"], $this->setFileName($folder, $fileName))) {
                throw new Exception("Erreur lors du transfert de l'image !");
            }
        }

        /**
         * Action: donne le nom du dossier et du fichier.
         * @param string $folder
         * @param string|null $fileName
         * @return string
         */
        protected function setFileName(string $folder, string $fileName = "") {
            if ($fileName !== null && $fileName !== "") {
                return $folder . $fileName;
            }
            return $folder . $this->files["image"]["name"];
        }

    }