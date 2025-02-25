<?php

namespace StockManager\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use StockManager\Model\StockOperationSourceStatus as ChildStockOperationSourceStatus;
use StockManager\Model\StockOperationSourceStatusQuery as ChildStockOperationSourceStatusQuery;
use StockManager\Model\Map\StockOperationSourceStatusTableMap;
use Thelia\Model\OrderStatus;

/**
 * Base class that represents a query for the 'stock_operation_source_status' table.
 *
 *
 *
 * @method     ChildStockOperationSourceStatusQuery orderByStockOperationId($order = Criteria::ASC) Order by the stock_operation_id column
 * @method     ChildStockOperationSourceStatusQuery orderBySourceStatusId($order = Criteria::ASC) Order by the source_status_id column
 *
 * @method     ChildStockOperationSourceStatusQuery groupByStockOperationId() Group by the stock_operation_id column
 * @method     ChildStockOperationSourceStatusQuery groupBySourceStatusId() Group by the source_status_id column
 *
 * @method     ChildStockOperationSourceStatusQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStockOperationSourceStatusQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStockOperationSourceStatusQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStockOperationSourceStatusQuery leftJoinStockOperation($relationAlias = null) Adds a LEFT JOIN clause to the query using the StockOperation relation
 * @method     ChildStockOperationSourceStatusQuery rightJoinStockOperation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StockOperation relation
 * @method     ChildStockOperationSourceStatusQuery innerJoinStockOperation($relationAlias = null) Adds a INNER JOIN clause to the query using the StockOperation relation
 *
 * @method     ChildStockOperationSourceStatusQuery leftJoinOrderStatus($relationAlias = null) Adds a LEFT JOIN clause to the query using the OrderStatus relation
 * @method     ChildStockOperationSourceStatusQuery rightJoinOrderStatus($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OrderStatus relation
 * @method     ChildStockOperationSourceStatusQuery innerJoinOrderStatus($relationAlias = null) Adds a INNER JOIN clause to the query using the OrderStatus relation
 *
 * @method     ChildStockOperationSourceStatus findOne(ConnectionInterface $con = null) Return the first ChildStockOperationSourceStatus matching the query
 * @method     ChildStockOperationSourceStatus findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStockOperationSourceStatus matching the query, or a new ChildStockOperationSourceStatus object populated from the query conditions when no match is found
 *
 * @method     ChildStockOperationSourceStatus findOneByStockOperationId(int $stock_operation_id) Return the first ChildStockOperationSourceStatus filtered by the stock_operation_id column
 * @method     ChildStockOperationSourceStatus findOneBySourceStatusId(int $source_status_id) Return the first ChildStockOperationSourceStatus filtered by the source_status_id column
 *
 * @method     array findByStockOperationId(int $stock_operation_id) Return ChildStockOperationSourceStatus objects filtered by the stock_operation_id column
 * @method     array findBySourceStatusId(int $source_status_id) Return ChildStockOperationSourceStatus objects filtered by the source_status_id column
 *
 */
