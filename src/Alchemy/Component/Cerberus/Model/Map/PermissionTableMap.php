<?php

namespace Alchemy\Component\Cerberus\Model\Map;

use Alchemy\Component\Cerberus\Model\Permission;
use Alchemy\Component\Cerberus\Model\PermissionQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
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
    const DATABASE_NAME = 'cerberus';

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
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the ID field
     */
    const ID = 'permission.ID';

    /**
     * the column name for the NAME field
     */
    const NAME = 'permission.NAME';

    /**
     * the column name for the CREATE_DATE field
     */
    const CREATE_DATE = 'permission.CREATE_DATE';

    /**
     * the column name for the DESCRIPTION field
     */
    const DESCRIPTION = 'permission.DESCRIPTION';

    /**
     * the column name for the UPDATE_DATE field
     */
    const UPDATE_DATE = 'permission.UPDATE_DATE';

    /**
     * the column name for the STATUS field
     */
    const STATUS = 'permission.STATUS';

    /**
     * the column name for the PARENT_ID field
     */
    const PARENT_ID = 'permission.PARENT_ID';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'CreateDate', 'Description', 'UpdateDate', 'Status', 'ParentId', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'name', 'createDate', 'description', 'updateDate', 'status', 'parentId', ),
        self::TYPE_COLNAME       => array(PermissionTableMap::ID, PermissionTableMap::NAME, PermissionTableMap::CREATE_DATE, PermissionTableMap::DESCRIPTION, PermissionTableMap::UPDATE_DATE, PermissionTableMap::STATUS, PermissionTableMap::PARENT_ID, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'NAME', 'CREATE_DATE', 'DESCRIPTION', 'UPDATE_DATE', 'STATUS', 'PARENT_ID', ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'create_date', 'description', 'update_date', 'status', 'parent_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'CreateDate' => 2, 'Description' => 3, 'UpdateDate' => 4, 'Status' => 5, 'ParentId' => 6, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'name' => 1, 'createDate' => 2, 'description' => 3, 'updateDate' => 4, 'status' => 5, 'parentId' => 6, ),
        self::TYPE_COLNAME       => array(PermissionTableMap::ID => 0, PermissionTableMap::NAME => 1, PermissionTableMap::CREATE_DATE => 2, PermissionTableMap::DESCRIPTION => 3, PermissionTableMap::UPDATE_DATE => 4, PermissionTableMap::STATUS => 5, PermissionTableMap::PARENT_ID => 6, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'NAME' => 1, 'CREATE_DATE' => 2, 'DESCRIPTION' => 3, 'UPDATE_DATE' => 4, 'STATUS' => 5, 'PARENT_ID' => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'create_date' => 2, 'description' => 3, 'update_date' => 4, 'status' => 5, 'parent_id' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setIsCrossRef(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('NAME', 'Name', 'VARCHAR', true, 256, null);
        $this->addColumn('CREATE_DATE', 'CreateDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', true, 256, null);
        $this->addColumn('UPDATE_DATE', 'UpdateDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('STATUS', 'Status', 'VARCHAR', false, 64, 'ACTIVE');
        $this->addForeignKey('PARENT_ID', 'ParentId', 'INTEGER', 'permission', 'ID', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('PermissionRelatedByParentId', '\\Alchemy\\Component\\Cerberus\\Model\\Permission', RelationMap::MANY_TO_ONE, array('parent_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('PermissionRelatedById', '\\Alchemy\\Component\\Cerberus\\Model\\Permission', RelationMap::ONE_TO_MANY, array('id' => 'parent_id', ), 'CASCADE', null, 'PermissionsRelatedById');
        $this->addRelation('RolePermission', '\\Alchemy\\Component\\Cerberus\\Model\\RolePermission', RelationMap::ONE_TO_MANY, array('id' => 'permission_id', ), 'CASCADE', null, 'RolePermissions');
        $this->addRelation('Role', '\\Alchemy\\Component\\Cerberus\\Model\\Role', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'Roles');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to permission     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                PermissionTableMap::clearInstancePool();
                RolePermissionTableMap::clearInstancePool();
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
            $criteria->addSelectColumn(PermissionTableMap::ID);
            $criteria->addSelectColumn(PermissionTableMap::NAME);
            $criteria->addSelectColumn(PermissionTableMap::CREATE_DATE);
            $criteria->addSelectColumn(PermissionTableMap::DESCRIPTION);
            $criteria->addSelectColumn(PermissionTableMap::UPDATE_DATE);
            $criteria->addSelectColumn(PermissionTableMap::STATUS);
            $criteria->addSelectColumn(PermissionTableMap::PARENT_ID);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.NAME');
            $criteria->addSelectColumn($alias . '.CREATE_DATE');
            $criteria->addSelectColumn($alias . '.DESCRIPTION');
            $criteria->addSelectColumn($alias . '.UPDATE_DATE');
            $criteria->addSelectColumn($alias . '.STATUS');
            $criteria->addSelectColumn($alias . '.PARENT_ID');
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
            $criteria->add(PermissionTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = PermissionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { PermissionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { PermissionTableMap::removeInstanceFromPool($singleval);
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

        if ($criteria->containsKey(PermissionTableMap::ID) && $criteria->keyContainsValue(PermissionTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PermissionTableMap::ID.')');
        }


        // Set the correct dbName
        $query = PermissionQuery::create()->mergeWith($criteria);

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

} // PermissionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PermissionTableMap::buildTableMap();
