<?php

namespace Chinook\Models\Base;

use \Exception;
use \PDO;
use Chinook\Models\Track as ChildTrack;
use Chinook\Models\TrackQuery as ChildTrackQuery;
use Chinook\Models\Map\TrackTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `track` table.
 *
 * @method     ChildTrackQuery orderByTrackId($order = Criteria::ASC) Order by the track_id column
 * @method     ChildTrackQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildTrackQuery orderByAlbumId($order = Criteria::ASC) Order by the album_id column
 * @method     ChildTrackQuery orderByMediaTypeId($order = Criteria::ASC) Order by the media_type_id column
 * @method     ChildTrackQuery orderByGenreId($order = Criteria::ASC) Order by the genre_id column
 * @method     ChildTrackQuery orderByComposer($order = Criteria::ASC) Order by the composer column
 * @method     ChildTrackQuery orderByMilliseconds($order = Criteria::ASC) Order by the milliseconds column
 * @method     ChildTrackQuery orderByBytes($order = Criteria::ASC) Order by the bytes column
 * @method     ChildTrackQuery orderByUnitPrice($order = Criteria::ASC) Order by the unit_price column
 *
 * @method     ChildTrackQuery groupByTrackId() Group by the track_id column
 * @method     ChildTrackQuery groupByName() Group by the name column
 * @method     ChildTrackQuery groupByAlbumId() Group by the album_id column
 * @method     ChildTrackQuery groupByMediaTypeId() Group by the media_type_id column
 * @method     ChildTrackQuery groupByGenreId() Group by the genre_id column
 * @method     ChildTrackQuery groupByComposer() Group by the composer column
 * @method     ChildTrackQuery groupByMilliseconds() Group by the milliseconds column
 * @method     ChildTrackQuery groupByBytes() Group by the bytes column
 * @method     ChildTrackQuery groupByUnitPrice() Group by the unit_price column
 *
 * @method     ChildTrackQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTrackQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTrackQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTrackQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTrackQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTrackQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTrackQuery leftJoinAlbum($relationAlias = null) Adds a LEFT JOIN clause to the query using the Album relation
 * @method     ChildTrackQuery rightJoinAlbum($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Album relation
 * @method     ChildTrackQuery innerJoinAlbum($relationAlias = null) Adds a INNER JOIN clause to the query using the Album relation
 *
 * @method     ChildTrackQuery joinWithAlbum($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Album relation
 *
 * @method     ChildTrackQuery leftJoinWithAlbum() Adds a LEFT JOIN clause and with to the query using the Album relation
 * @method     ChildTrackQuery rightJoinWithAlbum() Adds a RIGHT JOIN clause and with to the query using the Album relation
 * @method     ChildTrackQuery innerJoinWithAlbum() Adds a INNER JOIN clause and with to the query using the Album relation
 *
 * @method     ChildTrackQuery leftJoinGenre($relationAlias = null) Adds a LEFT JOIN clause to the query using the Genre relation
 * @method     ChildTrackQuery rightJoinGenre($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Genre relation
 * @method     ChildTrackQuery innerJoinGenre($relationAlias = null) Adds a INNER JOIN clause to the query using the Genre relation
 *
 * @method     ChildTrackQuery joinWithGenre($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Genre relation
 *
 * @method     ChildTrackQuery leftJoinWithGenre() Adds a LEFT JOIN clause and with to the query using the Genre relation
 * @method     ChildTrackQuery rightJoinWithGenre() Adds a RIGHT JOIN clause and with to the query using the Genre relation
 * @method     ChildTrackQuery innerJoinWithGenre() Adds a INNER JOIN clause and with to the query using the Genre relation
 *
 * @method     ChildTrackQuery leftJoinMediaType($relationAlias = null) Adds a LEFT JOIN clause to the query using the MediaType relation
 * @method     ChildTrackQuery rightJoinMediaType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MediaType relation
 * @method     ChildTrackQuery innerJoinMediaType($relationAlias = null) Adds a INNER JOIN clause to the query using the MediaType relation
 *
 * @method     ChildTrackQuery joinWithMediaType($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MediaType relation
 *
 * @method     ChildTrackQuery leftJoinWithMediaType() Adds a LEFT JOIN clause and with to the query using the MediaType relation
 * @method     ChildTrackQuery rightJoinWithMediaType() Adds a RIGHT JOIN clause and with to the query using the MediaType relation
 * @method     ChildTrackQuery innerJoinWithMediaType() Adds a INNER JOIN clause and with to the query using the MediaType relation
 *
 * @method     ChildTrackQuery leftJoinInvoiceLine($relationAlias = null) Adds a LEFT JOIN clause to the query using the InvoiceLine relation
 * @method     ChildTrackQuery rightJoinInvoiceLine($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InvoiceLine relation
 * @method     ChildTrackQuery innerJoinInvoiceLine($relationAlias = null) Adds a INNER JOIN clause to the query using the InvoiceLine relation
 *
 * @method     ChildTrackQuery joinWithInvoiceLine($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the InvoiceLine relation
 *
 * @method     ChildTrackQuery leftJoinWithInvoiceLine() Adds a LEFT JOIN clause and with to the query using the InvoiceLine relation
 * @method     ChildTrackQuery rightJoinWithInvoiceLine() Adds a RIGHT JOIN clause and with to the query using the InvoiceLine relation
 * @method     ChildTrackQuery innerJoinWithInvoiceLine() Adds a INNER JOIN clause and with to the query using the InvoiceLine relation
 *
 * @method     ChildTrackQuery leftJoinPlaylistTrack($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlaylistTrack relation
 * @method     ChildTrackQuery rightJoinPlaylistTrack($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlaylistTrack relation
 * @method     ChildTrackQuery innerJoinPlaylistTrack($relationAlias = null) Adds a INNER JOIN clause to the query using the PlaylistTrack relation
 *
 * @method     ChildTrackQuery joinWithPlaylistTrack($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PlaylistTrack relation
 *
 * @method     ChildTrackQuery leftJoinWithPlaylistTrack() Adds a LEFT JOIN clause and with to the query using the PlaylistTrack relation
 * @method     ChildTrackQuery rightJoinWithPlaylistTrack() Adds a RIGHT JOIN clause and with to the query using the PlaylistTrack relation
 * @method     ChildTrackQuery innerJoinWithPlaylistTrack() Adds a INNER JOIN clause and with to the query using the PlaylistTrack relation
 *
 * @method     \Chinook\Models\AlbumQuery|\Chinook\Models\GenreQuery|\Chinook\Models\MediaTypeQuery|\Chinook\Models\InvoiceLineQuery|\Chinook\Models\PlaylistTrackQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTrack|null findOne(?ConnectionInterface $con = null) Return the first ChildTrack matching the query
 * @method     ChildTrack findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildTrack matching the query, or a new ChildTrack object populated from the query conditions when no match is found
 *
 * @method     ChildTrack|null findOneByTrackId(int $track_id) Return the first ChildTrack filtered by the track_id column
 * @method     ChildTrack|null findOneByName(string $name) Return the first ChildTrack filtered by the name column
 * @method     ChildTrack|null findOneByAlbumId(int $album_id) Return the first ChildTrack filtered by the album_id column
 * @method     ChildTrack|null findOneByMediaTypeId(int $media_type_id) Return the first ChildTrack filtered by the media_type_id column
 * @method     ChildTrack|null findOneByGenreId(int $genre_id) Return the first ChildTrack filtered by the genre_id column
 * @method     ChildTrack|null findOneByComposer(string $composer) Return the first ChildTrack filtered by the composer column
 * @method     ChildTrack|null findOneByMilliseconds(int $milliseconds) Return the first ChildTrack filtered by the milliseconds column
 * @method     ChildTrack|null findOneByBytes(int $bytes) Return the first ChildTrack filtered by the bytes column
 * @method     ChildTrack|null findOneByUnitPrice(string $unit_price) Return the first ChildTrack filtered by the unit_price column
 *
 * @method     ChildTrack requirePk($key, ?ConnectionInterface $con = null) Return the ChildTrack by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrack requireOne(?ConnectionInterface $con = null) Return the first ChildTrack matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTrack requireOneByTrackId(int $track_id) Return the first ChildTrack filtered by the track_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrack requireOneByName(string $name) Return the first ChildTrack filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrack requireOneByAlbumId(int $album_id) Return the first ChildTrack filtered by the album_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrack requireOneByMediaTypeId(int $media_type_id) Return the first ChildTrack filtered by the media_type_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrack requireOneByGenreId(int $genre_id) Return the first ChildTrack filtered by the genre_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrack requireOneByComposer(string $composer) Return the first ChildTrack filtered by the composer column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrack requireOneByMilliseconds(int $milliseconds) Return the first ChildTrack filtered by the milliseconds column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrack requireOneByBytes(int $bytes) Return the first ChildTrack filtered by the bytes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTrack requireOneByUnitPrice(string $unit_price) Return the first ChildTrack filtered by the unit_price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTrack[]|Collection find(?ConnectionInterface $con = null) Return ChildTrack objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildTrack> find(?ConnectionInterface $con = null) Return ChildTrack objects based on current ModelCriteria
 *
 * @method     ChildTrack[]|Collection findByTrackId(int|array<int> $track_id) Return ChildTrack objects filtered by the track_id column
 * @psalm-method Collection&\Traversable<ChildTrack> findByTrackId(int|array<int> $track_id) Return ChildTrack objects filtered by the track_id column
 * @method     ChildTrack[]|Collection findByName(string|array<string> $name) Return ChildTrack objects filtered by the name column
 * @psalm-method Collection&\Traversable<ChildTrack> findByName(string|array<string> $name) Return ChildTrack objects filtered by the name column
 * @method     ChildTrack[]|Collection findByAlbumId(int|array<int> $album_id) Return ChildTrack objects filtered by the album_id column
 * @psalm-method Collection&\Traversable<ChildTrack> findByAlbumId(int|array<int> $album_id) Return ChildTrack objects filtered by the album_id column
 * @method     ChildTrack[]|Collection findByMediaTypeId(int|array<int> $media_type_id) Return ChildTrack objects filtered by the media_type_id column
 * @psalm-method Collection&\Traversable<ChildTrack> findByMediaTypeId(int|array<int> $media_type_id) Return ChildTrack objects filtered by the media_type_id column
 * @method     ChildTrack[]|Collection findByGenreId(int|array<int> $genre_id) Return ChildTrack objects filtered by the genre_id column
 * @psalm-method Collection&\Traversable<ChildTrack> findByGenreId(int|array<int> $genre_id) Return ChildTrack objects filtered by the genre_id column
 * @method     ChildTrack[]|Collection findByComposer(string|array<string> $composer) Return ChildTrack objects filtered by the composer column
 * @psalm-method Collection&\Traversable<ChildTrack> findByComposer(string|array<string> $composer) Return ChildTrack objects filtered by the composer column
 * @method     ChildTrack[]|Collection findByMilliseconds(int|array<int> $milliseconds) Return ChildTrack objects filtered by the milliseconds column
 * @psalm-method Collection&\Traversable<ChildTrack> findByMilliseconds(int|array<int> $milliseconds) Return ChildTrack objects filtered by the milliseconds column
 * @method     ChildTrack[]|Collection findByBytes(int|array<int> $bytes) Return ChildTrack objects filtered by the bytes column
 * @psalm-method Collection&\Traversable<ChildTrack> findByBytes(int|array<int> $bytes) Return ChildTrack objects filtered by the bytes column
 * @method     ChildTrack[]|Collection findByUnitPrice(string|array<string> $unit_price) Return ChildTrack objects filtered by the unit_price column
 * @psalm-method Collection&\Traversable<ChildTrack> findByUnitPrice(string|array<string> $unit_price) Return ChildTrack objects filtered by the unit_price column
 *
 * @method     ChildTrack[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildTrack> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class TrackQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Chinook\Models\Base\TrackQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Chinook\\Models\\Track', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTrackQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTrackQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildTrackQuery) {
            return $criteria;
        }
        $query = new ChildTrackQuery();
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
     * @return ChildTrack|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TrackTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TrackTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTrack A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT track_id, name, album_id, media_type_id, genre_id, composer, milliseconds, bytes, unit_price FROM track WHERE track_id = :p0';
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
            /** @var ChildTrack $obj */
            $obj = new ChildTrack();
            $obj->hydrate($row);
            TrackTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTrack|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(TrackTableMap::COL_TRACK_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(TrackTableMap::COL_TRACK_ID, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the track_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTrackId(1234); // WHERE track_id = 1234
     * $query->filterByTrackId(array(12, 34)); // WHERE track_id IN (12, 34)
     * $query->filterByTrackId(array('min' => 12)); // WHERE track_id > 12
     * </code>
     *
     * @param mixed $trackId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTrackId($trackId = null, ?string $comparison = null)
    {
        if (is_array($trackId)) {
            $useMinMax = false;
            if (isset($trackId['min'])) {
                $this->addUsingAlias(TrackTableMap::COL_TRACK_ID, $trackId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($trackId['max'])) {
                $this->addUsingAlias(TrackTableMap::COL_TRACK_ID, $trackId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(TrackTableMap::COL_TRACK_ID, $trackId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE name IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(TrackTableMap::COL_NAME, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the album_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAlbumId(1234); // WHERE album_id = 1234
     * $query->filterByAlbumId(array(12, 34)); // WHERE album_id IN (12, 34)
     * $query->filterByAlbumId(array('min' => 12)); // WHERE album_id > 12
     * </code>
     *
     * @see       filterByAlbum()
     *
     * @param mixed $albumId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByAlbumId($albumId = null, ?string $comparison = null)
    {
        if (is_array($albumId)) {
            $useMinMax = false;
            if (isset($albumId['min'])) {
                $this->addUsingAlias(TrackTableMap::COL_ALBUM_ID, $albumId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($albumId['max'])) {
                $this->addUsingAlias(TrackTableMap::COL_ALBUM_ID, $albumId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(TrackTableMap::COL_ALBUM_ID, $albumId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the media_type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMediaTypeId(1234); // WHERE media_type_id = 1234
     * $query->filterByMediaTypeId(array(12, 34)); // WHERE media_type_id IN (12, 34)
     * $query->filterByMediaTypeId(array('min' => 12)); // WHERE media_type_id > 12
     * </code>
     *
     * @see       filterByMediaType()
     *
     * @param mixed $mediaTypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByMediaTypeId($mediaTypeId = null, ?string $comparison = null)
    {
        if (is_array($mediaTypeId)) {
            $useMinMax = false;
            if (isset($mediaTypeId['min'])) {
                $this->addUsingAlias(TrackTableMap::COL_MEDIA_TYPE_ID, $mediaTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mediaTypeId['max'])) {
                $this->addUsingAlias(TrackTableMap::COL_MEDIA_TYPE_ID, $mediaTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(TrackTableMap::COL_MEDIA_TYPE_ID, $mediaTypeId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the genre_id column
     *
     * Example usage:
     * <code>
     * $query->filterByGenreId(1234); // WHERE genre_id = 1234
     * $query->filterByGenreId(array(12, 34)); // WHERE genre_id IN (12, 34)
     * $query->filterByGenreId(array('min' => 12)); // WHERE genre_id > 12
     * </code>
     *
     * @see       filterByGenre()
     *
     * @param mixed $genreId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByGenreId($genreId = null, ?string $comparison = null)
    {
        if (is_array($genreId)) {
            $useMinMax = false;
            if (isset($genreId['min'])) {
                $this->addUsingAlias(TrackTableMap::COL_GENRE_ID, $genreId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($genreId['max'])) {
                $this->addUsingAlias(TrackTableMap::COL_GENRE_ID, $genreId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(TrackTableMap::COL_GENRE_ID, $genreId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the composer column
     *
     * Example usage:
     * <code>
     * $query->filterByComposer('fooValue');   // WHERE composer = 'fooValue'
     * $query->filterByComposer('%fooValue%', Criteria::LIKE); // WHERE composer LIKE '%fooValue%'
     * $query->filterByComposer(['foo', 'bar']); // WHERE composer IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $composer The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByComposer($composer = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($composer)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(TrackTableMap::COL_COMPOSER, $composer, $comparison);

        return $this;
    }

    /**
     * Filter the query on the milliseconds column
     *
     * Example usage:
     * <code>
     * $query->filterByMilliseconds(1234); // WHERE milliseconds = 1234
     * $query->filterByMilliseconds(array(12, 34)); // WHERE milliseconds IN (12, 34)
     * $query->filterByMilliseconds(array('min' => 12)); // WHERE milliseconds > 12
     * </code>
     *
     * @param mixed $milliseconds The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByMilliseconds($milliseconds = null, ?string $comparison = null)
    {
        if (is_array($milliseconds)) {
            $useMinMax = false;
            if (isset($milliseconds['min'])) {
                $this->addUsingAlias(TrackTableMap::COL_MILLISECONDS, $milliseconds['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($milliseconds['max'])) {
                $this->addUsingAlias(TrackTableMap::COL_MILLISECONDS, $milliseconds['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(TrackTableMap::COL_MILLISECONDS, $milliseconds, $comparison);

        return $this;
    }

    /**
     * Filter the query on the bytes column
     *
     * Example usage:
     * <code>
     * $query->filterByBytes(1234); // WHERE bytes = 1234
     * $query->filterByBytes(array(12, 34)); // WHERE bytes IN (12, 34)
     * $query->filterByBytes(array('min' => 12)); // WHERE bytes > 12
     * </code>
     *
     * @param mixed $bytes The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByBytes($bytes = null, ?string $comparison = null)
    {
        if (is_array($bytes)) {
            $useMinMax = false;
            if (isset($bytes['min'])) {
                $this->addUsingAlias(TrackTableMap::COL_BYTES, $bytes['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bytes['max'])) {
                $this->addUsingAlias(TrackTableMap::COL_BYTES, $bytes['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(TrackTableMap::COL_BYTES, $bytes, $comparison);

        return $this;
    }

    /**
     * Filter the query on the unit_price column
     *
     * Example usage:
     * <code>
     * $query->filterByUnitPrice(1234); // WHERE unit_price = 1234
     * $query->filterByUnitPrice(array(12, 34)); // WHERE unit_price IN (12, 34)
     * $query->filterByUnitPrice(array('min' => 12)); // WHERE unit_price > 12
     * </code>
     *
     * @param mixed $unitPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUnitPrice($unitPrice = null, ?string $comparison = null)
    {
        if (is_array($unitPrice)) {
            $useMinMax = false;
            if (isset($unitPrice['min'])) {
                $this->addUsingAlias(TrackTableMap::COL_UNIT_PRICE, $unitPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($unitPrice['max'])) {
                $this->addUsingAlias(TrackTableMap::COL_UNIT_PRICE, $unitPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(TrackTableMap::COL_UNIT_PRICE, $unitPrice, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Chinook\Models\Album object
     *
     * @param \Chinook\Models\Album|ObjectCollection $album The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByAlbum($album, ?string $comparison = null)
    {
        if ($album instanceof \Chinook\Models\Album) {
            return $this
                ->addUsingAlias(TrackTableMap::COL_ALBUM_ID, $album->getAlbumId(), $comparison);
        } elseif ($album instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(TrackTableMap::COL_ALBUM_ID, $album->toKeyValue('PrimaryKey', 'AlbumId'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByAlbum() only accepts arguments of type \Chinook\Models\Album or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Album relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinAlbum(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Album');

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
            $this->addJoinObject($join, 'Album');
        }

        return $this;
    }

    /**
     * Use the Album relation Album object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Chinook\Models\AlbumQuery A secondary query class using the current class as primary query
     */
    public function useAlbumQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAlbum($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Album', '\Chinook\Models\AlbumQuery');
    }

    /**
     * Use the Album relation Album object
     *
     * @param callable(\Chinook\Models\AlbumQuery):\Chinook\Models\AlbumQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withAlbumQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useAlbumQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Album table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Chinook\Models\AlbumQuery The inner query object of the EXISTS statement
     */
    public function useAlbumExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Chinook\Models\AlbumQuery */
        $q = $this->useExistsQuery('Album', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Album table for a NOT EXISTS query.
     *
     * @see useAlbumExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\AlbumQuery The inner query object of the NOT EXISTS statement
     */
    public function useAlbumNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\AlbumQuery */
        $q = $this->useExistsQuery('Album', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Album table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Chinook\Models\AlbumQuery The inner query object of the IN statement
     */
    public function useInAlbumQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Chinook\Models\AlbumQuery */
        $q = $this->useInQuery('Album', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Album table for a NOT IN query.
     *
     * @see useAlbumInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\AlbumQuery The inner query object of the NOT IN statement
     */
    public function useNotInAlbumQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\AlbumQuery */
        $q = $this->useInQuery('Album', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Chinook\Models\Genre object
     *
     * @param \Chinook\Models\Genre|ObjectCollection $genre The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByGenre($genre, ?string $comparison = null)
    {
        if ($genre instanceof \Chinook\Models\Genre) {
            return $this
                ->addUsingAlias(TrackTableMap::COL_GENRE_ID, $genre->getGenreId(), $comparison);
        } elseif ($genre instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(TrackTableMap::COL_GENRE_ID, $genre->toKeyValue('PrimaryKey', 'GenreId'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByGenre() only accepts arguments of type \Chinook\Models\Genre or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Genre relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinGenre(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Genre');

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
            $this->addJoinObject($join, 'Genre');
        }

        return $this;
    }

    /**
     * Use the Genre relation Genre object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Chinook\Models\GenreQuery A secondary query class using the current class as primary query
     */
    public function useGenreQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGenre($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Genre', '\Chinook\Models\GenreQuery');
    }

    /**
     * Use the Genre relation Genre object
     *
     * @param callable(\Chinook\Models\GenreQuery):\Chinook\Models\GenreQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGenreQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useGenreQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Genre table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Chinook\Models\GenreQuery The inner query object of the EXISTS statement
     */
    public function useGenreExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Chinook\Models\GenreQuery */
        $q = $this->useExistsQuery('Genre', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Genre table for a NOT EXISTS query.
     *
     * @see useGenreExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\GenreQuery The inner query object of the NOT EXISTS statement
     */
    public function useGenreNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\GenreQuery */
        $q = $this->useExistsQuery('Genre', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Genre table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Chinook\Models\GenreQuery The inner query object of the IN statement
     */
    public function useInGenreQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Chinook\Models\GenreQuery */
        $q = $this->useInQuery('Genre', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Genre table for a NOT IN query.
     *
     * @see useGenreInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\GenreQuery The inner query object of the NOT IN statement
     */
    public function useNotInGenreQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\GenreQuery */
        $q = $this->useInQuery('Genre', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Chinook\Models\MediaType object
     *
     * @param \Chinook\Models\MediaType|ObjectCollection $mediaType The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByMediaType($mediaType, ?string $comparison = null)
    {
        if ($mediaType instanceof \Chinook\Models\MediaType) {
            return $this
                ->addUsingAlias(TrackTableMap::COL_MEDIA_TYPE_ID, $mediaType->getMediaTypeId(), $comparison);
        } elseif ($mediaType instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(TrackTableMap::COL_MEDIA_TYPE_ID, $mediaType->toKeyValue('PrimaryKey', 'MediaTypeId'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByMediaType() only accepts arguments of type \Chinook\Models\MediaType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MediaType relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinMediaType(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MediaType');

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
            $this->addJoinObject($join, 'MediaType');
        }

        return $this;
    }

    /**
     * Use the MediaType relation MediaType object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Chinook\Models\MediaTypeQuery A secondary query class using the current class as primary query
     */
    public function useMediaTypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMediaType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MediaType', '\Chinook\Models\MediaTypeQuery');
    }

    /**
     * Use the MediaType relation MediaType object
     *
     * @param callable(\Chinook\Models\MediaTypeQuery):\Chinook\Models\MediaTypeQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withMediaTypeQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useMediaTypeQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to MediaType table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Chinook\Models\MediaTypeQuery The inner query object of the EXISTS statement
     */
    public function useMediaTypeExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Chinook\Models\MediaTypeQuery */
        $q = $this->useExistsQuery('MediaType', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to MediaType table for a NOT EXISTS query.
     *
     * @see useMediaTypeExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\MediaTypeQuery The inner query object of the NOT EXISTS statement
     */
    public function useMediaTypeNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\MediaTypeQuery */
        $q = $this->useExistsQuery('MediaType', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to MediaType table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Chinook\Models\MediaTypeQuery The inner query object of the IN statement
     */
    public function useInMediaTypeQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Chinook\Models\MediaTypeQuery */
        $q = $this->useInQuery('MediaType', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to MediaType table for a NOT IN query.
     *
     * @see useMediaTypeInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\MediaTypeQuery The inner query object of the NOT IN statement
     */
    public function useNotInMediaTypeQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\MediaTypeQuery */
        $q = $this->useInQuery('MediaType', $modelAlias, $queryClass, 'NOT IN');
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
                ->addUsingAlias(TrackTableMap::COL_TRACK_ID, $invoiceLine->getTrackId(), $comparison);

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
     * Filter the query by a related \Chinook\Models\PlaylistTrack object
     *
     * @param \Chinook\Models\PlaylistTrack|ObjectCollection $playlistTrack the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPlaylistTrack($playlistTrack, ?string $comparison = null)
    {
        if ($playlistTrack instanceof \Chinook\Models\PlaylistTrack) {
            $this
                ->addUsingAlias(TrackTableMap::COL_TRACK_ID, $playlistTrack->getTrackId(), $comparison);

            return $this;
        } elseif ($playlistTrack instanceof ObjectCollection) {
            $this
                ->usePlaylistTrackQuery()
                ->filterByPrimaryKeys($playlistTrack->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByPlaylistTrack() only accepts arguments of type \Chinook\Models\PlaylistTrack or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PlaylistTrack relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinPlaylistTrack(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PlaylistTrack');

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
            $this->addJoinObject($join, 'PlaylistTrack');
        }

        return $this;
    }

    /**
     * Use the PlaylistTrack relation PlaylistTrack object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Chinook\Models\PlaylistTrackQuery A secondary query class using the current class as primary query
     */
    public function usePlaylistTrackQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPlaylistTrack($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PlaylistTrack', '\Chinook\Models\PlaylistTrackQuery');
    }

    /**
     * Use the PlaylistTrack relation PlaylistTrack object
     *
     * @param callable(\Chinook\Models\PlaylistTrackQuery):\Chinook\Models\PlaylistTrackQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPlaylistTrackQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePlaylistTrackQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to PlaylistTrack table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Chinook\Models\PlaylistTrackQuery The inner query object of the EXISTS statement
     */
    public function usePlaylistTrackExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Chinook\Models\PlaylistTrackQuery */
        $q = $this->useExistsQuery('PlaylistTrack', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to PlaylistTrack table for a NOT EXISTS query.
     *
     * @see usePlaylistTrackExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\PlaylistTrackQuery The inner query object of the NOT EXISTS statement
     */
    public function usePlaylistTrackNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\PlaylistTrackQuery */
        $q = $this->useExistsQuery('PlaylistTrack', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to PlaylistTrack table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Chinook\Models\PlaylistTrackQuery The inner query object of the IN statement
     */
    public function useInPlaylistTrackQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Chinook\Models\PlaylistTrackQuery */
        $q = $this->useInQuery('PlaylistTrack', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to PlaylistTrack table for a NOT IN query.
     *
     * @see usePlaylistTrackInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\PlaylistTrackQuery The inner query object of the NOT IN statement
     */
    public function useNotInPlaylistTrackQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\PlaylistTrackQuery */
        $q = $this->useInQuery('PlaylistTrack', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildTrack $track Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($track = null)
    {
        if ($track) {
            $this->addUsingAlias(TrackTableMap::COL_TRACK_ID, $track->getTrackId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the track table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrackTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TrackTableMap::clearInstancePool();
            TrackTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TrackTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TrackTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TrackTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TrackTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
