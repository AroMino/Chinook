<?php

namespace Chinook\Models\Map;

use Chinook\Models\Invoice;
use Chinook\Models\InvoiceQuery;
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
 * This class defines the structure of the 'invoice' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class InvoiceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Chinook.Models.Map.InvoiceTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'invoice';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Invoice';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Chinook\\Models\\Invoice';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Chinook.Models.Invoice';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the invoice_id field
     */
    public const COL_INVOICE_ID = 'invoice.invoice_id';

    /**
     * the column name for the customer_id field
     */
    public const COL_CUSTOMER_ID = 'invoice.customer_id';

    /**
     * the column name for the invoice_date field
     */
    public const COL_INVOICE_DATE = 'invoice.invoice_date';

    /**
     * the column name for the billing_address field
     */
    public const COL_BILLING_ADDRESS = 'invoice.billing_address';

    /**
     * the column name for the billing_city field
     */
    public const COL_BILLING_CITY = 'invoice.billing_city';

    /**
     * the column name for the billing_state field
     */
    public const COL_BILLING_STATE = 'invoice.billing_state';

    /**
     * the column name for the billing_country field
     */
    public const COL_BILLING_COUNTRY = 'invoice.billing_country';

    /**
     * the column name for the billing_postal_code field
     */
    public const COL_BILLING_POSTAL_CODE = 'invoice.billing_postal_code';

    /**
     * the column name for the total field
     */
    public const COL_TOTAL = 'invoice.total';

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
        self::TYPE_PHPNAME       => ['InvoiceId', 'CustomerId', 'InvoiceDate', 'BillingAddress', 'BillingCity', 'BillingState', 'BillingCountry', 'BillingPostalCode', 'Total', ],
        self::TYPE_CAMELNAME     => ['invoiceId', 'customerId', 'invoiceDate', 'billingAddress', 'billingCity', 'billingState', 'billingCountry', 'billingPostalCode', 'total', ],
        self::TYPE_COLNAME       => [InvoiceTableMap::COL_INVOICE_ID, InvoiceTableMap::COL_CUSTOMER_ID, InvoiceTableMap::COL_INVOICE_DATE, InvoiceTableMap::COL_BILLING_ADDRESS, InvoiceTableMap::COL_BILLING_CITY, InvoiceTableMap::COL_BILLING_STATE, InvoiceTableMap::COL_BILLING_COUNTRY, InvoiceTableMap::COL_BILLING_POSTAL_CODE, InvoiceTableMap::COL_TOTAL, ],
        self::TYPE_FIELDNAME     => ['invoice_id', 'customer_id', 'invoice_date', 'billing_address', 'billing_city', 'billing_state', 'billing_country', 'billing_postal_code', 'total', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, ]
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
        self::TYPE_PHPNAME       => ['InvoiceId' => 0, 'CustomerId' => 1, 'InvoiceDate' => 2, 'BillingAddress' => 3, 'BillingCity' => 4, 'BillingState' => 5, 'BillingCountry' => 6, 'BillingPostalCode' => 7, 'Total' => 8, ],
        self::TYPE_CAMELNAME     => ['invoiceId' => 0, 'customerId' => 1, 'invoiceDate' => 2, 'billingAddress' => 3, 'billingCity' => 4, 'billingState' => 5, 'billingCountry' => 6, 'billingPostalCode' => 7, 'total' => 8, ],
        self::TYPE_COLNAME       => [InvoiceTableMap::COL_INVOICE_ID => 0, InvoiceTableMap::COL_CUSTOMER_ID => 1, InvoiceTableMap::COL_INVOICE_DATE => 2, InvoiceTableMap::COL_BILLING_ADDRESS => 3, InvoiceTableMap::COL_BILLING_CITY => 4, InvoiceTableMap::COL_BILLING_STATE => 5, InvoiceTableMap::COL_BILLING_COUNTRY => 6, InvoiceTableMap::COL_BILLING_POSTAL_CODE => 7, InvoiceTableMap::COL_TOTAL => 8, ],
        self::TYPE_FIELDNAME     => ['invoice_id' => 0, 'customer_id' => 1, 'invoice_date' => 2, 'billing_address' => 3, 'billing_city' => 4, 'billing_state' => 5, 'billing_country' => 6, 'billing_postal_code' => 7, 'total' => 8, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'InvoiceId' => 'INVOICE_ID',
        'Invoice.InvoiceId' => 'INVOICE_ID',
        'invoiceId' => 'INVOICE_ID',
        'invoice.invoiceId' => 'INVOICE_ID',
        'InvoiceTableMap::COL_INVOICE_ID' => 'INVOICE_ID',
        'COL_INVOICE_ID' => 'INVOICE_ID',
        'invoice_id' => 'INVOICE_ID',
        'invoice.invoice_id' => 'INVOICE_ID',
        'CustomerId' => 'CUSTOMER_ID',
        'Invoice.CustomerId' => 'CUSTOMER_ID',
        'customerId' => 'CUSTOMER_ID',
        'invoice.customerId' => 'CUSTOMER_ID',
        'InvoiceTableMap::COL_CUSTOMER_ID' => 'CUSTOMER_ID',
        'COL_CUSTOMER_ID' => 'CUSTOMER_ID',
        'customer_id' => 'CUSTOMER_ID',
        'invoice.customer_id' => 'CUSTOMER_ID',
        'InvoiceDate' => 'INVOICE_DATE',
        'Invoice.InvoiceDate' => 'INVOICE_DATE',
        'invoiceDate' => 'INVOICE_DATE',
        'invoice.invoiceDate' => 'INVOICE_DATE',
        'InvoiceTableMap::COL_INVOICE_DATE' => 'INVOICE_DATE',
        'COL_INVOICE_DATE' => 'INVOICE_DATE',
        'invoice_date' => 'INVOICE_DATE',
        'invoice.invoice_date' => 'INVOICE_DATE',
        'BillingAddress' => 'BILLING_ADDRESS',
        'Invoice.BillingAddress' => 'BILLING_ADDRESS',
        'billingAddress' => 'BILLING_ADDRESS',
        'invoice.billingAddress' => 'BILLING_ADDRESS',
        'InvoiceTableMap::COL_BILLING_ADDRESS' => 'BILLING_ADDRESS',
        'COL_BILLING_ADDRESS' => 'BILLING_ADDRESS',
        'billing_address' => 'BILLING_ADDRESS',
        'invoice.billing_address' => 'BILLING_ADDRESS',
        'BillingCity' => 'BILLING_CITY',
        'Invoice.BillingCity' => 'BILLING_CITY',
        'billingCity' => 'BILLING_CITY',
        'invoice.billingCity' => 'BILLING_CITY',
        'InvoiceTableMap::COL_BILLING_CITY' => 'BILLING_CITY',
        'COL_BILLING_CITY' => 'BILLING_CITY',
        'billing_city' => 'BILLING_CITY',
        'invoice.billing_city' => 'BILLING_CITY',
        'BillingState' => 'BILLING_STATE',
        'Invoice.BillingState' => 'BILLING_STATE',
        'billingState' => 'BILLING_STATE',
        'invoice.billingState' => 'BILLING_STATE',
        'InvoiceTableMap::COL_BILLING_STATE' => 'BILLING_STATE',
        'COL_BILLING_STATE' => 'BILLING_STATE',
        'billing_state' => 'BILLING_STATE',
        'invoice.billing_state' => 'BILLING_STATE',
        'BillingCountry' => 'BILLING_COUNTRY',
        'Invoice.BillingCountry' => 'BILLING_COUNTRY',
        'billingCountry' => 'BILLING_COUNTRY',
        'invoice.billingCountry' => 'BILLING_COUNTRY',
        'InvoiceTableMap::COL_BILLING_COUNTRY' => 'BILLING_COUNTRY',
        'COL_BILLING_COUNTRY' => 'BILLING_COUNTRY',
        'billing_country' => 'BILLING_COUNTRY',
        'invoice.billing_country' => 'BILLING_COUNTRY',
        'BillingPostalCode' => 'BILLING_POSTAL_CODE',
        'Invoice.BillingPostalCode' => 'BILLING_POSTAL_CODE',
        'billingPostalCode' => 'BILLING_POSTAL_CODE',
        'invoice.billingPostalCode' => 'BILLING_POSTAL_CODE',
        'InvoiceTableMap::COL_BILLING_POSTAL_CODE' => 'BILLING_POSTAL_CODE',
        'COL_BILLING_POSTAL_CODE' => 'BILLING_POSTAL_CODE',
        'billing_postal_code' => 'BILLING_POSTAL_CODE',
        'invoice.billing_postal_code' => 'BILLING_POSTAL_CODE',
        'Total' => 'TOTAL',
        'Invoice.Total' => 'TOTAL',
        'total' => 'TOTAL',
        'invoice.total' => 'TOTAL',
        'InvoiceTableMap::COL_TOTAL' => 'TOTAL',
        'COL_TOTAL' => 'TOTAL',
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
        $this->setName('invoice');
        $this->setPhpName('Invoice');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Chinook\\Models\\Invoice');
        $this->setPackage('Chinook.Models');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('invoice_invoice_id_seq');
        // columns
        $this->addPrimaryKey('invoice_id', 'InvoiceId', 'INTEGER', true, null, null);
        $this->addForeignKey('customer_id', 'CustomerId', 'INTEGER', 'customer', 'customer_id', true, null, null);
        $this->addColumn('invoice_date', 'InvoiceDate', 'TIMESTAMP', true, null, null);
        $this->addColumn('billing_address', 'BillingAddress', 'VARCHAR', false, 70, null);
        $this->addColumn('billing_city', 'BillingCity', 'VARCHAR', false, 40, null);
        $this->addColumn('billing_state', 'BillingState', 'VARCHAR', false, 40, null);
        $this->addColumn('billing_country', 'BillingCountry', 'VARCHAR', false, 40, null);
        $this->addColumn('billing_postal_code', 'BillingPostalCode', 'VARCHAR', false, 10, null);
        $this->addColumn('total', 'Total', 'DECIMAL', true, 10, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('Customer', '\\Chinook\\Models\\Customer', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':customer_id',
    1 => ':customer_id',
  ),
), null, null, null, false);
        $this->addRelation('InvoiceLine', '\\Chinook\\Models\\InvoiceLine', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':invoice_id',
    1 => ':invoice_id',
  ),
), null, null, 'InvoiceLines', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('InvoiceId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? InvoiceTableMap::CLASS_DEFAULT : InvoiceTableMap::OM_CLASS;
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
     * @return array (Invoice object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = InvoiceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = InvoiceTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + InvoiceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = InvoiceTableMap::OM_CLASS;
            /** @var Invoice $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            InvoiceTableMap::addInstanceToPool($obj, $key);
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
            $key = InvoiceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = InvoiceTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Invoice $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                InvoiceTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(InvoiceTableMap::COL_INVOICE_ID);
            $criteria->addSelectColumn(InvoiceTableMap::COL_CUSTOMER_ID);
            $criteria->addSelectColumn(InvoiceTableMap::COL_INVOICE_DATE);
            $criteria->addSelectColumn(InvoiceTableMap::COL_BILLING_ADDRESS);
            $criteria->addSelectColumn(InvoiceTableMap::COL_BILLING_CITY);
            $criteria->addSelectColumn(InvoiceTableMap::COL_BILLING_STATE);
            $criteria->addSelectColumn(InvoiceTableMap::COL_BILLING_COUNTRY);
            $criteria->addSelectColumn(InvoiceTableMap::COL_BILLING_POSTAL_CODE);
            $criteria->addSelectColumn(InvoiceTableMap::COL_TOTAL);
        } else {
            $criteria->addSelectColumn($alias . '.invoice_id');
            $criteria->addSelectColumn($alias . '.customer_id');
            $criteria->addSelectColumn($alias . '.invoice_date');
            $criteria->addSelectColumn($alias . '.billing_address');
            $criteria->addSelectColumn($alias . '.billing_city');
            $criteria->addSelectColumn($alias . '.billing_state');
            $criteria->addSelectColumn($alias . '.billing_country');
            $criteria->addSelectColumn($alias . '.billing_postal_code');
            $criteria->addSelectColumn($alias . '.total');
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
            $criteria->removeSelectColumn(InvoiceTableMap::COL_INVOICE_ID);
            $criteria->removeSelectColumn(InvoiceTableMap::COL_CUSTOMER_ID);
            $criteria->removeSelectColumn(InvoiceTableMap::COL_INVOICE_DATE);
            $criteria->removeSelectColumn(InvoiceTableMap::COL_BILLING_ADDRESS);
            $criteria->removeSelectColumn(InvoiceTableMap::COL_BILLING_CITY);
            $criteria->removeSelectColumn(InvoiceTableMap::COL_BILLING_STATE);
            $criteria->removeSelectColumn(InvoiceTableMap::COL_BILLING_COUNTRY);
            $criteria->removeSelectColumn(InvoiceTableMap::COL_BILLING_POSTAL_CODE);
            $criteria->removeSelectColumn(InvoiceTableMap::COL_TOTAL);
        } else {
            $criteria->removeSelectColumn($alias . '.invoice_id');
            $criteria->removeSelectColumn($alias . '.customer_id');
            $criteria->removeSelectColumn($alias . '.invoice_date');
            $criteria->removeSelectColumn($alias . '.billing_address');
            $criteria->removeSelectColumn($alias . '.billing_city');
            $criteria->removeSelectColumn($alias . '.billing_state');
            $criteria->removeSelectColumn($alias . '.billing_country');
            $criteria->removeSelectColumn($alias . '.billing_postal_code');
            $criteria->removeSelectColumn($alias . '.total');
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
        return Propel::getServiceContainer()->getDatabaseMap(InvoiceTableMap::DATABASE_NAME)->getTable(InvoiceTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Invoice or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Invoice object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(InvoiceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Chinook\Models\Invoice) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(InvoiceTableMap::DATABASE_NAME);
            $criteria->add(InvoiceTableMap::COL_INVOICE_ID, (array) $values, Criteria::IN);
        }

        $query = InvoiceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            InvoiceTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                InvoiceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the invoice table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return InvoiceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Invoice or Criteria object.
     *
     * @param mixed $criteria Criteria or Invoice object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvoiceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Invoice object
        }

        if ($criteria->containsKey(InvoiceTableMap::COL_INVOICE_ID) && $criteria->keyContainsValue(InvoiceTableMap::COL_INVOICE_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.InvoiceTableMap::COL_INVOICE_ID.')');
        }


        // Set the correct dbName
        $query = InvoiceQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
