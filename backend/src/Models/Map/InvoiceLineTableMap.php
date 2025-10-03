<?php

namespace Chinook\Models\Map;

use Chinook\Models\InvoiceLine;
use Chinook\Models\InvoiceLineQuery;
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
 * This class defines the structure of the 'invoice_line' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class InvoiceLineTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Chinook.Models.Map.InvoiceLineTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'invoice_line';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'InvoiceLine';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Chinook\\Models\\InvoiceLine';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Chinook.Models.InvoiceLine';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the invoice_line_id field
     */
    public const COL_INVOICE_LINE_ID = 'invoice_line.invoice_line_id';

    /**
     * the column name for the invoice_id field
     */
    public const COL_INVOICE_ID = 'invoice_line.invoice_id';

    /**
     * the column name for the track_id field
     */
    public const COL_TRACK_ID = 'invoice_line.track_id';

    /**
     * the column name for the unit_price field
     */
    public const COL_UNIT_PRICE = 'invoice_line.unit_price';

    /**
     * the column name for the quantity field
     */
    public const COL_QUANTITY = 'invoice_line.quantity';

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
        self::TYPE_PHPNAME       => ['InvoiceLineId', 'InvoiceId', 'TrackId', 'UnitPrice', 'Quantity', ],
        self::TYPE_CAMELNAME     => ['invoiceLineId', 'invoiceId', 'trackId', 'unitPrice', 'quantity', ],
        self::TYPE_COLNAME       => [InvoiceLineTableMap::COL_INVOICE_LINE_ID, InvoiceLineTableMap::COL_INVOICE_ID, InvoiceLineTableMap::COL_TRACK_ID, InvoiceLineTableMap::COL_UNIT_PRICE, InvoiceLineTableMap::COL_QUANTITY, ],
        self::TYPE_FIELDNAME     => ['invoice_line_id', 'invoice_id', 'track_id', 'unit_price', 'quantity', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, ]
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
        self::TYPE_PHPNAME       => ['InvoiceLineId' => 0, 'InvoiceId' => 1, 'TrackId' => 2, 'UnitPrice' => 3, 'Quantity' => 4, ],
        self::TYPE_CAMELNAME     => ['invoiceLineId' => 0, 'invoiceId' => 1, 'trackId' => 2, 'unitPrice' => 3, 'quantity' => 4, ],
        self::TYPE_COLNAME       => [InvoiceLineTableMap::COL_INVOICE_LINE_ID => 0, InvoiceLineTableMap::COL_INVOICE_ID => 1, InvoiceLineTableMap::COL_TRACK_ID => 2, InvoiceLineTableMap::COL_UNIT_PRICE => 3, InvoiceLineTableMap::COL_QUANTITY => 4, ],
        self::TYPE_FIELDNAME     => ['invoice_line_id' => 0, 'invoice_id' => 1, 'track_id' => 2, 'unit_price' => 3, 'quantity' => 4, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'InvoiceLineId' => 'INVOICE_LINE_ID',
        'InvoiceLine.InvoiceLineId' => 'INVOICE_LINE_ID',
        'invoiceLineId' => 'INVOICE_LINE_ID',
        'invoiceLine.invoiceLineId' => 'INVOICE_LINE_ID',
        'InvoiceLineTableMap::COL_INVOICE_LINE_ID' => 'INVOICE_LINE_ID',
        'COL_INVOICE_LINE_ID' => 'INVOICE_LINE_ID',
        'invoice_line_id' => 'INVOICE_LINE_ID',
        'invoice_line.invoice_line_id' => 'INVOICE_LINE_ID',
        'InvoiceId' => 'INVOICE_ID',
        'InvoiceLine.InvoiceId' => 'INVOICE_ID',
        'invoiceId' => 'INVOICE_ID',
        'invoiceLine.invoiceId' => 'INVOICE_ID',
        'InvoiceLineTableMap::COL_INVOICE_ID' => 'INVOICE_ID',
        'COL_INVOICE_ID' => 'INVOICE_ID',
        'invoice_id' => 'INVOICE_ID',
        'invoice_line.invoice_id' => 'INVOICE_ID',
        'TrackId' => 'TRACK_ID',
        'InvoiceLine.TrackId' => 'TRACK_ID',
        'trackId' => 'TRACK_ID',
        'invoiceLine.trackId' => 'TRACK_ID',
        'InvoiceLineTableMap::COL_TRACK_ID' => 'TRACK_ID',
        'COL_TRACK_ID' => 'TRACK_ID',
        'track_id' => 'TRACK_ID',
        'invoice_line.track_id' => 'TRACK_ID',
        'UnitPrice' => 'UNIT_PRICE',
        'InvoiceLine.UnitPrice' => 'UNIT_PRICE',
        'unitPrice' => 'UNIT_PRICE',
        'invoiceLine.unitPrice' => 'UNIT_PRICE',
        'InvoiceLineTableMap::COL_UNIT_PRICE' => 'UNIT_PRICE',
        'COL_UNIT_PRICE' => 'UNIT_PRICE',
        'unit_price' => 'UNIT_PRICE',
        'invoice_line.unit_price' => 'UNIT_PRICE',
        'Quantity' => 'QUANTITY',
        'InvoiceLine.Quantity' => 'QUANTITY',
        'quantity' => 'QUANTITY',
        'invoiceLine.quantity' => 'QUANTITY',
        'InvoiceLineTableMap::COL_QUANTITY' => 'QUANTITY',
        'COL_QUANTITY' => 'QUANTITY',
        'invoice_line.quantity' => 'QUANTITY',
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
        $this->setName('invoice_line');
        $this->setPhpName('InvoiceLine');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Chinook\\Models\\InvoiceLine');
        $this->setPackage('Chinook.Models');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('invoice_line_invoice_line_id_seq');
        // columns
        $this->addPrimaryKey('invoice_line_id', 'InvoiceLineId', 'INTEGER', true, null, null);
        $this->addForeignKey('invoice_id', 'InvoiceId', 'INTEGER', 'invoice', 'invoice_id', true, null, null);
        $this->addForeignKey('track_id', 'TrackId', 'INTEGER', 'track', 'track_id', true, null, null);
        $this->addColumn('unit_price', 'UnitPrice', 'DECIMAL', true, 10, null);
        $this->addColumn('quantity', 'Quantity', 'INTEGER', true, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('Invoice', '\\Chinook\\Models\\Invoice', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':invoice_id',
    1 => ':invoice_id',
  ),
), null, null, null, false);
        $this->addRelation('Track', '\\Chinook\\Models\\Track', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':track_id',
    1 => ':track_id',
  ),
), null, null, null, false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceLineId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceLineId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceLineId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceLineId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceLineId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('InvoiceLineId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('InvoiceLineId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? InvoiceLineTableMap::CLASS_DEFAULT : InvoiceLineTableMap::OM_CLASS;
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
     * @return array (InvoiceLine object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = InvoiceLineTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = InvoiceLineTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + InvoiceLineTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = InvoiceLineTableMap::OM_CLASS;
            /** @var InvoiceLine $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            InvoiceLineTableMap::addInstanceToPool($obj, $key);
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
            $key = InvoiceLineTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = InvoiceLineTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var InvoiceLine $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                InvoiceLineTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(InvoiceLineTableMap::COL_INVOICE_LINE_ID);
            $criteria->addSelectColumn(InvoiceLineTableMap::COL_INVOICE_ID);
            $criteria->addSelectColumn(InvoiceLineTableMap::COL_TRACK_ID);
            $criteria->addSelectColumn(InvoiceLineTableMap::COL_UNIT_PRICE);
            $criteria->addSelectColumn(InvoiceLineTableMap::COL_QUANTITY);
        } else {
            $criteria->addSelectColumn($alias . '.invoice_line_id');
            $criteria->addSelectColumn($alias . '.invoice_id');
            $criteria->addSelectColumn($alias . '.track_id');
            $criteria->addSelectColumn($alias . '.unit_price');
            $criteria->addSelectColumn($alias . '.quantity');
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
            $criteria->removeSelectColumn(InvoiceLineTableMap::COL_INVOICE_LINE_ID);
            $criteria->removeSelectColumn(InvoiceLineTableMap::COL_INVOICE_ID);
            $criteria->removeSelectColumn(InvoiceLineTableMap::COL_TRACK_ID);
            $criteria->removeSelectColumn(InvoiceLineTableMap::COL_UNIT_PRICE);
            $criteria->removeSelectColumn(InvoiceLineTableMap::COL_QUANTITY);
        } else {
            $criteria->removeSelectColumn($alias . '.invoice_line_id');
            $criteria->removeSelectColumn($alias . '.invoice_id');
            $criteria->removeSelectColumn($alias . '.track_id');
            $criteria->removeSelectColumn($alias . '.unit_price');
            $criteria->removeSelectColumn($alias . '.quantity');
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
        return Propel::getServiceContainer()->getDatabaseMap(InvoiceLineTableMap::DATABASE_NAME)->getTable(InvoiceLineTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a InvoiceLine or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or InvoiceLine object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(InvoiceLineTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Chinook\Models\InvoiceLine) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(InvoiceLineTableMap::DATABASE_NAME);
            $criteria->add(InvoiceLineTableMap::COL_INVOICE_LINE_ID, (array) $values, Criteria::IN);
        }

        $query = InvoiceLineQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            InvoiceLineTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                InvoiceLineTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the invoice_line table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return InvoiceLineQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a InvoiceLine or Criteria object.
     *
     * @param mixed $criteria Criteria or InvoiceLine object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InvoiceLineTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from InvoiceLine object
        }

        if ($criteria->containsKey(InvoiceLineTableMap::COL_INVOICE_LINE_ID) && $criteria->keyContainsValue(InvoiceLineTableMap::COL_INVOICE_LINE_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.InvoiceLineTableMap::COL_INVOICE_LINE_ID.')');
        }


        // Set the correct dbName
        $query = InvoiceLineQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
