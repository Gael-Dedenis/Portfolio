<?php

    namespace App\Controllers;

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
        public function uploadFile(string $folder, string $fileName = null, int $maxSize = 500000) {

                if (!isset($this->files) && $this->files["image"]["error"] > 0) {
                    echo "Erreur lors du transferet !";
                    die;
                }

                if ($this->files["images"]["size"] > $maxSize) {
                    echo "Erreur le poids de l'image est trop lourd !";
                    die;
                }

                if (!move_uploaded_file($this->files["image"]["tmp_name"], $this->setFileName($folder, $fileName))) {
                    echo "Erreur lors du transfert de l'image !";
                    die;
                }

        }

        /**
         * Action: change l'image utiliser par le projet avec le nom de l'ancienne image.
         * @param string $folder
         * @return mixed|string 
         */
        public function changeUploadedFile(string $folder, int $maxSize = 500000) {

            if (!isset($this->files) && $this->files["image"]["error"] > 0) {
                echo "Erreur lors du transferet !";
                die;
            }

            if ($this->files["images"]["size"] > $maxSize) {
                echo "Erreur le poids de l'image est trop lourd !";
                die;
            }

            if (!move_uploaded_file($this->files["image"]["tmp_name"], $folder)) {
                echo "Erreur lors du transfert de l'image !";
                die;
            }

    }

        /**
         * Action: donne le nom du dossier et du fichier.
         * @param string $folder
         * @param string|null $fileName
         * @return string
         */
        public function setFileName(string $folder, string $fileName = null) {
            if ($fileName === null) {
                return $folder . $this->files["image"]["name"];
            }
            $newFileName = str_replace(array(".bmp", ".gif", ".jpg", ".png", ".webp"), "", $fileName);
            return $folder . $newFileName . $this->checkFileExtension();
        }

        /**
         * @return mixed
         */
        public function checkFileExtension() {
            switch($this->files["image"]["type"]) {
                case "image/bmp":
                    return ".bmp";
                    break;

                case "image/gif":
                    return ".gif";
                    break;

                case "image/jpeg":
                    return ".jpg";
                    break;

                case "image/png":
                    return ".png";
                    break;

                case "image/webp":
                    return ".webp";
                    break;

                default:
                    return false;
            }
        }

    }