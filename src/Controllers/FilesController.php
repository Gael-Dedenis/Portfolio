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
        public function uploadFile(string $folder, string $fileName, int $maxSize = 500000) {
            try {
                if (!isset($this->files) && $this->files["image"]["error"] > 0) {
                    throw new Exception("Erreur lors du transfert..");
                }

                if ($this->files["images"]["size"] > $maxSize) {
                    throw new Exception("Poids maximum dépassé..");
                }

                if (!move_uploaded_file($this->files["image"]["tmp_name"], $this->setFileName($folder, $fileName))) {
                    throw new Exception("Erreur lors du déplacement du fichier uploadé..");
                }

            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        /**
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