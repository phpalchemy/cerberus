<?php

namespace Alchemy\Component\Cerberus\Model\Map;

use Alchemy\Component\Cerberus\Model\Log;
use Alchemy\Component\Cerberus\Model\LogQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'log' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class LogTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Alchemy.Component.Cerberus.Model.Map.LogTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'cerberus';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'log';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Alchemy\\Component\\Cerberus\\Model\\Log';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Alchemy.Component.Cerberus.Model.Log';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the ID field
     */
    const COL_ID = 'log.ID';

    /**
     * the column name for the TYPE field
     */
    const COL_TYPE = 'log.TYPE';

    /**
     * the column name for the DATE_TIME field
     */
    const COL_DATE_TIME = 'log.DATE_TIME';

    /**
     * the column name for the LOG_TEXT field
     */
    const COL_LOG_TEXT = 'log.LOG_TEXT';

    /**
     * the column name for the USER_ID field
     */
    const COL_USER_ID = 'log.USER_ID';

    /**
     * the column name for the USERNAME field
     */
    const COL_USERNAME = 'log.USERNAME';

    /**
     * the column name for the SESSION_ID field
     */
    const COL_SESSION_ID = 'log.SESSION_ID';

    /**
     * the column name for the CLIENT_ADDRESS field
     */
    const COL_CLIENT_ADDRESS = 'log.CLIENT_ADDRESS';

    /**
     * the column name for the CLIENT_IP field
     */
    const COL_CLIENT_IP = 'log.CLIENT_IP';

    /**
     * the column name for the CLIENT_AGENT field
     */
    const COL_CLIENT_AGENT = 'log.CLIENT_AGENT';

    /**
     * the column name for the CLIENT_PLATFORM field
     */
    const COL_CLIENT_PLATFORM = 'log.CLIENT_PLATFORM';

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
        self::TYPE_PHPNAME       => array('Id', 'Type', 'DateTime', 'LogText', 'UserId', 'Username', 'SessionId', 'ClientAddress', 'ClientIp', 'ClientAgent', 'ClientPlatform', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'type', 'dateTime', 'logText', 'userId', 'username', 'sessionId', 'clientAddress', 'clientIp', 'clientAgent', 'clientPlatform', ),
        self::TYPE_COLNAME       => array(LogTableMap::COL_ID, LogTableMap::COL_TYPE, LogTableMap::COL_DATE_TIME, LogTableMap::COL_LOG_TEXT, LogTableMap::COL_USER_ID, LogTableMap::COL_USERNAME, LogTableMap::COL_SESSION_ID, LogTableMap::COL_CLIENT_ADDRESS, LogTableMap::COL_CLIENT_IP, LogTableMap::COL_CLIENT_AGENT, LogTableMap::COL_CLIENT_PLATFORM, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID', 'COL_TYPE', 'COL_DATE_TIME', 'COL_LOG_TEXT', 'COL_USER_ID', 'COL_USERNAME', 'COL_SESSION_ID', 'COL_CLIENT_ADDRESS', 'COL_CLIENT_IP', 'COL_CLIENT_AGENT', 'COL_CLIENT_PLATFORM', ),
        self::TYPE_FIELDNAME     => array('id', 'type', 'date_time', 'log_text', 'user_id', 'username', 'session_id', 'client_address', 'client_ip', 'client_agent', 'client_platform', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Type' => 1, 'DateTime' => 2, 'LogText' => 3, 'UserId' => 4, 'Username' => 5, 'SessionId' => 6, 'ClientAddress' => 7, 'ClientIp' => 8, 'ClientAgent' => 9, 'ClientPlatform' => 10, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'type' => 1, 'dateTime' => 2, 'logText' => 3, 'userId' => 4, 'username' => 5, 'sessionId' => 6, 'clientAddress' => 7, 'clientIp' => 8, 'clientAgent' => 9, 'clientPlatform' => 10, ),
        self::TYPE_COLNAME       => array(LogTableMap::COL_ID => 0, LogTableMap::COL_TYPE => 1, LogTableMap::COL_DATE_TIME => 2, LogTableMap::COL_LOG_TEXT => 3, LogTableMap::COL_USER_ID => 4, LogTableMap::COL_USERNAME => 5, LogTableMap::COL_SESSION_ID => 6, LogTableMap::COL_CLIENT_ADDRESS => 7, LogTableMap::COL_CLIENT_IP => 8, LogTableMap::COL_CLIENT_AGENT => 9, LogTableMap::COL_CLIENT_PLATFORM => 10, ),
        self::TYPE_RAW_COLNAME   => array('COL_ID' => 0, 'COL_TYPE' => 1, 'COL_DATE_TIME' => 2, 'COL_LOG_TEXT' => 3, 'COL_USER_ID' => 4, 'COL_USERNAME' => 5, 'COL_SESSION_ID' => 6, 'COL_CLIENT_ADDRESS' => 7, 'COL_CLIENT_IP' => 8, 'COL_CLIENT_AGENT' => 9, 'COL_CLIENT_PLATFORM' => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'type' => 1, 'date_time' => 2, 'log_text' => 3, 'user_id' => 4, 'username' => 5, 'session_id' => 6, 'client_address' => 7, 'client_ip' => 8, 'client_agent' => 9, 'client_platform' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('log');
        $this->setPhpName('Log');
        $this->setClassName('\\Alchemy\\Component\\Cerberus\\Model\\Log');
        $this->setPackage('Alchemy.Component.Cerberus.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('TYPE', 'Type', 'VARCHAR', false, 32, null);
        $this->addColumn('DATE_TIME', 'DateTime', 'TIMESTAMP', false, null, null);
        $this->addColumn('LOG_TEXT', 'LogText', 'LONGVARCHAR', false, null, null);
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
     *
     * @return string The primary key hash of the row
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
        return $withPrefix ? LogTableMap::CLASS_DEFAULT : LogTableMap::OM_CLASS;
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
     *                         rethrown wrapped into a PropelException.
     * @return array           (Log object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = LogTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = LogTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + LogTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = LogTableMap::OM_CLASS;
            /** @var Log $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            LogTableMap::addInstanceToPool($obj, $key);
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
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = LogTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = LogTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Log $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                LogTableMap::addInstanceToPool($obj, $key);
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
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(LogTableMap::COL_ID);
            $criteria->addSelectColumn(LogTableMap::COL_TYPE);
            $criteria->addSelectColumn(LogTableMap::COL_DATE_TIME);
            $criteria->addSelectColumn(LogTableMap::COL_LOG_TEXT);
            $criteria->addSelectColumn(LogTableMap::COL_USER_ID);
            $criteria->addSelectColumn(LogTableMap::COL_USERNAME);
            $criteria->addSelectColumn(LogTableMap::COL_SESSION_ID);
            $criteria->addSelectColumn(LogTableMap::COL_CLIENT_ADDRESS);
            $criteria->addSelectColumn(LogTableMap::COL_CLIENT_IP);
            $criteria->addSelectColumn(LogTableMap::COL_CLIENT_AGENT);
            $criteria->addSelectColumn(LogTableMap::COL_CLIENT_PLATFORM);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.TYPE');
            $criteria->addSelectColumn($alias . '.DATE_TIME');
            $criteria->addSelectColumn($alias . '.LOG_TEXT');
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
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(LogTableMap::DATABASE_NAME)->getTable(LogTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(LogTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(LogTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new LogTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Log or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Log object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LogTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Alchemy\Component\Cerberus\Model\Log) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(LogTableMap::DATABASE_NAME);
            $criteria->add(LogTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = LogQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            LogTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                LogTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return LogQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Log or Criteria object.
     *
     * @param mixed               $criteria Criteria or Log object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LogTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Log object
        }

        if ($criteria->containsKey(LogTableMap::COL_ID) && $criteria->keyContainsValue(LogTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.LogTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = LogQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // LogTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
LogTableMap::buildTableMap();
