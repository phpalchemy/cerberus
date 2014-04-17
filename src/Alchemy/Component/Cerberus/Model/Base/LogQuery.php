<?php

namespace Alchemy\Component\Cerberus\Model\Base;

use \Exception;
use \PDO;
use Alchemy\Component\Cerberus\Model\Log as ChildLog;
use Alchemy\Component\Cerberus\Model\LogQuery as ChildLogQuery;
use Alchemy\Component\Cerberus\Model\Map\LogTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'log' table.
 *
 *
 *
 * @method     ChildLogQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildLogQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildLogQuery orderByDateTime($order = Criteria::ASC) Order by the date_time column
 * @method     ChildLogQuery orderByLogText($order = Criteria::ASC) Order by the log_text column
 * @method     ChildLogQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildLogQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildLogQuery orderBySessionId($order = Criteria::ASC) Order by the session_id column
 * @method     ChildLogQuery orderByClientAddress($order = Criteria::ASC) Order by the client_address column
 * @method     ChildLogQuery orderByClientIp($order = Criteria::ASC) Order by the client_ip column
 * @method     ChildLogQuery orderByClientAgent($order = Criteria::ASC) Order by the client_agent column
 * @method     ChildLogQuery orderByClientPlatform($order = Criteria::ASC) Order by the client_platform column
 *
 * @method     ChildLogQuery groupById() Group by the id column
 * @method     ChildLogQuery groupByType() Group by the type column
 * @method     ChildLogQuery groupByDateTime() Group by the date_time column
 * @method     ChildLogQuery groupByLogText() Group by the log_text column
 * @method     ChildLogQuery groupByUserId() Group by the user_id column
 * @method     ChildLogQuery groupByUsername() Group by the username column
 * @method     ChildLogQuery groupBySessionId() Group by the session_id column
 * @method     ChildLogQuery groupByClientAddress() Group by the client_address column
 * @method     ChildLogQuery groupByClientIp() Group by the client_ip column
 * @method     ChildLogQuery groupByClientAgent() Group by the client_agent column
 * @method     ChildLogQuery groupByClientPlatform() Group by the client_platform column
 *
 * @method     ChildLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLog findOne(ConnectionInterface $con = null) Return the first ChildLog matching the query
 * @method     ChildLog findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLog matching the query, or a new ChildLog object populated from the query conditions when no match is found
 *
 * @method     ChildLog findOneById(int $id) Return the first ChildLog filtered by the id column
 * @method     ChildLog findOneByType(string $type) Return the first ChildLog filtered by the type column
 * @method     ChildLog findOneByDateTime(string $date_time) Return the first ChildLog filtered by the date_time column
 * @method     ChildLog findOneByLogText(string $log_text) Return the first ChildLog filtered by the log_text column
 * @method     ChildLog findOneByUserId(string $user_id) Return the first ChildLog filtered by the user_id column
 * @method     ChildLog findOneByUsername(string $username) Return the first ChildLog filtered by the username column
 * @method     ChildLog findOneBySessionId(string $session_id) Return the first ChildLog filtered by the session_id column
 * @method     ChildLog findOneByClientAddress(string $client_address) Return the first ChildLog filtered by the client_address column
 * @method     ChildLog findOneByClientIp(string $client_ip) Return the first ChildLog filtered by the client_ip column
 * @method     ChildLog findOneByClientAgent(string $client_agent) Return the first ChildLog filtered by the client_agent column
 * @method     ChildLog findOneByClientPlatform(string $client_platform) Return the first ChildLog filtered by the client_platform column
 *
 * @method     ChildLog[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildLog objects based on current ModelCriteria
 * @method     ChildLog[]|ObjectCollection findById(int $id) Return ChildLog objects filtered by the id column
 * @method     ChildLog[]|ObjectCollection findByType(string $type) Return ChildLog objects filtered by the type column
 * @method     ChildLog[]|ObjectCollection findByDateTime(string $date_time) Return ChildLog objects filtered by the date_time column
 * @method     ChildLog[]|ObjectCollection findByLogText(string $log_text) Return ChildLog objects filtered by the log_text column
 * @method     ChildLog[]|ObjectCollection findByUserId(string $user_id) Return ChildLog objects filtered by the user_id column
 * @method     ChildLog[]|ObjectCollection findByUsername(string $username) Return ChildLog objects filtered by the username column
 * @method     ChildLog[]|ObjectCollection findBySessionId(string $session_id) Return ChildLog objects filtered by the session_id column
 * @method     ChildLog[]|ObjectCollection findByClientAddress(string $client_address) Return ChildLog objects filtered by the client_address column
 * @method     ChildLog[]|ObjectCollection findByClientIp(string $client_ip) Return ChildLog objects filtered by the client_ip column
 * @method     ChildLog[]|ObjectCollection findByClientAgent(string $client_agent) Return ChildLog objects filtered by the client_agent column
 * @method     ChildLog[]|ObjectCollection findByClientPlatform(string $client_platform) Return ChildLog objects filtered by the client_platform column
 * @method     ChildLog[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class LogQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Alchemy\Component\Cerberus\Model\Base\LogQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cerberus', $modelName = '\\Alchemy\\Component\\Cerberus\\Model\\Log', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLogQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildLogQuery) {
            return $criteria;
        }
        $query = new ChildLogQuery();
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
     * @return ChildLog|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = LogTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LogTableMap::DATABASE_NAME);
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
     * @return ChildLog A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ID, TYPE, DATE_TIME, LOG_TEXT, USER_ID, USERNAME, SESSION_ID, CLIENT_ADDRESS, CLIENT_IP, CLIENT_AGENT, CLIENT_PLATFORM FROM log WHERE ID = :p0';
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
            /** @var ChildLog $obj */
            $obj = new ChildLog();
            $obj->hydrate($row);
            LogTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildLog|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LogTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LogTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(LogTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(LogTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildLogQuery The current query, for fluid interface
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

        return $this->addUsingAlias(LogTableMap::COL_TYPE, $type, $comparison);
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
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterByDateTime($dateTime = null, $comparison = null)
    {
        if (is_array($dateTime)) {
            $useMinMax = false;
            if (isset($dateTime['min'])) {
                $this->addUsingAlias(LogTableMap::COL_DATE_TIME, $dateTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateTime['max'])) {
                $this->addUsingAlias(LogTableMap::COL_DATE_TIME, $dateTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogTableMap::COL_DATE_TIME, $dateTime, $comparison);
    }

    /**
     * Filter the query on the log_text column
     *
     * Example usage:
     * <code>
     * $query->filterByLogText('fooValue');   // WHERE log_text = 'fooValue'
     * $query->filterByLogText('%fooValue%'); // WHERE log_text LIKE '%fooValue%'
     * </code>
     *
     * @param     string $logText The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterByLogText($logText = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($logText)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $logText)) {
                $logText = str_replace('*', '%', $logText);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LogTableMap::COL_LOG_TEXT, $logText, $comparison);
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
     * @return $this|ChildLogQuery The current query, for fluid interface
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

        return $this->addUsingAlias(LogTableMap::COL_USER_ID, $userId, $comparison);
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
     * @return $this|ChildLogQuery The current query, for fluid interface
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

        return $this->addUsingAlias(LogTableMap::COL_USERNAME, $username, $comparison);
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
     * @return $this|ChildLogQuery The current query, for fluid interface
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

        return $this->addUsingAlias(LogTableMap::COL_SESSION_ID, $sessionId, $comparison);
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
     * @return $this|ChildLogQuery The current query, for fluid interface
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

        return $this->addUsingAlias(LogTableMap::COL_CLIENT_ADDRESS, $clientAddress, $comparison);
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
     * @return $this|ChildLogQuery The current query, for fluid interface
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

        return $this->addUsingAlias(LogTableMap::COL_CLIENT_IP, $clientIp, $comparison);
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
     * @return $this|ChildLogQuery The current query, for fluid interface
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

        return $this->addUsingAlias(LogTableMap::COL_CLIENT_AGENT, $clientAgent, $comparison);
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
     * @return $this|ChildLogQuery The current query, for fluid interface
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

        return $this->addUsingAlias(LogTableMap::COL_CLIENT_PLATFORM, $clientPlatform, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildLog $log Object to remove from the list of results
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function prune($log = null)
    {
        if ($log) {
            $this->addUsingAlias(LogTableMap::COL_ID, $log->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LogTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LogTableMap::clearInstancePool();
            LogTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(LogTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LogTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            LogTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            LogTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // LogQuery
