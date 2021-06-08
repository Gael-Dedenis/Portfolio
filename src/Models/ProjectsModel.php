<?php

    namespace App\Models;

    use App\Models\MainModel;

    /**
    * Class ProjectsModel
    * @package App\Models
    */
    class ProjectsModel extends MainModel {
        /**
         * requête spéciale pour récuperer uniquement les 4 derniers projets.
         */
        public function get4LastProjects(string $value = null) {
            $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC LIMIT 4";

            return $this->database->getAllData($query, [$value]);
        }
    }