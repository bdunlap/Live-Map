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
                thumbnail_url,
                caption,
                location,
                goo_id
            )
            VALUES ( ?, ?, ?, ?, ? )
        ";

        $params = array(
            $photo->url,
            $photo->thumbnailUrl,
            $photo->text,
            $photo->location,
            $photo->gooId,
        );
            
        self::_changeDb($q, $params);
    }

    /**
     * @return Photo
     */
    static public function getNextUnseen()
    {
        $photo = self::getPhoto(NULL);
        self::markAsSeen($photo->gooId);

        return $photo;
    }
    /**
     * @return Photo
     */
    static public function getPhoto($id = NULL)
    {
		global $_logger;

        if (is_null(self::$_dbh)) {
            self::_connectToDb();
        }

        $params = array();
        $q = "
            SELECT goo_id, url, thumbnail_url, caption, location
            FROM photos
        ";

        if (is_null($id)) {
            $q .= "
                WHERE seen_yet = 0
                ORDER BY id ASC
                LIMIT 1
            ";
        } else {
            $q .= "
                WHERE id = ?
            ";
            $params[] = $id;
        }

        $sth = self::$_dbh->prepare($q);
        if (!$sth) {
            $errorInfo = $sth->errorInfo();
            $_logger->error(__FUNCTION__.": PDO's prepare() "
                . " returned error [{$errorInfo[2]}]"
            );

            throw new Exception("Database-prepare error [read operation]");
        }

        if (!$sth->execute($params)) {
            $errorInfo = $sth->errorInfo();
            $_logger->error(__FUNCTION__.": PDO's execute() "
                . " returned error [{$errorInfo[2]}]"
            );

            throw new Exception("Database-execute error [read operation]");
        }

        $row = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return NULL;
        }

        $photo = new Photo();

        $photo->url = $row['url'];
        $photo->thumbnailUrl = $row['thumbnail_url'];
        $photo->text = $row['text'];
        $photo->location = $row['location'];
        $photo->gooId = $row['goo_id'];

		return $photo;
    }

    /**
     * @param string
     *
     * @throws Exception If validation of 'gooId' fails
     * @throws Exception Bubbles up from _changeDb()
     */
    static public function markAsSeen($gooId)
    {
		$idToMark = filter_var($gooId, FILTER_VALIDATE_REGEXP,
			array(
				'options' => array(
					'regexp' => '/^[a-z0-9]{1,12}$/i',
				),
			)
		);

		if ($idToMark === FALSE) {
			throw new Exception(__FUNCTION__ . ": passed an invalid goo-ID");
		}

        $q = "
            UPDATE photos
            SET seen_yet = 1
            WHERE goo_id = ?
        ";

        $params= array ( $idToMark );

        self::_changeDb($q, $params);
    }

    /**
     * Executes a "write" query on $_dbh
     *
     * @param string
     * @param array
     */
    static private function _changeDb($q, $params)
    {
		global $_logger;

        if (is_null(self::$_dbh)) {
            self::_connectToDb();
        }

        $sth = self::$_dbh->prepare($q);

        if (!$sth) {
            $errorInfo = $sth->errorInfo();
            $_logger->error(__FUNCTION__.": PDO's prepare() "
                . " returned error [{$errorInfo[2]}]"
            );

            throw new Exception("Database-prepare error [write operation]");
        }

        if (!$sth->execute($params)) {
            $errorInfo = $sth->errorInfo();
            $_logger->error(__FUNCTION__.": PDO's execute() "
                . " returned error [{$errorInfo[2]}]"
            );

            throw new Exception("Database-execute error [write operation]");
        }
    }

    static private function _connectToDb()
    {
        global $settings, $_logger;
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
            $_logger->error(__FUNCTION__.": PDO constructor failed. "
                . "Exception follows.\n" . print_r($e, 1)
            );

            throw new Exception("Database-connect error");
        }
            
    }
}

?>
