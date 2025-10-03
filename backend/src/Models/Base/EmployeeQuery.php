<?php

namespace Chinook\Models\Base;

use \Exception;
use \PDO;
use Chinook\Models\Employee as ChildEmployee;
use Chinook\Models\EmployeeQuery as ChildEmployeeQuery;
use Chinook\Models\Map\EmployeeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `employee` table.
 *
 * @method     ChildEmployeeQuery orderByEmployeeId($order = Criteria::ASC) Order by the employee_id column
 * @method     ChildEmployeeQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 * @method     ChildEmployeeQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method     ChildEmployeeQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildEmployeeQuery orderByReportsTo($order = Criteria::ASC) Order by the reports_to column
 * @method     ChildEmployeeQuery orderByBirthDate($order = Criteria::ASC) Order by the birth_date column
 * @method     ChildEmployeeQuery orderByHireDate($order = Criteria::ASC) Order by the hire_date column
 * @method     ChildEmployeeQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildEmployeeQuery orderByCity($order = Criteria::ASC) Order by the city column
 * @method     ChildEmployeeQuery orderByState($order = Criteria::ASC) Order by the state column
 * @method     ChildEmployeeQuery orderByCountry($order = Criteria::ASC) Order by the country column
 * @method     ChildEmployeeQuery orderByPostalCode($order = Criteria::ASC) Order by the postal_code column
 * @method     ChildEmployeeQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildEmployeeQuery orderByFax($order = Criteria::ASC) Order by the fax column
 * @method     ChildEmployeeQuery orderByEmail($order = Criteria::ASC) Order by the email column
 *
 * @method     ChildEmployeeQuery groupByEmployeeId() Group by the employee_id column
 * @method     ChildEmployeeQuery groupByLastName() Group by the last_name column
 * @method     ChildEmployeeQuery groupByFirstName() Group by the first_name column
 * @method     ChildEmployeeQuery groupByTitle() Group by the title column
 * @method     ChildEmployeeQuery groupByReportsTo() Group by the reports_to column
 * @method     ChildEmployeeQuery groupByBirthDate() Group by the birth_date column
 * @method     ChildEmployeeQuery groupByHireDate() Group by the hire_date column
 * @method     ChildEmployeeQuery groupByAddress() Group by the address column
 * @method     ChildEmployeeQuery groupByCity() Group by the city column
 * @method     ChildEmployeeQuery groupByState() Group by the state column
 * @method     ChildEmployeeQuery groupByCountry() Group by the country column
 * @method     ChildEmployeeQuery groupByPostalCode() Group by the postal_code column
 * @method     ChildEmployeeQuery groupByPhone() Group by the phone column
 * @method     ChildEmployeeQuery groupByFax() Group by the fax column
 * @method     ChildEmployeeQuery groupByEmail() Group by the email column
 *
 * @method     ChildEmployeeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEmployeeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEmployeeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEmployeeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildEmployeeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildEmployeeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildEmployeeQuery leftJoinEmployeeRelatedByReportsTo($relationAlias = null) Adds a LEFT JOIN clause to the query using the EmployeeRelatedByReportsTo relation
 * @method     ChildEmployeeQuery rightJoinEmployeeRelatedByReportsTo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EmployeeRelatedByReportsTo relation
 * @method     ChildEmployeeQuery innerJoinEmployeeRelatedByReportsTo($relationAlias = null) Adds a INNER JOIN clause to the query using the EmployeeRelatedByReportsTo relation
 *
 * @method     ChildEmployeeQuery joinWithEmployeeRelatedByReportsTo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the EmployeeRelatedByReportsTo relation
 *
 * @method     ChildEmployeeQuery leftJoinWithEmployeeRelatedByReportsTo() Adds a LEFT JOIN clause and with to the query using the EmployeeRelatedByReportsTo relation
 * @method     ChildEmployeeQuery rightJoinWithEmployeeRelatedByReportsTo() Adds a RIGHT JOIN clause and with to the query using the EmployeeRelatedByReportsTo relation
 * @method     ChildEmployeeQuery innerJoinWithEmployeeRelatedByReportsTo() Adds a INNER JOIN clause and with to the query using the EmployeeRelatedByReportsTo relation
 *
 * @method     ChildEmployeeQuery leftJoinCustomer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Customer relation
 * @method     ChildEmployeeQuery rightJoinCustomer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Customer relation
 * @method     ChildEmployeeQuery innerJoinCustomer($relationAlias = null) Adds a INNER JOIN clause to the query using the Customer relation
 *
 * @method     ChildEmployeeQuery joinWithCustomer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Customer relation
 *
 * @method     ChildEmployeeQuery leftJoinWithCustomer() Adds a LEFT JOIN clause and with to the query using the Customer relation
 * @method     ChildEmployeeQuery rightJoinWithCustomer() Adds a RIGHT JOIN clause and with to the query using the Customer relation
 * @method     ChildEmployeeQuery innerJoinWithCustomer() Adds a INNER JOIN clause and with to the query using the Customer relation
 *
 * @method     ChildEmployeeQuery leftJoinEmployeeRelatedByEmployeeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the EmployeeRelatedByEmployeeId relation
 * @method     ChildEmployeeQuery rightJoinEmployeeRelatedByEmployeeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EmployeeRelatedByEmployeeId relation
 * @method     ChildEmployeeQuery innerJoinEmployeeRelatedByEmployeeId($relationAlias = null) Adds a INNER JOIN clause to the query using the EmployeeRelatedByEmployeeId relation
 *
 * @method     ChildEmployeeQuery joinWithEmployeeRelatedByEmployeeId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the EmployeeRelatedByEmployeeId relation
 *
 * @method     ChildEmployeeQuery leftJoinWithEmployeeRelatedByEmployeeId() Adds a LEFT JOIN clause and with to the query using the EmployeeRelatedByEmployeeId relation
 * @method     ChildEmployeeQuery rightJoinWithEmployeeRelatedByEmployeeId() Adds a RIGHT JOIN clause and with to the query using the EmployeeRelatedByEmployeeId relation
 * @method     ChildEmployeeQuery innerJoinWithEmployeeRelatedByEmployeeId() Adds a INNER JOIN clause and with to the query using the EmployeeRelatedByEmployeeId relation
 *
 * @method     \Chinook\Models\EmployeeQuery|\Chinook\Models\CustomerQuery|\Chinook\Models\EmployeeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEmployee|null findOne(?ConnectionInterface $con = null) Return the first ChildEmployee matching the query
 * @method     ChildEmployee findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildEmployee matching the query, or a new ChildEmployee object populated from the query conditions when no match is found
 *
 * @method     ChildEmployee|null findOneByEmployeeId(int $employee_id) Return the first ChildEmployee filtered by the employee_id column
 * @method     ChildEmployee|null findOneByLastName(string $last_name) Return the first ChildEmployee filtered by the last_name column
 * @method     ChildEmployee|null findOneByFirstName(string $first_name) Return the first ChildEmployee filtered by the first_name column
 * @method     ChildEmployee|null findOneByTitle(string $title) Return the first ChildEmployee filtered by the title column
 * @method     ChildEmployee|null findOneByReportsTo(int $reports_to) Return the first ChildEmployee filtered by the reports_to column
 * @method     ChildEmployee|null findOneByBirthDate(string $birth_date) Return the first ChildEmployee filtered by the birth_date column
 * @method     ChildEmployee|null findOneByHireDate(string $hire_date) Return the first ChildEmployee filtered by the hire_date column
 * @method     ChildEmployee|null findOneByAddress(string $address) Return the first ChildEmployee filtered by the address column
 * @method     ChildEmployee|null findOneByCity(string $city) Return the first ChildEmployee filtered by the city column
 * @method     ChildEmployee|null findOneByState(string $state) Return the first ChildEmployee filtered by the state column
 * @method     ChildEmployee|null findOneByCountry(string $country) Return the first ChildEmployee filtered by the country column
 * @method     ChildEmployee|null findOneByPostalCode(string $postal_code) Return the first ChildEmployee filtered by the postal_code column
 * @method     ChildEmployee|null findOneByPhone(string $phone) Return the first ChildEmployee filtered by the phone column
 * @method     ChildEmployee|null findOneByFax(string $fax) Return the first ChildEmployee filtered by the fax column
 * @method     ChildEmployee|null findOneByEmail(string $email) Return the first ChildEmployee filtered by the email column
 *
 * @method     ChildEmployee requirePk($key, ?ConnectionInterface $con = null) Return the ChildEmployee by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOne(?ConnectionInterface $con = null) Return the first ChildEmployee matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEmployee requireOneByEmployeeId(int $employee_id) Return the first ChildEmployee filtered by the employee_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByLastName(string $last_name) Return the first ChildEmployee filtered by the last_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByFirstName(string $first_name) Return the first ChildEmployee filtered by the first_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByTitle(string $title) Return the first ChildEmployee filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByReportsTo(int $reports_to) Return the first ChildEmployee filtered by the reports_to column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByBirthDate(string $birth_date) Return the first ChildEmployee filtered by the birth_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByHireDate(string $hire_date) Return the first ChildEmployee filtered by the hire_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByAddress(string $address) Return the first ChildEmployee filtered by the address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByCity(string $city) Return the first ChildEmployee filtered by the city column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByState(string $state) Return the first ChildEmployee filtered by the state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByCountry(string $country) Return the first ChildEmployee filtered by the country column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByPostalCode(string $postal_code) Return the first ChildEmployee filtered by the postal_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByPhone(string $phone) Return the first ChildEmployee filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByFax(string $fax) Return the first ChildEmployee filtered by the fax column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmployee requireOneByEmail(string $email) Return the first ChildEmployee filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEmployee[]|Collection find(?ConnectionInterface $con = null) Return ChildEmployee objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildEmployee> find(?ConnectionInterface $con = null) Return ChildEmployee objects based on current ModelCriteria
 *
 * @method     ChildEmployee[]|Collection findByEmployeeId(int|array<int> $employee_id) Return ChildEmployee objects filtered by the employee_id column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByEmployeeId(int|array<int> $employee_id) Return ChildEmployee objects filtered by the employee_id column
 * @method     ChildEmployee[]|Collection findByLastName(string|array<string> $last_name) Return ChildEmployee objects filtered by the last_name column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByLastName(string|array<string> $last_name) Return ChildEmployee objects filtered by the last_name column
 * @method     ChildEmployee[]|Collection findByFirstName(string|array<string> $first_name) Return ChildEmployee objects filtered by the first_name column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByFirstName(string|array<string> $first_name) Return ChildEmployee objects filtered by the first_name column
 * @method     ChildEmployee[]|Collection findByTitle(string|array<string> $title) Return ChildEmployee objects filtered by the title column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByTitle(string|array<string> $title) Return ChildEmployee objects filtered by the title column
 * @method     ChildEmployee[]|Collection findByReportsTo(int|array<int> $reports_to) Return ChildEmployee objects filtered by the reports_to column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByReportsTo(int|array<int> $reports_to) Return ChildEmployee objects filtered by the reports_to column
 * @method     ChildEmployee[]|Collection findByBirthDate(string|array<string> $birth_date) Return ChildEmployee objects filtered by the birth_date column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByBirthDate(string|array<string> $birth_date) Return ChildEmployee objects filtered by the birth_date column
 * @method     ChildEmployee[]|Collection findByHireDate(string|array<string> $hire_date) Return ChildEmployee objects filtered by the hire_date column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByHireDate(string|array<string> $hire_date) Return ChildEmployee objects filtered by the hire_date column
 * @method     ChildEmployee[]|Collection findByAddress(string|array<string> $address) Return ChildEmployee objects filtered by the address column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByAddress(string|array<string> $address) Return ChildEmployee objects filtered by the address column
 * @method     ChildEmployee[]|Collection findByCity(string|array<string> $city) Return ChildEmployee objects filtered by the city column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByCity(string|array<string> $city) Return ChildEmployee objects filtered by the city column
 * @method     ChildEmployee[]|Collection findByState(string|array<string> $state) Return ChildEmployee objects filtered by the state column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByState(string|array<string> $state) Return ChildEmployee objects filtered by the state column
 * @method     ChildEmployee[]|Collection findByCountry(string|array<string> $country) Return ChildEmployee objects filtered by the country column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByCountry(string|array<string> $country) Return ChildEmployee objects filtered by the country column
 * @method     ChildEmployee[]|Collection findByPostalCode(string|array<string> $postal_code) Return ChildEmployee objects filtered by the postal_code column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByPostalCode(string|array<string> $postal_code) Return ChildEmployee objects filtered by the postal_code column
 * @method     ChildEmployee[]|Collection findByPhone(string|array<string> $phone) Return ChildEmployee objects filtered by the phone column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByPhone(string|array<string> $phone) Return ChildEmployee objects filtered by the phone column
 * @method     ChildEmployee[]|Collection findByFax(string|array<string> $fax) Return ChildEmployee objects filtered by the fax column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByFax(string|array<string> $fax) Return ChildEmployee objects filtered by the fax column
 * @method     ChildEmployee[]|Collection findByEmail(string|array<string> $email) Return ChildEmployee objects filtered by the email column
 * @psalm-method Collection&\Traversable<ChildEmployee> findByEmail(string|array<string> $email) Return ChildEmployee objects filtered by the email column
 *
 * @method     ChildEmployee[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildEmployee> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class EmployeeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Chinook\Models\Base\EmployeeQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Chinook\\Models\\Employee', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEmployeeQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEmployeeQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildEmployeeQuery) {
            return $criteria;
        }
        $query = new ChildEmployeeQuery();
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
     * @return ChildEmployee|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EmployeeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = EmployeeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildEmployee A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT employee_id, last_name, first_name, title, reports_to, birth_date, hire_date, address, city, state, country, postal_code, phone, fax, email FROM employee WHERE employee_id = :p0';
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
            /** @var ChildEmployee $obj */
            $obj = new ChildEmployee();
            $obj->hydrate($row);
            EmployeeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildEmployee|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(EmployeeTableMap::COL_EMPLOYEE_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(EmployeeTableMap::COL_EMPLOYEE_ID, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the employee_id column
     *
     * Example usage:
     * <code>
     * $query->filterByEmployeeId(1234); // WHERE employee_id = 1234
     * $query->filterByEmployeeId(array(12, 34)); // WHERE employee_id IN (12, 34)
     * $query->filterByEmployeeId(array('min' => 12)); // WHERE employee_id > 12
     * </code>
     *
     * @param mixed $employeeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByEmployeeId($employeeId = null, ?string $comparison = null)
    {
        if (is_array($employeeId)) {
            $useMinMax = false;
            if (isset($employeeId['min'])) {
                $this->addUsingAlias(EmployeeTableMap::COL_EMPLOYEE_ID, $employeeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($employeeId['max'])) {
                $this->addUsingAlias(EmployeeTableMap::COL_EMPLOYEE_ID, $employeeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(EmployeeTableMap::COL_EMPLOYEE_ID, $employeeId, $comparison);

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

        $this->addUsingAlias(EmployeeTableMap::COL_LAST_NAME, $lastName, $comparison);

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

        $this->addUsingAlias(EmployeeTableMap::COL_FIRST_NAME, $firstName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE title LIKE '%fooValue%'
     * $query->filterByTitle(['foo', 'bar']); // WHERE title IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $title The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTitle($title = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(EmployeeTableMap::COL_TITLE, $title, $comparison);

        return $this;
    }

    /**
     * Filter the query on the reports_to column
     *
     * Example usage:
     * <code>
     * $query->filterByReportsTo(1234); // WHERE reports_to = 1234
     * $query->filterByReportsTo(array(12, 34)); // WHERE reports_to IN (12, 34)
     * $query->filterByReportsTo(array('min' => 12)); // WHERE reports_to > 12
     * </code>
     *
     * @see       filterByEmployeeRelatedByReportsTo()
     *
     * @param mixed $reportsTo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByReportsTo($reportsTo = null, ?string $comparison = null)
    {
        if (is_array($reportsTo)) {
            $useMinMax = false;
            if (isset($reportsTo['min'])) {
                $this->addUsingAlias(EmployeeTableMap::COL_REPORTS_TO, $reportsTo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($reportsTo['max'])) {
                $this->addUsingAlias(EmployeeTableMap::COL_REPORTS_TO, $reportsTo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(EmployeeTableMap::COL_REPORTS_TO, $reportsTo, $comparison);

        return $this;
    }

    /**
     * Filter the query on the birth_date column
     *
     * Example usage:
     * <code>
     * $query->filterByBirthDate('2011-03-14'); // WHERE birth_date = '2011-03-14'
     * $query->filterByBirthDate('now'); // WHERE birth_date = '2011-03-14'
     * $query->filterByBirthDate(array('max' => 'yesterday')); // WHERE birth_date > '2011-03-13'
     * </code>
     *
     * @param mixed $birthDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByBirthDate($birthDate = null, ?string $comparison = null)
    {
        if (is_array($birthDate)) {
            $useMinMax = false;
            if (isset($birthDate['min'])) {
                $this->addUsingAlias(EmployeeTableMap::COL_BIRTH_DATE, $birthDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($birthDate['max'])) {
                $this->addUsingAlias(EmployeeTableMap::COL_BIRTH_DATE, $birthDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(EmployeeTableMap::COL_BIRTH_DATE, $birthDate, $comparison);

        return $this;
    }

    /**
     * Filter the query on the hire_date column
     *
     * Example usage:
     * <code>
     * $query->filterByHireDate('2011-03-14'); // WHERE hire_date = '2011-03-14'
     * $query->filterByHireDate('now'); // WHERE hire_date = '2011-03-14'
     * $query->filterByHireDate(array('max' => 'yesterday')); // WHERE hire_date > '2011-03-13'
     * </code>
     *
     * @param mixed $hireDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByHireDate($hireDate = null, ?string $comparison = null)
    {
        if (is_array($hireDate)) {
            $useMinMax = false;
            if (isset($hireDate['min'])) {
                $this->addUsingAlias(EmployeeTableMap::COL_HIRE_DATE, $hireDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hireDate['max'])) {
                $this->addUsingAlias(EmployeeTableMap::COL_HIRE_DATE, $hireDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(EmployeeTableMap::COL_HIRE_DATE, $hireDate, $comparison);

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

        $this->addUsingAlias(EmployeeTableMap::COL_ADDRESS, $address, $comparison);

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

        $this->addUsingAlias(EmployeeTableMap::COL_CITY, $city, $comparison);

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

        $this->addUsingAlias(EmployeeTableMap::COL_STATE, $state, $comparison);

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

        $this->addUsingAlias(EmployeeTableMap::COL_COUNTRY, $country, $comparison);

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

        $this->addUsingAlias(EmployeeTableMap::COL_POSTAL_CODE, $postalCode, $comparison);

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

        $this->addUsingAlias(EmployeeTableMap::COL_PHONE, $phone, $comparison);

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

        $this->addUsingAlias(EmployeeTableMap::COL_FAX, $fax, $comparison);

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

        $this->addUsingAlias(EmployeeTableMap::COL_EMAIL, $email, $comparison);

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
    public function filterByEmployeeRelatedByReportsTo($employee, ?string $comparison = null)
    {
        if ($employee instanceof \Chinook\Models\Employee) {
            return $this
                ->addUsingAlias(EmployeeTableMap::COL_REPORTS_TO, $employee->getEmployeeId(), $comparison);
        } elseif ($employee instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(EmployeeTableMap::COL_REPORTS_TO, $employee->toKeyValue('PrimaryKey', 'EmployeeId'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByEmployeeRelatedByReportsTo() only accepts arguments of type \Chinook\Models\Employee or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EmployeeRelatedByReportsTo relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinEmployeeRelatedByReportsTo(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EmployeeRelatedByReportsTo');

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
            $this->addJoinObject($join, 'EmployeeRelatedByReportsTo');
        }

        return $this;
    }

    /**
     * Use the EmployeeRelatedByReportsTo relation Employee object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Chinook\Models\EmployeeQuery A secondary query class using the current class as primary query
     */
    public function useEmployeeRelatedByReportsToQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEmployeeRelatedByReportsTo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EmployeeRelatedByReportsTo', '\Chinook\Models\EmployeeQuery');
    }

    /**
     * Use the EmployeeRelatedByReportsTo relation Employee object
     *
     * @param callable(\Chinook\Models\EmployeeQuery):\Chinook\Models\EmployeeQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withEmployeeRelatedByReportsToQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useEmployeeRelatedByReportsToQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the EmployeeRelatedByReportsTo relation to the Employee table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Chinook\Models\EmployeeQuery The inner query object of the EXISTS statement
     */
    public function useEmployeeRelatedByReportsToExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Chinook\Models\EmployeeQuery */
        $q = $this->useExistsQuery('EmployeeRelatedByReportsTo', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the EmployeeRelatedByReportsTo relation to the Employee table for a NOT EXISTS query.
     *
     * @see useEmployeeRelatedByReportsToExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\EmployeeQuery The inner query object of the NOT EXISTS statement
     */
    public function useEmployeeRelatedByReportsToNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\EmployeeQuery */
        $q = $this->useExistsQuery('EmployeeRelatedByReportsTo', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the EmployeeRelatedByReportsTo relation to the Employee table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Chinook\Models\EmployeeQuery The inner query object of the IN statement
     */
    public function useInEmployeeRelatedByReportsToQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Chinook\Models\EmployeeQuery */
        $q = $this->useInQuery('EmployeeRelatedByReportsTo', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the EmployeeRelatedByReportsTo relation to the Employee table for a NOT IN query.
     *
     * @see useEmployeeRelatedByReportsToInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\EmployeeQuery The inner query object of the NOT IN statement
     */
    public function useNotInEmployeeRelatedByReportsToQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\EmployeeQuery */
        $q = $this->useInQuery('EmployeeRelatedByReportsTo', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Chinook\Models\Customer object
     *
     * @param \Chinook\Models\Customer|ObjectCollection $customer the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCustomer($customer, ?string $comparison = null)
    {
        if ($customer instanceof \Chinook\Models\Customer) {
            $this
                ->addUsingAlias(EmployeeTableMap::COL_EMPLOYEE_ID, $customer->getSupportRepId(), $comparison);

            return $this;
        } elseif ($customer instanceof ObjectCollection) {
            $this
                ->useCustomerQuery()
                ->filterByPrimaryKeys($customer->getPrimaryKeys())
                ->endUse();

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
    public function joinCustomer(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
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
    public function useCustomerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
        ?string $joinType = Criteria::LEFT_JOIN
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
     * Filter the query by a related \Chinook\Models\Employee object
     *
     * @param \Chinook\Models\Employee|ObjectCollection $employee the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByEmployeeRelatedByEmployeeId($employee, ?string $comparison = null)
    {
        if ($employee instanceof \Chinook\Models\Employee) {
            $this
                ->addUsingAlias(EmployeeTableMap::COL_EMPLOYEE_ID, $employee->getReportsTo(), $comparison);

            return $this;
        } elseif ($employee instanceof ObjectCollection) {
            $this
                ->useEmployeeRelatedByEmployeeIdQuery()
                ->filterByPrimaryKeys($employee->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByEmployeeRelatedByEmployeeId() only accepts arguments of type \Chinook\Models\Employee or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EmployeeRelatedByEmployeeId relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinEmployeeRelatedByEmployeeId(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EmployeeRelatedByEmployeeId');

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
            $this->addJoinObject($join, 'EmployeeRelatedByEmployeeId');
        }

        return $this;
    }

    /**
     * Use the EmployeeRelatedByEmployeeId relation Employee object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Chinook\Models\EmployeeQuery A secondary query class using the current class as primary query
     */
    public function useEmployeeRelatedByEmployeeIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEmployeeRelatedByEmployeeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EmployeeRelatedByEmployeeId', '\Chinook\Models\EmployeeQuery');
    }

    /**
     * Use the EmployeeRelatedByEmployeeId relation Employee object
     *
     * @param callable(\Chinook\Models\EmployeeQuery):\Chinook\Models\EmployeeQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withEmployeeRelatedByEmployeeIdQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useEmployeeRelatedByEmployeeIdQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the EmployeeRelatedByEmployeeId relation to the Employee table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Chinook\Models\EmployeeQuery The inner query object of the EXISTS statement
     */
    public function useEmployeeRelatedByEmployeeIdExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Chinook\Models\EmployeeQuery */
        $q = $this->useExistsQuery('EmployeeRelatedByEmployeeId', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the EmployeeRelatedByEmployeeId relation to the Employee table for a NOT EXISTS query.
     *
     * @see useEmployeeRelatedByEmployeeIdExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\EmployeeQuery The inner query object of the NOT EXISTS statement
     */
    public function useEmployeeRelatedByEmployeeIdNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\EmployeeQuery */
        $q = $this->useExistsQuery('EmployeeRelatedByEmployeeId', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the EmployeeRelatedByEmployeeId relation to the Employee table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Chinook\Models\EmployeeQuery The inner query object of the IN statement
     */
    public function useInEmployeeRelatedByEmployeeIdQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Chinook\Models\EmployeeQuery */
        $q = $this->useInQuery('EmployeeRelatedByEmployeeId', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the EmployeeRelatedByEmployeeId relation to the Employee table for a NOT IN query.
     *
     * @see useEmployeeRelatedByEmployeeIdInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\EmployeeQuery The inner query object of the NOT IN statement
     */
    public function useNotInEmployeeRelatedByEmployeeIdQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\EmployeeQuery */
        $q = $this->useInQuery('EmployeeRelatedByEmployeeId', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildEmployee $employee Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($employee = null)
    {
        if ($employee) {
            $this->addUsingAlias(EmployeeTableMap::COL_EMPLOYEE_ID, $employee->getEmployeeId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the employee table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EmployeeTableMap::clearInstancePool();
            EmployeeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EmployeeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EmployeeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EmployeeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
