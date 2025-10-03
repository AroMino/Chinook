<?php

namespace Chinook\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use Chinook\Models\Customer as ChildCustomer;
use Chinook\Models\CustomerQuery as ChildCustomerQuery;
use Chinook\Models\Employee as ChildEmployee;
use Chinook\Models\EmployeeQuery as ChildEmployeeQuery;
use Chinook\Models\Map\CustomerTableMap;
use Chinook\Models\Map\EmployeeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'employee' table.
 *
 *
 *
 * @package    propel.generator.Chinook.Models.Base
 */
abstract class Employee implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\Chinook\\Models\\Map\\EmployeeTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var bool
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var bool
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = [];

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = [];

    /**
     * The value for the employee_id field.
     *
     * @var        int
     */
    protected $employee_id;

    /**
     * The value for the last_name field.
     *
     * @var        string
     */
    protected $last_name;

    /**
     * The value for the first_name field.
     *
     * @var        string
     */
    protected $first_name;

    /**
     * The value for the title field.
     *
     * @var        string|null
     */
    protected $title;

    /**
     * The value for the reports_to field.
     *
     * @var        int|null
     */
    protected $reports_to;

    /**
     * The value for the birth_date field.
     *
     * @var        DateTime|null
     */
    protected $birth_date;

    /**
     * The value for the hire_date field.
     *
     * @var        DateTime|null
     */
    protected $hire_date;

    /**
     * The value for the address field.
     *
     * @var        string|null
     */
    protected $address;

    /**
     * The value for the city field.
     *
     * @var        string|null
     */
    protected $city;

    /**
     * The value for the state field.
     *
     * @var        string|null
     */
    protected $state;

    /**
     * The value for the country field.
     *
     * @var        string|null
     */
    protected $country;

    /**
     * The value for the postal_code field.
     *
     * @var        string|null
     */
    protected $postal_code;

    /**
     * The value for the phone field.
     *
     * @var        string|null
     */
    protected $phone;

    /**
     * The value for the fax field.
     *
     * @var        string|null
     */
    protected $fax;

    /**
     * The value for the email field.
     *
     * @var        string|null
     */
    protected $email;

    /**
     * @var        ChildEmployee
     */
    protected $aEmployeeRelatedByReportsTo;

    /**
     * @var        ObjectCollection|ChildCustomer[] Collection to store aggregation of ChildCustomer objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildCustomer> Collection to store aggregation of ChildCustomer objects.
     */
    protected $collCustomers;
    protected $collCustomersPartial;

    /**
     * @var        ObjectCollection|ChildEmployee[] Collection to store aggregation of ChildEmployee objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildEmployee> Collection to store aggregation of ChildEmployee objects.
     */
    protected $collEmployeesRelatedByEmployeeId;
    protected $collEmployeesRelatedByEmployeeIdPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCustomer[]
     * @phpstan-var ObjectCollection&\Traversable<ChildCustomer>
     */
    protected $customersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEmployee[]
     * @phpstan-var ObjectCollection&\Traversable<ChildEmployee>
     */
    protected $employeesRelatedByEmployeeIdScheduledForDeletion = null;

    /**
     * Initializes internal state of Chinook\Models\Base\Employee object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return bool True if the object has been modified.
     */
    public function isModified(): bool
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param string $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return bool True if $col has been modified.
     */
    public function isColumnModified(string $col): bool
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns(): array
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return bool True, if the object has never been persisted.
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param bool $b the state of the object.
     */
    public function setNew(bool $b): void
    {
        $this->new = $b;
    }

    /**
     * Whether this object has been deleted.
     * @return bool The deleted state of this object.
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param bool $b The deleted state of this object.
     * @return void
     */
    public function setDeleted(bool $b): void
    {
        $this->deleted = $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified(?string $col = null): void
    {
        if (null !== $col) {
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = [];
        }
    }

    /**
     * Compares this with another <code>Employee</code> instance.  If
     * <code>obj</code> is an instance of <code>Employee</code>, delegates to
     * <code>equals(Employee)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param mixed $obj The object to compare to.
     * @return bool Whether equal to the object specified.
     */
    public function equals($obj): bool
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns(): array
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return bool
     */
    public function hasVirtualColumn(string $name): bool
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return mixed
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getVirtualColumn(string $name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of nonexistent virtual column `%s`.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @param mixed $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn(string $name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param string $msg
     * @param int $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log(string $msg, int $priority = Propel::LOG_INFO): void
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param \Propel\Runtime\Parser\AbstractParser|string $parser An AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     * @return string The exported data
     */
    public function exportTo($parser, bool $includeLazyLoadColumns = true, string $keyType = TableMap::TYPE_PHPNAME): string
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     *
     * @return array<string>
     */
    public function __sleep(): array
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [employee_id] column value.
     *
     * @return int
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }

    /**
     * Get the [last_name] column value.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Get the [first_name] column value.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Get the [title] column value.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [reports_to] column value.
     *
     * @return int|null
     */
    public function getReportsTo()
    {
        return $this->reports_to;
    }

    /**
     * Get the [optionally formatted] temporal [birth_date] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime|null : string|null)
     */
    public function getBirthDate($format = null)
    {
        if ($format === null) {
            return $this->birth_date;
        } else {
            return $this->birth_date instanceof \DateTimeInterface ? $this->birth_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [hire_date] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime|null : string|null)
     */
    public function getHireDate($format = null)
    {
        if ($format === null) {
            return $this->hire_date;
        } else {
            return $this->hire_date instanceof \DateTimeInterface ? $this->hire_date->format($format) : null;
        }
    }

    /**
     * Get the [address] column value.
     *
     * @return string|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get the [city] column value.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get the [state] column value.
     *
     * @return string|null
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get the [country] column value.
     *
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get the [postal_code] column value.
     *
     * @return string|null
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * Get the [phone] column value.
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get the [fax] column value.
     *
     * @return string|null
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Get the [email] column value.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of [employee_id] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setEmployeeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->employee_id !== $v) {
            $this->employee_id = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_EMPLOYEE_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [last_name] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setLastName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->last_name !== $v) {
            $this->last_name = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_LAST_NAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [first_name] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setFirstName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->first_name !== $v) {
            $this->first_name = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_FIRST_NAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [title] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_TITLE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [reports_to] column.
     *
     * @param int|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setReportsTo($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->reports_to !== $v) {
            $this->reports_to = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_REPORTS_TO] = true;
        }

        if ($this->aEmployeeRelatedByReportsTo !== null && $this->aEmployeeRelatedByReportsTo->getEmployeeId() !== $v) {
            $this->aEmployeeRelatedByReportsTo = null;
        }

        return $this;
    }

    /**
     * Sets the value of [birth_date] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setBirthDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->birth_date !== null || $dt !== null) {
            if ($this->birth_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->birth_date->format("Y-m-d H:i:s.u")) {
                $this->birth_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EmployeeTableMap::COL_BIRTH_DATE] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [hire_date] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setHireDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->hire_date !== null || $dt !== null) {
            if ($this->hire_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->hire_date->format("Y-m-d H:i:s.u")) {
                $this->hire_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EmployeeTableMap::COL_HIRE_DATE] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [address] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_ADDRESS] = true;
        }

        return $this;
    }

    /**
     * Set the value of [city] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setCity($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->city !== $v) {
            $this->city = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_CITY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [state] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setState($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->state !== $v) {
            $this->state = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_STATE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [country] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setCountry($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->country !== $v) {
            $this->country = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_COUNTRY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [postal_code] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setPostalCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->postal_code !== $v) {
            $this->postal_code = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_POSTAL_CODE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [phone] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_PHONE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fax] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setFax($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fax !== $v) {
            $this->fax = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_FAX] = true;
        }

        return $this;
    }

    /**
     * Set the value of [email] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[EmployeeTableMap::COL_EMAIL] = true;
        }

        return $this;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return bool Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues(): bool
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    }

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by DataFetcher->fetch().
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param bool $rehydrate Whether this object is being re-hydrated from the database.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int next starting column
     * @throws \Propel\Runtime\Exception\PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate(array $row, int $startcol = 0, bool $rehydrate = false, string $indexType = TableMap::TYPE_NUM): int
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : EmployeeTableMap::translateFieldName('EmployeeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->employee_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : EmployeeTableMap::translateFieldName('LastName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->last_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : EmployeeTableMap::translateFieldName('FirstName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->first_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : EmployeeTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : EmployeeTableMap::translateFieldName('ReportsTo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->reports_to = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : EmployeeTableMap::translateFieldName('BirthDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->birth_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : EmployeeTableMap::translateFieldName('HireDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hire_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : EmployeeTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : EmployeeTableMap::translateFieldName('City', TableMap::TYPE_PHPNAME, $indexType)];
            $this->city = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : EmployeeTableMap::translateFieldName('State', TableMap::TYPE_PHPNAME, $indexType)];
            $this->state = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : EmployeeTableMap::translateFieldName('Country', TableMap::TYPE_PHPNAME, $indexType)];
            $this->country = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : EmployeeTableMap::translateFieldName('PostalCode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->postal_code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : EmployeeTableMap::translateFieldName('Phone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : EmployeeTableMap::translateFieldName('Fax', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fax = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : EmployeeTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 15; // 15 = EmployeeTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Chinook\\Models\\Employee'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function ensureConsistency(): void
    {
        if ($this->aEmployeeRelatedByReportsTo !== null && $this->reports_to !== $this->aEmployeeRelatedByReportsTo->getEmployeeId()) {
            $this->aEmployeeRelatedByReportsTo = null;
        }
    }

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param bool $deep (optional) Whether to also de-associated any related objects.
     * @param ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload(bool $deep = false, ?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EmployeeTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEmployeeQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aEmployeeRelatedByReportsTo = null;
            $this->collCustomers = null;

            $this->collEmployeesRelatedByEmployeeId = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see Employee::setDeleted()
     * @see Employee::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeeTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEmployeeQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    public function save(?ConnectionInterface $con = null): int
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeeTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                EmployeeTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con): int
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aEmployeeRelatedByReportsTo !== null) {
                if ($this->aEmployeeRelatedByReportsTo->isModified() || $this->aEmployeeRelatedByReportsTo->isNew()) {
                    $affectedRows += $this->aEmployeeRelatedByReportsTo->save($con);
                }
                $this->setEmployeeRelatedByReportsTo($this->aEmployeeRelatedByReportsTo);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->customersScheduledForDeletion !== null) {
                if (!$this->customersScheduledForDeletion->isEmpty()) {
                    foreach ($this->customersScheduledForDeletion as $customer) {
                        // need to save related object because we set the relation to null
                        $customer->save($con);
                    }
                    $this->customersScheduledForDeletion = null;
                }
            }

            if ($this->collCustomers !== null) {
                foreach ($this->collCustomers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->employeesRelatedByEmployeeIdScheduledForDeletion !== null) {
                if (!$this->employeesRelatedByEmployeeIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->employeesRelatedByEmployeeIdScheduledForDeletion as $employeeRelatedByEmployeeId) {
                        // need to save related object because we set the relation to null
                        $employeeRelatedByEmployeeId->save($con);
                    }
                    $this->employeesRelatedByEmployeeIdScheduledForDeletion = null;
                }
            }

            if ($this->collEmployeesRelatedByEmployeeId !== null) {
                foreach ($this->collEmployeesRelatedByEmployeeId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    }

    /**
     * Insert the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con): void
    {
        $modifiedColumns = [];
        $index = 0;

        $this->modifiedColumns[EmployeeTableMap::COL_EMPLOYEE_ID] = true;
        if (null !== $this->employee_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EmployeeTableMap::COL_EMPLOYEE_ID . ')');
        }
        if (null === $this->employee_id) {
            try {
                $dataFetcher = $con->query("SELECT nextval('employee_employee_id_seq')");
                $this->employee_id = (int) $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EmployeeTableMap::COL_EMPLOYEE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'employee_id';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_LAST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'last_name';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_FIRST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'first_name';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'title';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_REPORTS_TO)) {
            $modifiedColumns[':p' . $index++]  = 'reports_to';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_BIRTH_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'birth_date';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_HIRE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'hire_date';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'address';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_CITY)) {
            $modifiedColumns[':p' . $index++]  = 'city';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_STATE)) {
            $modifiedColumns[':p' . $index++]  = 'state';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_COUNTRY)) {
            $modifiedColumns[':p' . $index++]  = 'country';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_POSTAL_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'postal_code';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_PHONE)) {
            $modifiedColumns[':p' . $index++]  = 'phone';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_FAX)) {
            $modifiedColumns[':p' . $index++]  = 'fax';
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }

        $sql = sprintf(
            'INSERT INTO employee (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'employee_id':
                        $stmt->bindValue($identifier, $this->employee_id, PDO::PARAM_INT);

                        break;
                    case 'last_name':
                        $stmt->bindValue($identifier, $this->last_name, PDO::PARAM_STR);

                        break;
                    case 'first_name':
                        $stmt->bindValue($identifier, $this->first_name, PDO::PARAM_STR);

                        break;
                    case 'title':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);

                        break;
                    case 'reports_to':
                        $stmt->bindValue($identifier, $this->reports_to, PDO::PARAM_INT);

                        break;
                    case 'birth_date':
                        $stmt->bindValue($identifier, $this->birth_date ? $this->birth_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);

                        break;
                    case 'hire_date':
                        $stmt->bindValue($identifier, $this->hire_date ? $this->hire_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);

                        break;
                    case 'address':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);

                        break;
                    case 'city':
                        $stmt->bindValue($identifier, $this->city, PDO::PARAM_STR);

                        break;
                    case 'state':
                        $stmt->bindValue($identifier, $this->state, PDO::PARAM_STR);

                        break;
                    case 'country':
                        $stmt->bindValue($identifier, $this->country, PDO::PARAM_STR);

                        break;
                    case 'postal_code':
                        $stmt->bindValue($identifier, $this->postal_code, PDO::PARAM_STR);

                        break;
                    case 'phone':
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);

                        break;
                    case 'fax':
                        $stmt->bindValue($identifier, $this->fax, PDO::PARAM_STR);

                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);

                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @return int Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con): int
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName(string $name, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EmployeeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos Position in XML schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition(int $pos)
    {
        switch ($pos) {
            case 0:
                return $this->getEmployeeId();

            case 1:
                return $this->getLastName();

            case 2:
                return $this->getFirstName();

            case 3:
                return $this->getTitle();

            case 4:
                return $this->getReportsTo();

            case 5:
                return $this->getBirthDate();

            case 6:
                return $this->getHireDate();

            case 7:
                return $this->getAddress();

            case 8:
                return $this->getCity();

            case 9:
                return $this->getState();

            case 10:
                return $this->getCountry();

            case 11:
                return $this->getPostalCode();

            case 12:
                return $this->getPhone();

            case 13:
                return $this->getFax();

            case 14:
                return $this->getEmail();

            default:
                return null;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param bool $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array An associative array containing the field names (as keys) and field values
     */
    public function toArray(string $keyType = TableMap::TYPE_PHPNAME, bool $includeLazyLoadColumns = true, array $alreadyDumpedObjects = [], bool $includeForeignObjects = false): array
    {
        if (isset($alreadyDumpedObjects['Employee'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Employee'][$this->hashCode()] = true;
        $keys = EmployeeTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getEmployeeId(),
            $keys[1] => $this->getLastName(),
            $keys[2] => $this->getFirstName(),
            $keys[3] => $this->getTitle(),
            $keys[4] => $this->getReportsTo(),
            $keys[5] => $this->getBirthDate(),
            $keys[6] => $this->getHireDate(),
            $keys[7] => $this->getAddress(),
            $keys[8] => $this->getCity(),
            $keys[9] => $this->getState(),
            $keys[10] => $this->getCountry(),
            $keys[11] => $this->getPostalCode(),
            $keys[12] => $this->getPhone(),
            $keys[13] => $this->getFax(),
            $keys[14] => $this->getEmail(),
        ];
        if ($result[$keys[5]] instanceof \DateTimeInterface) {
            $result[$keys[5]] = $result[$keys[5]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[6]] instanceof \DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aEmployeeRelatedByReportsTo) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'employee';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'employee';
                        break;
                    default:
                        $key = 'Employee';
                }

                $result[$key] = $this->aEmployeeRelatedByReportsTo->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCustomers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'customers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'customers';
                        break;
                    default:
                        $key = 'Customers';
                }

                $result[$key] = $this->collCustomers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collEmployeesRelatedByEmployeeId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'employees';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'employees';
                        break;
                    default:
                        $key = 'Employees';
                }

                $result[$key] = $this->collEmployeesRelatedByEmployeeId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this
     */
    public function setByName(string $name, $value, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EmployeeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        $this->setByPosition($pos, $value);

        return $this;
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return $this
     */
    public function setByPosition(int $pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setEmployeeId($value);
                break;
            case 1:
                $this->setLastName($value);
                break;
            case 2:
                $this->setFirstName($value);
                break;
            case 3:
                $this->setTitle($value);
                break;
            case 4:
                $this->setReportsTo($value);
                break;
            case 5:
                $this->setBirthDate($value);
                break;
            case 6:
                $this->setHireDate($value);
                break;
            case 7:
                $this->setAddress($value);
                break;
            case 8:
                $this->setCity($value);
                break;
            case 9:
                $this->setState($value);
                break;
            case 10:
                $this->setCountry($value);
                break;
            case 11:
                $this->setPostalCode($value);
                break;
            case 12:
                $this->setPhone($value);
                break;
            case 13:
                $this->setFax($value);
                break;
            case 14:
                $this->setEmail($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param array $arr An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return $this
     */
    public function fromArray(array $arr, string $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = EmployeeTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setEmployeeId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setLastName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFirstName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTitle($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setReportsTo($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setBirthDate($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setHireDate($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setAddress($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setCity($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setState($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setCountry($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setPostalCode($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setPhone($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setFax($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setEmail($arr[$keys[14]]);
        }

        return $this;
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this The current object, for fluid interface
     */
    public function importFrom($parser, string $data, string $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria(): Criteria
    {
        $criteria = new Criteria(EmployeeTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EmployeeTableMap::COL_EMPLOYEE_ID)) {
            $criteria->add(EmployeeTableMap::COL_EMPLOYEE_ID, $this->employee_id);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_LAST_NAME)) {
            $criteria->add(EmployeeTableMap::COL_LAST_NAME, $this->last_name);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_FIRST_NAME)) {
            $criteria->add(EmployeeTableMap::COL_FIRST_NAME, $this->first_name);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_TITLE)) {
            $criteria->add(EmployeeTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_REPORTS_TO)) {
            $criteria->add(EmployeeTableMap::COL_REPORTS_TO, $this->reports_to);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_BIRTH_DATE)) {
            $criteria->add(EmployeeTableMap::COL_BIRTH_DATE, $this->birth_date);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_HIRE_DATE)) {
            $criteria->add(EmployeeTableMap::COL_HIRE_DATE, $this->hire_date);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_ADDRESS)) {
            $criteria->add(EmployeeTableMap::COL_ADDRESS, $this->address);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_CITY)) {
            $criteria->add(EmployeeTableMap::COL_CITY, $this->city);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_STATE)) {
            $criteria->add(EmployeeTableMap::COL_STATE, $this->state);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_COUNTRY)) {
            $criteria->add(EmployeeTableMap::COL_COUNTRY, $this->country);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_POSTAL_CODE)) {
            $criteria->add(EmployeeTableMap::COL_POSTAL_CODE, $this->postal_code);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_PHONE)) {
            $criteria->add(EmployeeTableMap::COL_PHONE, $this->phone);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_FAX)) {
            $criteria->add(EmployeeTableMap::COL_FAX, $this->fax);
        }
        if ($this->isColumnModified(EmployeeTableMap::COL_EMAIL)) {
            $criteria->add(EmployeeTableMap::COL_EMAIL, $this->email);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria(): Criteria
    {
        $criteria = ChildEmployeeQuery::create();
        $criteria->add(EmployeeTableMap::COL_EMPLOYEE_ID, $this->employee_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int|string Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getEmployeeId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getEmployeeId();
    }

    /**
     * Generic method to set the primary key (employee_id column).
     *
     * @param int|null $key Primary key.
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setEmployeeId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return null === $this->getEmployeeId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \Chinook\Models\Employee (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setLastName($this->getLastName());
        $copyObj->setFirstName($this->getFirstName());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setReportsTo($this->getReportsTo());
        $copyObj->setBirthDate($this->getBirthDate());
        $copyObj->setHireDate($this->getHireDate());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setCity($this->getCity());
        $copyObj->setState($this->getState());
        $copyObj->setCountry($this->getCountry());
        $copyObj->setPostalCode($this->getPostalCode());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setFax($this->getFax());
        $copyObj->setEmail($this->getEmail());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCustomers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCustomer($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getEmployeesRelatedByEmployeeId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEmployeeRelatedByEmployeeId($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setEmployeeId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Chinook\Models\Employee Clone of current object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function copy(bool $deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildEmployee object.
     *
     * @param ChildEmployee|null $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setEmployeeRelatedByReportsTo(ChildEmployee $v = null)
    {
        if ($v === null) {
            $this->setReportsTo(NULL);
        } else {
            $this->setReportsTo($v->getEmployeeId());
        }

        $this->aEmployeeRelatedByReportsTo = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildEmployee object, it will not be re-added.
        if ($v !== null) {
            $v->addEmployeeRelatedByEmployeeId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildEmployee object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildEmployee|null The associated ChildEmployee object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getEmployeeRelatedByReportsTo(?ConnectionInterface $con = null)
    {
        if ($this->aEmployeeRelatedByReportsTo === null && ($this->reports_to != 0)) {
            $this->aEmployeeRelatedByReportsTo = ChildEmployeeQuery::create()->findPk($this->reports_to, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEmployeeRelatedByReportsTo->addEmployeesRelatedByEmployeeId($this);
             */
        }

        return $this->aEmployeeRelatedByReportsTo;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName): void
    {
        if ('Customer' === $relationName) {
            $this->initCustomers();
            return;
        }
        if ('EmployeeRelatedByEmployeeId' === $relationName) {
            $this->initEmployeesRelatedByEmployeeId();
            return;
        }
    }

    /**
     * Clears out the collCustomers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addCustomers()
     */
    public function clearCustomers()
    {
        $this->collCustomers = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collCustomers collection loaded partially.
     *
     * @return void
     */
    public function resetPartialCustomers($v = true): void
    {
        $this->collCustomersPartial = $v;
    }

    /**
     * Initializes the collCustomers collection.
     *
     * By default this just sets the collCustomers collection to an empty array (like clearcollCustomers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCustomers(bool $overrideExisting = true): void
    {
        if (null !== $this->collCustomers && !$overrideExisting) {
            return;
        }

        $collectionClassName = CustomerTableMap::getTableMap()->getCollectionClassName();

        $this->collCustomers = new $collectionClassName;
        $this->collCustomers->setModel('\Chinook\Models\Customer');
    }

    /**
     * Gets an array of ChildCustomer objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmployee is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCustomer[] List of ChildCustomer objects
     * @phpstan-return ObjectCollection&\Traversable<ChildCustomer> List of ChildCustomer objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getCustomers(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collCustomersPartial && !$this->isNew();
        if (null === $this->collCustomers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collCustomers) {
                    $this->initCustomers();
                } else {
                    $collectionClassName = CustomerTableMap::getTableMap()->getCollectionClassName();

                    $collCustomers = new $collectionClassName;
                    $collCustomers->setModel('\Chinook\Models\Customer');

                    return $collCustomers;
                }
            } else {
                $collCustomers = ChildCustomerQuery::create(null, $criteria)
                    ->filterByEmployee($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCustomersPartial && count($collCustomers)) {
                        $this->initCustomers(false);

                        foreach ($collCustomers as $obj) {
                            if (false == $this->collCustomers->contains($obj)) {
                                $this->collCustomers->append($obj);
                            }
                        }

                        $this->collCustomersPartial = true;
                    }

                    return $collCustomers;
                }

                if ($partial && $this->collCustomers) {
                    foreach ($this->collCustomers as $obj) {
                        if ($obj->isNew()) {
                            $collCustomers[] = $obj;
                        }
                    }
                }

                $this->collCustomers = $collCustomers;
                $this->collCustomersPartial = false;
            }
        }

        return $this->collCustomers;
    }

    /**
     * Sets a collection of ChildCustomer objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $customers A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setCustomers(Collection $customers, ?ConnectionInterface $con = null)
    {
        /** @var ChildCustomer[] $customersToDelete */
        $customersToDelete = $this->getCustomers(new Criteria(), $con)->diff($customers);


        $this->customersScheduledForDeletion = $customersToDelete;

        foreach ($customersToDelete as $customerRemoved) {
            $customerRemoved->setEmployee(null);
        }

        $this->collCustomers = null;
        foreach ($customers as $customer) {
            $this->addCustomer($customer);
        }

        $this->collCustomers = $customers;
        $this->collCustomersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Customer objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related Customer objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countCustomers(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collCustomersPartial && !$this->isNew();
        if (null === $this->collCustomers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCustomers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCustomers());
            }

            $query = ChildCustomerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmployee($this)
                ->count($con);
        }

        return count($this->collCustomers);
    }

    /**
     * Method called to associate a ChildCustomer object to this object
     * through the ChildCustomer foreign key attribute.
     *
     * @param ChildCustomer $l ChildCustomer
     * @return $this The current object (for fluent API support)
     */
    public function addCustomer(ChildCustomer $l)
    {
        if ($this->collCustomers === null) {
            $this->initCustomers();
            $this->collCustomersPartial = true;
        }

        if (!$this->collCustomers->contains($l)) {
            $this->doAddCustomer($l);

            if ($this->customersScheduledForDeletion and $this->customersScheduledForDeletion->contains($l)) {
                $this->customersScheduledForDeletion->remove($this->customersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCustomer $customer The ChildCustomer object to add.
     */
    protected function doAddCustomer(ChildCustomer $customer): void
    {
        $this->collCustomers[]= $customer;
        $customer->setEmployee($this);
    }

    /**
     * @param ChildCustomer $customer The ChildCustomer object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeCustomer(ChildCustomer $customer)
    {
        if ($this->getCustomers()->contains($customer)) {
            $pos = $this->collCustomers->search($customer);
            $this->collCustomers->remove($pos);
            if (null === $this->customersScheduledForDeletion) {
                $this->customersScheduledForDeletion = clone $this->collCustomers;
                $this->customersScheduledForDeletion->clear();
            }
            $this->customersScheduledForDeletion[]= $customer;
            $customer->setEmployee(null);
        }

        return $this;
    }

    /**
     * Clears out the collEmployeesRelatedByEmployeeId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addEmployeesRelatedByEmployeeId()
     */
    public function clearEmployeesRelatedByEmployeeId()
    {
        $this->collEmployeesRelatedByEmployeeId = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collEmployeesRelatedByEmployeeId collection loaded partially.
     *
     * @return void
     */
    public function resetPartialEmployeesRelatedByEmployeeId($v = true): void
    {
        $this->collEmployeesRelatedByEmployeeIdPartial = $v;
    }

    /**
     * Initializes the collEmployeesRelatedByEmployeeId collection.
     *
     * By default this just sets the collEmployeesRelatedByEmployeeId collection to an empty array (like clearcollEmployeesRelatedByEmployeeId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEmployeesRelatedByEmployeeId(bool $overrideExisting = true): void
    {
        if (null !== $this->collEmployeesRelatedByEmployeeId && !$overrideExisting) {
            return;
        }

        $collectionClassName = EmployeeTableMap::getTableMap()->getCollectionClassName();

        $this->collEmployeesRelatedByEmployeeId = new $collectionClassName;
        $this->collEmployeesRelatedByEmployeeId->setModel('\Chinook\Models\Employee');
    }

    /**
     * Gets an array of ChildEmployee objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmployee is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEmployee[] List of ChildEmployee objects
     * @phpstan-return ObjectCollection&\Traversable<ChildEmployee> List of ChildEmployee objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getEmployeesRelatedByEmployeeId(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collEmployeesRelatedByEmployeeIdPartial && !$this->isNew();
        if (null === $this->collEmployeesRelatedByEmployeeId || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collEmployeesRelatedByEmployeeId) {
                    $this->initEmployeesRelatedByEmployeeId();
                } else {
                    $collectionClassName = EmployeeTableMap::getTableMap()->getCollectionClassName();

                    $collEmployeesRelatedByEmployeeId = new $collectionClassName;
                    $collEmployeesRelatedByEmployeeId->setModel('\Chinook\Models\Employee');

                    return $collEmployeesRelatedByEmployeeId;
                }
            } else {
                $collEmployeesRelatedByEmployeeId = ChildEmployeeQuery::create(null, $criteria)
                    ->filterByEmployeeRelatedByReportsTo($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEmployeesRelatedByEmployeeIdPartial && count($collEmployeesRelatedByEmployeeId)) {
                        $this->initEmployeesRelatedByEmployeeId(false);

                        foreach ($collEmployeesRelatedByEmployeeId as $obj) {
                            if (false == $this->collEmployeesRelatedByEmployeeId->contains($obj)) {
                                $this->collEmployeesRelatedByEmployeeId->append($obj);
                            }
                        }

                        $this->collEmployeesRelatedByEmployeeIdPartial = true;
                    }

                    return $collEmployeesRelatedByEmployeeId;
                }

                if ($partial && $this->collEmployeesRelatedByEmployeeId) {
                    foreach ($this->collEmployeesRelatedByEmployeeId as $obj) {
                        if ($obj->isNew()) {
                            $collEmployeesRelatedByEmployeeId[] = $obj;
                        }
                    }
                }

                $this->collEmployeesRelatedByEmployeeId = $collEmployeesRelatedByEmployeeId;
                $this->collEmployeesRelatedByEmployeeIdPartial = false;
            }
        }

        return $this->collEmployeesRelatedByEmployeeId;
    }

    /**
     * Sets a collection of ChildEmployee objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $employeesRelatedByEmployeeId A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setEmployeesRelatedByEmployeeId(Collection $employeesRelatedByEmployeeId, ?ConnectionInterface $con = null)
    {
        /** @var ChildEmployee[] $employeesRelatedByEmployeeIdToDelete */
        $employeesRelatedByEmployeeIdToDelete = $this->getEmployeesRelatedByEmployeeId(new Criteria(), $con)->diff($employeesRelatedByEmployeeId);


        $this->employeesRelatedByEmployeeIdScheduledForDeletion = $employeesRelatedByEmployeeIdToDelete;

        foreach ($employeesRelatedByEmployeeIdToDelete as $employeeRelatedByEmployeeIdRemoved) {
            $employeeRelatedByEmployeeIdRemoved->setEmployeeRelatedByReportsTo(null);
        }

        $this->collEmployeesRelatedByEmployeeId = null;
        foreach ($employeesRelatedByEmployeeId as $employeeRelatedByEmployeeId) {
            $this->addEmployeeRelatedByEmployeeId($employeeRelatedByEmployeeId);
        }

        $this->collEmployeesRelatedByEmployeeId = $employeesRelatedByEmployeeId;
        $this->collEmployeesRelatedByEmployeeIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Employee objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related Employee objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countEmployeesRelatedByEmployeeId(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collEmployeesRelatedByEmployeeIdPartial && !$this->isNew();
        if (null === $this->collEmployeesRelatedByEmployeeId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEmployeesRelatedByEmployeeId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEmployeesRelatedByEmployeeId());
            }

            $query = ChildEmployeeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmployeeRelatedByReportsTo($this)
                ->count($con);
        }

        return count($this->collEmployeesRelatedByEmployeeId);
    }

    /**
     * Method called to associate a ChildEmployee object to this object
     * through the ChildEmployee foreign key attribute.
     *
     * @param ChildEmployee $l ChildEmployee
     * @return $this The current object (for fluent API support)
     */
    public function addEmployeeRelatedByEmployeeId(ChildEmployee $l)
    {
        if ($this->collEmployeesRelatedByEmployeeId === null) {
            $this->initEmployeesRelatedByEmployeeId();
            $this->collEmployeesRelatedByEmployeeIdPartial = true;
        }

        if (!$this->collEmployeesRelatedByEmployeeId->contains($l)) {
            $this->doAddEmployeeRelatedByEmployeeId($l);

            if ($this->employeesRelatedByEmployeeIdScheduledForDeletion and $this->employeesRelatedByEmployeeIdScheduledForDeletion->contains($l)) {
                $this->employeesRelatedByEmployeeIdScheduledForDeletion->remove($this->employeesRelatedByEmployeeIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildEmployee $employeeRelatedByEmployeeId The ChildEmployee object to add.
     */
    protected function doAddEmployeeRelatedByEmployeeId(ChildEmployee $employeeRelatedByEmployeeId): void
    {
        $this->collEmployeesRelatedByEmployeeId[]= $employeeRelatedByEmployeeId;
        $employeeRelatedByEmployeeId->setEmployeeRelatedByReportsTo($this);
    }

    /**
     * @param ChildEmployee $employeeRelatedByEmployeeId The ChildEmployee object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeEmployeeRelatedByEmployeeId(ChildEmployee $employeeRelatedByEmployeeId)
    {
        if ($this->getEmployeesRelatedByEmployeeId()->contains($employeeRelatedByEmployeeId)) {
            $pos = $this->collEmployeesRelatedByEmployeeId->search($employeeRelatedByEmployeeId);
            $this->collEmployeesRelatedByEmployeeId->remove($pos);
            if (null === $this->employeesRelatedByEmployeeIdScheduledForDeletion) {
                $this->employeesRelatedByEmployeeIdScheduledForDeletion = clone $this->collEmployeesRelatedByEmployeeId;
                $this->employeesRelatedByEmployeeIdScheduledForDeletion->clear();
            }
            $this->employeesRelatedByEmployeeIdScheduledForDeletion[]= $employeeRelatedByEmployeeId;
            $employeeRelatedByEmployeeId->setEmployeeRelatedByReportsTo(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     *
     * @return $this
     */
    public function clear()
    {
        if (null !== $this->aEmployeeRelatedByReportsTo) {
            $this->aEmployeeRelatedByReportsTo->removeEmployeeRelatedByEmployeeId($this);
        }
        $this->employee_id = null;
        $this->last_name = null;
        $this->first_name = null;
        $this->title = null;
        $this->reports_to = null;
        $this->birth_date = null;
        $this->hire_date = null;
        $this->address = null;
        $this->city = null;
        $this->state = null;
        $this->country = null;
        $this->postal_code = null;
        $this->phone = null;
        $this->fax = null;
        $this->email = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);

        return $this;
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param bool $deep Whether to also clear the references on all referrer objects.
     * @return $this
     */
    public function clearAllReferences(bool $deep = false)
    {
        if ($deep) {
            if ($this->collCustomers) {
                foreach ($this->collCustomers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEmployeesRelatedByEmployeeId) {
                foreach ($this->collEmployeesRelatedByEmployeeId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCustomers = null;
        $this->collEmployeesRelatedByEmployeeId = null;
        $this->aEmployeeRelatedByReportsTo = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(EmployeeTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preSave(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postSave(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before inserting to database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preInsert(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postInsert(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preUpdate(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postUpdate(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preDelete(?ConnectionInterface $con = null): bool
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postDelete(?ConnectionInterface $con = null): void
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);
            $inputData = $params[0];
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->importFrom($format, $inputData, $keyType);
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = $params[0] ?? true;
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->exportTo($format, $includeLazyLoadColumns, $keyType);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
