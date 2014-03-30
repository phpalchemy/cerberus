<?php

namespace Alchemy\Component\Cerberus\Model\Map;

use Alchemy\Component\Cerberus\Model\Permission;
use Alchemy\Component\Cerberus\Model\PermissionQuery;
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
 * This class defines the structure of the 'permission' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PermissionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Alchemy.Component.Cerberus.Model.Map.PermissionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Cerberus';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'permission';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Alchemy\\Component\\Cerberus\\Model\\Permission';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Alchemy.Component.Cerberus.Model.Permission';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the PRM_ID field
     */
    const COL_PRM_ID = 'permission.PRM_ID';

    /**
     * the column name for the PRM_NAME field
     */
    const COL_PRM_NAME = 'permission.PRM_NAME';

    /**
     * the column name for the PRM_CREATE_DATE field
     */
    const COL_PRM_CREATE_DATE = 'permission.PRM_CREATE_DATE';

    /**
     * the column name for the PRM_UPDATE_DATE field
     */
    const COL_PRM_UPDATE_DATE = 'permission.PRM_UPDATE_DATE';

    /**
     * the column name for the PRM_STATUS field
     */
    const COL_PRM_STATUS = 'permission.PRM_STATUS';

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
        self::TYPE_PHPNAME       => array('PrmId', 'PrmName', 'PrmCreateDate', 'PrmUpdateDate', 'PrmStatus', ),
        self::TYPE_STUDLYPHPNAME => array('prmId', 'prmName', 'prmCreateDate', 'prmUpdateDate', 'prmStatus', ),
        self::TYPE_COLNAME       => array(PermissionTableMap::COL_PRM_ID, PermissionTableMap::COL_PRM_NAME, PermissionTableMap::COL_PRM_CREATE_DATE, PermissionTableMap::COL_PRM_UPDATE_DATE, PermissionTableMap::COL_PRM_STATUS, ),
        self::TYPE_RAW_COLNAME   => array('COL_PRM_ID', 'COL_PRM_NAME', 'COL_PRM_CREATE_DATE', 'COL_PRM_UPDATE_DATE', 'COL_PRM_STATUS', ),
        self::TYPE_FIELDNAME     => array('prm_id', 'prm_name', 'prm_create_date', 'prm_update_date', 'prm_status', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('PrmId' => 0, 'PrmName' => 1, 'PrmCreateDate' => 2, 'PrmUpdateDate' => 3, 'PrmStatus' => 4, ),
        self::TYPE_STUDLYPHPNAME => array('prmId' => 0, 'prmName' => 1, 'prmCreateDate' => 2, 'prmUpdateDate' => 3, 'prmStatus' => 4, ),
        self::TYPE_COLNAME       => array(PermissionTableMap::COL_PRM_ID => 0, PermissionTableMap::COL_PRM_NAME => 1, PermissionTableMap::COL_PRM_CREATE_DATE => 2, PermissionTableMap::COL_PRM_UPDATE_DATE => 3, PermissionTableMap::COL_PRM_STATUS => 4, ),
        self::TYPE_RAW_COLNAME   => array('COL_PRM_ID' => 0, 'COL_PRM_NAME' => 1, 'COL_PRM_CREATE_DATE' => 2, 'COL_PRM_UPDATE_DATE' => 3, 'COL_PRM_STATUS' => 4, ),
        self::TYPE_FIELDNAME     => array('prm_id' => 0, 'prm_name' => 1, 'prm_create_date' => 2, 'prm_update_date' => 3, 'prm_status' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('permission');
        $this->setPhpName('Permission');
        $this->setClassName('\\Alchemy\\Component\\Cerberus\\Model\\Permission');
        $this->setPackage('Alchemy.Component.Cerberus.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('PRM_ID', 'PrmId', 'INTEGER', true, null, null);
        $this->addColumn('PRM_NAME', 'PrmName', 'VARCHAR', true, 256, null);
        $this->addColumn('PRM_CREATE_DATE', 'PrmCreateDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('PRM_UPDATE_DATE', 'PrmUpdateDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('PRM_STATUS', 'PrmStatus', 'VARCHAR', false, 64, 'ACTIVE');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('RolPermission', '\\Alchemy\\Component\\Cerberus\\Model\\RolPermission', RelationMap::ONE_TO_MANY, array('prm_id' => 'prm_id', ), 'CASCADE', null, 'RolPermissions');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to permission     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        RolPermissionTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PrmId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PrmId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('PrmId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? PermissionTableMap::CLASS_DEFAULT : PermissionTableMap::OM_CLASS;
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
     * @return array (Permission object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PermissionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PermissionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PermissionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PermissionTableMap::OM_CLASS;
            /** @var Permission $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PermissionTableMap::addInstanceToPool($obj, $key);
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
            $key = PermissionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PermissionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Permission $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PermissionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PermissionTableMap::COL_PRM_ID);
            $criteria->addSelectColumn(PermissionTableMap::COL_PRM_NAME);
            $criteria->addSelectColumn(PermissionTableMap::COL_PRM_CREATE_DATE);
            $criteria->addSelectColumn(PermissionTableMap::COL_PRM_UPDATE_DATE);
            $criteria->addSelectColumn(PermissionTableMap::COL_PRM_STATUS);
        } else {
            $criteria->addSelectColumn($alias . '.PRM_ID');
            $criteria->addSelectColumn($alias . '.PRM_NAME');
            $criteria->addSelectColumn($alias . '.PRM_CREATE_DATE');
            $criteria->addSelectColumn($alias . '.PRM_UPDATE_DATE');
            $criteria->addSelectColumn($alias . '.PRM_STATUS');
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
        return Propel::getServiceContainer()->getDatabaseMap(PermissionTableMap::DATABASE_NAME)->getTable(PermissionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PermissionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PermissionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PermissionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Permission or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Permission object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Alchemy\Component\Cerberus\Model\Permission) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PermissionTableMap::DATABASE_NAME);
            $criteria->add(PermissionTableMap::COL_PRM_ID, (array) $values, Criteria::IN);
        }

        $query = PermissionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PermissionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PermissionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the permission table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PermissionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Permission or Criteria object.
     *
     * @param mixed               $criteria Criteria or Permission object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PermissionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Permission object
        }

        if ($criteria->containsKey(PermissionTableMap::COL_PRM_ID) && $criteria->keyContainsValue(PermissionTableMap::COL_PRM_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PermissionTableMap::COL_PRM_ID.')');
        }


        // Set the correct dbName
        $query = PermissionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PermissionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PermissionTableMap::buildTableMap();
