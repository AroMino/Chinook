<?php

namespace Chinook\Models\Base;

use \Exception;
use \PDO;
use Chinook\Models\InvoiceLine as ChildInvoiceLine;
use Chinook\Models\InvoiceLineQuery as ChildInvoiceLineQuery;
use Chinook\Models\Map\InvoiceLineTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `invoice_line` table.
 *
 * @method     ChildInvoiceLineQuery orderByInvoiceLineId($order = Criteria::ASC) Order by the invoice_line_id column
 * @method     ChildInvoiceLineQuery orderByInvoiceId($order = Criteria::ASC) Order by the invoice_id column
 * @method     ChildInvoiceLineQuery orderByTrackId($order = Criteria::ASC) Order by the track_id column
 * @method     ChildInvoiceLineQuery orderByUnitPrice($order = Criteria::ASC) Order by the unit_price column
 * @method     ChildInvoiceLineQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 *
 * @method     ChildInvoiceLineQuery groupByInvoiceLineId() Group by the invoice_line_id column
 * @method     ChildInvoiceLineQuery groupByInvoiceId() Group by the invoice_id column
 * @method     ChildInvoiceLineQuery groupByTrackId() Group by the track_id column
 * @method     ChildInvoiceLineQuery groupByUnitPrice() Group by the unit_price column
 * @method     ChildInvoiceLineQuery groupByQuantity() Group by the quantity column
 *
 * @method     ChildInvoiceLineQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInvoiceLineQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInvoiceLineQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInvoiceLineQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildInvoiceLineQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildInvoiceLineQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildInvoiceLineQuery leftJoinInvoice($relationAlias = null) Adds a LEFT JOIN clause to the query using the Invoice relation
 * @method     ChildInvoiceLineQuery rightJoinInvoice($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Invoice relation
 * @method     ChildInvoiceLineQuery innerJoinInvoice($relationAlias = null) Adds a INNER JOIN clause to the query using the Invoice relation
 *
 * @method     ChildInvoiceLineQuery joinWithInvoice($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Invoice relation
 *
 * @method     ChildInvoiceLineQuery leftJoinWithInvoice() Adds a LEFT JOIN clause and with to the query using the Invoice relation
 * @method     ChildInvoiceLineQuery rightJoinWithInvoice() Adds a RIGHT JOIN clause and with to the query using the Invoice relation
 * @method     ChildInvoiceLineQuery innerJoinWithInvoice() Adds a INNER JOIN clause and with to the query using the Invoice relation
 *
 * @method     ChildInvoiceLineQuery leftJoinTrack($relationAlias = null) Adds a LEFT JOIN clause to the query using the Track relation
 * @method     ChildInvoiceLineQuery rightJoinTrack($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Track relation
 * @method     ChildInvoiceLineQuery innerJoinTrack($relationAlias = null) Adds a INNER JOIN clause to the query using the Track relation
 *
 * @method     ChildInvoiceLineQuery joinWithTrack($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Track relation
 *
 * @method     ChildInvoiceLineQuery leftJoinWithTrack() Adds a LEFT JOIN clause and with to the query using the Track relation
 * @method     ChildInvoiceLineQuery rightJoinWithTrack() Adds a RIGHT JOIN clause and with to the query using the Track relation
 * @method     ChildInvoiceLineQuery innerJoinWithTrack() Adds a INNER JOIN clause and with to the query using the Track relation
 *
 * @method     \Chinook\Models\InvoiceQuery|\Chinook\Models\TrackQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInvoiceLine|null findOne(?ConnectionInterface $con = null) Return the first ChildInvoiceLine matching the query
 * @method     ChildInvoiceLine findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildInvoiceLine matching the query, or a new ChildInvoiceLine object populated from the query conditions when no match is found
 *
 * @method     ChildInvoiceLine|null findOneByInvoiceLineId(int $invoice_line_id) Return the first ChildInvoiceLine filtered by the invoice_line_id column
 * @method     ChildInvoiceLine|null findOneByInvoiceId(int $invoice_id) Return the first ChildInvoiceLine filtered by the invoice_id column
 * @method     ChildInvoiceLine|null findOneByTrackId(int $track_id) Return the first ChildInvoiceLine filtered by the track_id column
 * @method     ChildInvoiceLine|null findOneByUnitPrice(string $unit_price) Return the first ChildInvoiceLine filtered by the unit_price column
 * @method     ChildInvoiceLine|null findOneByQuantity(int $quantity) Return the first ChildInvoiceLine filtered by the quantity column
 *
 * @method     ChildInvoiceLine requirePk($key, ?ConnectionInterface $con = null) Return the ChildInvoiceLine by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoiceLine requireOne(?ConnectionInterface $con = null) Return the first ChildInvoiceLine matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvoiceLine requireOneByInvoiceLineId(int $invoice_line_id) Return the first ChildInvoiceLine filtered by the invoice_line_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoiceLine requireOneByInvoiceId(int $invoice_id) Return the first ChildInvoiceLine filtered by the invoice_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoiceLine requireOneByTrackId(int $track_id) Return the first ChildInvoiceLine filtered by the track_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoiceLine requireOneByUnitPrice(string $unit_price) Return the first ChildInvoiceLine filtered by the unit_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoiceLine requireOneByQuantity(int $quantity) Return the first ChildInvoiceLine filtered by the quantity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvoiceLine[]|Collection find(?ConnectionInterface $con = null) Return ChildInvoiceLine objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildInvoiceLine> find(?ConnectionInterface $con = null) Return ChildInvoiceLine objects based on current ModelCriteria
 *
 * @method     ChildInvoiceLine[]|Collection findByInvoiceLineId(int|array<int> $invoice_line_id) Return ChildInvoiceLine objects filtered by the invoice_line_id column
 * @psalm-method Collection&\Traversable<ChildInvoiceLine> findByInvoiceLineId(int|array<int> $invoice_line_id) Return ChildInvoiceLine objects filtered by the invoice_line_id column
 * @method     ChildInvoiceLine[]|Collection findByInvoiceId(int|array<int> $invoice_id) Return ChildInvoiceLine objects filtered by the invoice_id column
 * @psalm-method Collection&\Traversable<ChildInvoiceLine> findByInvoiceId(int|array<int> $invoice_id) Return ChildInvoiceLine objects filtered by the invoice_id column
 * @method     ChildInvoiceLine[]|Collection findByTrackId(int|array<int> $track_id) Return ChildInvoiceLine objects filtered by the track_id column
 * @psalm-method Collection&\Traversable<ChildInvoiceLine> findByTrackId(int|array<int> $track_id) Return ChildInvoiceLine objects filtered by the track_id column
 * @method     ChildInvoiceLine[]|Collection findByUnitPrice(string|array<string> $unit_price) Return ChildInvoiceLine objects filtered by the unit_price column
 * @psalm-method Collection&\Traversable<ChildInvoiceLine> findByUnitPrice(string|array<string> $unit_price) Return ChildInvoiceLine objects filtered by the unit_price column
 * @method     ChildInvoiceLine[]|Collection findByQuantity(int|array<int> $quantity) Return ChildInvoiceLine objects filtered by the quantity column
 * @psalm-method Collection&\Traversable<ChildInvoiceLine> findByQuantity(int|array<int> $quantity) Return ChildInvoiceLine objects filtered by the quantity column
 *
 * @method     ChildInvoiceLine[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildInvoiceLine> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class InvoiceLineQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Chinook\Models\Base\InvoiceLineQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Chinook\\Models\\InvoiceLine', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInvoiceLineQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInvoiceLineQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildInvoiceLineQuery) {
            return $criteria;
        }
        $query = new ChildInvoiceLineQuery();
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
     * @return ChildInvoiceLine|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InvoiceLineTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = InvoiceLineTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInvoiceLine A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT invoice_line_id, invoice_id, track_id, unit_price, quantity FROM invoice_line WHERE invoice_line_id = :p0';
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
            /** @var ChildInvoiceLine $obj */
            $obj = new ChildInvoiceLine();
            $obj->hydrate($row);
            InvoiceLineTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildInvoiceLine|array|mixed the result, formatted by the current formatter
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
     * @param array $keys Primary keys to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return Collection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
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
     * @param mixed $key Primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        $this->addUsingAlias(InvoiceLineTableMap::COL_INVOICE_LINE_ID, $key, Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array|int $keys The list of primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        $this->addUsingAlias(InvoiceLineTableMap::COL_INVOICE_LINE_ID, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the invoice_line_id column
     *
     * Example usage:
     * <code>
     * $query->filterByInvoiceLineId(1234); // WHERE invoice_line_id = 1234
     * $query->filterByInvoiceLineId(array(12, 34)); // WHERE invoice_line_id IN (12, 34)
     * $query->filterByInvoiceLineId(array('min' => 12)); // WHERE invoice_line_id > 12
     * </code>
     *
     * @param mixed $invoiceLineId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByInvoiceLineId($invoiceLineId = null, ?string $comparison = null)
    {
        if (is_array($invoiceLineId)) {
            $useMinMax = false;
            if (isset($invoiceLineId['min'])) {
                $this->addUsingAlias(InvoiceLineTableMap::COL_INVOICE_LINE_ID, $invoiceLineId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($invoiceLineId['max'])) {
                $this->addUsingAlias(InvoiceLineTableMap::COL_INVOICE_LINE_ID, $invoiceLineId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceLineTableMap::COL_INVOICE_LINE_ID, $invoiceLineId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the invoice_id column
     *
     * Example usage:
     * <code>
     * $query->filterByInvoiceId(1234); // WHERE invoice_id = 1234
     * $query->filterByInvoiceId(array(12, 34)); // WHERE invoice_id IN (12, 34)
     * $query->filterByInvoiceId(array('min' => 12)); // WHERE invoice_id > 12
     * </code>
     *
     * @see       filterByInvoice()
     *
     * @param mixed $invoiceId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByInvoiceId($invoiceId = null, ?string $comparison = null)
    {
        if (is_array($invoiceId)) {
            $useMinMax = false;
            if (isset($invoiceId['min'])) {
                $this->addUsingAlias(InvoiceLineTableMap::COL_INVOICE_ID, $invoiceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($invoiceId['max'])) {
                $this->addUsingAlias(InvoiceLineTableMap::COL_INVOICE_ID, $invoiceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceLineTableMap::COL_INVOICE_ID, $invoiceId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the track_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTrackId(1234); // WHERE track_id = 1234
     * $query->filterByTrackId(array(12, 34)); // WHERE track_id IN (12, 34)
     * $query->filterByTrackId(array('min' => 12)); // WHERE track_id > 12
     * </code>
     *
     * @see       filterByTrack()
     *
     * @param mixed $trackId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTrackId($trackId = null, ?string $comparison = null)
    {
        if (is_array($trackId)) {
            $useMinMax = false;
            if (isset($trackId['min'])) {
                $this->addUsingAlias(InvoiceLineTableMap::COL_TRACK_ID, $trackId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($trackId['max'])) {
                $this->addUsingAlias(InvoiceLineTableMap::COL_TRACK_ID, $trackId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceLineTableMap::COL_TRACK_ID, $trackId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the unit_price column
     *
     * Example usage:
     * <code>
     * $query->filterByUnitPrice(1234); // WHERE unit_price = 1234
     * $query->filterByUnitPrice(array(12, 34)); // WHERE unit_price IN (12, 34)
     * $query->filterByUnitPrice(array('min' => 12)); // WHERE unit_price > 12
     * </code>
     *
     * @param mixed $unitPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUnitPrice($unitPrice = null, ?string $comparison = null)
    {
        if (is_array($unitPrice)) {
            $useMinMax = false;
            if (isset($unitPrice['min'])) {
                $this->addUsingAlias(InvoiceLineTableMap::COL_UNIT_PRICE, $unitPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($unitPrice['max'])) {
                $this->addUsingAlias(InvoiceLineTableMap::COL_UNIT_PRICE, $unitPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceLineTableMap::COL_UNIT_PRICE, $unitPrice, $comparison);

        return $this;
    }

    /**
     * Filter the query on the quantity column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantity(1234); // WHERE quantity = 1234
     * $query->filterByQuantity(array(12, 34)); // WHERE quantity IN (12, 34)
     * $query->filterByQuantity(array('min' => 12)); // WHERE quantity > 12
     * </code>
     *
     * @param mixed $quantity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, ?string $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(InvoiceLineTableMap::COL_QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(InvoiceLineTableMap::COL_QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceLineTableMap::COL_QUANTITY, $quantity, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Chinook\Models\Invoice object
     *
     * @param \Chinook\Models\Invoice|ObjectCollection $invoice The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByInvoice($invoice, ?string $comparison = null)
    {
        if ($invoice instanceof \Chinook\Models\Invoice) {
            return $this
                ->addUsingAlias(InvoiceLineTableMap::COL_INVOICE_ID, $invoice->getInvoiceId(), $comparison);
        } elseif ($invoice instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(InvoiceLineTableMap::COL_INVOICE_ID, $invoice->toKeyValue('PrimaryKey', 'InvoiceId'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByInvoice() only accepts arguments of type \Chinook\Models\Invoice or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Invoice relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinInvoice(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Invoice');

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
            $this->addJoinObject($join, 'Invoice');
        }

        return $this;
    }

    /**
     * Use the Invoice relation Invoice object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Chinook\Models\InvoiceQuery A secondary query class using the current class as primary query
     */
    public function useInvoiceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInvoice($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Invoice', '\Chinook\Models\InvoiceQuery');
    }

    /**
     * Use the Invoice relation Invoice object
     *
     * @param callable(\Chinook\Models\InvoiceQuery):\Chinook\Models\InvoiceQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withInvoiceQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useInvoiceQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Invoice table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Chinook\Models\InvoiceQuery The inner query object of the EXISTS statement
     */
    public function useInvoiceExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Chinook\Models\InvoiceQuery */
        $q = $this->useExistsQuery('Invoice', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Invoice table for a NOT EXISTS query.
     *
     * @see useInvoiceExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\InvoiceQuery The inner query object of the NOT EXISTS statement
     */
    public function useInvoiceNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\InvoiceQuery */
        $q = $this->useExistsQuery('Invoice', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Invoice table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Chinook\Models\InvoiceQuery The inner query object of the IN statement
     */
    public function useInInvoiceQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Chinook\Models\InvoiceQuery */
        $q = $this->useInQuery('Invoice', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Invoice table for a NOT IN query.
     *
     * @see useInvoiceInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\InvoiceQuery The inner query object of the NOT IN statement
     */
    public function useNotInInvoiceQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\InvoiceQuery */
        $q = $this->useInQuery('Invoice', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Chinook\Models\Track object
     *
     * @param \Chinook\Models\Track|ObjectCollection $track The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTrack($track, ?string $comparison = null)
    {
        if ($track instanceof \Chinook\Models\Track) {
            return $this
                ->addUsingAlias(InvoiceLineTableMap::COL_TRACK_ID, $track->getTrackId(), $comparison);
        } elseif ($track instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(InvoiceLineTableMap::COL_TRACK_ID, $track->toKeyValue('PrimaryKey', 'TrackId'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByTrack() only accepts arguments of type \Chinook\Models\Track or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Track relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinTrack(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Track');

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
            $this->addJoinObject($join, 'Track');
        }

        return $this;
    }

    /**
     * Use the Track relation Track object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Chinook\Models\TrackQuery A secondary query class using the current class as primary query
     */
    public function useTrackQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTrack($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Track', '\Chinook\Models\TrackQuery');
    }

    /**
     * Use the Track relation Track object
     *
     * @param callable(\Chinook\Models\TrackQuery):\Chinook\Models\TrackQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withTrackQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useTrackQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Track table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Chinook\Models\TrackQuery The inner query object of the EXISTS statement
     */
    public function useTrackExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Chinook\Models\TrackQuery */
        $q = $this->useExistsQuery('Track', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Track table for a NOT EXISTS query.
     *
     * @see useTrackExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\TrackQuery The inner query object of the NOT EXISTS statement
     */
    public function useTrackNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\TrackQuery */
        $q = $this->useExistsQuery('Track', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Track table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Chinook\Models\TrackQuery The inner query object of the IN statement
     */
    public function useInTrackQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Chinook\Models\TrackQuery */
        $q = $this->useInQuery('Track', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Track table for a NOT IN query.
     *
     * @see useTrackInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\TrackQuery The inner query object of the NOT IN statement
     */
    public function useNotInTrackQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\TrackQuery */
        $q = $this->useInQuery('Track', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildInvoiceLine $invoiceLine Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($invoiceLine = null)
    {
        if ($invoiceLine) {
            $this->addUsingAlias(InvoiceLineTableMap::COL_INVOICE_LINE_ID, $invoiceLine->getInvoiceLineId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the invoice_line table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvoiceLineTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InvoiceLineTableMap::clearInstancePool();
            InvoiceLineTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvoiceLineTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InvoiceLineTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            InvoiceLineTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            InvoiceLineTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
