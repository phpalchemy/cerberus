<?php

namespace Alchemy\Component\Cerberus\Model\Base;

use \Exception;
use \PDO;
use Alchemy\Component\Cerberus\Model\RolePermission as ChildRolePermission;
use Alchemy\Component\Cerberus\Model\RolePermissionQuery as ChildRolePermissionQuery;
use Alchemy\Component\Cerberus\Model\Map\RolePermissionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ROLE_PERMISSION' table.
 *
 *
 *
 * @method     ChildRolePermissionQuery orderByRoleId($order = Criteria::ASC) Order by the role_id column
 * @method     ChildRolePermissionQuery orderByPermissionId($order = Criteria::ASC) Order by the permission_id column
 *
 * @method     ChildRolePermissionQuery groupByRoleId() Group by the role_id column
 * @method     ChildRolePermissionQuery groupByPermissionId() Group by the permission_id column
 *
 * @method     ChildRolePermissionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRolePermissionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRolePermissionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRolePermissionQuery leftJoinRole($relationAlias = null) Adds a LEFT JOIN clause to the query using the Role relation
 * @method     ChildRolePermissionQuery rightJoinRole($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Role relation
 * @method     ChildRolePermissionQuery innerJoinRole($relationAlias = null) Adds a INNER JOIN clause to the query using the Role relation
 *
 * @method     ChildRolePermissionQuery leftJoinPermission($relationAlias = null) Adds a LEFT JOIN clause to the query using the Permission relation
 * @method     ChildRolePermissionQuery rightJoinPermission($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Permission relation
 * @method     ChildRolePermissionQuery innerJoinPermission($relationAlias = null) Adds a INNER JOIN clause to the query using the Permission relation
 *
 * @method     \Alchemy\Component\Cerberus\Model\RoleQuery|\Alchemy\Component\Cerberus\Model\PermissionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRolePermission findOne(ConnectionInterface $con = null) Return the first ChildRolePermission matching the query
 * @method     ChildRolePermission findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRolePermission matching the query, or a new ChildRolePermission object populated from the query conditions when no match is found
 *
 * @method     ChildRolePermission findOneByRoleId(int $role_id) Return the first ChildRolePermission filtered by the role_id column
 * @method     ChildRolePermission findOneByPermissionId(int $permission_id) Return the first ChildRolePermission filtered by the permission_id column
 *
 * @method     ChildRolePermission[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRolePermission objects based on current ModelCriteria
 * @method     ChildRolePermission[]|ObjectCollection findByRoleId(int $role_id) Return ChildRolePermission objects filtered by the role_id column
 * @method     ChildRolePermission[]|ObjectCollection findByPermissionId(int $permission_id) Return ChildRolePermission objects filtered by the permission_id column
 * @method     ChildRolePermission[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RolePermissionQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Alchemy\Component\Cerberus\Model\Base\RolePermissionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Cerberus', $modelName = '\\Alchemy\\Component\\Cerberus\\Model\\RolePermission', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRolePermissionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRolePermissionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRolePermissionQuery) {
            return $criteria;
        }
        $query = new ChildRolePermissionQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$role_id, $permission_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRolePermission|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RolePermissionTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RolePermissionTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildRolePermission A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ROLE_ID, PERMISSION_ID FROM ROLE_PERMISSION WHERE ROLE_ID = :p0 AND PERMISSION_ID = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildRolePermission $obj */
            $obj = new ChildRolePermission();
            $obj->hydrate($row);
            RolePermissionTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildRolePermission|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RolePermissionTableMap::COL_ROLE_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RolePermissionTableMap::COL_PERMISSION_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RolePermissionTableMap::COL_ROLE_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RolePermissionTableMap::COL_PERMISSION_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the role_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRoleId(1234); // WHERE role_id = 1234
     * $query->filterByRoleId(array(12, 34)); // WHERE role_id IN (12, 34)
     * $query->filterByRoleId(array('min' => 12)); // WHERE role_id > 12
     * </code>
     *
     * @see       filterByRole()
     *
     * @param     mixed $roleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByRoleId($roleId = null, $comparison = null)
    {
        if (is_array($roleId)) {
            $useMinMax = false;
            if (isset($roleId['min'])) {
                $this->addUsingAlias(RolePermissionTableMap::COL_ROLE_ID, $roleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roleId['max'])) {
                $this->addUsingAlias(RolePermissionTableMap::COL_ROLE_ID, $roleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RolePermissionTableMap::COL_ROLE_ID, $roleId, $comparison);
    }

    /**
     * Filter the query on the permission_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPermissionId(1234); // WHERE permission_id = 1234
     * $query->filterByPermissionId(array(12, 34)); // WHERE permission_id IN (12, 34)
     * $query->filterByPermissionId(array('min' => 12)); // WHERE permission_id > 12
     * </code>
     *
     * @see       filterByPermission()
     *
     * @param     mixed $permissionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByPermissionId($permissionId = null, $comparison = null)
    {
        if (is_array($permissionId)) {
            $useMinMax = false;
            if (isset($permissionId['min'])) {
                $this->addUsingAlias(RolePermissionTableMap::COL_PERMISSION_ID, $permissionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($permissionId['max'])) {
                $this->addUsingAlias(RolePermissionTableMap::COL_PERMISSION_ID, $permissionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RolePermissionTableMap::COL_PERMISSION_ID, $permissionId, $comparison);
    }

    /**
     * Filter the query by a related \Alchemy\Component\Cerberus\Model\Role object
     *
     * @param \Alchemy\Component\Cerberus\Model\Role|ObjectCollection $role The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByRole($role, $comparison = null)
    {
        if ($role instanceof \Alchemy\Component\Cerberus\Model\Role) {
            return $this
                ->addUsingAlias(RolePermissionTableMap::COL_ROLE_ID, $role->getId(), $comparison);
        } elseif ($role instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RolePermissionTableMap::COL_ROLE_ID, $role->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRole() only accepts arguments of type \Alchemy\Component\Cerberus\Model\Role or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Role relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function joinRole($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Role');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Role');
        }

        return $this;
    }

    /**
     * Use the Role relation Role object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Alchemy\Component\Cerberus\Model\RoleQuery A secondary query class using the current class as primary query
     */
    public function useRoleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRole($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Role', '\Alchemy\Component\Cerberus\Model\RoleQuery');
    }

    /**
     * Filter the query by a related \Alchemy\Component\Cerberus\Model\Permission object
     *
     * @param \Alchemy\Component\Cerberus\Model\Permission|ObjectCollection $permission The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRolePermissionQuery The current query, for fluid interface
     */
    public function filterByPermission($permission, $comparison = null)
    {
        if ($permission instanceof \Alchemy\Component\Cerberus\Model\Permission) {
            return $this
                ->addUsingAlias(RolePermissionTableMap::COL_PERMISSION_ID, $permission->getId(), $comparison);
        } elseif ($permission instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RolePermissionTableMap::COL_PERMISSION_ID, $permission->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPermission() only accepts arguments of type \Alchemy\Component\Cerberus\Model\Permission or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Permission relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function joinPermission($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Permission');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Permission');
        }

        return $this;
    }

    /**
     * Use the Permission relation Permission object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Alchemy\Component\Cerberus\Model\PermissionQuery A secondary query class using the current class as primary query
     */
    public function usePermissionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPermission($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Permission', '\Alchemy\Component\Cerberus\Model\PermissionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRolePermission $rolePermission Object to remove from the list of results
     *
     * @return $this|ChildRolePermissionQuery The current query, for fluid interface
     */
    public function prune($rolePermission = null)
    {
        if ($rolePermission) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RolePermissionTableMap::COL_ROLE_ID), $rolePermission->getRoleId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RolePermissionTableMap::COL_PERMISSION_ID), $rolePermission->getPermissionId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ROLE_PERMISSION table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RolePermissionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RolePermissionTableMap::clearInstancePool();
            RolePermissionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RolePermissionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RolePermissionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RolePermissionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RolePermissionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RolePermissionQuery
