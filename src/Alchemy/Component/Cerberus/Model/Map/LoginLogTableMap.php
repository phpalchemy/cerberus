<?php

namespace Alchemy\Component\Cerberus\Model\Map;

use Alchemy\Component\Cerberus\Model\LoginLog;
use Alchemy\Component\Cerberus\Model\LoginLogQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'login_log' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class LoginLogTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Alchemy.Component.Cerberus.Model.Map.LoginLogTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'cerberus';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'login_log';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Alchemy\\Component\\Cerberus\\Model\\LoginLog';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Alchemy.Component.Cerberus.Model.LoginLog';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the ID field
     */
    const ID = 'login_log.ID';

    /**
     * the column name for the TYPE field
     */
    const TYPE = 'login_log.TYPE';

    /**
     * the column name for the DATE_TIME field
     */
    const DATE_TIME = 'login_log.DATE_TIME';

    /**
     * the column name for the USER_ID field
     */
    const USER_ID = 'login_log.USER_ID';

    /**
     * the column name for the USERNAME field
     */
    const USERNAME = 'login_log.USERNAME';

    /**
     * the column name for the SESSION_ID field
     */
    const SESSION_ID = 'login_log.SESSION_ID';

    /**
     * the column name for the CLIENT_ADDRESS field
     */
    const CLIENT_ADDRESS = 'login_log.CLIENT_ADDRESS';

    /**
     * the column name for the CLIENT_IP field
     */
    const CLIENT_IP = 'login_log.CLIENT_IP';

    /**
     * the column name for the CLIENT_AGENT field
     */
    const CLIENT_AGENT = 'login_log.CLIENT_AGENT';

    /**
     * the column name for the CLIENT_PLATFORM field
     */
    const CLIENT_PLATFORM = 'login_log.CLIENT_PLATFORM';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Type', 'DateTime', 'UserId', 'Username', 'SessionId', 'ClientAddress', 'ClientIp', 'ClientAgent', 'ClientPlatform', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'type', 'dateTime', 'userId', 'username', 'sessionId', 'clientAddress', 'clientIp', 'clientAgent', 'clientPlatform', ),
        self::TYPE_COLNAME       => array(LoginLogTableMap::ID, LoginLogTableMap::TYPE, LoginLogTableMap::DATE_TIME, LoginLogTableMap::USER_ID, LoginLogTableMap::USERNAME, LoginLogTableMap::SESSION_ID, LoginLogTableMap::CLIENT_ADDRESS, LoginLogTableMap::CLIENT_IP, LoginLogTableMap::CLIENT_AGENT, LoginLogTableMap::CLIENT_PLATFORM, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'TYPE', 'DATE_TIME', 'USER_ID', 'USERNAME', 'SESSION_ID', 'CLIENT_ADDRESS', 'CLIENT_IP', 'CLIENT_AGENT', 'CLIENT_PLATFORM', ),
        self::TYPE_FIELDNAME     => array('id', 'type', 'date_time', 'user_id', 'username', 'session_id', 'client_address', 'client_ip', 'client_agent', 'client_platform', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Type' => 1, 'DateTime' => 2, 'UserId' => 3, 'Username' => 4, 'SessionId' => 5, 'ClientAddress' => 6, 'ClientIp' => 7, 'ClientAgent' => 8, 'ClientPlatform' => 9, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'type' => 1, 'dateTime' => 2, 'userId' => 3, 'username' => 4, 'sessionId' => 5, 'clientAddress' => 6, 'clientIp' => 7, 'clientAgent' => 8, 'clientPlatform' => 9, ),
        self::TYPE_COLNAME       => array(LoginLogTableMap::ID => 0, LoginLogTableMap::TYPE => 1, LoginLogTableMap::DATE_TIME => 2, LoginLogTableMap::USER_ID => 3, LoginLogTableMap::USERNAME => 4, LoginLogTableMap::SESSION_ID => 5, LoginLogTableMap::CLIENT_ADDRESS => 6, LoginLogTableMap::CLIENT_IP => 7, LoginLogTableMap::CLIENT_AGENT => 8, LoginLogTableMap::CLIENT_PLATFORM => 9, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'TYPE' => 1, 'DATE_TIME' => 2, 'USER_ID' => 3, 'USERNAME' => 4, 'SESSION_ID' => 5, 'CLIENT_ADDRESS' => 6, 'CLIENT_IP' => 7, 'CLIENT_AGENT' => 8, 'CLIENT_PLATFORM' => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'type' => 1, 'date_time' => 2, 'user_id' => 3, 'username' => 4, 'session_id' => 5, 'client_address' => 6, 'client_ip' => 7, 'client_agent' => 8, 'client_platform' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('login_log');
        $this->setPhpName('LoginLog');
        $this->setClassName('\\Alchemy\\Component\\Cerberus\\Model\\LoginLog');
        $this->setPackage('Alchemy.Component.Cerberus.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('TYPE', 'Type', 'VARCHAR', false, 32, null);
        $this->addColumn('DATE_TIME', 'DateTime', 'TIMESTAMP', false, null, null);
        $this->addColumn('USER_ID', 'UserId', 'VARCHAR', false, 256, null);
        $this->addColumn('USERNAME', 'Username', 'VARCHAR', false, 128, null);
        $this->addColumn('SESSION_ID', 'SessionId', 'VARCHAR', false, 64, null);
        $this->addColumn('CLIENT_ADDRESS', 'ClientAddress', 'VARCHAR', false, 128, null);
        $this->addColumn('CLIENT_IP', 'ClientIp', 'VARCHAR', false, 16, null);
        $this->addColumn('CLIENT_AGENT', 'ClientAgent', 'VARCHAR', false, 128, null);
        $this->addColumn('CLIENT_PLATFORM', 'ClientPlatform', 'VARCHAR', false, 64, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? LoginLogTableMap::CLASS_DEFAULT : LoginLogTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (LoginLog object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = LoginLogTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = LoginLogTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + LoginLogTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = LoginLogTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            LoginLogTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = LoginLogTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = LoginLogTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                LoginLogTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(LoginLogTableMap::ID);
            $criteria->addSelectColumn(LoginLogTableMap::TYPE);
            $criteria->addSelectColumn(LoginLogTableMap::DATE_TIME);
            $criteria->addSelectColumn(LoginLogTableMap::USER_ID);
            $criteria->addSelectColumn(LoginLogTableMap::USERNAME);
            $criteria->addSelectColumn(LoginLogTableMap::SESSION_ID);
            $criteria->addSelectColumn(LoginLogTableMap::CLIENT_ADDRESS);
            $criteria->addSelectColumn(LoginLogTableMap::CLIENT_IP);
            $criteria->addSelectColumn(LoginLogTableMap::CLIENT_AGENT);
            $criteria->addSelectColumn(LoginLogTableMap::CLIENT_PLATFORM);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.TYPE');
            $criteria->addSelectColumn($alias . '.DATE_TIME');
            $criteria->addSelectColumn($alias . '.USER_ID');
            $criteria->addSelectColumn($alias . '.USERNAME');
            $criteria->addSelectColumn($alias . '.SESSION_ID');
            $criteria->addSelectColumn($alias . '.CLIENT_ADDRESS');
            $criteria->addSelectColumn($alias . '.CLIENT_IP');
            $criteria->addSelectColumn($alias . '.CLIENT_AGENT');
            $criteria->addSelectColumn($alias . '.CLIENT_PLATFORM');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(LoginLogTableMap::DATABASE_NAME)->getTable(LoginLogTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(LoginLogTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(LoginLogTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new LoginLogTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a LoginLog or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or LoginLog object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LoginLogTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Alchemy\Component\Cerberus\Model\LoginLog) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(LoginLogTableMap::DATABASE_NAME);
            $criteria->add(LoginLogTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = LoginLogQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { LoginLogTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { LoginLogTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the login_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return LoginLogQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a LoginLog or Criteria object.
     *
     * @param mixed               $criteria Criteria or LoginLog object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LoginLogTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from LoginLog object
        }

        if ($criteria->containsKey(LoginLogTableMap::ID) && $criteria->keyContainsValue(LoginLogTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.LoginLogTableMap::ID.')');
        }


        // Set the correct dbName
        $query = LoginLogQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // LoginLogTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
LoginLogTableMap::buildTableMap();
