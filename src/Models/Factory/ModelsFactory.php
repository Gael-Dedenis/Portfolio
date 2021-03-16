<?php

    namespace App\Models\Factory;

    use App\Models\PdoDb;

    /**
     * Class ModelsFactory.
     * Actions: Création des models si ils n'existent pas.
     * @package App\Models
     */

    class ModelsFactory
    {

        /**
         * Models
         * @var array
         */
        private static $models = [];

        /**
         * Actions: On retourne le model si il existe sinon on le créer avant de le retourné.
         * @param $table
         * @return mixed
         */
        public static function getModel(string $table)
        {
            if (array_key_exists($table, self::$models))
            {
                return self::$models[$table];
            }

            $class                = "App\Models\\" . \ucfirst($table) . "Model";
            self::$models[$table] = new $class(new PdoDb(PDOFactory::getPDO()));
            return self::$models[$table];
        }

    }