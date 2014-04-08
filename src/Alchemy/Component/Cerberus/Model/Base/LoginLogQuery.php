<?php

namespace Alchemy\Component\Cerberus\Model\Base;

use \Exception;
use \PDO;
use Alchemy\Component\Cerberus\Model\LoginLog as ChildLoginLog;
use Alchemy\Component\Cerberus\Model\LoginLogQuery as ChildLoginLogQuery;
use Alchemy\Component\Cerberus\Model\Map\LoginLogTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'login_log' table.
 *
 *
 *
 * @method     ChildLoginLogQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildLoginLogQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildLoginLogQuery orderByDateTime($order = Criteria::ASC) Order by the date_time column
 * @method     ChildLoginLogQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildLoginLogQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildLoginLogQuery orderBySessionId($order = Criteria::ASC) Order by the session_id column
 * @method     ChildLoginLogQuery orderByClientAddress($order = Criteria::ASC) Order by the client_address column
 * @method     ChildLoginLogQuery orderByClientIp($order = Criteria::ASC) Order by the client_ip column
 * @method     ChildLoginLogQuery orderByClientAgent($order = Criteria::ASC) Order by the client_agent column
 * @method     ChildLoginLogQuery orderByClientPlatform($order = Criteria::ASC) Order by the client_platform column
 *
 * @method     ChildLoginLogQuery groupById() Group by the id column
 * @method     ChildLoginLogQuery groupByType() Group by the type column
 * @method     ChildLoginLogQuery groupByDateTime() Group by the date_time column
 * @method     ChildLoginLogQuery groupByUserId() Group by the user_id column
 * @method     ChildLoginLogQuery groupByUsername() Group by the username column
 * @method     ChildLoginLogQuery groupBySessionId() Group by the session_id column
 * @method     ChildLoginLogQuery groupByClientAddress() Group by the client_address column
 * @method     ChildLoginLogQuery groupByClientIp() Group by the client_ip column
 * @method     ChildLoginLogQuery groupByClientAgent() Group by the client_agent column
 * @method     ChildLoginLogQuery groupByClientPlatform() Group by the client_platform column
 *
 * @method     ChildLoginLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLoginLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLoginLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLoginLog findOne(ConnectionInterface $con = null) Return the first ChildLoginLog matching the query
 * @method     ChildLoginLog findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLoginLog matching the query, or a new ChildLoginLog object populated from the query conditions when no match is found
 *
 * @method     ChildLoginLog findOneById(int $id) Return the first ChildLoginLog filtered by the id column
 * @method     ChildLoginLog findOneByType(string $type) Return the first ChildLoginLog filtered by the type column
 * @method     ChildLoginLog findOneByDateTime(string $date_time) Return the first ChildLoginLog filtered by the date_time column
 * @method     ChildLoginLog findOneByUserId(string $user_id) Return the first ChildLoginLog filtered by the user_id column
 * @method     ChildLoginLog findOneByUsername(string $username) Return the first ChildLoginLog filtered by the username column
 * @method     ChildLoginLog findOneBySessionId(string $session_id) Return the first ChildLoginLog filtered by the session_id column
 * @method     ChildLoginLog findOneByClientAddress(string $client_address) Return the first ChildLoginLog filtered by the client_address column
 * @method     ChildLoginLog findOneByClientIp(string $client_ip) Return the first ChildLoginLog filtered by the client_ip column
 * @method     ChildLoginLog findOneByClientAgent(string $client_agent) Return the first ChildLoginLog filtered by the client_agent column
 * @method     ChildLoginLog findOneByClientPlatform(string $client_platform) Return the first ChildLoginLog filtered by the client_platform column
 *
 * @method     array findById(int $id) Return ChildLoginLog objects filtered by the id column
 * @method     array findByType(string $type) Return ChildLoginLog objects filtered by the type column
 * @method     array findByDateTime(string $date_time) Return ChildLoginLog objects filtered by the date_time column
 * @method     array findByUserId(string $user_id) Return ChildLoginLog objects filtered by the user_id column
 * @method     array findByUsername(string $username) Return ChildLoginLog objects filtered by the username column
 * @method     array findBySessionId(string $session_id) Return ChildLoginLog objects filtered by the session_id column
 * @method     array findByClientAddress(string $client_address) Return ChildLoginLog objects filtered by the client_address column
 * @method     array findByClientIp(string $client_ip) Return ChildLoginLog objects filtered by the client_ip column
 * @method     array findByClientAgent(string $client_agent) Return ChildLoginLog objects filtered by the client_agent column
 * @method     array findByClientPlatform(string $client_platform) Return ChildLoginLog objects filtered by the client_platform column
 *
 */
