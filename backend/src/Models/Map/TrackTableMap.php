<?php

namespace Chinook\Models\Map;

use Chinook\Models\Track;
use Chinook\Models\TrackQuery;
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
 * This class defines the structure of the 'track' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class TrackTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Chinook.Models.Map.TrackTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'track';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Track';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Chinook\\Models\\Track';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Chinook.Models.Track';

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
     * the column name for the track_id field
     */
    public const COL_TRACK_ID = 'track.track_id';

    /**
     * the column name for the name field
     */
    public const COL_NAME = 'track.name';

    /**
     * the column name for the album_id field
     */
    public const COL_ALBUM_ID = 'track.album_id';

    /**
     * the column name for the media_type_id field
     */
    public const COL_MEDIA_TYPE_ID = 'track.media_type_id';

    /**
     * the column name for the genre_id field
     */
    public const COL_GENRE_ID = 'track.genre_id';

    /**
     * the column name for the composer field
     */
    public const COL_COMPOSER = 'track.composer';

    /**
     * the column name for the milliseconds field
     */
    public const COL_MILLISECONDS = 'track.milliseconds';

    /**
     * the column name for the bytes field
     */
    public const COL_BYTES = 'track.bytes';

    /**
     * the column name for the unit_price field
     */
    public const COL_UNIT_PRICE = 'track.unit_price';

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
        self::TYPE_PHPNAME       => ['TrackId', 'Name', 'AlbumId', 'MediaTypeId', 'GenreId', 'Composer', 'Milliseconds', 'Bytes', 'UnitPrice', ],
        self::TYPE_CAMELNAME     => ['trackId', 'name', 'albumId', 'mediaTypeId', 'genreId', 'composer', 'milliseconds', 'bytes', 'unitPrice', ],
        self::TYPE_COLNAME       => [TrackTableMap::COL_TRACK_ID, TrackTableMap::COL_NAME, TrackTableMap::COL_ALBUM_ID, TrackTableMap::COL_MEDIA_TYPE_ID, TrackTableMap::COL_GENRE_ID, TrackTableMap::COL_COMPOSER, TrackTableMap::COL_MILLISECONDS, TrackTableMap::COL_BYTES, TrackTableMap::COL_UNIT_PRICE, ],
        self::TYPE_FIELDNAME     => ['track_id', 'name', 'album_id', 'media_type_id', 'genre_id', 'composer', 'milliseconds', 'bytes', 'unit_price', ],
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
        self::TYPE_PHPNAME       => ['TrackId' => 0, 'Name' => 1, 'AlbumId' => 2, 'MediaTypeId' => 3, 'GenreId' => 4, 'Composer' => 5, 'Milliseconds' => 6, 'Bytes' => 7, 'UnitPrice' => 8, ],
        self::TYPE_CAMELNAME     => ['trackId' => 0, 'name' => 1, 'albumId' => 2, 'mediaTypeId' => 3, 'genreId' => 4, 'composer' => 5, 'milliseconds' => 6, 'bytes' => 7, 'unitPrice' => 8, ],
        self::TYPE_COLNAME       => [TrackTableMap::COL_TRACK_ID => 0, TrackTableMap::COL_NAME => 1, TrackTableMap::COL_ALBUM_ID => 2, TrackTableMap::COL_MEDIA_TYPE_ID => 3, TrackTableMap::COL_GENRE_ID => 4, TrackTableMap::COL_COMPOSER => 5, TrackTableMap::COL_MILLISECONDS => 6, TrackTableMap::COL_BYTES => 7, TrackTableMap::COL_UNIT_PRICE => 8, ],
        self::TYPE_FIELDNAME     => ['track_id' => 0, 'name' => 1, 'album_id' => 2, 'media_type_id' => 3, 'genre_id' => 4, 'composer' => 5, 'milliseconds' => 6, 'bytes' => 7, 'unit_price' => 8, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'TrackId' => 'TRACK_ID',
        'Track.TrackId' => 'TRACK_ID',
        'trackId' => 'TRACK_ID',
        'track.trackId' => 'TRACK_ID',
        'TrackTableMap::COL_TRACK_ID' => 'TRACK_ID',
        'COL_TRACK_ID' => 'TRACK_ID',
        'track_id' => 'TRACK_ID',
        'track.track_id' => 'TRACK_ID',
        'Name' => 'NAME',
        'Track.Name' => 'NAME',
        'name' => 'NAME',
        'track.name' => 'NAME',
        'TrackTableMap::COL_NAME' => 'NAME',
        'COL_NAME' => 'NAME',
        'AlbumId' => 'ALBUM_ID',
        'Track.AlbumId' => 'ALBUM_ID',
        'albumId' => 'ALBUM_ID',
        'track.albumId' => 'ALBUM_ID',
        'TrackTableMap::COL_ALBUM_ID' => 'ALBUM_ID',
        'COL_ALBUM_ID' => 'ALBUM_ID',
        'album_id' => 'ALBUM_ID',
        'track.album_id' => 'ALBUM_ID',
        'MediaTypeId' => 'MEDIA_TYPE_ID',
        'Track.MediaTypeId' => 'MEDIA_TYPE_ID',
        'mediaTypeId' => 'MEDIA_TYPE_ID',
        'track.mediaTypeId' => 'MEDIA_TYPE_ID',
        'TrackTableMap::COL_MEDIA_TYPE_ID' => 'MEDIA_TYPE_ID',
        'COL_MEDIA_TYPE_ID' => 'MEDIA_TYPE_ID',
        'media_type_id' => 'MEDIA_TYPE_ID',
        'track.media_type_id' => 'MEDIA_TYPE_ID',
        'GenreId' => 'GENRE_ID',
        'Track.GenreId' => 'GENRE_ID',
        'genreId' => 'GENRE_ID',
        'track.genreId' => 'GENRE_ID',
        'TrackTableMap::COL_GENRE_ID' => 'GENRE_ID',
        'COL_GENRE_ID' => 'GENRE_ID',
        'genre_id' => 'GENRE_ID',
        'track.genre_id' => 'GENRE_ID',
        'Composer' => 'COMPOSER',
        'Track.Composer' => 'COMPOSER',
        'composer' => 'COMPOSER',
        'track.composer' => 'COMPOSER',
        'TrackTableMap::COL_COMPOSER' => 'COMPOSER',
        'COL_COMPOSER' => 'COMPOSER',
        'Milliseconds' => 'MILLISECONDS',
        'Track.Milliseconds' => 'MILLISECONDS',
        'milliseconds' => 'MILLISECONDS',
        'track.milliseconds' => 'MILLISECONDS',
        'TrackTableMap::COL_MILLISECONDS' => 'MILLISECONDS',
        'COL_MILLISECONDS' => 'MILLISECONDS',
        'Bytes' => 'BYTES',
        'Track.Bytes' => 'BYTES',
        'bytes' => 'BYTES',
        'track.bytes' => 'BYTES',
        'TrackTableMap::COL_BYTES' => 'BYTES',
        'COL_BYTES' => 'BYTES',
        'UnitPrice' => 'UNIT_PRICE',
        'Track.UnitPrice' => 'UNIT_PRICE',
        'unitPrice' => 'UNIT_PRICE',
        'track.unitPrice' => 'UNIT_PRICE',
        'TrackTableMap::COL_UNIT_PRICE' => 'UNIT_PRICE',
        'COL_UNIT_PRICE' => 'UNIT_PRICE',
        'unit_price' => 'UNIT_PRICE',
        'track.unit_price' => 'UNIT_PRICE',
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
        $this->setName('track');
        $this->setPhpName('Track');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Chinook\\Models\\Track');
        $this->setPackage('Chinook.Models');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('track_track_id_seq');
        // columns
        $this->addPrimaryKey('track_id', 'TrackId', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 200, null);
        $this->addForeignKey('album_id', 'AlbumId', 'INTEGER', 'album', 'album_id', false, null, null);
        $this->addForeignKey('media_type_id', 'MediaTypeId', 'INTEGER', 'media_type', 'media_type_id', true, null, null);
        $this->addForeignKey('genre_id', 'GenreId', 'INTEGER', 'genre', 'genre_id', false, null, null);
        $this->addColumn('composer', 'Composer', 'VARCHAR', false, 220, null);
        $this->addColumn('milliseconds', 'Milliseconds', 'INTEGER', true, null, null);
        $this->addColumn('bytes', 'Bytes', 'INTEGER', false, null, null);
        $this->addColumn('unit_price', 'UnitPrice', 'DECIMAL', true, 10, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('Album', '\\Chinook\\Models\\Album', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':album_id',
    1 => ':album_id',
  ),
), null, null, null, false);
        $this->addRelation('Genre', '\\Chinook\\Models\\Genre', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':genre_id',
    1 => ':genre_id',
  ),
), null, null, null, false);
        $this->addRelation('MediaType', '\\Chinook\\Models\\MediaType', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':media_type_id',
    1 => ':media_type_id',
  ),
), null, null, null, false);
        $this->addRelation('InvoiceLine', '\\Chinook\\Models\\InvoiceLine', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':track_id',
    1 => ':track_id',
  ),
), null, null, 'InvoiceLines', false);
        $this->addRelation('PlaylistTrack', '\\Chinook\\Models\\PlaylistTrack', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':track_id',
    1 => ':track_id',
  ),
), null, null, 'PlaylistTracks', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TrackId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TrackId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TrackId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TrackId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TrackId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TrackId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('TrackId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? TrackTableMap::CLASS_DEFAULT : TrackTableMap::OM_CLASS;
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
     * @return array (Track object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = TrackTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TrackTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TrackTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TrackTableMap::OM_CLASS;
            /** @var Track $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TrackTableMap::addInstanceToPool($obj, $key);
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
            $key = TrackTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TrackTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Track $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TrackTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TrackTableMap::COL_TRACK_ID);
            $criteria->addSelectColumn(TrackTableMap::COL_NAME);
            $criteria->addSelectColumn(TrackTableMap::COL_ALBUM_ID);
            $criteria->addSelectColumn(TrackTableMap::COL_MEDIA_TYPE_ID);
            $criteria->addSelectColumn(TrackTableMap::COL_GENRE_ID);
            $criteria->addSelectColumn(TrackTableMap::COL_COMPOSER);
            $criteria->addSelectColumn(TrackTableMap::COL_MILLISECONDS);
            $criteria->addSelectColumn(TrackTableMap::COL_BYTES);
            $criteria->addSelectColumn(TrackTableMap::COL_UNIT_PRICE);
        } else {
            $criteria->addSelectColumn($alias . '.track_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.album_id');
            $criteria->addSelectColumn($alias . '.media_type_id');
            $criteria->addSelectColumn($alias . '.genre_id');
            $criteria->addSelectColumn($alias . '.composer');
            $criteria->addSelectColumn($alias . '.milliseconds');
            $criteria->addSelectColumn($alias . '.bytes');
            $criteria->addSelectColumn($alias . '.unit_price');
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
            $criteria->removeSelectColumn(TrackTableMap::COL_TRACK_ID);
            $criteria->removeSelectColumn(TrackTableMap::COL_NAME);
            $criteria->removeSelectColumn(TrackTableMap::COL_ALBUM_ID);
            $criteria->removeSelectColumn(TrackTableMap::COL_MEDIA_TYPE_ID);
            $criteria->removeSelectColumn(TrackTableMap::COL_GENRE_ID);
            $criteria->removeSelectColumn(TrackTableMap::COL_COMPOSER);
            $criteria->removeSelectColumn(TrackTableMap::COL_MILLISECONDS);
            $criteria->removeSelectColumn(TrackTableMap::COL_BYTES);
            $criteria->removeSelectColumn(TrackTableMap::COL_UNIT_PRICE);
        } else {
            $criteria->removeSelectColumn($alias . '.track_id');
            $criteria->removeSelectColumn($alias . '.name');
            $criteria->removeSelectColumn($alias . '.album_id');
            $criteria->removeSelectColumn($alias . '.media_type_id');
            $criteria->removeSelectColumn($alias . '.genre_id');
            $criteria->removeSelectColumn($alias . '.composer');
            $criteria->removeSelectColumn($alias . '.milliseconds');
            $criteria->removeSelectColumn($alias . '.bytes');
            $criteria->removeSelectColumn($alias . '.unit_price');
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
        return Propel::getServiceContainer()->getDatabaseMap(TrackTableMap::DATABASE_NAME)->getTable(TrackTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Track or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Track object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TrackTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Chinook\Models\Track) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TrackTableMap::DATABASE_NAME);
            $criteria->add(TrackTableMap::COL_TRACK_ID, (array) $values, Criteria::IN);
        }

        $query = TrackQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TrackTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TrackTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the track table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return TrackQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Track or Criteria object.
     *
     * @param mixed $criteria Criteria or Track object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrackTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Track object
        }

        if ($criteria->containsKey(TrackTableMap::COL_TRACK_ID) && $criteria->keyContainsValue(TrackTableMap::COL_TRACK_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TrackTableMap::COL_TRACK_ID.')');
        }


        // Set the correct dbName
        $query = TrackQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
