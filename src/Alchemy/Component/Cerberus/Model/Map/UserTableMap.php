<?php

namespace Alchemy\Component\Cerberus\Model\Map;

use Alchemy\Component\Cerberus\Model\User;
use Alchemy\Component\Cerberus\Model\UserQuery;
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
 * This class defines the structure of the 'user' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UserTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Alchemy.Component.Cerberus.Model.Map.UserTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Cerberus';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'user';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Alchemy\\Component\\Cerberus\\Model\\User';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Alchemy.Component.Cerberus.Model.User';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the USR_ID field
     */
    const COL_USR_ID = 'user.USR_ID';

    /**
     * the column name for the USR_USERNAME field
     */
    const COL_USR_USERNAME = 'user.USR_USERNAME';

    /**
     * the column name for the USR_PASSWORD field
     */
    const COL_USR_PASSWORD = 'user.USR_PASSWORD';

    /**
     * the column name for the USR_FIRST_NAME field
     */
    const COL_USR_FIRST_NAME = 'user.USR_FIRST_NAME';

    /**
     * the column name for the USR_LAST_NAME field
     */
    const COL_USR_LAST_NAME = 'user.USR_LAST_NAME';

    /**
     * the column name for the USR_CREATE_DATE field
     */
    const COL_USR_CREATE_DATE = 'user.USR_CREATE_DATE';

    /**
     * the column name for the USR_UPDATE_DATE field
     */
    const COL_USR_UPDATE_DATE = 'user.USR_UPDATE_DATE';

    /**
     * the column name for the USR_STATUS field
     */
    const COL_USR_STATUS = 'user.USR_STATUS';

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
        self::TYPE_PHPNAME       => array('UsrId', 'UsrUsername', 'UsrPassword', 'UsrFirstName', 'UsrLastName', 'UsrCreateDate', 'UsrUpdateDate', 'UsrStatus', ),
        self::TYPE_STUDLYPHPNAME => array('usrId', 'usrUsername', 'usrPassword', 'usrFirstName', 'usrLastName', 'usrCreateDate', 'usrUpdateDate', 'usrStatus', ),
        self::TYPE_COLNAME       => array(UserTableMap::COL_USR_ID, UserTableMap::COL_USR_USERNAME, UserTableMap::COL_USR_PASSWORD, UserTableMap::COL_USR_FIRST_NAME, UserTableMap::COL_USR_LAST_NAME, UserTableMap::COL_USR_CREATE_DATE, UserTableMap::COL_USR_UPDATE_DATE, UserTableMap::COL_USR_STATUS, ),
        self::TYPE_RAW_COLNAME   => array('COL_USR_ID', 'COL_USR_USERNAME', 'COL_USR_PASSWORD', 'COL_USR_FIRST_NAME', 'COL_USR_LAST_NAME', 'COL_USR_CREATE_DATE', 'COL_USR_UPDATE_DATE', 'COL_USR_STATUS', ),
        self::TYPE_FIELDNAME     => array('usr_id', 'usr_username', 'usr_password', 'usr_first_name', 'usr_last_name', 'usr_create_date', 'usr_update_date', 'usr_status', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('UsrId' => 0, 'UsrUsername' => 1, 'UsrPassword' => 2, 'UsrFirstName' => 3, 'UsrLastName' => 4, 'UsrCreateDate' => 5, 'UsrUpdateDate' => 6, 'UsrStatus' => 7, ),
        self::TYPE_STUDLYPHPNAME => array('usrId' => 0, 'usrUsername' => 1, 'usrPassword' => 2, 'usrFirstName' => 3, 'usrLastName' => 4, 'usrCreateDate' => 5, 'usrUpdateDate' => 6, 'usrStatus' => 7, ),
        self::TYPE_COLNAME       => array(UserTableMap::COL_USR_ID => 0, UserTableMap::COL_USR_USERNAME => 1, UserTableMap::COL_USR_PASSWORD => 2, UserTableMap::COL_USR_FIRST_NAME => 3, UserTableMap::COL_USR_LAST_NAME => 4, UserTableMap::COL_USR_CREATE_DATE => 5, UserTableMap::COL_USR_UPDATE_DATE => 6, UserTableMap::COL_USR_STATUS => 7, ),
        self::TYPE_RAW_COLNAME   => array('COL_USR_ID' => 0, 'COL_USR_USERNAME' => 1, 'COL_USR_PASSWORD' => 2, 'COL_USR_FIRST_NAME' => 3, 'COL_USR_LAST_NAME' => 4, 'COL_USR_CREATE_DATE' => 5, 'COL_USR_UPDATE_DATE' => 6, 'COL_USR_STATUS' => 7, ),
        self::TYPE_FIELDNAME     => array('usr_id' => 0, 'usr_username' => 1, 'usr_password' => 2, 'usr_first_name' => 3, 'usr_last_name' => 4, 'usr_create_date' => 5, 'usr_update_date' => 6, 'usr_status' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('user');
        $this->setPhpName('User');
        $this->setClassName('\\Alchemy\\Component\\Cerberus\\Model\\User');
        $this->setPackage('Alchemy.Component.Cerberus.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('USR_ID', 'UsrId', 'INTEGER', true, null, null);
        $this->addColumn('USR_USERNAME', 'UsrUsername', 'VARCHAR', true, 128, null);
        $this->addColumn('USR_PASSWORD', 'UsrPassword', 'VARCHAR', true, 32, null);
        $this->addColumn('USR_FIRST_NAME', 'UsrFirstName', 'VARCHAR', true, 128, null);
        $this->addColumn('USR_LAST_NAME', 'UsrLastName', 'VARCHAR', true, 128, null);
        $this->addColumn('USR_CREATE_DATE', 'UsrCreateDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('USR_UPDATE_DATE', 'UsrUpdateDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('USR_STATUS', 'UsrStatus', 'VARCHAR', false, 64, 'ACTIVE');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UserRol', '\\Alchemy\\Component\\Cerberus\\Model\\UserRol', RelationMap::ONE_TO_MANY, array('usr_id' => 'usr_id', ), 'CASCADE', null, 'UserRols');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to user     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        UserRolTableMap::clearInstancePool();
    }

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UsrId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UsrId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('UsrId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? UserTableMap::CLASS_DEFAULT : UserTableMap::OM_CLASS;
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
     * @return array (User object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UserTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UserTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UserTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UserTableMap::OM_CLASS;
            /** @var User $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UserTableMap::addInstanceToPool($obj, $key);
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
            $key = UserTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UserTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var User $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UserTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(UserTableMap::COL_USR_ID);
            $criteria->addSelectColumn(UserTableMap::COL_USR_USERNAME);
            $criteria->addSelectColumn(UserTableMap::COL_USR_PASSWORD);
            $criteria->addSelectColumn(UserTableMap::COL_USR_FIRST_NAME);
            $criteria->addSelectColumn(UserTableMap::COL_USR_LAST_NAME);
            $criteria->addSelectColumn(UserTableMap::COL_USR_CREATE_DATE);
            $criteria->addSelectColumn(UserTableMap::COL_USR_UPDATE_DATE);
            $criteria->addSelectColumn(UserTableMap::COL_USR_STATUS);
        } else {
            $criteria->addSelectColumn($alias . '.USR_ID');
            $criteria->addSelectColumn($alias . '.USR_USERNAME');
            $criteria->addSelectColumn($alias . '.USR_PASSWORD');
            $criteria->addSelectColumn($alias . '.USR_FIRST_NAME');
            $criteria->addSelectColumn($alias . '.USR_LAST_NAME');
            $criteria->addSelectColumn($alias . '.USR_CREATE_DATE');
            $criteria->addSelectColumn($alias . '.USR_UPDATE_DATE');
            $criteria->addSelectColumn($alias . '.USR_STATUS');
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
        return Propel::getServiceContainer()->getDatabaseMap(UserTableMap::DATABASE_NAME)->getTable(UserTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UserTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UserTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UserTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a User or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or User object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Alchemy\Component\Cerberus\Model\User) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UserTableMap::DATABASE_NAME);
            $criteria->add(UserTableMap::COL_USR_ID, (array) $values, Criteria::IN);
        }

        $query = UserQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UserTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UserTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the user table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UserQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a User or Criteria object.
     *
     * @param mixed               $criteria Criteria or User object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from User object
        }

        if ($criteria->containsKey(UserTableMap::COL_USR_ID) && $criteria->keyContainsValue(UserTableMap::COL_USR_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UserTableMap::COL_USR_ID.')');
        }


        // Set the correct dbName
        $query = UserQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UserTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UserTableMap::buildTableMap();
