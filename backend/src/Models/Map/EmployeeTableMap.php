<?php

namespace Chinook\Models\Map;

use Chinook\Models\Employee;
use Chinook\Models\EmployeeQuery;
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
 * This class defines the structure of the 'employee' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class EmployeeTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Chinook.Models.Map.EmployeeTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'employee';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Employee';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Chinook\\Models\\Employee';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Chinook.Models.Employee';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 15;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 15;

    /**
     * the column name for the employee_id field
     */
    public const COL_EMPLOYEE_ID = 'employee.employee_id';

    /**
     * the column name for the last_name field
     */
    public const COL_LAST_NAME = 'employee.last_name';

    /**
     * the column name for the first_name field
     */
    public const COL_FIRST_NAME = 'employee.first_name';

    /**
     * the column name for the title field
     */
    public const COL_TITLE = 'employee.title';

    /**
     * the column name for the reports_to field
     */
    public const COL_REPORTS_TO = 'employee.reports_to';

    /**
     * the column name for the birth_date field
     */
    public const COL_BIRTH_DATE = 'employee.birth_date';

    /**
     * the column name for the hire_date field
     */
    public const COL_HIRE_DATE = 'employee.hire_date';

    /**
     * the column name for the address field
     */
    public const COL_ADDRESS = 'employee.address';

    /**
     * the column name for the city field
     */
    public const COL_CITY = 'employee.city';

    /**
     * the column name for the state field
     */
    public const COL_STATE = 'employee.state';

    /**
     * the column name for the country field
     */
    public const COL_COUNTRY = 'employee.country';

    /**
     * the column name for the postal_code field
     */
    public const COL_POSTAL_CODE = 'employee.postal_code';

    /**
     * the column name for the phone field
     */
    public const COL_PHONE = 'employee.phone';

    /**
     * the column name for the fax field
     */
    public const COL_FAX = 'employee.fax';

    /**
     * the column name for the email field
     */
    public const COL_EMAIL = 'employee.email';

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
        self::TYPE_PHPNAME       => ['EmployeeId', 'LastName', 'FirstName', 'Title', 'ReportsTo', 'BirthDate', 'HireDate', 'Address', 'City', 'State', 'Country', 'PostalCode', 'Phone', 'Fax', 'Email', ],
        self::TYPE_CAMELNAME     => ['employeeId', 'lastName', 'firstName', 'title', 'reportsTo', 'birthDate', 'hireDate', 'address', 'city', 'state', 'country', 'postalCode', 'phone', 'fax', 'email', ],
        self::TYPE_COLNAME       => [EmployeeTableMap::COL_EMPLOYEE_ID, EmployeeTableMap::COL_LAST_NAME, EmployeeTableMap::COL_FIRST_NAME, EmployeeTableMap::COL_TITLE, EmployeeTableMap::COL_REPORTS_TO, EmployeeTableMap::COL_BIRTH_DATE, EmployeeTableMap::COL_HIRE_DATE, EmployeeTableMap::COL_ADDRESS, EmployeeTableMap::COL_CITY, EmployeeTableMap::COL_STATE, EmployeeTableMap::COL_COUNTRY, EmployeeTableMap::COL_POSTAL_CODE, EmployeeTableMap::COL_PHONE, EmployeeTableMap::COL_FAX, EmployeeTableMap::COL_EMAIL, ],
        self::TYPE_FIELDNAME     => ['employee_id', 'last_name', 'first_name', 'title', 'reports_to', 'birth_date', 'hire_date', 'address', 'city', 'state', 'country', 'postal_code', 'phone', 'fax', 'email', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, ]
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
        self::TYPE_PHPNAME       => ['EmployeeId' => 0, 'LastName' => 1, 'FirstName' => 2, 'Title' => 3, 'ReportsTo' => 4, 'BirthDate' => 5, 'HireDate' => 6, 'Address' => 7, 'City' => 8, 'State' => 9, 'Country' => 10, 'PostalCode' => 11, 'Phone' => 12, 'Fax' => 13, 'Email' => 14, ],
        self::TYPE_CAMELNAME     => ['employeeId' => 0, 'lastName' => 1, 'firstName' => 2, 'title' => 3, 'reportsTo' => 4, 'birthDate' => 5, 'hireDate' => 6, 'address' => 7, 'city' => 8, 'state' => 9, 'country' => 10, 'postalCode' => 11, 'phone' => 12, 'fax' => 13, 'email' => 14, ],
        self::TYPE_COLNAME       => [EmployeeTableMap::COL_EMPLOYEE_ID => 0, EmployeeTableMap::COL_LAST_NAME => 1, EmployeeTableMap::COL_FIRST_NAME => 2, EmployeeTableMap::COL_TITLE => 3, EmployeeTableMap::COL_REPORTS_TO => 4, EmployeeTableMap::COL_BIRTH_DATE => 5, EmployeeTableMap::COL_HIRE_DATE => 6, EmployeeTableMap::COL_ADDRESS => 7, EmployeeTableMap::COL_CITY => 8, EmployeeTableMap::COL_STATE => 9, EmployeeTableMap::COL_COUNTRY => 10, EmployeeTableMap::COL_POSTAL_CODE => 11, EmployeeTableMap::COL_PHONE => 12, EmployeeTableMap::COL_FAX => 13, EmployeeTableMap::COL_EMAIL => 14, ],
        self::TYPE_FIELDNAME     => ['employee_id' => 0, 'last_name' => 1, 'first_name' => 2, 'title' => 3, 'reports_to' => 4, 'birth_date' => 5, 'hire_date' => 6, 'address' => 7, 'city' => 8, 'state' => 9, 'country' => 10, 'postal_code' => 11, 'phone' => 12, 'fax' => 13, 'email' => 14, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'EmployeeId' => 'EMPLOYEE_ID',
        'Employee.EmployeeId' => 'EMPLOYEE_ID',
        'employeeId' => 'EMPLOYEE_ID',
        'employee.employeeId' => 'EMPLOYEE_ID',
        'EmployeeTableMap::COL_EMPLOYEE_ID' => 'EMPLOYEE_ID',
        'COL_EMPLOYEE_ID' => 'EMPLOYEE_ID',
        'employee_id' => 'EMPLOYEE_ID',
        'employee.employee_id' => 'EMPLOYEE_ID',
        'LastName' => 'LAST_NAME',
        'Employee.LastName' => 'LAST_NAME',
        'lastName' => 'LAST_NAME',
        'employee.lastName' => 'LAST_NAME',
        'EmployeeTableMap::COL_LAST_NAME' => 'LAST_NAME',
        'COL_LAST_NAME' => 'LAST_NAME',
        'last_name' => 'LAST_NAME',
        'employee.last_name' => 'LAST_NAME',
        'FirstName' => 'FIRST_NAME',
        'Employee.FirstName' => 'FIRST_NAME',
        'firstName' => 'FIRST_NAME',
        'employee.firstName' => 'FIRST_NAME',
        'EmployeeTableMap::COL_FIRST_NAME' => 'FIRST_NAME',
        'COL_FIRST_NAME' => 'FIRST_NAME',
        'first_name' => 'FIRST_NAME',
        'employee.first_name' => 'FIRST_NAME',
        'Title' => 'TITLE',
        'Employee.Title' => 'TITLE',
        'title' => 'TITLE',
        'employee.title' => 'TITLE',
        'EmployeeTableMap::COL_TITLE' => 'TITLE',
        'COL_TITLE' => 'TITLE',
        'ReportsTo' => 'REPORTS_TO',
        'Employee.ReportsTo' => 'REPORTS_TO',
        'reportsTo' => 'REPORTS_TO',
        'employee.reportsTo' => 'REPORTS_TO',
        'EmployeeTableMap::COL_REPORTS_TO' => 'REPORTS_TO',
        'COL_REPORTS_TO' => 'REPORTS_TO',
        'reports_to' => 'REPORTS_TO',
        'employee.reports_to' => 'REPORTS_TO',
        'BirthDate' => 'BIRTH_DATE',
        'Employee.BirthDate' => 'BIRTH_DATE',
        'birthDate' => 'BIRTH_DATE',
        'employee.birthDate' => 'BIRTH_DATE',
        'EmployeeTableMap::COL_BIRTH_DATE' => 'BIRTH_DATE',
        'COL_BIRTH_DATE' => 'BIRTH_DATE',
        'birth_date' => 'BIRTH_DATE',
        'employee.birth_date' => 'BIRTH_DATE',
        'HireDate' => 'HIRE_DATE',
        'Employee.HireDate' => 'HIRE_DATE',
        'hireDate' => 'HIRE_DATE',
        'employee.hireDate' => 'HIRE_DATE',
        'EmployeeTableMap::COL_HIRE_DATE' => 'HIRE_DATE',
        'COL_HIRE_DATE' => 'HIRE_DATE',
        'hire_date' => 'HIRE_DATE',
        'employee.hire_date' => 'HIRE_DATE',
        'Address' => 'ADDRESS',
        'Employee.Address' => 'ADDRESS',
        'address' => 'ADDRESS',
        'employee.address' => 'ADDRESS',
        'EmployeeTableMap::COL_ADDRESS' => 'ADDRESS',
        'COL_ADDRESS' => 'ADDRESS',
        'City' => 'CITY',
        'Employee.City' => 'CITY',
        'city' => 'CITY',
        'employee.city' => 'CITY',
        'EmployeeTableMap::COL_CITY' => 'CITY',
        'COL_CITY' => 'CITY',
        'State' => 'STATE',
        'Employee.State' => 'STATE',
        'state' => 'STATE',
        'employee.state' => 'STATE',
        'EmployeeTableMap::COL_STATE' => 'STATE',
        'COL_STATE' => 'STATE',
        'Country' => 'COUNTRY',
        'Employee.Country' => 'COUNTRY',
        'country' => 'COUNTRY',
        'employee.country' => 'COUNTRY',
        'EmployeeTableMap::COL_COUNTRY' => 'COUNTRY',
        'COL_COUNTRY' => 'COUNTRY',
        'PostalCode' => 'POSTAL_CODE',
        'Employee.PostalCode' => 'POSTAL_CODE',
        'postalCode' => 'POSTAL_CODE',
        'employee.postalCode' => 'POSTAL_CODE',
        'EmployeeTableMap::COL_POSTAL_CODE' => 'POSTAL_CODE',
        'COL_POSTAL_CODE' => 'POSTAL_CODE',
        'postal_code' => 'POSTAL_CODE',
        'employee.postal_code' => 'POSTAL_CODE',
        'Phone' => 'PHONE',
        'Employee.Phone' => 'PHONE',
        'phone' => 'PHONE',
        'employee.phone' => 'PHONE',
        'EmployeeTableMap::COL_PHONE' => 'PHONE',
        'COL_PHONE' => 'PHONE',
        'Fax' => 'FAX',
        'Employee.Fax' => 'FAX',
        'fax' => 'FAX',
        'employee.fax' => 'FAX',
        'EmployeeTableMap::COL_FAX' => 'FAX',
        'COL_FAX' => 'FAX',
        'Email' => 'EMAIL',
        'Employee.Email' => 'EMAIL',
        'email' => 'EMAIL',
        'employee.email' => 'EMAIL',
        'EmployeeTableMap::COL_EMAIL' => 'EMAIL',
        'COL_EMAIL' => 'EMAIL',
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
        $this->setName('employee');
        $this->setPhpName('Employee');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Chinook\\Models\\Employee');
        $this->setPackage('Chinook.Models');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('employee_employee_id_seq');
        // columns
        $this->addPrimaryKey('employee_id', 'EmployeeId', 'INTEGER', true, null, null);
        $this->addColumn('last_name', 'LastName', 'VARCHAR', true, 20, null);
        $this->addColumn('first_name', 'FirstName', 'VARCHAR', true, 20, null);
        $this->addColumn('title', 'Title', 'VARCHAR', false, 30, null);
        $this->addForeignKey('reports_to', 'ReportsTo', 'INTEGER', 'employee', 'employee_id', false, null, null);
        $this->addColumn('birth_date', 'BirthDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('hire_date', 'HireDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('address', 'Address', 'VARCHAR', false, 70, null);
        $this->addColumn('city', 'City', 'VARCHAR', false, 40, null);
        $this->addColumn('state', 'State', 'VARCHAR', false, 40, null);
        $this->addColumn('country', 'Country', 'VARCHAR', false, 40, null);
        $this->addColumn('postal_code', 'PostalCode', 'VARCHAR', false, 10, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 24, null);
        $this->addColumn('fax', 'Fax', 'VARCHAR', false, 24, null);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 60, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('EmployeeRelatedByReportsTo', '\\Chinook\\Models\\Employee', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':reports_to',
    1 => ':employee_id',
  ),
), null, null, null, false);
        $this->addRelation('Customer', '\\Chinook\\Models\\Customer', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':support_rep_id',
    1 => ':employee_id',
  ),
), null, null, 'Customers', false);
        $this->addRelation('EmployeeRelatedByEmployeeId', '\\Chinook\\Models\\Employee', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':reports_to',
    1 => ':employee_id',
  ),
), null, null, 'EmployeesRelatedByEmployeeId', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EmployeeId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EmployeeId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EmployeeId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EmployeeId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EmployeeId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EmployeeId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('EmployeeId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? EmployeeTableMap::CLASS_DEFAULT : EmployeeTableMap::OM_CLASS;
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
     * @return array (Employee object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = EmployeeTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = EmployeeTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + EmployeeTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = EmployeeTableMap::OM_CLASS;
            /** @var Employee $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            EmployeeTableMap::addInstanceToPool($obj, $key);
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
            $key = EmployeeTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = EmployeeTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Employee $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                EmployeeTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(EmployeeTableMap::COL_EMPLOYEE_ID);
            $criteria->addSelectColumn(EmployeeTableMap::COL_LAST_NAME);
            $criteria->addSelectColumn(EmployeeTableMap::COL_FIRST_NAME);
            $criteria->addSelectColumn(EmployeeTableMap::COL_TITLE);
            $criteria->addSelectColumn(EmployeeTableMap::COL_REPORTS_TO);
            $criteria->addSelectColumn(EmployeeTableMap::COL_BIRTH_DATE);
            $criteria->addSelectColumn(EmployeeTableMap::COL_HIRE_DATE);
            $criteria->addSelectColumn(EmployeeTableMap::COL_ADDRESS);
            $criteria->addSelectColumn(EmployeeTableMap::COL_CITY);
            $criteria->addSelectColumn(EmployeeTableMap::COL_STATE);
            $criteria->addSelectColumn(EmployeeTableMap::COL_COUNTRY);
            $criteria->addSelectColumn(EmployeeTableMap::COL_POSTAL_CODE);
            $criteria->addSelectColumn(EmployeeTableMap::COL_PHONE);
            $criteria->addSelectColumn(EmployeeTableMap::COL_FAX);
            $criteria->addSelectColumn(EmployeeTableMap::COL_EMAIL);
        } else {
            $criteria->addSelectColumn($alias . '.employee_id');
            $criteria->addSelectColumn($alias . '.last_name');
            $criteria->addSelectColumn($alias . '.first_name');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.reports_to');
            $criteria->addSelectColumn($alias . '.birth_date');
            $criteria->addSelectColumn($alias . '.hire_date');
            $criteria->addSelectColumn($alias . '.address');
            $criteria->addSelectColumn($alias . '.city');
            $criteria->addSelectColumn($alias . '.state');
            $criteria->addSelectColumn($alias . '.country');
            $criteria->addSelectColumn($alias . '.postal_code');
            $criteria->addSelectColumn($alias . '.phone');
            $criteria->addSelectColumn($alias . '.fax');
            $criteria->addSelectColumn($alias . '.email');
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
            $criteria->removeSelectColumn(EmployeeTableMap::COL_EMPLOYEE_ID);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_LAST_NAME);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_FIRST_NAME);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_TITLE);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_REPORTS_TO);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_BIRTH_DATE);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_HIRE_DATE);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_ADDRESS);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_CITY);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_STATE);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_COUNTRY);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_POSTAL_CODE);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_PHONE);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_FAX);
            $criteria->removeSelectColumn(EmployeeTableMap::COL_EMAIL);
        } else {
            $criteria->removeSelectColumn($alias . '.employee_id');
            $criteria->removeSelectColumn($alias . '.last_name');
            $criteria->removeSelectColumn($alias . '.first_name');
            $criteria->removeSelectColumn($alias . '.title');
            $criteria->removeSelectColumn($alias . '.reports_to');
            $criteria->removeSelectColumn($alias . '.birth_date');
            $criteria->removeSelectColumn($alias . '.hire_date');
            $criteria->removeSelectColumn($alias . '.address');
            $criteria->removeSelectColumn($alias . '.city');
            $criteria->removeSelectColumn($alias . '.state');
            $criteria->removeSelectColumn($alias . '.country');
            $criteria->removeSelectColumn($alias . '.postal_code');
            $criteria->removeSelectColumn($alias . '.phone');
            $criteria->removeSelectColumn($alias . '.fax');
            $criteria->removeSelectColumn($alias . '.email');
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
        return Propel::getServiceContainer()->getDatabaseMap(EmployeeTableMap::DATABASE_NAME)->getTable(EmployeeTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Employee or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Employee object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeeTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Chinook\Models\Employee) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(EmployeeTableMap::DATABASE_NAME);
            $criteria->add(EmployeeTableMap::COL_EMPLOYEE_ID, (array) $values, Criteria::IN);
        }

        $query = EmployeeQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            EmployeeTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                EmployeeTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the employee table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return EmployeeQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Employee or Criteria object.
     *
     * @param mixed $criteria Criteria or Employee object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeeTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Employee object
        }

        if ($criteria->containsKey(EmployeeTableMap::COL_EMPLOYEE_ID) && $criteria->keyContainsValue(EmployeeTableMap::COL_EMPLOYEE_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.EmployeeTableMap::COL_EMPLOYEE_ID.')');
        }


        // Set the correct dbName
        $query = EmployeeQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
