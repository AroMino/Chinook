<?php

namespace Chinook\Models\Base;

use \Exception;
use \PDO;
use Chinook\Models\Album as ChildAlbum;
use Chinook\Models\AlbumQuery as ChildAlbumQuery;
use Chinook\Models\Genre as ChildGenre;
use Chinook\Models\GenreQuery as ChildGenreQuery;
use Chinook\Models\InvoiceLine as ChildInvoiceLine;
use Chinook\Models\InvoiceLineQuery as ChildInvoiceLineQuery;
use Chinook\Models\MediaType as ChildMediaType;
use Chinook\Models\MediaTypeQuery as ChildMediaTypeQuery;
use Chinook\Models\PlaylistTrack as ChildPlaylistTrack;
use Chinook\Models\PlaylistTrackQuery as ChildPlaylistTrackQuery;
use Chinook\Models\Track as ChildTrack;
use Chinook\Models\TrackQuery as ChildTrackQuery;
use Chinook\Models\Map\InvoiceLineTableMap;
use Chinook\Models\Map\PlaylistTrackTableMap;
use Chinook\Models\Map\TrackTableMap;
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

/**
 * Base class that represents a row from the 'track' table.
 *
 *
 *
 * @package    propel.generator.Chinook.Models.Base
 */
abstract class Track implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\Chinook\\Models\\Map\\TrackTableMap';


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
     * The value for the track_id field.
     *
     * @var        int
     */
    protected $track_id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the album_id field.
     *
     * @var        int|null
     */
    protected $album_id;

    /**
     * The value for the media_type_id field.
     *
     * @var        int
     */
    protected $media_type_id;

    /**
     * The value for the genre_id field.
     *
     * @var        int|null
     */
    protected $genre_id;

    /**
     * The value for the composer field.
     *
     * @var        string|null
     */
    protected $composer;

    /**
     * The value for the milliseconds field.
     *
     * @var        int
     */
    protected $milliseconds;

    /**
     * The value for the bytes field.
     *
     * @var        int|null
     */
    protected $bytes;

    /**
     * The value for the unit_price field.
     *
     * @var        string
     */
    protected $unit_price;

    /**
     * @var        ChildAlbum
     */
    protected $aAlbum;

    /**
     * @var        ChildGenre
     */
    protected $aGenre;

    /**
     * @var        ChildMediaType
     */
    protected $aMediaType;

    /**
     * @var        ObjectCollection|ChildInvoiceLine[] Collection to store aggregation of ChildInvoiceLine objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildInvoiceLine> Collection to store aggregation of ChildInvoiceLine objects.
     */
    protected $collInvoiceLines;
    protected $collInvoiceLinesPartial;

    /**
     * @var        ObjectCollection|ChildPlaylistTrack[] Collection to store aggregation of ChildPlaylistTrack objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildPlaylistTrack> Collection to store aggregation of ChildPlaylistTrack objects.
     */
    protected $collPlaylistTracks;
    protected $collPlaylistTracksPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInvoiceLine[]
     * @phpstan-var ObjectCollection&\Traversable<ChildInvoiceLine>
     */
    protected $invoiceLinesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlaylistTrack[]
     * @phpstan-var ObjectCollection&\Traversable<ChildPlaylistTrack>
     */
    protected $playlistTracksScheduledForDeletion = null;

    /**
     * Initializes internal state of Chinook\Models\Base\Track object.
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
     * Compares this with another <code>Track</code> instance.  If
     * <code>obj</code> is an instance of <code>Track</code>, delegates to
     * <code>equals(Track)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [track_id] column value.
     *
     * @return int
     */
    public function getTrackId()
    {
        return $this->track_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [album_id] column value.
     *
     * @return int|null
     */
    public function getAlbumId()
    {
        return $this->album_id;
    }

    /**
     * Get the [media_type_id] column value.
     *
     * @return int
     */
    public function getMediaTypeId()
    {
        return $this->media_type_id;
    }

    /**
     * Get the [genre_id] column value.
     *
     * @return int|null
     */
    public function getGenreId()
    {
        return $this->genre_id;
    }

    /**
     * Get the [composer] column value.
     *
     * @return string|null
     */
    public function getComposer()
    {
        return $this->composer;
    }

    /**
     * Get the [milliseconds] column value.
     *
     * @return int
     */
    public function getMilliseconds()
    {
        return $this->milliseconds;
    }

    /**
     * Get the [bytes] column value.
     *
     * @return int|null
     */
    public function getBytes()
    {
        return $this->bytes;
    }

    /**
     * Get the [unit_price] column value.
     *
     * @return string
     */
    public function getUnitPrice()
    {
        return $this->unit_price;
    }

    /**
     * Set the value of [track_id] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setTrackId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->track_id !== $v) {
            $this->track_id = $v;
            $this->modifiedColumns[TrackTableMap::COL_TRACK_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [name] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[TrackTableMap::COL_NAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [album_id] column.
     *
     * @param int|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setAlbumId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->album_id !== $v) {
            $this->album_id = $v;
            $this->modifiedColumns[TrackTableMap::COL_ALBUM_ID] = true;
        }

        if ($this->aAlbum !== null && $this->aAlbum->getAlbumId() !== $v) {
            $this->aAlbum = null;
        }

        return $this;
    }

    /**
     * Set the value of [media_type_id] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setMediaTypeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->media_type_id !== $v) {
            $this->media_type_id = $v;
            $this->modifiedColumns[TrackTableMap::COL_MEDIA_TYPE_ID] = true;
        }

        if ($this->aMediaType !== null && $this->aMediaType->getMediaTypeId() !== $v) {
            $this->aMediaType = null;
        }

        return $this;
    }

    /**
     * Set the value of [genre_id] column.
     *
     * @param int|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setGenreId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->genre_id !== $v) {
            $this->genre_id = $v;
            $this->modifiedColumns[TrackTableMap::COL_GENRE_ID] = true;
        }

        if ($this->aGenre !== null && $this->aGenre->getGenreId() !== $v) {
            $this->aGenre = null;
        }

        return $this;
    }

    /**
     * Set the value of [composer] column.
     *
     * @param string|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setComposer($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->composer !== $v) {
            $this->composer = $v;
            $this->modifiedColumns[TrackTableMap::COL_COMPOSER] = true;
        }

        return $this;
    }

    /**
     * Set the value of [milliseconds] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setMilliseconds($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->milliseconds !== $v) {
            $this->milliseconds = $v;
            $this->modifiedColumns[TrackTableMap::COL_MILLISECONDS] = true;
        }

        return $this;
    }

    /**
     * Set the value of [bytes] column.
     *
     * @param int|null $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setBytes($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->bytes !== $v) {
            $this->bytes = $v;
            $this->modifiedColumns[TrackTableMap::COL_BYTES] = true;
        }

        return $this;
    }

    /**
     * Set the value of [unit_price] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setUnitPrice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->unit_price !== $v) {
            $this->unit_price = $v;
            $this->modifiedColumns[TrackTableMap::COL_UNIT_PRICE] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TrackTableMap::translateFieldName('TrackId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->track_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TrackTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TrackTableMap::translateFieldName('AlbumId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->album_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TrackTableMap::translateFieldName('MediaTypeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->media_type_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TrackTableMap::translateFieldName('GenreId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->genre_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TrackTableMap::translateFieldName('Composer', TableMap::TYPE_PHPNAME, $indexType)];
            $this->composer = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TrackTableMap::translateFieldName('Milliseconds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->milliseconds = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : TrackTableMap::translateFieldName('Bytes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bytes = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : TrackTableMap::translateFieldName('UnitPrice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->unit_price = (null !== $col) ? (string) $col : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = TrackTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Chinook\\Models\\Track'), 0, $e);
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
        if ($this->aAlbum !== null && $this->album_id !== $this->aAlbum->getAlbumId()) {
            $this->aAlbum = null;
        }
        if ($this->aMediaType !== null && $this->media_type_id !== $this->aMediaType->getMediaTypeId()) {
            $this->aMediaType = null;
        }
        if ($this->aGenre !== null && $this->genre_id !== $this->aGenre->getGenreId()) {
            $this->aGenre = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(TrackTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTrackQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAlbum = null;
            $this->aGenre = null;
            $this->aMediaType = null;
            $this->collInvoiceLines = null;

            $this->collPlaylistTracks = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see Track::setDeleted()
     * @see Track::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrackTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTrackQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(TrackTableMap::DATABASE_NAME);
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
                TrackTableMap::addInstanceToPool($this);
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

            if ($this->aAlbum !== null) {
                if ($this->aAlbum->isModified() || $this->aAlbum->isNew()) {
                    $affectedRows += $this->aAlbum->save($con);
                }
                $this->setAlbum($this->aAlbum);
            }

            if ($this->aGenre !== null) {
                if ($this->aGenre->isModified() || $this->aGenre->isNew()) {
                    $affectedRows += $this->aGenre->save($con);
                }
                $this->setGenre($this->aGenre);
            }

            if ($this->aMediaType !== null) {
                if ($this->aMediaType->isModified() || $this->aMediaType->isNew()) {
                    $affectedRows += $this->aMediaType->save($con);
                }
                $this->setMediaType($this->aMediaType);
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

            if ($this->invoiceLinesScheduledForDeletion !== null) {
                if (!$this->invoiceLinesScheduledForDeletion->isEmpty()) {
                    \Chinook\Models\InvoiceLineQuery::create()
                        ->filterByPrimaryKeys($this->invoiceLinesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->invoiceLinesScheduledForDeletion = null;
                }
            }

            if ($this->collInvoiceLines !== null) {
                foreach ($this->collInvoiceLines as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->playlistTracksScheduledForDeletion !== null) {
                if (!$this->playlistTracksScheduledForDeletion->isEmpty()) {
                    \Chinook\Models\PlaylistTrackQuery::create()
                        ->filterByPrimaryKeys($this->playlistTracksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->playlistTracksScheduledForDeletion = null;
                }
            }

            if ($this->collPlaylistTracks !== null) {
                foreach ($this->collPlaylistTracks as $referrerFK) {
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

        $this->modifiedColumns[TrackTableMap::COL_TRACK_ID] = true;
        if (null !== $this->track_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TrackTableMap::COL_TRACK_ID . ')');
        }
        if (null === $this->track_id) {
            try {
                $dataFetcher = $con->query("SELECT nextval('track_track_id_seq')");
                $this->track_id = (int) $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TrackTableMap::COL_TRACK_ID)) {
            $modifiedColumns[':p' . $index++]  = 'track_id';
        }
        if ($this->isColumnModified(TrackTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(TrackTableMap::COL_ALBUM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'album_id';
        }
        if ($this->isColumnModified(TrackTableMap::COL_MEDIA_TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'media_type_id';
        }
        if ($this->isColumnModified(TrackTableMap::COL_GENRE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'genre_id';
        }
        if ($this->isColumnModified(TrackTableMap::COL_COMPOSER)) {
            $modifiedColumns[':p' . $index++]  = 'composer';
        }
        if ($this->isColumnModified(TrackTableMap::COL_MILLISECONDS)) {
            $modifiedColumns[':p' . $index++]  = 'milliseconds';
        }
        if ($this->isColumnModified(TrackTableMap::COL_BYTES)) {
            $modifiedColumns[':p' . $index++]  = 'bytes';
        }
        if ($this->isColumnModified(TrackTableMap::COL_UNIT_PRICE)) {
            $modifiedColumns[':p' . $index++]  = 'unit_price';
        }

        $sql = sprintf(
            'INSERT INTO track (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'track_id':
                        $stmt->bindValue($identifier, $this->track_id, PDO::PARAM_INT);

                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);

                        break;
                    case 'album_id':
                        $stmt->bindValue($identifier, $this->album_id, PDO::PARAM_INT);

                        break;
                    case 'media_type_id':
                        $stmt->bindValue($identifier, $this->media_type_id, PDO::PARAM_INT);

                        break;
                    case 'genre_id':
                        $stmt->bindValue($identifier, $this->genre_id, PDO::PARAM_INT);

                        break;
                    case 'composer':
                        $stmt->bindValue($identifier, $this->composer, PDO::PARAM_STR);

                        break;
                    case 'milliseconds':
                        $stmt->bindValue($identifier, $this->milliseconds, PDO::PARAM_INT);

                        break;
                    case 'bytes':
                        $stmt->bindValue($identifier, $this->bytes, PDO::PARAM_INT);

                        break;
                    case 'unit_price':
                        $stmt->bindValue($identifier, $this->unit_price, PDO::PARAM_STR);

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
        $pos = TrackTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTrackId();

            case 1:
                return $this->getName();

            case 2:
                return $this->getAlbumId();

            case 3:
                return $this->getMediaTypeId();

            case 4:
                return $this->getGenreId();

            case 5:
                return $this->getComposer();

            case 6:
                return $this->getMilliseconds();

            case 7:
                return $this->getBytes();

            case 8:
                return $this->getUnitPrice();

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
        if (isset($alreadyDumpedObjects['Track'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Track'][$this->hashCode()] = true;
        $keys = TrackTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getTrackId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getAlbumId(),
            $keys[3] => $this->getMediaTypeId(),
            $keys[4] => $this->getGenreId(),
            $keys[5] => $this->getComposer(),
            $keys[6] => $this->getMilliseconds(),
            $keys[7] => $this->getBytes(),
            $keys[8] => $this->getUnitPrice(),
        ];
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAlbum) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'album';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'album';
                        break;
                    default:
                        $key = 'Album';
                }

                $result[$key] = $this->aAlbum->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aGenre) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'genre';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'genre';
                        break;
                    default:
                        $key = 'Genre';
                }

                $result[$key] = $this->aGenre->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aMediaType) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'mediaType';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'media_type';
                        break;
                    default:
                        $key = 'MediaType';
                }

                $result[$key] = $this->aMediaType->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collInvoiceLines) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'invoiceLines';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'invoice_lines';
                        break;
                    default:
                        $key = 'InvoiceLines';
                }

                $result[$key] = $this->collInvoiceLines->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPlaylistTracks) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'playlistTracks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'playlist_tracks';
                        break;
                    default:
                        $key = 'PlaylistTracks';
                }

                $result[$key] = $this->collPlaylistTracks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = TrackTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setTrackId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setAlbumId($value);
                break;
            case 3:
                $this->setMediaTypeId($value);
                break;
            case 4:
                $this->setGenreId($value);
                break;
            case 5:
                $this->setComposer($value);
                break;
            case 6:
                $this->setMilliseconds($value);
                break;
            case 7:
                $this->setBytes($value);
                break;
            case 8:
                $this->setUnitPrice($value);
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
        $keys = TrackTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setTrackId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setAlbumId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setMediaTypeId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setGenreId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setComposer($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setMilliseconds($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setBytes($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setUnitPrice($arr[$keys[8]]);
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
        $criteria = new Criteria(TrackTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TrackTableMap::COL_TRACK_ID)) {
            $criteria->add(TrackTableMap::COL_TRACK_ID, $this->track_id);
        }
        if ($this->isColumnModified(TrackTableMap::COL_NAME)) {
            $criteria->add(TrackTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(TrackTableMap::COL_ALBUM_ID)) {
            $criteria->add(TrackTableMap::COL_ALBUM_ID, $this->album_id);
        }
        if ($this->isColumnModified(TrackTableMap::COL_MEDIA_TYPE_ID)) {
            $criteria->add(TrackTableMap::COL_MEDIA_TYPE_ID, $this->media_type_id);
        }
        if ($this->isColumnModified(TrackTableMap::COL_GENRE_ID)) {
            $criteria->add(TrackTableMap::COL_GENRE_ID, $this->genre_id);
        }
        if ($this->isColumnModified(TrackTableMap::COL_COMPOSER)) {
            $criteria->add(TrackTableMap::COL_COMPOSER, $this->composer);
        }
        if ($this->isColumnModified(TrackTableMap::COL_MILLISECONDS)) {
            $criteria->add(TrackTableMap::COL_MILLISECONDS, $this->milliseconds);
        }
        if ($this->isColumnModified(TrackTableMap::COL_BYTES)) {
            $criteria->add(TrackTableMap::COL_BYTES, $this->bytes);
        }
        if ($this->isColumnModified(TrackTableMap::COL_UNIT_PRICE)) {
            $criteria->add(TrackTableMap::COL_UNIT_PRICE, $this->unit_price);
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
        $criteria = ChildTrackQuery::create();
        $criteria->add(TrackTableMap::COL_TRACK_ID, $this->track_id);

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
        $validPk = null !== $this->getTrackId();

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
        return $this->getTrackId();
    }

    /**
     * Generic method to set the primary key (track_id column).
     *
     * @param int|null $key Primary key.
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setTrackId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return null === $this->getTrackId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \Chinook\Models\Track (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setName($this->getName());
        $copyObj->setAlbumId($this->getAlbumId());
        $copyObj->setMediaTypeId($this->getMediaTypeId());
        $copyObj->setGenreId($this->getGenreId());
        $copyObj->setComposer($this->getComposer());
        $copyObj->setMilliseconds($this->getMilliseconds());
        $copyObj->setBytes($this->getBytes());
        $copyObj->setUnitPrice($this->getUnitPrice());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getInvoiceLines() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addInvoiceLine($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPlaylistTracks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPlaylistTrack($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setTrackId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Chinook\Models\Track Clone of current object.
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
     * Declares an association between this object and a ChildAlbum object.
     *
     * @param ChildAlbum|null $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setAlbum(ChildAlbum $v = null)
    {
        if ($v === null) {
            $this->setAlbumId(NULL);
        } else {
            $this->setAlbumId($v->getAlbumId());
        }

        $this->aAlbum = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAlbum object, it will not be re-added.
        if ($v !== null) {
            $v->addTrack($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAlbum object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildAlbum|null The associated ChildAlbum object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getAlbum(?ConnectionInterface $con = null)
    {
        if ($this->aAlbum === null && ($this->album_id != 0)) {
            $this->aAlbum = ChildAlbumQuery::create()->findPk($this->album_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAlbum->addTracks($this);
             */
        }

        return $this->aAlbum;
    }

    /**
     * Declares an association between this object and a ChildGenre object.
     *
     * @param ChildGenre|null $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setGenre(ChildGenre $v = null)
    {
        if ($v === null) {
            $this->setGenreId(NULL);
        } else {
            $this->setGenreId($v->getGenreId());
        }

        $this->aGenre = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildGenre object, it will not be re-added.
        if ($v !== null) {
            $v->addTrack($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildGenre object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildGenre|null The associated ChildGenre object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getGenre(?ConnectionInterface $con = null)
    {
        if ($this->aGenre === null && ($this->genre_id != 0)) {
            $this->aGenre = ChildGenreQuery::create()->findPk($this->genre_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aGenre->addTracks($this);
             */
        }

        return $this->aGenre;
    }

    /**
     * Declares an association between this object and a ChildMediaType object.
     *
     * @param ChildMediaType $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setMediaType(ChildMediaType $v = null)
    {
        if ($v === null) {
            $this->setMediaTypeId(NULL);
        } else {
            $this->setMediaTypeId($v->getMediaTypeId());
        }

        $this->aMediaType = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildMediaType object, it will not be re-added.
        if ($v !== null) {
            $v->addTrack($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildMediaType object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildMediaType The associated ChildMediaType object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getMediaType(?ConnectionInterface $con = null)
    {
        if ($this->aMediaType === null && ($this->media_type_id != 0)) {
            $this->aMediaType = ChildMediaTypeQuery::create()->findPk($this->media_type_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMediaType->addTracks($this);
             */
        }

        return $this->aMediaType;
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
        if ('InvoiceLine' === $relationName) {
            $this->initInvoiceLines();
            return;
        }
        if ('PlaylistTrack' === $relationName) {
            $this->initPlaylistTracks();
            return;
        }
    }

    /**
     * Clears out the collInvoiceLines collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addInvoiceLines()
     */
    public function clearInvoiceLines()
    {
        $this->collInvoiceLines = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collInvoiceLines collection loaded partially.
     *
     * @return void
     */
    public function resetPartialInvoiceLines($v = true): void
    {
        $this->collInvoiceLinesPartial = $v;
    }

    /**
     * Initializes the collInvoiceLines collection.
     *
     * By default this just sets the collInvoiceLines collection to an empty array (like clearcollInvoiceLines());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initInvoiceLines(bool $overrideExisting = true): void
    {
        if (null !== $this->collInvoiceLines && !$overrideExisting) {
            return;
        }

        $collectionClassName = InvoiceLineTableMap::getTableMap()->getCollectionClassName();

        $this->collInvoiceLines = new $collectionClassName;
        $this->collInvoiceLines->setModel('\Chinook\Models\InvoiceLine');
    }

    /**
     * Gets an array of ChildInvoiceLine objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTrack is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildInvoiceLine[] List of ChildInvoiceLine objects
     * @phpstan-return ObjectCollection&\Traversable<ChildInvoiceLine> List of ChildInvoiceLine objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getInvoiceLines(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collInvoiceLinesPartial && !$this->isNew();
        if (null === $this->collInvoiceLines || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collInvoiceLines) {
                    $this->initInvoiceLines();
                } else {
                    $collectionClassName = InvoiceLineTableMap::getTableMap()->getCollectionClassName();

                    $collInvoiceLines = new $collectionClassName;
                    $collInvoiceLines->setModel('\Chinook\Models\InvoiceLine');

                    return $collInvoiceLines;
                }
            } else {
                $collInvoiceLines = ChildInvoiceLineQuery::create(null, $criteria)
                    ->filterByTrack($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collInvoiceLinesPartial && count($collInvoiceLines)) {
                        $this->initInvoiceLines(false);

                        foreach ($collInvoiceLines as $obj) {
                            if (false == $this->collInvoiceLines->contains($obj)) {
                                $this->collInvoiceLines->append($obj);
                            }
                        }

                        $this->collInvoiceLinesPartial = true;
                    }

                    return $collInvoiceLines;
                }

                if ($partial && $this->collInvoiceLines) {
                    foreach ($this->collInvoiceLines as $obj) {
                        if ($obj->isNew()) {
                            $collInvoiceLines[] = $obj;
                        }
                    }
                }

                $this->collInvoiceLines = $collInvoiceLines;
                $this->collInvoiceLinesPartial = false;
            }
        }

        return $this->collInvoiceLines;
    }

    /**
     * Sets a collection of ChildInvoiceLine objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $invoiceLines A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setInvoiceLines(Collection $invoiceLines, ?ConnectionInterface $con = null)
    {
        /** @var ChildInvoiceLine[] $invoiceLinesToDelete */
        $invoiceLinesToDelete = $this->getInvoiceLines(new Criteria(), $con)->diff($invoiceLines);


        $this->invoiceLinesScheduledForDeletion = $invoiceLinesToDelete;

        foreach ($invoiceLinesToDelete as $invoiceLineRemoved) {
            $invoiceLineRemoved->setTrack(null);
        }

        $this->collInvoiceLines = null;
        foreach ($invoiceLines as $invoiceLine) {
            $this->addInvoiceLine($invoiceLine);
        }

        $this->collInvoiceLines = $invoiceLines;
        $this->collInvoiceLinesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related InvoiceLine objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related InvoiceLine objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countInvoiceLines(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collInvoiceLinesPartial && !$this->isNew();
        if (null === $this->collInvoiceLines || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collInvoiceLines) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getInvoiceLines());
            }

            $query = ChildInvoiceLineQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTrack($this)
                ->count($con);
        }

        return count($this->collInvoiceLines);
    }

    /**
     * Method called to associate a ChildInvoiceLine object to this object
     * through the ChildInvoiceLine foreign key attribute.
     *
     * @param ChildInvoiceLine $l ChildInvoiceLine
     * @return $this The current object (for fluent API support)
     */
    public function addInvoiceLine(ChildInvoiceLine $l)
    {
        if ($this->collInvoiceLines === null) {
            $this->initInvoiceLines();
            $this->collInvoiceLinesPartial = true;
        }

        if (!$this->collInvoiceLines->contains($l)) {
            $this->doAddInvoiceLine($l);

            if ($this->invoiceLinesScheduledForDeletion and $this->invoiceLinesScheduledForDeletion->contains($l)) {
                $this->invoiceLinesScheduledForDeletion->remove($this->invoiceLinesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildInvoiceLine $invoiceLine The ChildInvoiceLine object to add.
     */
    protected function doAddInvoiceLine(ChildInvoiceLine $invoiceLine): void
    {
        $this->collInvoiceLines[]= $invoiceLine;
        $invoiceLine->setTrack($this);
    }

    /**
     * @param ChildInvoiceLine $invoiceLine The ChildInvoiceLine object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeInvoiceLine(ChildInvoiceLine $invoiceLine)
    {
        if ($this->getInvoiceLines()->contains($invoiceLine)) {
            $pos = $this->collInvoiceLines->search($invoiceLine);
            $this->collInvoiceLines->remove($pos);
            if (null === $this->invoiceLinesScheduledForDeletion) {
                $this->invoiceLinesScheduledForDeletion = clone $this->collInvoiceLines;
                $this->invoiceLinesScheduledForDeletion->clear();
            }
            $this->invoiceLinesScheduledForDeletion[]= clone $invoiceLine;
            $invoiceLine->setTrack(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Track is new, it will return
     * an empty collection; or if this Track has previously
     * been saved, it will retrieve related InvoiceLines from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Track.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildInvoiceLine[] List of ChildInvoiceLine objects
     * @phpstan-return ObjectCollection&\Traversable<ChildInvoiceLine}> List of ChildInvoiceLine objects
     */
    public function getInvoiceLinesJoinInvoice(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildInvoiceLineQuery::create(null, $criteria);
        $query->joinWith('Invoice', $joinBehavior);

        return $this->getInvoiceLines($query, $con);
    }

    /**
     * Clears out the collPlaylistTracks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addPlaylistTracks()
     */
    public function clearPlaylistTracks()
    {
        $this->collPlaylistTracks = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collPlaylistTracks collection loaded partially.
     *
     * @return void
     */
    public function resetPartialPlaylistTracks($v = true): void
    {
        $this->collPlaylistTracksPartial = $v;
    }

    /**
     * Initializes the collPlaylistTracks collection.
     *
     * By default this just sets the collPlaylistTracks collection to an empty array (like clearcollPlaylistTracks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPlaylistTracks(bool $overrideExisting = true): void
    {
        if (null !== $this->collPlaylistTracks && !$overrideExisting) {
            return;
        }

        $collectionClassName = PlaylistTrackTableMap::getTableMap()->getCollectionClassName();

        $this->collPlaylistTracks = new $collectionClassName;
        $this->collPlaylistTracks->setModel('\Chinook\Models\PlaylistTrack');
    }

    /**
     * Gets an array of ChildPlaylistTrack objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTrack is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPlaylistTrack[] List of ChildPlaylistTrack objects
     * @phpstan-return ObjectCollection&\Traversable<ChildPlaylistTrack> List of ChildPlaylistTrack objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getPlaylistTracks(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collPlaylistTracksPartial && !$this->isNew();
        if (null === $this->collPlaylistTracks || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPlaylistTracks) {
                    $this->initPlaylistTracks();
                } else {
                    $collectionClassName = PlaylistTrackTableMap::getTableMap()->getCollectionClassName();

                    $collPlaylistTracks = new $collectionClassName;
                    $collPlaylistTracks->setModel('\Chinook\Models\PlaylistTrack');

                    return $collPlaylistTracks;
                }
            } else {
                $collPlaylistTracks = ChildPlaylistTrackQuery::create(null, $criteria)
                    ->filterByTrack($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPlaylistTracksPartial && count($collPlaylistTracks)) {
                        $this->initPlaylistTracks(false);

                        foreach ($collPlaylistTracks as $obj) {
                            if (false == $this->collPlaylistTracks->contains($obj)) {
                                $this->collPlaylistTracks->append($obj);
                            }
                        }

                        $this->collPlaylistTracksPartial = true;
                    }

                    return $collPlaylistTracks;
                }

                if ($partial && $this->collPlaylistTracks) {
                    foreach ($this->collPlaylistTracks as $obj) {
                        if ($obj->isNew()) {
                            $collPlaylistTracks[] = $obj;
                        }
                    }
                }

                $this->collPlaylistTracks = $collPlaylistTracks;
                $this->collPlaylistTracksPartial = false;
            }
        }

        return $this->collPlaylistTracks;
    }

    /**
     * Sets a collection of ChildPlaylistTrack objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $playlistTracks A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setPlaylistTracks(Collection $playlistTracks, ?ConnectionInterface $con = null)
    {
        /** @var ChildPlaylistTrack[] $playlistTracksToDelete */
        $playlistTracksToDelete = $this->getPlaylistTracks(new Criteria(), $con)->diff($playlistTracks);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->playlistTracksScheduledForDeletion = clone $playlistTracksToDelete;

        foreach ($playlistTracksToDelete as $playlistTrackRemoved) {
            $playlistTrackRemoved->setTrack(null);
        }

        $this->collPlaylistTracks = null;
        foreach ($playlistTracks as $playlistTrack) {
            $this->addPlaylistTrack($playlistTrack);
        }

        $this->collPlaylistTracks = $playlistTracks;
        $this->collPlaylistTracksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PlaylistTrack objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related PlaylistTrack objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countPlaylistTracks(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collPlaylistTracksPartial && !$this->isNew();
        if (null === $this->collPlaylistTracks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPlaylistTracks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPlaylistTracks());
            }

            $query = ChildPlaylistTrackQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTrack($this)
                ->count($con);
        }

        return count($this->collPlaylistTracks);
    }

    /**
     * Method called to associate a ChildPlaylistTrack object to this object
     * through the ChildPlaylistTrack foreign key attribute.
     *
     * @param ChildPlaylistTrack $l ChildPlaylistTrack
     * @return $this The current object (for fluent API support)
     */
    public function addPlaylistTrack(ChildPlaylistTrack $l)
    {
        if ($this->collPlaylistTracks === null) {
            $this->initPlaylistTracks();
            $this->collPlaylistTracksPartial = true;
        }

        if (!$this->collPlaylistTracks->contains($l)) {
            $this->doAddPlaylistTrack($l);

            if ($this->playlistTracksScheduledForDeletion and $this->playlistTracksScheduledForDeletion->contains($l)) {
                $this->playlistTracksScheduledForDeletion->remove($this->playlistTracksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPlaylistTrack $playlistTrack The ChildPlaylistTrack object to add.
     */
    protected function doAddPlaylistTrack(ChildPlaylistTrack $playlistTrack): void
    {
        $this->collPlaylistTracks[]= $playlistTrack;
        $playlistTrack->setTrack($this);
    }

    /**
     * @param ChildPlaylistTrack $playlistTrack The ChildPlaylistTrack object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removePlaylistTrack(ChildPlaylistTrack $playlistTrack)
    {
        if ($this->getPlaylistTracks()->contains($playlistTrack)) {
            $pos = $this->collPlaylistTracks->search($playlistTrack);
            $this->collPlaylistTracks->remove($pos);
            if (null === $this->playlistTracksScheduledForDeletion) {
                $this->playlistTracksScheduledForDeletion = clone $this->collPlaylistTracks;
                $this->playlistTracksScheduledForDeletion->clear();
            }
            $this->playlistTracksScheduledForDeletion[]= clone $playlistTrack;
            $playlistTrack->setTrack(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Track is new, it will return
     * an empty collection; or if this Track has previously
     * been saved, it will retrieve related PlaylistTracks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Track.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPlaylistTrack[] List of ChildPlaylistTrack objects
     * @phpstan-return ObjectCollection&\Traversable<ChildPlaylistTrack}> List of ChildPlaylistTrack objects
     */
    public function getPlaylistTracksJoinPlaylist(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlaylistTrackQuery::create(null, $criteria);
        $query->joinWith('Playlist', $joinBehavior);

        return $this->getPlaylistTracks($query, $con);
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
        if (null !== $this->aAlbum) {
            $this->aAlbum->removeTrack($this);
        }
        if (null !== $this->aGenre) {
            $this->aGenre->removeTrack($this);
        }
        if (null !== $this->aMediaType) {
            $this->aMediaType->removeTrack($this);
        }
        $this->track_id = null;
        $this->name = null;
        $this->album_id = null;
        $this->media_type_id = null;
        $this->genre_id = null;
        $this->composer = null;
        $this->milliseconds = null;
        $this->bytes = null;
        $this->unit_price = null;
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
            if ($this->collInvoiceLines) {
                foreach ($this->collInvoiceLines as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPlaylistTracks) {
                foreach ($this->collPlaylistTracks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collInvoiceLines = null;
        $this->collPlaylistTracks = null;
        $this->aAlbum = null;
        $this->aGenre = null;
        $this->aMediaType = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TrackTableMap::DEFAULT_STRING_FORMAT);
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
