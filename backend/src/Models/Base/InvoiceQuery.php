<?php

namespace Chinook\Models\Base;

use \Exception;
use \PDO;
use Chinook\Models\Invoice as ChildInvoice;
use Chinook\Models\InvoiceQuery as ChildInvoiceQuery;
use Chinook\Models\Map\InvoiceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `invoice` table.
 *
 * @method     ChildInvoiceQuery orderByInvoiceId($order = Criteria::ASC) Order by the invoice_id column
 * @method     ChildInvoiceQuery orderByCustomerId($order = Criteria::ASC) Order by the customer_id column
 * @method     ChildInvoiceQuery orderByInvoiceDate($order = Criteria::ASC) Order by the invoice_date column
 * @method     ChildInvoiceQuery orderByBillingAddress($order = Criteria::ASC) Order by the billing_address column
 * @method     ChildInvoiceQuery orderByBillingCity($order = Criteria::ASC) Order by the billing_city column
 * @method     ChildInvoiceQuery orderByBillingState($order = Criteria::ASC) Order by the billing_state column
 * @method     ChildInvoiceQuery orderByBillingCountry($order = Criteria::ASC) Order by the billing_country column
 * @method     ChildInvoiceQuery orderByBillingPostalCode($order = Criteria::ASC) Order by the billing_postal_code column
 * @method     ChildInvoiceQuery orderByTotal($order = Criteria::ASC) Order by the total column
 *
 * @method     ChildInvoiceQuery groupByInvoiceId() Group by the invoice_id column
 * @method     ChildInvoiceQuery groupByCustomerId() Group by the customer_id column
 * @method     ChildInvoiceQuery groupByInvoiceDate() Group by the invoice_date column
 * @method     ChildInvoiceQuery groupByBillingAddress() Group by the billing_address column
 * @method     ChildInvoiceQuery groupByBillingCity() Group by the billing_city column
 * @method     ChildInvoiceQuery groupByBillingState() Group by the billing_state column
 * @method     ChildInvoiceQuery groupByBillingCountry() Group by the billing_country column
 * @method     ChildInvoiceQuery groupByBillingPostalCode() Group by the billing_postal_code column
 * @method     ChildInvoiceQuery groupByTotal() Group by the total column
 *
 * @method     ChildInvoiceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInvoiceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInvoiceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInvoiceQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildInvoiceQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildInvoiceQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildInvoiceQuery leftJoinCustomer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Customer relation
 * @method     ChildInvoiceQuery rightJoinCustomer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Customer relation
 * @method     ChildInvoiceQuery innerJoinCustomer($relationAlias = null) Adds a INNER JOIN clause to the query using the Customer relation
 *
 * @method     ChildInvoiceQuery joinWithCustomer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Customer relation
 *
 * @method     ChildInvoiceQuery leftJoinWithCustomer() Adds a LEFT JOIN clause and with to the query using the Customer relation
 * @method     ChildInvoiceQuery rightJoinWithCustomer() Adds a RIGHT JOIN clause and with to the query using the Customer relation
 * @method     ChildInvoiceQuery innerJoinWithCustomer() Adds a INNER JOIN clause and with to the query using the Customer relation
 *
 * @method     ChildInvoiceQuery leftJoinInvoiceLine($relationAlias = null) Adds a LEFT JOIN clause to the query using the InvoiceLine relation
 * @method     ChildInvoiceQuery rightJoinInvoiceLine($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InvoiceLine relation
 * @method     ChildInvoiceQuery innerJoinInvoiceLine($relationAlias = null) Adds a INNER JOIN clause to the query using the InvoiceLine relation
 *
 * @method     ChildInvoiceQuery joinWithInvoiceLine($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the InvoiceLine relation
 *
 * @method     ChildInvoiceQuery leftJoinWithInvoiceLine() Adds a LEFT JOIN clause and with to the query using the InvoiceLine relation
 * @method     ChildInvoiceQuery rightJoinWithInvoiceLine() Adds a RIGHT JOIN clause and with to the query using the InvoiceLine relation
 * @method     ChildInvoiceQuery innerJoinWithInvoiceLine() Adds a INNER JOIN clause and with to the query using the InvoiceLine relation
 *
 * @method     \Chinook\Models\CustomerQuery|\Chinook\Models\InvoiceLineQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInvoice|null findOne(?ConnectionInterface $con = null) Return the first ChildInvoice matching the query
 * @method     ChildInvoice findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildInvoice matching the query, or a new ChildInvoice object populated from the query conditions when no match is found
 *
 * @method     ChildInvoice|null findOneByInvoiceId(int $invoice_id) Return the first ChildInvoice filtered by the invoice_id column
 * @method     ChildInvoice|null findOneByCustomerId(int $customer_id) Return the first ChildInvoice filtered by the customer_id column
 * @method     ChildInvoice|null findOneByInvoiceDate(string $invoice_date) Return the first ChildInvoice filtered by the invoice_date column
 * @method     ChildInvoice|null findOneByBillingAddress(string $billing_address) Return the first ChildInvoice filtered by the billing_address column
 * @method     ChildInvoice|null findOneByBillingCity(string $billing_city) Return the first ChildInvoice filtered by the billing_city column
 * @method     ChildInvoice|null findOneByBillingState(string $billing_state) Return the first ChildInvoice filtered by the billing_state column
 * @method     ChildInvoice|null findOneByBillingCountry(string $billing_country) Return the first ChildInvoice filtered by the billing_country column
 * @method     ChildInvoice|null findOneByBillingPostalCode(string $billing_postal_code) Return the first ChildInvoice filtered by the billing_postal_code column
 * @method     ChildInvoice|null findOneByTotal(string $total) Return the first ChildInvoice filtered by the total column
 *
 * @method     ChildInvoice requirePk($key, ?ConnectionInterface $con = null) Return the ChildInvoice by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoice requireOne(?ConnectionInterface $con = null) Return the first ChildInvoice matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvoice requireOneByInvoiceId(int $invoice_id) Return the first ChildInvoice filtered by the invoice_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoice requireOneByCustomerId(int $customer_id) Return the first ChildInvoice filtered by the customer_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoice requireOneByInvoiceDate(string $invoice_date) Return the first ChildInvoice filtered by the invoice_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoice requireOneByBillingAddress(string $billing_address) Return the first ChildInvoice filtered by the billing_address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoice requireOneByBillingCity(string $billing_city) Return the first ChildInvoice filtered by the billing_city column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoice requireOneByBillingState(string $billing_state) Return the first ChildInvoice filtered by the billing_state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoice requireOneByBillingCountry(string $billing_country) Return the first ChildInvoice filtered by the billing_country column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoice requireOneByBillingPostalCode(string $billing_postal_code) Return the first ChildInvoice filtered by the billing_postal_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInvoice requireOneByTotal(string $total) Return the first ChildInvoice filtered by the total column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInvoice[]|Collection find(?ConnectionInterface $con = null) Return ChildInvoice objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildInvoice> find(?ConnectionInterface $con = null) Return ChildInvoice objects based on current ModelCriteria
 *
 * @method     ChildInvoice[]|Collection findByInvoiceId(int|array<int> $invoice_id) Return ChildInvoice objects filtered by the invoice_id column
 * @psalm-method Collection&\Traversable<ChildInvoice> findByInvoiceId(int|array<int> $invoice_id) Return ChildInvoice objects filtered by the invoice_id column
 * @method     ChildInvoice[]|Collection findByCustomerId(int|array<int> $customer_id) Return ChildInvoice objects filtered by the customer_id column
 * @psalm-method Collection&\Traversable<ChildInvoice> findByCustomerId(int|array<int> $customer_id) Return ChildInvoice objects filtered by the customer_id column
 * @method     ChildInvoice[]|Collection findByInvoiceDate(string|array<string> $invoice_date) Return ChildInvoice objects filtered by the invoice_date column
 * @psalm-method Collection&\Traversable<ChildInvoice> findByInvoiceDate(string|array<string> $invoice_date) Return ChildInvoice objects filtered by the invoice_date column
 * @method     ChildInvoice[]|Collection findByBillingAddress(string|array<string> $billing_address) Return ChildInvoice objects filtered by the billing_address column
 * @psalm-method Collection&\Traversable<ChildInvoice> findByBillingAddress(string|array<string> $billing_address) Return ChildInvoice objects filtered by the billing_address column
 * @method     ChildInvoice[]|Collection findByBillingCity(string|array<string> $billing_city) Return ChildInvoice objects filtered by the billing_city column
 * @psalm-method Collection&\Traversable<ChildInvoice> findByBillingCity(string|array<string> $billing_city) Return ChildInvoice objects filtered by the billing_city column
 * @method     ChildInvoice[]|Collection findByBillingState(string|array<string> $billing_state) Return ChildInvoice objects filtered by the billing_state column
 * @psalm-method Collection&\Traversable<ChildInvoice> findByBillingState(string|array<string> $billing_state) Return ChildInvoice objects filtered by the billing_state column
 * @method     ChildInvoice[]|Collection findByBillingCountry(string|array<string> $billing_country) Return ChildInvoice objects filtered by the billing_country column
 * @psalm-method Collection&\Traversable<ChildInvoice> findByBillingCountry(string|array<string> $billing_country) Return ChildInvoice objects filtered by the billing_country column
 * @method     ChildInvoice[]|Collection findByBillingPostalCode(string|array<string> $billing_postal_code) Return ChildInvoice objects filtered by the billing_postal_code column
 * @psalm-method Collection&\Traversable<ChildInvoice> findByBillingPostalCode(string|array<string> $billing_postal_code) Return ChildInvoice objects filtered by the billing_postal_code column
 * @method     ChildInvoice[]|Collection findByTotal(string|array<string> $total) Return ChildInvoice objects filtered by the total column
 * @psalm-method Collection&\Traversable<ChildInvoice> findByTotal(string|array<string> $total) Return ChildInvoice objects filtered by the total column
 *
 * @method     ChildInvoice[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildInvoice> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class InvoiceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Chinook\Models\Base\InvoiceQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Chinook\\Models\\Invoice', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInvoiceQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInvoiceQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildInvoiceQuery) {
            return $criteria;
        }
        $query = new ChildInvoiceQuery();
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
     * @return ChildInvoice|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InvoiceTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = InvoiceTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildInvoice A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT invoice_id, customer_id, invoice_date, billing_address, billing_city, billing_state, billing_country, billing_postal_code, total FROM invoice WHERE invoice_id = :p0';
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
            /** @var ChildInvoice $obj */
            $obj = new ChildInvoice();
            $obj->hydrate($row);
            InvoiceTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildInvoice|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(InvoiceTableMap::COL_INVOICE_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(InvoiceTableMap::COL_INVOICE_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(InvoiceTableMap::COL_INVOICE_ID, $invoiceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($invoiceId['max'])) {
                $this->addUsingAlias(InvoiceTableMap::COL_INVOICE_ID, $invoiceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceTableMap::COL_INVOICE_ID, $invoiceId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the customer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomerId(1234); // WHERE customer_id = 1234
     * $query->filterByCustomerId(array(12, 34)); // WHERE customer_id IN (12, 34)
     * $query->filterByCustomerId(array('min' => 12)); // WHERE customer_id > 12
     * </code>
     *
     * @see       filterByCustomer()
     *
     * @param mixed $customerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCustomerId($customerId = null, ?string $comparison = null)
    {
        if (is_array($customerId)) {
            $useMinMax = false;
            if (isset($customerId['min'])) {
                $this->addUsingAlias(InvoiceTableMap::COL_CUSTOMER_ID, $customerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($customerId['max'])) {
                $this->addUsingAlias(InvoiceTableMap::COL_CUSTOMER_ID, $customerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceTableMap::COL_CUSTOMER_ID, $customerId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the invoice_date column
     *
     * Example usage:
     * <code>
     * $query->filterByInvoiceDate('2011-03-14'); // WHERE invoice_date = '2011-03-14'
     * $query->filterByInvoiceDate('now'); // WHERE invoice_date = '2011-03-14'
     * $query->filterByInvoiceDate(array('max' => 'yesterday')); // WHERE invoice_date > '2011-03-13'
     * </code>
     *
     * @param mixed $invoiceDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByInvoiceDate($invoiceDate = null, ?string $comparison = null)
    {
        if (is_array($invoiceDate)) {
            $useMinMax = false;
            if (isset($invoiceDate['min'])) {
                $this->addUsingAlias(InvoiceTableMap::COL_INVOICE_DATE, $invoiceDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($invoiceDate['max'])) {
                $this->addUsingAlias(InvoiceTableMap::COL_INVOICE_DATE, $invoiceDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceTableMap::COL_INVOICE_DATE, $invoiceDate, $comparison);

        return $this;
    }

    /**
     * Filter the query on the billing_address column
     *
     * Example usage:
     * <code>
     * $query->filterByBillingAddress('fooValue');   // WHERE billing_address = 'fooValue'
     * $query->filterByBillingAddress('%fooValue%', Criteria::LIKE); // WHERE billing_address LIKE '%fooValue%'
     * $query->filterByBillingAddress(['foo', 'bar']); // WHERE billing_address IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $billingAddress The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByBillingAddress($billingAddress = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($billingAddress)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceTableMap::COL_BILLING_ADDRESS, $billingAddress, $comparison);

        return $this;
    }

    /**
     * Filter the query on the billing_city column
     *
     * Example usage:
     * <code>
     * $query->filterByBillingCity('fooValue');   // WHERE billing_city = 'fooValue'
     * $query->filterByBillingCity('%fooValue%', Criteria::LIKE); // WHERE billing_city LIKE '%fooValue%'
     * $query->filterByBillingCity(['foo', 'bar']); // WHERE billing_city IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $billingCity The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByBillingCity($billingCity = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($billingCity)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceTableMap::COL_BILLING_CITY, $billingCity, $comparison);

        return $this;
    }

    /**
     * Filter the query on the billing_state column
     *
     * Example usage:
     * <code>
     * $query->filterByBillingState('fooValue');   // WHERE billing_state = 'fooValue'
     * $query->filterByBillingState('%fooValue%', Criteria::LIKE); // WHERE billing_state LIKE '%fooValue%'
     * $query->filterByBillingState(['foo', 'bar']); // WHERE billing_state IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $billingState The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByBillingState($billingState = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($billingState)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceTableMap::COL_BILLING_STATE, $billingState, $comparison);

        return $this;
    }

    /**
     * Filter the query on the billing_country column
     *
     * Example usage:
     * <code>
     * $query->filterByBillingCountry('fooValue');   // WHERE billing_country = 'fooValue'
     * $query->filterByBillingCountry('%fooValue%', Criteria::LIKE); // WHERE billing_country LIKE '%fooValue%'
     * $query->filterByBillingCountry(['foo', 'bar']); // WHERE billing_country IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $billingCountry The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByBillingCountry($billingCountry = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($billingCountry)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceTableMap::COL_BILLING_COUNTRY, $billingCountry, $comparison);

        return $this;
    }

    /**
     * Filter the query on the billing_postal_code column
     *
     * Example usage:
     * <code>
     * $query->filterByBillingPostalCode('fooValue');   // WHERE billing_postal_code = 'fooValue'
     * $query->filterByBillingPostalCode('%fooValue%', Criteria::LIKE); // WHERE billing_postal_code LIKE '%fooValue%'
     * $query->filterByBillingPostalCode(['foo', 'bar']); // WHERE billing_postal_code IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $billingPostalCode The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByBillingPostalCode($billingPostalCode = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($billingPostalCode)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceTableMap::COL_BILLING_POSTAL_CODE, $billingPostalCode, $comparison);

        return $this;
    }

    /**
     * Filter the query on the total column
     *
     * Example usage:
     * <code>
     * $query->filterByTotal(1234); // WHERE total = 1234
     * $query->filterByTotal(array(12, 34)); // WHERE total IN (12, 34)
     * $query->filterByTotal(array('min' => 12)); // WHERE total > 12
     * </code>
     *
     * @param mixed $total The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTotal($total = null, ?string $comparison = null)
    {
        if (is_array($total)) {
            $useMinMax = false;
            if (isset($total['min'])) {
                $this->addUsingAlias(InvoiceTableMap::COL_TOTAL, $total['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($total['max'])) {
                $this->addUsingAlias(InvoiceTableMap::COL_TOTAL, $total['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(InvoiceTableMap::COL_TOTAL, $total, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Chinook\Models\Customer object
     *
     * @param \Chinook\Models\Customer|ObjectCollection $customer The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCustomer($customer, ?string $comparison = null)
    {
        if ($customer instanceof \Chinook\Models\Customer) {
            return $this
                ->addUsingAlias(InvoiceTableMap::COL_CUSTOMER_ID, $customer->getCustomerId(), $comparison);
        } elseif ($customer instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(InvoiceTableMap::COL_CUSTOMER_ID, $customer->toKeyValue('PrimaryKey', 'CustomerId'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByCustomer() only accepts arguments of type \Chinook\Models\Customer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Customer relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinCustomer(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Customer');

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
            $this->addJoinObject($join, 'Customer');
        }

        return $this;
    }

    /**
     * Use the Customer relation Customer object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Chinook\Models\CustomerQuery A secondary query class using the current class as primary query
     */
    public function useCustomerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCustomer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Customer', '\Chinook\Models\CustomerQuery');
    }

    /**
     * Use the Customer relation Customer object
     *
     * @param callable(\Chinook\Models\CustomerQuery):\Chinook\Models\CustomerQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withCustomerQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useCustomerQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Customer table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Chinook\Models\CustomerQuery The inner query object of the EXISTS statement
     */
    public function useCustomerExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Chinook\Models\CustomerQuery */
        $q = $this->useExistsQuery('Customer', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Customer table for a NOT EXISTS query.
     *
     * @see useCustomerExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\CustomerQuery The inner query object of the NOT EXISTS statement
     */
    public function useCustomerNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\CustomerQuery */
        $q = $this->useExistsQuery('Customer', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Customer table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Chinook\Models\CustomerQuery The inner query object of the IN statement
     */
    public function useInCustomerQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Chinook\Models\CustomerQuery */
        $q = $this->useInQuery('Customer', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Customer table for a NOT IN query.
     *
     * @see useCustomerInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\CustomerQuery The inner query object of the NOT IN statement
     */
    public function useNotInCustomerQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\CustomerQuery */
        $q = $this->useInQuery('Customer', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Chinook\Models\InvoiceLine object
     *
     * @param \Chinook\Models\InvoiceLine|ObjectCollection $invoiceLine the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByInvoiceLine($invoiceLine, ?string $comparison = null)
    {
        if ($invoiceLine instanceof \Chinook\Models\InvoiceLine) {
            $this
                ->addUsingAlias(InvoiceTableMap::COL_INVOICE_ID, $invoiceLine->getInvoiceId(), $comparison);

            return $this;
        } elseif ($invoiceLine instanceof ObjectCollection) {
            $this
                ->useInvoiceLineQuery()
                ->filterByPrimaryKeys($invoiceLine->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByInvoiceLine() only accepts arguments of type \Chinook\Models\InvoiceLine or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the InvoiceLine relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinInvoiceLine(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('InvoiceLine');

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
            $this->addJoinObject($join, 'InvoiceLine');
        }

        return $this;
    }

    /**
     * Use the InvoiceLine relation InvoiceLine object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Chinook\Models\InvoiceLineQuery A secondary query class using the current class as primary query
     */
    public function useInvoiceLineQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInvoiceLine($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'InvoiceLine', '\Chinook\Models\InvoiceLineQuery');
    }

    /**
     * Use the InvoiceLine relation InvoiceLine object
     *
     * @param callable(\Chinook\Models\InvoiceLineQuery):\Chinook\Models\InvoiceLineQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withInvoiceLineQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useInvoiceLineQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to InvoiceLine table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Chinook\Models\InvoiceLineQuery The inner query object of the EXISTS statement
     */
    public function useInvoiceLineExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Chinook\Models\InvoiceLineQuery */
        $q = $this->useExistsQuery('InvoiceLine', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to InvoiceLine table for a NOT EXISTS query.
     *
     * @see useInvoiceLineExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\InvoiceLineQuery The inner query object of the NOT EXISTS statement
     */
    public function useInvoiceLineNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\InvoiceLineQuery */
        $q = $this->useExistsQuery('InvoiceLine', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to InvoiceLine table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Chinook\Models\InvoiceLineQuery The inner query object of the IN statement
     */
    public function useInInvoiceLineQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Chinook\Models\InvoiceLineQuery */
        $q = $this->useInQuery('InvoiceLine', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to InvoiceLine table for a NOT IN query.
     *
     * @see useInvoiceLineInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\InvoiceLineQuery The inner query object of the NOT IN statement
     */
    public function useNotInInvoiceLineQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\InvoiceLineQuery */
        $q = $this->useInQuery('InvoiceLine', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildInvoice $invoice Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($invoice = null)
    {
        if ($invoice) {
            $this->addUsingAlias(InvoiceTableMap::COL_INVOICE_ID, $invoice->getInvoiceId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the invoice table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvoiceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InvoiceTableMap::clearInstancePool();
            InvoiceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InvoiceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InvoiceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            InvoiceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            InvoiceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