abstract class StockOperationSourceStatusQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \StockManager\Model\Base\StockOperationSourceStatusQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\StockManager\\Model\\StockOperationSourceStatus', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStockOperationSourceStatusQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStockOperationSourceStatusQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \StockManager\Model\StockOperationSourceStatusQuery) {
            return $criteria;
        }
        $query = new \StockManager\Model\StockOperationSourceStatusQuery();
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
     * @param array[$stock_operation_id, $source_status_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildStockOperationSourceStatus|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StockOperationSourceStatusTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StockOperationSourceStatusTableMap::DATABASE_NAME);
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
     * @return   ChildStockOperationSourceStatus A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT STOCK_OPERATION_ID, SOURCE_STATUS_ID FROM stock_operation_source_status WHERE STOCK_OPERATION_ID = :p0 AND SOURCE_STATUS_ID = :p1';
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
            $obj = new ChildStockOperationSourceStatus();
            $obj->hydrate($row);
            StockOperationSourceStatusTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildStockOperationSourceStatus|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return ChildStockOperationSourceStatusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(StockOperationSourceStatusTableMap::STOCK_OPERATION_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(StockOperationSourceStatusTableMap::SOURCE_STATUS_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildStockOperationSourceStatusQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(StockOperationSourceStatusTableMap::STOCK_OPERATION_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(StockOperationSourceStatusTableMap::SOURCE_STATUS_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the stock_operation_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStockOperationId(1234); // WHERE stock_operation_id = 1234
     * $query->filterByStockOperationId(array(12, 34)); // WHERE stock_operation_id IN (12, 34)
     * $query->filterByStockOperationId(array('min' => 12)); // WHERE stock_operation_id > 12
     * </code>
     *
     * @see       filterByStockOperation()
     *
     * @param     mixed $stockOperationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockOperationSourceStatusQuery The current query, for fluid interface
     */
    public function filterByStockOperationId($stockOperationId = null, $comparison = null)
    {
        if (is_array($stockOperationId)) {
            $useMinMax = false;
            if (isset($stockOperationId['min'])) {
                $this->addUsingAlias(StockOperationSourceStatusTableMap::STOCK_OPERATION_ID, $stockOperationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stockOperationId['max'])) {
                $this->addUsingAlias(StockOperationSourceStatusTableMap::STOCK_OPERATION_ID, $stockOperationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockOperationSourceStatusTableMap::STOCK_OPERATION_ID, $stockOperationId, $comparison);
    }

    /**
     * Filter the query on the source_status_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySourceStatusId(1234); // WHERE source_status_id = 1234
     * $query->filterBySourceStatusId(array(12, 34)); // WHERE source_status_id IN (12, 34)
     * $query->filterBySourceStatusId(array('min' => 12)); // WHERE source_status_id > 12
     * </code>
     *
     * @see       filterByOrderStatus()
     *
     * @param     mixed $sourceStatusId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockOperationSourceStatusQuery The current query, for fluid interface
     */
    public function filterBySourceStatusId($sourceStatusId = null, $comparison = null)
    {
        if (is_array($sourceStatusId)) {
            $useMinMax = false;
            if (isset($sourceStatusId['min'])) {
                $this->addUsingAlias(StockOperationSourceStatusTableMap::SOURCE_STATUS_ID, $sourceStatusId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sourceStatusId['max'])) {
                $this->addUsingAlias(StockOperationSourceStatusTableMap::SOURCE_STATUS_ID, $sourceStatusId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StockOperationSourceStatusTableMap::SOURCE_STATUS_ID, $sourceStatusId, $comparison);
    }

    /**
     * Filter the query by a related \StockManager\Model\StockOperation object
     *
     * @param \StockManager\Model\StockOperation|ObjectCollection $stockOperation The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockOperationSourceStatusQuery The current query, for fluid interface
     */
    public function filterByStockOperation($stockOperation, $comparison = null)
    {
        if ($stockOperation instanceof \StockManager\Model\StockOperation) {
            return $this
                ->addUsingAlias(StockOperationSourceStatusTableMap::STOCK_OPERATION_ID, $stockOperation->getId(), $comparison);
        } elseif ($stockOperation instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StockOperationSourceStatusTableMap::STOCK_OPERATION_ID, $stockOperation->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByStockOperation() only accepts arguments of type \StockManager\Model\StockOperation or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StockOperation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildStockOperationSourceStatusQuery The current query, for fluid interface
     */
    public function joinStockOperation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StockOperation');

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
            $this->addJoinObject($join, 'StockOperation');
        }

        return $this;
    }

    /**
     * Use the StockOperation relation StockOperation object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \StockManager\Model\StockOperationQuery A secondary query class using the current class as primary query
     */
    public function useStockOperationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStockOperation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StockOperation', '\StockManager\Model\StockOperationQuery');
    }

    /**
     * Filter the query by a related \Thelia\Model\OrderStatus object
     *
     * @param \Thelia\Model\OrderStatus|ObjectCollection $orderStatus The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStockOperationSourceStatusQuery The current query, for fluid interface
     */
    public function filterByOrderStatus($orderStatus, $comparison = null)
    {
        if ($orderStatus instanceof \Thelia\Model\OrderStatus) {
            return $this
                ->addUsingAlias(StockOperationSourceStatusTableMap::SOURCE_STATUS_ID, $orderStatus->getId(), $comparison);
        } elseif ($orderStatus instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StockOperationSourceStatusTableMap::SOURCE_STATUS_ID, $orderStatus->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOrderStatus() only accepts arguments of type \Thelia\Model\OrderStatus or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OrderStatus relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildStockOperationSourceStatusQuery The current query, for fluid interface
     */
    public function joinOrderStatus($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OrderStatus');

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
            $this->addJoinObject($join, 'OrderStatus');
        }

        return $this;
    }

    /**
     * Use the OrderStatus relation OrderStatus object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\OrderStatusQuery A secondary query class using the current class as primary query
     */
    public function useOrderStatusQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrderStatus($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OrderStatus', '\Thelia\Model\OrderStatusQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildStockOperationSourceStatus $stockOperationSourceStatus Object to remove from the list of results
     *
     * @return ChildStockOperationSourceStatusQuery The current query, for fluid interface
     */
    public function prune($stockOperationSourceStatus = null)
    {
        if ($stockOperationSourceStatus) {
            $this->addCond('pruneCond0', $this->getAliasedColName(StockOperationSourceStatusTableMap::STOCK_OPERATION_ID), $stockOperationSourceStatus->getStockOperationId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(StockOperationSourceStatusTableMap::SOURCE_STATUS_ID), $stockOperationSourceStatus->getSourceStatusId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the stock_operation_source_status table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StockOperationSourceStatusTableMap::DATABASE_NAME);
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
            StockOperationSourceStatusTableMap::clearInstancePool();
            StockOperationSourceStatusTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildStockOperationSourceStatus or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildStockOperationSourceStatus object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(StockOperationSourceStatusTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StockOperationSourceStatusTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        StockOperationSourceStatusTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StockOperationSourceStatusTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // StockOperationSourceStatusQuery
