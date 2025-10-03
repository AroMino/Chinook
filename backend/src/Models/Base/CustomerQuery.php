<?php

namespace Chinook\Models\Base;

use \Exception;
use \PDO;
use Chinook\Models\Customer as ChildCustomer;
use Chinook\Models\CustomerQuery as ChildCustomerQuery;
use Chinook\Models\Map\CustomerTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `customer` table.
 *
 * @method     ChildCustomerQuery orderByCustomerId($order = Criteria::ASC) Order by the customer_id column
 * @method     ChildCustomerQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method     ChildCustomerQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 * @method     ChildCustomerQuery orderByCompany($order = Criteria::ASC) Order by the company column
 * @method     ChildCustomerQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildCustomerQuery orderByCity($order = Criteria::ASC) Order by the city column
 * @method     ChildCustomerQuery orderByState($order = Criteria::ASC) Order by the state column
 * @method     ChildCustomerQuery orderByCountry($order = Criteria::ASC) Order by the country column
 * @method     ChildCustomerQuery orderByPostalCode($order = Criteria::ASC) Order by the postal_code column
 * @method     ChildCustomerQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildCustomerQuery orderByFax($order = Criteria::ASC) Order by the fax column
 * @method     ChildCustomerQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildCustomerQuery orderBySupportRepId($order = Criteria::ASC) Order by the support_rep_id column
 *
 * @method     ChildCustomerQuery groupByCustomerId() Group by the customer_id column
 * @method     ChildCustomerQuery groupByFirstName() Group by the first_name column
 * @method     ChildCustomerQuery groupByLastName() Group by the last_name column
 * @method     ChildCustomerQuery groupByCompany() Group by the company column
 * @method     ChildCustomerQuery groupByAddress() Group by the address column
 * @method     ChildCustomerQuery groupByCity() Group by the city column
 * @method     ChildCustomerQuery groupByState() Group by the state column
 * @method     ChildCustomerQuery groupByCountry() Group by the country column
 * @method     ChildCustomerQuery groupByPostalCode() Group by the postal_code column
 * @method     ChildCustomerQuery groupByPhone() Group by the phone column
 * @method     ChildCustomerQuery groupByFax() Group by the fax column
 * @method     ChildCustomerQuery groupByEmail() Group by the email column
 * @method     ChildCustomerQuery groupBySupportRepId() Group by the support_rep_id column
 *
 * @method     ChildCustomerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCustomerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCustomerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCustomerQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCustomerQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCustomerQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCustomerQuery leftJoinEmployee($relationAlias = null) Adds a LEFT JOIN clause to the query using the Employee relation
 * @method     ChildCustomerQuery rightJoinEmployee($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Employee relation
 * @method     ChildCustomerQuery innerJoinEmployee($relationAlias = null) Adds a INNER JOIN clause to the query using the Employee relation
 *
 * @method     ChildCustomerQuery joinWithEmployee($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Employee relation
 *
 * @method     ChildCustomerQuery leftJoinWithEmployee() Adds a LEFT JOIN clause and with to the query using the Employee relation
 * @method     ChildCustomerQuery rightJoinWithEmployee() Adds a RIGHT JOIN clause and with to the query using the Employee relation
 * @method     ChildCustomerQuery innerJoinWithEmployee() Adds a INNER JOIN clause and with to the query using the Employee relation
 *
 * @method     ChildCustomerQuery leftJoinInvoice($relationAlias = null) Adds a LEFT JOIN clause to the query using the Invoice relation
 * @method     ChildCustomerQuery rightJoinInvoice($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Invoice relation
 * @method     ChildCustomerQuery innerJoinInvoice($relationAlias = null) Adds a INNER JOIN clause to the query using the Invoice relation
 *
 * @method     ChildCustomerQuery joinWithInvoice($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Invoice relation
 *
 * @method     ChildCustomerQuery leftJoinWithInvoice() Adds a LEFT JOIN clause and with to the query using the Invoice relation
 * @method     ChildCustomerQuery rightJoinWithInvoice() Adds a RIGHT JOIN clause and with to the query using the Invoice relation
 * @method     ChildCustomerQuery innerJoinWithInvoice() Adds a INNER JOIN clause and with to the query using the Invoice relation
 *
 * @method     \Chinook\Models\EmployeeQuery|\Chinook\Models\InvoiceQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCustomer|null findOne(?ConnectionInterface $con = null) Return the first ChildCustomer matching the query
 * @method     ChildCustomer findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildCustomer matching the query, or a new ChildCustomer object populated from the query conditions when no match is found
 *
 * @method     ChildCustomer|null findOneByCustomerId(int $customer_id) Return the first ChildCustomer filtered by the customer_id column
 * @method     ChildCustomer|null findOneByFirstName(string $first_name) Return the first ChildCustomer filtered by the first_name column
 * @method     ChildCustomer|null findOneByLastName(string $last_name) Return the first ChildCustomer filtered by the last_name column
 * @method     ChildCustomer|null findOneByCompany(string $company) Return the first ChildCustomer filtered by the company column
 * @method     ChildCustomer|null findOneByAddress(string $address) Return the first ChildCustomer filtered by the address column
 * @method     ChildCustomer|null findOneByCity(string $city) Return the first ChildCustomer filtered by the city column
 * @method     ChildCustomer|null findOneByState(string $state) Return the first ChildCustomer filtered by the state column
 * @method     ChildCustomer|null findOneByCountry(string $country) Return the first ChildCustomer filtered by the country column
 * @method     ChildCustomer|null findOneByPostalCode(string $postal_code) Return the first ChildCustomer filtered by the postal_code column
 * @method     ChildCustomer|null findOneByPhone(string $phone) Return the first ChildCustomer filtered by the phone column
 * @method     ChildCustomer|null findOneByFax(string $fax) Return the first ChildCustomer filtered by the fax column
 * @method     ChildCustomer|null findOneByEmail(string $email) Return the first ChildCustomer filtered by the email column
 * @method     ChildCustomer|null findOneBySupportRepId(int $support_rep_id) Return the first ChildCustomer filtered by the support_rep_id column
 *
 * @method     ChildCustomer requirePk($key, ?ConnectionInterface $con = null) Return the ChildCustomer by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOne(?ConnectionInterface $con = null) Return the first ChildCustomer matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCustomer requireOneByCustomerId(int $customer_id) Return the first ChildCustomer filtered by the customer_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByFirstName(string $first_name) Return the first ChildCustomer filtered by the first_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByLastName(string $last_name) Return the first ChildCustomer filtered by the last_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByCompany(string $company) Return the first ChildCustomer filtered by the company column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByAddress(string $address) Return the first ChildCustomer filtered by the address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByCity(string $city) Return the first ChildCustomer filtered by the city column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByState(string $state) Return the first ChildCustomer filtered by the state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByCountry(string $country) Return the first ChildCustomer filtered by the country column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByPostalCode(string $postal_code) Return the first ChildCustomer filtered by the postal_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByPhone(string $phone) Return the first ChildCustomer filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByFax(string $fax) Return the first ChildCustomer filtered by the fax column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByEmail(string $email) Return the first ChildCustomer filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneBySupportRepId(int $support_rep_id) Return the first ChildCustomer filtered by the support_rep_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCustomer[]|Collection find(?ConnectionInterface $con = null) Return ChildCustomer objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildCustomer> find(?ConnectionInterface $con = null) Return ChildCustomer objects based on current ModelCriteria
 *
 * @method     ChildCustomer[]|Collection findByCustomerId(int|array<int> $customer_id) Return ChildCustomer objects filtered by the customer_id column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByCustomerId(int|array<int> $customer_id) Return ChildCustomer objects filtered by the customer_id column
 * @method     ChildCustomer[]|Collection findByFirstName(string|array<string> $first_name) Return ChildCustomer objects filtered by the first_name column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByFirstName(string|array<string> $first_name) Return ChildCustomer objects filtered by the first_name column
 * @method     ChildCustomer[]|Collection findByLastName(string|array<string> $last_name) Return ChildCustomer objects filtered by the last_name column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByLastName(string|array<string> $last_name) Return ChildCustomer objects filtered by the last_name column
 * @method     ChildCustomer[]|Collection findByCompany(string|array<string> $company) Return ChildCustomer objects filtered by the company column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByCompany(string|array<string> $company) Return ChildCustomer objects filtered by the company column
 * @method     ChildCustomer[]|Collection findByAddress(string|array<string> $address) Return ChildCustomer objects filtered by the address column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByAddress(string|array<string> $address) Return ChildCustomer objects filtered by the address column
 * @method     ChildCustomer[]|Collection findByCity(string|array<string> $city) Return ChildCustomer objects filtered by the city column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByCity(string|array<string> $city) Return ChildCustomer objects filtered by the city column
 * @method     ChildCustomer[]|Collection findByState(string|array<string> $state) Return ChildCustomer objects filtered by the state column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByState(string|array<string> $state) Return ChildCustomer objects filtered by the state column
 * @method     ChildCustomer[]|Collection findByCountry(string|array<string> $country) Return ChildCustomer objects filtered by the country column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByCountry(string|array<string> $country) Return ChildCustomer objects filtered by the country column
 * @method     ChildCustomer[]|Collection findByPostalCode(string|array<string> $postal_code) Return ChildCustomer objects filtered by the postal_code column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByPostalCode(string|array<string> $postal_code) Return ChildCustomer objects filtered by the postal_code column
 * @method     ChildCustomer[]|Collection findByPhone(string|array<string> $phone) Return ChildCustomer objects filtered by the phone column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByPhone(string|array<string> $phone) Return ChildCustomer objects filtered by the phone column
 * @method     ChildCustomer[]|Collection findByFax(string|array<string> $fax) Return ChildCustomer objects filtered by the fax column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByFax(string|array<string> $fax) Return ChildCustomer objects filtered by the fax column
 * @method     ChildCustomer[]|Collection findByEmail(string|array<string> $email) Return ChildCustomer objects filtered by the email column
 * @psalm-method Collection&\Traversable<ChildCustomer> findByEmail(string|array<string> $email) Return ChildCustomer objects filtered by the email column
 * @method     ChildCustomer[]|Collection findBySupportRepId(int|array<int> $support_rep_id) Return ChildCustomer objects filtered by the support_rep_id column
 * @psalm-method Collection&\Traversable<ChildCustomer> findBySupportRepId(int|array<int> $support_rep_id) Return ChildCustomer objects filtered by the support_rep_id column
 *
 * @method     ChildCustomer[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildCustomer> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class CustomerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Chinook\Models\Base\CustomerQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Chinook\\Models\\Customer', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCustomerQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCustomerQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildCustomerQuery) {
            return $criteria;
        }
        $query = new ChildCustomerQuery();
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
     * @return ChildCustomer|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CustomerTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CustomerTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCustomer A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT customer_id, first_name, last_name, company, address, city, state, country, postal_code, phone, fax, email, support_rep_id FROM customer WHERE customer_id = :p0';
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
            /** @var ChildCustomer $obj */
            $obj = new ChildCustomer();
            $obj->hydrate($row);
            CustomerTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCustomer|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(CustomerTableMap::COL_CUSTOMER_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(CustomerTableMap::COL_CUSTOMER_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(CustomerTableMap::COL_CUSTOMER_ID, $customerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($customerId['max'])) {
                $this->addUsingAlias(CustomerTableMap::COL_CUSTOMER_ID, $customerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_CUSTOMER_ID, $customerId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the first_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstName('fooValue');   // WHERE first_name = 'fooValue'
     * $query->filterByFirstName('%fooValue%', Criteria::LIKE); // WHERE first_name LIKE '%fooValue%'
     * $query->filterByFirstName(['foo', 'bar']); // WHERE first_name IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $firstName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByFirstName($firstName = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstName)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_FIRST_NAME, $firstName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the last_name column
     *
     * Example usage:
     * <code>
     * $query->filterByLastName('fooValue');   // WHERE last_name = 'fooValue'
     * $query->filterByLastName('%fooValue%', Criteria::LIKE); // WHERE last_name LIKE '%fooValue%'
     * $query->filterByLastName(['foo', 'bar']); // WHERE last_name IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $lastName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByLastName($lastName = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastName)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_LAST_NAME, $lastName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the company column
     *
     * Example usage:
     * <code>
     * $query->filterByCompany('fooValue');   // WHERE company = 'fooValue'
     * $query->filterByCompany('%fooValue%', Criteria::LIKE); // WHERE company LIKE '%fooValue%'
     * $query->filterByCompany(['foo', 'bar']); // WHERE company IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $company The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCompany($company = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($company)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_COMPANY, $company, $comparison);

        return $this;
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%', Criteria::LIKE); // WHERE address LIKE '%fooValue%'
     * $query->filterByAddress(['foo', 'bar']); // WHERE address IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $address The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByAddress($address = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_ADDRESS, $address, $comparison);

        return $this;
    }

    /**
     * Filter the query on the city column
     *
     * Example usage:
     * <code>
     * $query->filterByCity('fooValue');   // WHERE city = 'fooValue'
     * $query->filterByCity('%fooValue%', Criteria::LIKE); // WHERE city LIKE '%fooValue%'
     * $query->filterByCity(['foo', 'bar']); // WHERE city IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $city The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCity($city = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($city)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_CITY, $city, $comparison);

        return $this;
    }

    /**
     * Filter the query on the state column
     *
     * Example usage:
     * <code>
     * $query->filterByState('fooValue');   // WHERE state = 'fooValue'
     * $query->filterByState('%fooValue%', Criteria::LIKE); // WHERE state LIKE '%fooValue%'
     * $query->filterByState(['foo', 'bar']); // WHERE state IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $state The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByState($state = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($state)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_STATE, $state, $comparison);

        return $this;
    }

    /**
     * Filter the query on the country column
     *
     * Example usage:
     * <code>
     * $query->filterByCountry('fooValue');   // WHERE country = 'fooValue'
     * $query->filterByCountry('%fooValue%', Criteria::LIKE); // WHERE country LIKE '%fooValue%'
     * $query->filterByCountry(['foo', 'bar']); // WHERE country IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $country The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCountry($country = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($country)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_COUNTRY, $country, $comparison);

        return $this;
    }

    /**
     * Filter the query on the postal_code column
     *
     * Example usage:
     * <code>
     * $query->filterByPostalCode('fooValue');   // WHERE postal_code = 'fooValue'
     * $query->filterByPostalCode('%fooValue%', Criteria::LIKE); // WHERE postal_code LIKE '%fooValue%'
     * $query->filterByPostalCode(['foo', 'bar']); // WHERE postal_code IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $postalCode The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPostalCode($postalCode = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postalCode)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_POSTAL_CODE, $postalCode, $comparison);

        return $this;
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%', Criteria::LIKE); // WHERE phone LIKE '%fooValue%'
     * $query->filterByPhone(['foo', 'bar']); // WHERE phone IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $phone The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPhone($phone = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_PHONE, $phone, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fax column
     *
     * Example usage:
     * <code>
     * $query->filterByFax('fooValue');   // WHERE fax = 'fooValue'
     * $query->filterByFax('%fooValue%', Criteria::LIKE); // WHERE fax LIKE '%fooValue%'
     * $query->filterByFax(['foo', 'bar']); // WHERE fax IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $fax The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByFax($fax = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fax)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_FAX, $fax, $comparison);

        return $this;
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * $query->filterByEmail(['foo', 'bar']); // WHERE email IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $email The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByEmail($email = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_EMAIL, $email, $comparison);

        return $this;
    }

    /**
     * Filter the query on the support_rep_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySupportRepId(1234); // WHERE support_rep_id = 1234
     * $query->filterBySupportRepId(array(12, 34)); // WHERE support_rep_id IN (12, 34)
     * $query->filterBySupportRepId(array('min' => 12)); // WHERE support_rep_id > 12
     * </code>
     *
     * @see       filterByEmployee()
     *
     * @param mixed $supportRepId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterBySupportRepId($supportRepId = null, ?string $comparison = null)
    {
        if (is_array($supportRepId)) {
            $useMinMax = false;
            if (isset($supportRepId['min'])) {
                $this->addUsingAlias(CustomerTableMap::COL_SUPPORT_REP_ID, $supportRepId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($supportRepId['max'])) {
                $this->addUsingAlias(CustomerTableMap::COL_SUPPORT_REP_ID, $supportRepId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CustomerTableMap::COL_SUPPORT_REP_ID, $supportRepId, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Chinook\Models\Employee object
     *
     * @param \Chinook\Models\Employee|ObjectCollection $employee The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByEmployee($employee, ?string $comparison = null)
    {
        if ($employee instanceof \Chinook\Models\Employee) {
            return $this
                ->addUsingAlias(CustomerTableMap::COL_SUPPORT_REP_ID, $employee->getEmployeeId(), $comparison);
        } elseif ($employee instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(CustomerTableMap::COL_SUPPORT_REP_ID, $employee->toKeyValue('PrimaryKey', 'EmployeeId'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByEmployee() only accepts arguments of type \Chinook\Models\Employee or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Employee relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinEmployee(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Employee');

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
            $this->addJoinObject($join, 'Employee');
        }

        return $this;
    }

    /**
     * Use the Employee relation Employee object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Chinook\Models\EmployeeQuery A secondary query class using the current class as primary query
     */
    public function useEmployeeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEmployee($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Employee', '\Chinook\Models\EmployeeQuery');
    }

    /**
     * Use the Employee relation Employee object
     *
     * @param callable(\Chinook\Models\EmployeeQuery):\Chinook\Models\EmployeeQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withEmployeeQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useEmployeeQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Employee table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Chinook\Models\EmployeeQuery The inner query object of the EXISTS statement
     */
    public function useEmployeeExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Chinook\Models\EmployeeQuery */
        $q = $this->useExistsQuery('Employee', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Employee table for a NOT EXISTS query.
     *
     * @see useEmployeeExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\EmployeeQuery The inner query object of the NOT EXISTS statement
     */
    public function useEmployeeNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\EmployeeQuery */
        $q = $this->useExistsQuery('Employee', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Employee table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Chinook\Models\EmployeeQuery The inner query object of the IN statement
     */
    public function useInEmployeeQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Chinook\Models\EmployeeQuery */
        $q = $this->useInQuery('Employee', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Employee table for a NOT IN query.
     *
     * @see useEmployeeInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\EmployeeQuery The inner query object of the NOT IN statement
     */
    public function useNotInEmployeeQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\EmployeeQuery */
        $q = $this->useInQuery('Employee', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Chinook\Models\Invoice object
     *
     * @param \Chinook\Models\Invoice|ObjectCollection $invoice the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByInvoice($invoice, ?string $comparison = null)
    {
        if ($invoice instanceof \Chinook\Models\Invoice) {
            $this
                ->addUsingAlias(CustomerTableMap::COL_CUSTOMER_ID, $invoice->getCustomerId(), $comparison);

            return $this;
        } elseif ($invoice instanceof ObjectCollection) {
            $this
                ->useInvoiceQuery()
                ->filterByPrimaryKeys($invoice->getPrimaryKeys())
                ->endUse();

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
     * Exclude object from result
     *
     * @param ChildCustomer $customer Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($customer = null)
    {
        if ($customer) {
            $this->addUsingAlias(CustomerTableMap::COL_CUSTOMER_ID, $customer->getCustomerId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the customer table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CustomerTableMap::clearInstancePool();
            CustomerTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CustomerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CustomerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CustomerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CustomerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
