<?php

    namespace App\Models\Factory;

    use PDO;

    /**
     * Class PDOFactory.
     * Actions: Créer une connection à la BD si aucune existe.
     * @package App\Models
     */

    class PDOFactory
    {

        /**
         * Actions: Stock la connection
         * @var null
         */
        private static $pdo = null;

        /**
         * Actions: On retourne la connection si elle existe,
         * Sinon on la créer puis on la retourne.
         */
        public static function getPDO()
        {

            if (self::$pdo === null)
            {

                    self::$pdo = new PDO(DEV['DB_HOST'], DEV['DB_USER'], DEV['DB_PASS'], DEV['DB_OPTIONS']);
                    self::$pdo->exec("SET NAMES UTF8");

            }
            return self::$pdo;
        }

    }