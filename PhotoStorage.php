<?php
/**
 * @package Live-Map
 *
 * @class PhotoStorage
 */

class PhotoStorage
{
    static $_dbh = NULL;
    /**
     * Adds info about a photo to our local storage
     *
     * @param Photo
     * @param string
     *
     * @throws Exception Bubbles up from _changeDb()
     */
    static public function addPhoto($photo, $location)
    {
        $q = "
            INSERT INTO photos
            (
                url,
                caption,
                location
            )
            VALUES ( ?, ?, ? )
        ";

        $params = array(
            $photo->url,
            $photo->text,
            $location,
        );
            
        self::_changeDb($q, $params);
    }

    /**
     * @return Photo
     */
    static public function getNextUnseen()
    {
        if (is_null(self::$_dbh)) {
            self::_connectToDb();
        }

        $q = "
            SELECT id, url, caption, location
            FROM photos
            WHERE seen_yet = 0
            ORDER BY id ASC
            LIMIT 1
        ";

        $sth = self::$_dbh->query($q);

        $row = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return NULL;
        }

        $photo = new Photo();

        $photo->url = $row['url'];
        $photo->text = $row['text'];
        $photo->location = $row['location'];

        self::_markAsSeen($row['id']);
    }

    /**
     * @param string
     *
     * @throws Exception Bubbles up from _changeDb()
     */
    static private function _markAsSeen($id)
    {
        $q = "
            UPDATE photos
            SET seen_yet = 1
            WHERE id = ?
        ";

        $params= array ( $id );

        self::_changeDb($q, $params);
    }

    /**
     * Executes a "write" query on $_dbh
     *
     * @param string
     * @param 
     */
    static private function _changeDb($q, $params)
    {
        if (is_null(self::$_dbh)) {
            self::_connectToDb();
        }

        $sth = self::$_dbh->prepare($q);

        if (!$sth) {
            $errorInfo = self::$_dbh->errorInfo();
            error_log(__FUNCTION__.": PDO's prepare() "
                . " returned error [{$errorInfo[2]}]. Query follows.\n"
                . $q
            );

            throw new Exception("Database-prepare error [write operation]");
        }

        if (!$sth->execute($params)) {
            $errorInfo = self::$_dbh->errorInfo();
            error_log(__FUNCTION__.": PDO's execute() "
                . " returned error [{$errorInfo[2]}]. Query follows.\n"
                . "[$q], parameters: "
                . '[' . implode("],[", $params) . ']'
            );

            throw new Exception("Database-execute error [write operation]");
        }
    }

    static private function _connectToDb()
    {
        global $settings;
        $dsn = "mysql:dbname={$settings['db_name']};"
                   . "host={$settings['db_host']}";
        try {
            self::$_dbh = new PDO(
                $dsn,
                $settings['db_uid'],
                $settings['db_pwd'],
                array(
                    PDO::MYSQL_ATTR_DIRECT_QUERY => 0,
                )
            );
        } catch (PDOException $e) {
            error_log(__FUNCTION__.": PDO constructor failed. "
                . "Exception follows.\n" . print_r($e, 1)
            );

            throw new Exception("Database-connect error");
        }
            
    }
}

?>
