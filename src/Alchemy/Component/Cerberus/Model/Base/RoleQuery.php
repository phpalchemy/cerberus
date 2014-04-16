<?php

namespace Alchemy\Component\Cerberus\Model\Base;

use \Exception;
use \PDO;
use Alchemy\Component\Cerberus\Model\Role as ChildRole;
use Alchemy\Component\Cerberus\Model\RoleQuery as ChildRoleQuery;
use Alchemy\Component\Cerberus\Model\Map\RoleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'role' table.
 *
 *
 *
 * @method     ChildRoleQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRoleQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildRoleQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildRoleQuery orderByCreateDate($order = Criteria::ASC) Order by the create_date column
 * @method     ChildRoleQuery orderByUpdateDate($order = Criteria::ASC) Order by the update_date column
 * @method     ChildRoleQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildRoleQuery groupById() Group by the id column
 * @method     ChildRoleQuery groupByName() Group by the name column
 * @method     ChildRoleQuery groupByDescription() Group by the description column
 * @method     ChildRoleQuery groupByCreateDate() Group by the create_date column
 * @method     ChildRoleQuery groupByUpdateDate() Group by the update_date column
 * @method     ChildRoleQuery groupByStatus() Group by the status column
 *
 * @method     ChildRoleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRoleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRoleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRoleQuery leftJoinUserRole($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRole relation
 * @method     ChildRoleQuery rightJoinUserRole($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRole relation
 * @method     ChildRoleQuery innerJoinUserRole($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRole relation
 *
 * @method     ChildRoleQuery leftJoinRolePermission($relationAlias = null) Adds a LEFT JOIN clause to the query using the RolePermission relation
 * @method     ChildRoleQuery rightJoinRolePermission($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RolePermission relation
 * @method     ChildRoleQuery innerJoinRolePermission($relationAlias = null) Adds a INNER JOIN clause to the query using the RolePermission relation
 *
 * @method     \Alchemy\Component\Cerberus\Model\UserRoleQuery|\Alchemy\Component\Cerberus\Model\RolePermissionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRole findOne(ConnectionInterface $con = null) Return the first ChildRole matching the query
 * @method     ChildRole findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRole matching the query, or a new ChildRole object populated from the query conditions when no match is found
 *
 * @method     ChildRole findOneById(int $id) Return the first ChildRole filtered by the id column
 * @method     ChildRole findOneByName(string $name) Return the first ChildRole filtered by the name column
 * @method     ChildRole findOneByDescription(string $description) Return the first ChildRole filtered by the description column
 * @method     ChildRole findOneByCreateDate(string $create_date) Return the first ChildRole filtered by the create_date column
 * @method     ChildRole findOneByUpdateDate(string $update_date) Return the first ChildRole filtered by the update_date column
 * @method     ChildRole findOneByStatus(string $status) Return the first ChildRole filtered by the status column
 *
 * @method     ChildRole[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRole objects based on current ModelCriteria
 * @method     ChildRole[]|ObjectCollection findById(int $id) Return ChildRole objects filtered by the id column
 * @method     ChildRole[]|ObjectCollection findByName(string $name) Return ChildRole objects filtered by the name column
 * @method     ChildRole[]|ObjectCollection findByDescription(string $description) Return ChildRole objects filtered by the description column
 * @method     ChildRole[]|ObjectCollection findByCreateDate(string $create_date) Return ChildRole objects filtered by the create_date column
 * @method     ChildRole[]|ObjectCollection findByUpdateDate(string $update_date) Return ChildRole objects filtered by the update_date column
 * @method     ChildRole[]|ObjectCollection findByStatus(string $status) Return ChildRole objects filtered by the status column
 * @method     ChildRole[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RoleQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Alchemy\Component\Cerberus\Model\Base\RoleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cerberus', $modelName = '\\Alchemy\\Component\\Cerberus\\Model\\Role', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRoleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRoleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRoleQuery) {
            return $criteria;
        }
        $query = new ChildRoleQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRole|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RoleTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RoleTableMap::DATABASE_NAME);
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
     * @return ChildRole A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, NAME, DESCRIPTION, CREATE_DATE, UPDATE_DATE, STATUS FROM role WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildRole $obj */
            $obj = new ChildRole();
            $obj->hydrate($row);
            RoleTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildRole|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildRoleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RoleTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRoleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RoleTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoleQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RoleTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RoleTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoleTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoleQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RoleTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoleQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RoleTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the create_date column
     *
     * Example usage:
     * <code>
     * $query->filterByCreateDate('2011-03-14'); // WHERE create_date = '2011-03-14'
     * $query->filterByCreateDate('now'); // WHERE create_date = '2011-03-14'
     * $query->filterByCreateDate(array('max' => 'yesterday')); // WHERE create_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $createDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoleQuery The current query, for fluid interface
     */
    public function filterByCreateDate($createDate = null, $comparison = null)
    {
        if (is_array($createDate)) {
            $useMinMax = false;
            if (isset($createDate['min'])) {
                $this->addUsingAlias(RoleTableMap::COL_CREATE_DATE, $createDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createDate['max'])) {
                $this->addUsingAlias(RoleTableMap::COL_CREATE_DATE, $createDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoleTableMap::COL_CREATE_DATE, $createDate, $comparison);
    }

    /**
     * Filter the query on the update_date column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateDate('2011-03-14'); // WHERE update_date = '2011-03-14'
     * $query->filterByUpdateDate('now'); // WHERE update_date = '2011-03-14'
     * $query->filterByUpdateDate(array('max' => 'yesterday')); // WHERE update_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $updateDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoleQuery The current query, for fluid interface
     */
    public function filterByUpdateDate($updateDate = null, $comparison = null)
    {
        if (is_array($updateDate)) {
            $useMinMax = false;
            if (isset($updateDate['min'])) {
                $this->addUsingAlias(RoleTableMap::COL_UPDATE_DATE, $updateDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updateDate['max'])) {
                $this->addUsingAlias(RoleTableMap::COL_UPDATE_DATE, $updateDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RoleTableMap::COL_UPDATE_DATE, $updateDate, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%'); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRoleQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $status)) {
                $status = str_replace('*', '%', $status);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RoleTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \Alchemy\Component\Cerberus\Model\UserRole object
     *
     * @param \Alchemy\Component\Cerberus\Model\UserRole|ObjectCollection $userRole  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRoleQuery The current query, for fluid interface
     */
    public function filterByUserRole($userRole, $comparison = null)
    {
        if ($userRole instanceof \Alchemy\Component\Cerberus\Model\UserRole) {
            return $this
                ->addUsingAlias(RoleTableMap::COL_ID, $userRole->getRoleId(), $comparison);
        } elseif ($userRole instanceof ObjectCollection) {
            return $this
                ->useUserRoleQuery()
                ->filterByPrimaryKeys($userRole->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserRole() only accepts arguments of type \Alchemy\Component\Cerberus\Model\UserRole or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRole relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRoleQuery The current query, for fluid interface
     */
    public function joinUserRole($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRole');

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
            $this->addJoinObject($join, 'UserRole');
        }

        return $this;
    }

    /**
     * Use the UserRole relation UserRole object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Alchemy\Component\Cerberus\Model\UserRoleQuery A secondary query class using the current class as primary query
     */
    public function useUserRoleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserRole($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRole', '\Alchemy\Component\Cerberus\Model\UserRoleQuery');
    }

    /**
     * Filter the query by a related \Alchemy\Component\Cerberus\Model\RolePermission object
     *
     * @param \Alchemy\Component\Cerberus\Model\RolePermission|ObjectCollection $rolePermission  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRoleQuery The current query, for fluid interface
     */
    public function filterByRolePermission($rolePermission, $comparison = null)
    {
        if ($rolePermission instanceof \Alchemy\Component\Cerberus\Model\RolePermission) {
            return $this
                ->addUsingAlias(RoleTableMap::COL_ID, $rolePermission->getRoleId(), $comparison);
        } elseif ($rolePermission instanceof ObjectCollection) {
            return $this
                ->useRolePermissionQuery()
                ->filterByPrimaryKeys($rolePermission->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRolePermission() only accepts arguments of type \Alchemy\Component\Cerberus\Model\RolePermission or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RolePermission relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRoleQuery The current query, for fluid interface
     */
    public function joinRolePermission($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RolePermission');

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
            $this->addJoinObject($join, 'RolePermission');
        }

        return $this;
    }

    /**
     * Use the RolePermission relation RolePermission object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Alchemy\Component\Cerberus\Model\RolePermissionQuery A secondary query class using the current class as primary query
     */
    public function useRolePermissionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRolePermission($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RolePermission', '\Alchemy\Component\Cerberus\Model\RolePermissionQuery');
    }

    /**
     * Filter the query by a related User object
     * using the user_role table as cross reference
     *
     * @param User $user the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRoleQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useUserRoleQuery()
            ->filterByUser($user, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Permission object
     * using the role_permission table as cross reference
     *
     * @param Permission $permission the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRoleQuery The current query, for fluid interface
     */
    public function filterByPermission($permission, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRolePermissionQuery()
            ->filterByPermission($permission, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRole $role Object to remove from the list of results
     *
     * @return $this|ChildRoleQuery The current query, for fluid interface
     */
    public function prune($role = null)
    {
        if ($role) {
            $this->addUsingAlias(RoleTableMap::COL_ID, $role->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the role table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RoleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RoleTableMap::clearInstancePool();
            RoleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RoleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RoleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RoleTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RoleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RoleQuery
