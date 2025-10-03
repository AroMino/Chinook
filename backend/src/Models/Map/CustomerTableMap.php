<?php

namespace Chinook\Models\Map;

use Chinook\Models\Customer;
use Chinook\Models\CustomerQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'customer' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class CustomerTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Chinook.Models.Map.CustomerTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'customer';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Customer';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Chinook\\Models\\Customer';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Chinook.Models.Customer';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 13;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the customer_id field
     */
    public const COL_CUSTOMER_ID = 'customer.customer_id';

    /**
     * the column name for the first_name field
     */
    public const COL_FIRST_NAME = 'customer.first_name';

    /**
     * the column name for the last_name field
     */
    public const COL_LAST_NAME = 'customer.last_name';

    /**
     * the column name for the company field
     */
    public const COL_COMPANY = 'customer.company';

    /**
     * the column name for the address field
     */
    public const COL_ADDRESS = 'customer.address';

    /**
     * the column name for the city field
     */
    public const COL_CITY = 'customer.city';

    /**
     * the column name for the state field
     */
    public const COL_STATE = 'customer.state';

    /**
     * the column name for the country field
     */
    public const COL_COUNTRY = 'customer.country';

    /**
     * the column name for the postal_code field
     */
    public const COL_POSTAL_CODE = 'customer.postal_code';

    /**
     * the column name for the phone field
     */
    public const COL_PHONE = 'customer.phone';

    /**
     * the column name for the fax field
     */
    public const COL_FAX = 'customer.fax';

    /**
     * the column name for the email field
     */
    public const COL_EMAIL = 'customer.email';

    /**
     * the column name for the support_rep_id field
     */
    public const COL_SUPPORT_REP_ID = 'customer.support_rep_id';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['CustomerId', 'FirstName', 'LastName', 'Company', 'Address', 'City', 'State', 'Country', 'PostalCode', 'Phone', 'Fax', 'Email', 'SupportRepId', ],
        self::TYPE_CAMELNAME     => ['customerId', 'firstName', 'lastName', 'company', 'address', 'city', 'state', 'country', 'postalCode', 'phone', 'fax', 'email', 'supportRepId', ],
        self::TYPE_COLNAME       => [CustomerTableMap::COL_CUSTOMER_ID, CustomerTableMap::COL_FIRST_NAME, CustomerTableMap::COL_LAST_NAME, CustomerTableMap::COL_COMPANY, CustomerTableMap::COL_ADDRESS, CustomerTableMap::COL_CITY, CustomerTableMap::COL_STATE, CustomerTableMap::COL_COUNTRY, CustomerTableMap::COL_POSTAL_CODE, CustomerTableMap::COL_PHONE, CustomerTableMap::COL_FAX, CustomerTableMap::COL_EMAIL, CustomerTableMap::COL_SUPPORT_REP_ID, ],
        self::TYPE_FIELDNAME     => ['customer_id', 'first_name', 'last_name', 'company', 'address', 'city', 'state', 'country', 'postal_code', 'phone', 'fax', 'email', 'support_rep_id', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, ]
    ];

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     *
     * @var array<string, mixed>
     */
    protected static $fieldKeys = [
        self::TYPE_PHPNAME       => ['CustomerId' => 0, 'FirstName' => 1, 'LastName' => 2, 'Company' => 3, 'Address' => 4, 'City' => 5, 'State' => 6, 'Country' => 7, 'PostalCode' => 8, 'Phone' => 9, 'Fax' => 10, 'Email' => 11, 'SupportRepId' => 12, ],
        self::TYPE_CAMELNAME     => ['customerId' => 0, 'firstName' => 1, 'lastName' => 2, 'company' => 3, 'address' => 4, 'city' => 5, 'state' => 6, 'country' => 7, 'postalCode' => 8, 'phone' => 9, 'fax' => 10, 'email' => 11, 'supportRepId' => 12, ],
        self::TYPE_COLNAME       => [CustomerTableMap::COL_CUSTOMER_ID => 0, CustomerTableMap::COL_FIRST_NAME => 1, CustomerTableMap::COL_LAST_NAME => 2, CustomerTableMap::COL_COMPANY => 3, CustomerTableMap::COL_ADDRESS => 4, CustomerTableMap::COL_CITY => 5, CustomerTableMap::COL_STATE => 6, CustomerTableMap::COL_COUNTRY => 7, CustomerTableMap::COL_POSTAL_CODE => 8, CustomerTableMap::COL_PHONE => 9, CustomerTableMap::COL_FAX => 10, CustomerTableMap::COL_EMAIL => 11, CustomerTableMap::COL_SUPPORT_REP_ID => 12, ],
        self::TYPE_FIELDNAME     => ['customer_id' => 0, 'first_name' => 1, 'last_name' => 2, 'company' => 3, 'address' => 4, 'city' => 5, 'state' => 6, 'country' => 7, 'postal_code' => 8, 'phone' => 9, 'fax' => 10, 'email' => 11, 'support_rep_id' => 12, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'CustomerId' => 'CUSTOMER_ID',
        'Customer.CustomerId' => 'CUSTOMER_ID',
        'customerId' => 'CUSTOMER_ID',
        'customer.customerId' => 'CUSTOMER_ID',
        'CustomerTableMap::COL_CUSTOMER_ID' => 'CUSTOMER_ID',
        'COL_CUSTOMER_ID' => 'CUSTOMER_ID',
        'customer_id' => 'CUSTOMER_ID',
        'customer.customer_id' => 'CUSTOMER_ID',
        'FirstName' => 'FIRST_NAME',
        'Customer.FirstName' => 'FIRST_NAME',
        'firstName' => 'FIRST_NAME',
        'customer.firstName' => 'FIRST_NAME',
        'CustomerTableMap::COL_FIRST_NAME' => 'FIRST_NAME',
        'COL_FIRST_NAME' => 'FIRST_NAME',
        'first_name' => 'FIRST_NAME',
        'customer.first_name' => 'FIRST_NAME',
        'LastName' => 'LAST_NAME',
        'Customer.LastName' => 'LAST_NAME',
        'lastName' => 'LAST_NAME',
        'customer.lastName' => 'LAST_NAME',
        'CustomerTableMap::COL_LAST_NAME' => 'LAST_NAME',
        'COL_LAST_NAME' => 'LAST_NAME',
        'last_name' => 'LAST_NAME',
        'customer.last_name' => 'LAST_NAME',
        'Company' => 'COMPANY',
        'Customer.Company' => 'COMPANY',
        'company' => 'COMPANY',
        'customer.company' => 'COMPANY',
        'CustomerTableMap::COL_COMPANY' => 'COMPANY',
        'COL_COMPANY' => 'COMPANY',
        'Address' => 'ADDRESS',
        'Customer.Address' => 'ADDRESS',
        'address' => 'ADDRESS',
        'customer.address' => 'ADDRESS',
        'CustomerTableMap::COL_ADDRESS' => 'ADDRESS',
        'COL_ADDRESS' => 'ADDRESS',
        'City' => 'CITY',
        'Customer.City' => 'CITY',
        'city' => 'CITY',
        'customer.city' => 'CITY',
        'CustomerTableMap::COL_CITY' => 'CITY',
        'COL_CITY' => 'CITY',
        'State' => 'STATE',
        'Customer.State' => 'STATE',
        'state' => 'STATE',
        'customer.state' => 'STATE',
        'CustomerTableMap::COL_STATE' => 'STATE',
        'COL_STATE' => 'STATE',
        'Country' => 'COUNTRY',
        'Customer.Country' => 'COUNTRY',
        'country' => 'COUNTRY',
        'customer.country' => 'COUNTRY',
        'CustomerTableMap::COL_COUNTRY' => 'COUNTRY',
        'COL_COUNTRY' => 'COUNTRY',
        'PostalCode' => 'POSTAL_CODE',
        'Customer.PostalCode' => 'POSTAL_CODE',
        'postalCode' => 'POSTAL_CODE',
        'customer.postalCode' => 'POSTAL_CODE',
        'CustomerTableMap::COL_POSTAL_CODE' => 'POSTAL_CODE',
        'COL_POSTAL_CODE' => 'POSTAL_CODE',
        'postal_code' => 'POSTAL_CODE',
        'customer.postal_code' => 'POSTAL_CODE',
        'Phone' => 'PHONE',
        'Customer.Phone' => 'PHONE',
        'phone' => 'PHONE',
        'customer.phone' => 'PHONE',
        'CustomerTableMap::COL_PHONE' => 'PHONE',
        'COL_PHONE' => 'PHONE',
        'Fax' => 'FAX',
        'Customer.Fax' => 'FAX',
        'fax' => 'FAX',
        'customer.fax' => 'FAX',
        'CustomerTableMap::COL_FAX' => 'FAX',
        'COL_FAX' => 'FAX',
        'Email' => 'EMAIL',
        'Customer.Email' => 'EMAIL',
        'email' => 'EMAIL',
        'customer.email' => 'EMAIL',
        'CustomerTableMap::COL_EMAIL' => 'EMAIL',
        'COL_EMAIL' => 'EMAIL',
        'SupportRepId' => 'SUPPORT_REP_ID',
        'Customer.SupportRepId' => 'SUPPORT_REP_ID',
        'supportRepId' => 'SUPPORT_REP_ID',
        'customer.supportRepId' => 'SUPPORT_REP_ID',
        'CustomerTableMap::COL_SUPPORT_REP_ID' => 'SUPPORT_REP_ID',
        'COL_SUPPORT_REP_ID' => 'SUPPORT_REP_ID',
        'support_rep_id' => 'SUPPORT_REP_ID',
        'customer.support_rep_id' => 'SUPPORT_REP_ID',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function initialize(): void
    {
        // attributes
        $this->setName('customer');
        $this->setPhpName('Customer');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Chinook\\Models\\Customer');
        $this->setPackage('Chinook.Models');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('customer_customer_id_seq');
        // columns
        $this->addPrimaryKey('customer_id', 'CustomerId', 'INTEGER', true, null, null);
        $this->addColumn('first_name', 'FirstName', 'VARCHAR', true, 40, null);
        $this->addColumn('last_name', 'LastName', 'VARCHAR', true, 20, null);
        $this->addColumn('company', 'Company', 'VARCHAR', false, 80, null);
        $this->addColumn('address', 'Address', 'VARCHAR', false, 70, null);
        $this->addColumn('city', 'City', 'VARCHAR', false, 40, null);
        $this->addColumn('state', 'State', 'VARCHAR', false, 40, null);
        $this->addColumn('country', 'Country', 'VARCHAR', false, 40, null);
        $this->addColumn('postal_code', 'PostalCode', 'VARCHAR', false, 10, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 24, null);
        $this->addColumn('fax', 'Fax', 'VARCHAR', false, 24, null);
        $this->addColumn('email', 'Email', 'VARCHAR', true, 60, null);
        $this->addForeignKey('support_rep_id', 'SupportRepId', 'INTEGER', 'employee', 'employee_id', false, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('Employee', '\\Chinook\\Models\\Employee', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':support_rep_id',
    1 => ':employee_id',
  ),
), null, null, null, false);
        $this->addRelation('Invoice', '\\Chinook\\Models\\Invoice', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':customer_id',
    1 => ':customer_id',
  ),
), null, null, 'Invoices', false);
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string|null The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): ?string
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CustomerId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CustomerId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CustomerId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CustomerId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CustomerId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CustomerId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('CustomerId', TableMap::TYPE_PHPNAME, $indexType)
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
     * @param bool $withPrefix Whether to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass(bool $withPrefix = true): string
    {
        return $withPrefix ? CustomerTableMap::CLASS_DEFAULT : CustomerTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array $row Row returned by DataFetcher->fetch().
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array (Customer object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = CustomerTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CustomerTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CustomerTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CustomerTableMap::OM_CLASS;
            /** @var Customer $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CustomerTableMap::addInstanceToPool($obj, $key);
        }

        return [$obj, $col];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array<object>
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher): array
    {
        $results = [];

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = CustomerTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CustomerTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Customer $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CustomerTableMap::addInstanceToPool($obj, $key);
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
     * @param Criteria $criteria Object containing the columns to add.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function addSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->addSelectColumn(CustomerTableMap::COL_CUSTOMER_ID);
            $criteria->addSelectColumn(CustomerTableMap::COL_FIRST_NAME);
            $criteria->addSelectColumn(CustomerTableMap::COL_LAST_NAME);
            $criteria->addSelectColumn(CustomerTableMap::COL_COMPANY);
            $criteria->addSelectColumn(CustomerTableMap::COL_ADDRESS);
            $criteria->addSelectColumn(CustomerTableMap::COL_CITY);
            $criteria->addSelectColumn(CustomerTableMap::COL_STATE);
            $criteria->addSelectColumn(CustomerTableMap::COL_COUNTRY);
            $criteria->addSelectColumn(CustomerTableMap::COL_POSTAL_CODE);
            $criteria->addSelectColumn(CustomerTableMap::COL_PHONE);
            $criteria->addSelectColumn(CustomerTableMap::COL_FAX);
            $criteria->addSelectColumn(CustomerTableMap::COL_EMAIL);
            $criteria->addSelectColumn(CustomerTableMap::COL_SUPPORT_REP_ID);
        } else {
            $criteria->addSelectColumn($alias . '.customer_id');
            $criteria->addSelectColumn($alias . '.first_name');
            $criteria->addSelectColumn($alias . '.last_name');
            $criteria->addSelectColumn($alias . '.company');
            $criteria->addSelectColumn($alias . '.address');
            $criteria->addSelectColumn($alias . '.city');
            $criteria->addSelectColumn($alias . '.state');
            $criteria->addSelectColumn($alias . '.country');
            $criteria->addSelectColumn($alias . '.postal_code');
            $criteria->addSelectColumn($alias . '.phone');
            $criteria->addSelectColumn($alias . '.fax');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.support_rep_id');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria Object containing the columns to remove.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function removeSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(CustomerTableMap::COL_CUSTOMER_ID);
            $criteria->removeSelectColumn(CustomerTableMap::COL_FIRST_NAME);
            $criteria->removeSelectColumn(CustomerTableMap::COL_LAST_NAME);
            $criteria->removeSelectColumn(CustomerTableMap::COL_COMPANY);
            $criteria->removeSelectColumn(CustomerTableMap::COL_ADDRESS);
            $criteria->removeSelectColumn(CustomerTableMap::COL_CITY);
            $criteria->removeSelectColumn(CustomerTableMap::COL_STATE);
            $criteria->removeSelectColumn(CustomerTableMap::COL_COUNTRY);
            $criteria->removeSelectColumn(CustomerTableMap::COL_POSTAL_CODE);
            $criteria->removeSelectColumn(CustomerTableMap::COL_PHONE);
            $criteria->removeSelectColumn(CustomerTableMap::COL_FAX);
            $criteria->removeSelectColumn(CustomerTableMap::COL_EMAIL);
            $criteria->removeSelectColumn(CustomerTableMap::COL_SUPPORT_REP_ID);
        } else {
            $criteria->removeSelectColumn($alias . '.customer_id');
            $criteria->removeSelectColumn($alias . '.first_name');
            $criteria->removeSelectColumn($alias . '.last_name');
            $criteria->removeSelectColumn($alias . '.company');
            $criteria->removeSelectColumn($alias . '.address');
            $criteria->removeSelectColumn($alias . '.city');
            $criteria->removeSelectColumn($alias . '.state');
            $criteria->removeSelectColumn($alias . '.country');
            $criteria->removeSelectColumn($alias . '.postal_code');
            $criteria->removeSelectColumn($alias . '.phone');
            $criteria->removeSelectColumn($alias . '.fax');
            $criteria->removeSelectColumn($alias . '.email');
            $criteria->removeSelectColumn($alias . '.support_rep_id');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap(): TableMap
    {
        return Propel::getServiceContainer()->getDatabaseMap(CustomerTableMap::DATABASE_NAME)->getTable(CustomerTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Customer or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Customer object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ?ConnectionInterface $con = null): int
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomerTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Chinook\Models\Customer) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CustomerTableMap::DATABASE_NAME);
            $criteria->add(CustomerTableMap::COL_CUSTOMER_ID, (array) $values, Criteria::IN);
        }

        $query = CustomerQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CustomerTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CustomerTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the customer table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return CustomerQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Customer or Criteria object.
     *
     * @param mixed $criteria Criteria or Customer object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomerTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Customer object
        }

        if ($criteria->containsKey(CustomerTableMap::COL_CUSTOMER_ID) && $criteria->keyContainsValue(CustomerTableMap::COL_CUSTOMER_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CustomerTableMap::COL_CUSTOMER_ID.')');
        }


        // Set the correct dbName
        $query = CustomerQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