abstract class LoginLogQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Alchemy\Component\Cerberus\Model\Base\LoginLogQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cerberus', $modelName = '\\Alchemy\\Component\\Cerberus\\Model\\LoginLog', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLoginLogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLoginLogQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Alchemy\Component\Cerberus\Model\LoginLogQuery) {
            return $criteria;
        }
        $query = new \Alchemy\Component\Cerberus\Model\LoginLogQuery();
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
     * @return ChildLoginLog|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = LoginLogTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LoginLogTableMap::DATABASE_NAME);
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
     * @return   ChildLoginLog A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, TYPE, DATE_TIME, USER_ID, USERNAME, SESSION_ID, CLIENT_ADDRESS, CLIENT_IP, CLIENT_AGENT, CLIENT_PLATFORM FROM login_log WHERE ID = :p0';
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
            $obj = new ChildLoginLog();
            $obj->hydrate($row);
            LoginLogTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildLoginLog|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
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
    public function findPks($keys, $con = null)
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
     * @return ChildLoginLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LoginLogTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildLoginLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LoginLogTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildLoginLogQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(LoginLogTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(LoginLogTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LoginLogTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%'); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLoginLogQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type)) {
                $type = str_replace('*', '%', $type);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LoginLogTableMap::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the date_time column
     *
     * Example usage:
     * <code>
     * $query->filterByDateTime('2011-03-14'); // WHERE date_time = '2011-03-14'
     * $query->filterByDateTime('now'); // WHERE date_time = '2011-03-14'
     * $query->filterByDateTime(array('max' => 'yesterday')); // WHERE date_time > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateTime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLoginLogQuery The current query, for fluid interface
     */
    public function filterByDateTime($dateTime = null, $comparison = null)
    {
        if (is_array($dateTime)) {
            $useMinMax = false;
            if (isset($dateTime['min'])) {
                $this->addUsingAlias(LoginLogTableMap::DATE_TIME, $dateTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateTime['max'])) {
                $this->addUsingAlias(LoginLogTableMap::DATE_TIME, $dateTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LoginLogTableMap::DATE_TIME, $dateTime, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId('fooValue');   // WHERE user_id = 'fooValue'
     * $query->filterByUserId('%fooValue%'); // WHERE user_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLoginLogQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userId)) {
                $userId = str_replace('*', '%', $userId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LoginLogTableMap::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%'); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLoginLogQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $username)) {
                $username = str_replace('*', '%', $username);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LoginLogTableMap::USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the session_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySessionId('fooValue');   // WHERE session_id = 'fooValue'
     * $query->filterBySessionId('%fooValue%'); // WHERE session_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sessionId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLoginLogQuery The current query, for fluid interface
     */
    public function filterBySessionId($sessionId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sessionId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sessionId)) {
                $sessionId = str_replace('*', '%', $sessionId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LoginLogTableMap::SESSION_ID, $sessionId, $comparison);
    }

    /**
     * Filter the query on the client_address column
     *
     * Example usage:
     * <code>
     * $query->filterByClientAddress('fooValue');   // WHERE client_address = 'fooValue'
     * $query->filterByClientAddress('%fooValue%'); // WHERE client_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $clientAddress The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLoginLogQuery The current query, for fluid interface
     */
    public function filterByClientAddress($clientAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($clientAddress)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $clientAddress)) {
                $clientAddress = str_replace('*', '%', $clientAddress);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LoginLogTableMap::CLIENT_ADDRESS, $clientAddress, $comparison);
    }

    /**
     * Filter the query on the client_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByClientIp('fooValue');   // WHERE client_ip = 'fooValue'
     * $query->filterByClientIp('%fooValue%'); // WHERE client_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $clientIp The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLoginLogQuery The current query, for fluid interface
     */
    public function filterByClientIp($clientIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($clientIp)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $clientIp)) {
                $clientIp = str_replace('*', '%', $clientIp);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LoginLogTableMap::CLIENT_IP, $clientIp, $comparison);
    }

    /**
     * Filter the query on the client_agent column
     *
     * Example usage:
     * <code>
     * $query->filterByClientAgent('fooValue');   // WHERE client_agent = 'fooValue'
     * $query->filterByClientAgent('%fooValue%'); // WHERE client_agent LIKE '%fooValue%'
     * </code>
     *
     * @param     string $clientAgent The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLoginLogQuery The current query, for fluid interface
     */
    public function filterByClientAgent($clientAgent = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($clientAgent)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $clientAgent)) {
                $clientAgent = str_replace('*', '%', $clientAgent);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LoginLogTableMap::CLIENT_AGENT, $clientAgent, $comparison);
    }

    /**
     * Filter the query on the client_platform column
     *
     * Example usage:
     * <code>
     * $query->filterByClientPlatform('fooValue');   // WHERE client_platform = 'fooValue'
     * $query->filterByClientPlatform('%fooValue%'); // WHERE client_platform LIKE '%fooValue%'
     * </code>
     *
     * @param     string $clientPlatform The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLoginLogQuery The current query, for fluid interface
     */
    public function filterByClientPlatform($clientPlatform = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($clientPlatform)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $clientPlatform)) {
                $clientPlatform = str_replace('*', '%', $clientPlatform);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LoginLogTableMap::CLIENT_PLATFORM, $clientPlatform, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildLoginLog $loginLog Object to remove from the list of results
     *
     * @return ChildLoginLogQuery The current query, for fluid interface
     */
    public function prune($loginLog = null)
    {
        if ($loginLog) {
            $this->addUsingAlias(LoginLogTableMap::ID, $loginLog->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the login_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LoginLogTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LoginLogTableMap::clearInstancePool();
            LoginLogTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildLoginLog or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildLoginLog object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LoginLogTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LoginLogTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        LoginLogTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            LoginLogTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // LoginLogQuery
