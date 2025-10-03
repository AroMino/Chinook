<?php

namespace Chinook\Models\Base;

use \Exception;
use \PDO;
use Chinook\Models\Album as ChildAlbum;
use Chinook\Models\AlbumQuery as ChildAlbumQuery;
use Chinook\Models\Map\AlbumTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `album` table.
 *
 * @method     ChildAlbumQuery orderByAlbumId($order = Criteria::ASC) Order by the album_id column
 * @method     ChildAlbumQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildAlbumQuery orderByArtistId($order = Criteria::ASC) Order by the artist_id column
 *
 * @method     ChildAlbumQuery groupByAlbumId() Group by the album_id column
 * @method     ChildAlbumQuery groupByTitle() Group by the title column
 * @method     ChildAlbumQuery groupByArtistId() Group by the artist_id column
 *
 * @method     ChildAlbumQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAlbumQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAlbumQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAlbumQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAlbumQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAlbumQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAlbumQuery leftJoinArtist($relationAlias = null) Adds a LEFT JOIN clause to the query using the Artist relation
 * @method     ChildAlbumQuery rightJoinArtist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Artist relation
 * @method     ChildAlbumQuery innerJoinArtist($relationAlias = null) Adds a INNER JOIN clause to the query using the Artist relation
 *
 * @method     ChildAlbumQuery joinWithArtist($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Artist relation
 *
 * @method     ChildAlbumQuery leftJoinWithArtist() Adds a LEFT JOIN clause and with to the query using the Artist relation
 * @method     ChildAlbumQuery rightJoinWithArtist() Adds a RIGHT JOIN clause and with to the query using the Artist relation
 * @method     ChildAlbumQuery innerJoinWithArtist() Adds a INNER JOIN clause and with to the query using the Artist relation
 *
 * @method     ChildAlbumQuery leftJoinTrack($relationAlias = null) Adds a LEFT JOIN clause to the query using the Track relation
 * @method     ChildAlbumQuery rightJoinTrack($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Track relation
 * @method     ChildAlbumQuery innerJoinTrack($relationAlias = null) Adds a INNER JOIN clause to the query using the Track relation
 *
 * @method     ChildAlbumQuery joinWithTrack($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Track relation
 *
 * @method     ChildAlbumQuery leftJoinWithTrack() Adds a LEFT JOIN clause and with to the query using the Track relation
 * @method     ChildAlbumQuery rightJoinWithTrack() Adds a RIGHT JOIN clause and with to the query using the Track relation
 * @method     ChildAlbumQuery innerJoinWithTrack() Adds a INNER JOIN clause and with to the query using the Track relation
 *
 * @method     \Chinook\Models\ArtistQuery|\Chinook\Models\TrackQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAlbum|null findOne(?ConnectionInterface $con = null) Return the first ChildAlbum matching the query
 * @method     ChildAlbum findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildAlbum matching the query, or a new ChildAlbum object populated from the query conditions when no match is found
 *
 * @method     ChildAlbum|null findOneByAlbumId(int $album_id) Return the first ChildAlbum filtered by the album_id column
 * @method     ChildAlbum|null findOneByTitle(string $title) Return the first ChildAlbum filtered by the title column
 * @method     ChildAlbum|null findOneByArtistId(int $artist_id) Return the first ChildAlbum filtered by the artist_id column
 *
 * @method     ChildAlbum requirePk($key, ?ConnectionInterface $con = null) Return the ChildAlbum by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbum requireOne(?ConnectionInterface $con = null) Return the first ChildAlbum matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAlbum requireOneByAlbumId(int $album_id) Return the first ChildAlbum filtered by the album_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbum requireOneByTitle(string $title) Return the first ChildAlbum filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAlbum requireOneByArtistId(int $artist_id) Return the first ChildAlbum filtered by the artist_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAlbum[]|Collection find(?ConnectionInterface $con = null) Return ChildAlbum objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildAlbum> find(?ConnectionInterface $con = null) Return ChildAlbum objects based on current ModelCriteria
 *
 * @method     ChildAlbum[]|Collection findByAlbumId(int|array<int> $album_id) Return ChildAlbum objects filtered by the album_id column
 * @psalm-method Collection&\Traversable<ChildAlbum> findByAlbumId(int|array<int> $album_id) Return ChildAlbum objects filtered by the album_id column
 * @method     ChildAlbum[]|Collection findByTitle(string|array<string> $title) Return ChildAlbum objects filtered by the title column
 * @psalm-method Collection&\Traversable<ChildAlbum> findByTitle(string|array<string> $title) Return ChildAlbum objects filtered by the title column
 * @method     ChildAlbum[]|Collection findByArtistId(int|array<int> $artist_id) Return ChildAlbum objects filtered by the artist_id column
 * @psalm-method Collection&\Traversable<ChildAlbum> findByArtistId(int|array<int> $artist_id) Return ChildAlbum objects filtered by the artist_id column
 *
 * @method     ChildAlbum[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildAlbum> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class AlbumQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Chinook\Models\Base\AlbumQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Chinook\\Models\\Album', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAlbumQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAlbumQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildAlbumQuery) {
            return $criteria;
        }
        $query = new ChildAlbumQuery();
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
     * @return ChildAlbum|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AlbumTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AlbumTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAlbum A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT album_id, title, artist_id FROM album WHERE album_id = :p0';
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
            /** @var ChildAlbum $obj */
            $obj = new ChildAlbum();
            $obj->hydrate($row);
            AlbumTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAlbum|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $albumId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($albumId['max'])) {
                $this->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $albumId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $albumId, $comparison);

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

        $this->addUsingAlias(AlbumTableMap::COL_TITLE, $title, $comparison);

        return $this;
    }

    /**
     * Filter the query on the artist_id column
     *
     * Example usage:
     * <code>
     * $query->filterByArtistId(1234); // WHERE artist_id = 1234
     * $query->filterByArtistId(array(12, 34)); // WHERE artist_id IN (12, 34)
     * $query->filterByArtistId(array('min' => 12)); // WHERE artist_id > 12
     * </code>
     *
     * @see       filterByArtist()
     *
     * @param mixed $artistId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByArtistId($artistId = null, ?string $comparison = null)
    {
        if (is_array($artistId)) {
            $useMinMax = false;
            if (isset($artistId['min'])) {
                $this->addUsingAlias(AlbumTableMap::COL_ARTIST_ID, $artistId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($artistId['max'])) {
                $this->addUsingAlias(AlbumTableMap::COL_ARTIST_ID, $artistId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(AlbumTableMap::COL_ARTIST_ID, $artistId, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Chinook\Models\Artist object
     *
     * @param \Chinook\Models\Artist|ObjectCollection $artist The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByArtist($artist, ?string $comparison = null)
    {
        if ($artist instanceof \Chinook\Models\Artist) {
            return $this
                ->addUsingAlias(AlbumTableMap::COL_ARTIST_ID, $artist->getArtistId(), $comparison);
        } elseif ($artist instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(AlbumTableMap::COL_ARTIST_ID, $artist->toKeyValue('PrimaryKey', 'ArtistId'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByArtist() only accepts arguments of type \Chinook\Models\Artist or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Artist relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinArtist(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Artist');

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
            $this->addJoinObject($join, 'Artist');
        }

        return $this;
    }

    /**
     * Use the Artist relation Artist object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Chinook\Models\ArtistQuery A secondary query class using the current class as primary query
     */
    public function useArtistQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinArtist($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Artist', '\Chinook\Models\ArtistQuery');
    }

    /**
     * Use the Artist relation Artist object
     *
     * @param callable(\Chinook\Models\ArtistQuery):\Chinook\Models\ArtistQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withArtistQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useArtistQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Artist table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Chinook\Models\ArtistQuery The inner query object of the EXISTS statement
     */
    public function useArtistExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Chinook\Models\ArtistQuery */
        $q = $this->useExistsQuery('Artist', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Artist table for a NOT EXISTS query.
     *
     * @see useArtistExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\ArtistQuery The inner query object of the NOT EXISTS statement
     */
    public function useArtistNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\ArtistQuery */
        $q = $this->useExistsQuery('Artist', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Artist table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Chinook\Models\ArtistQuery The inner query object of the IN statement
     */
    public function useInArtistQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Chinook\Models\ArtistQuery */
        $q = $this->useInQuery('Artist', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Artist table for a NOT IN query.
     *
     * @see useArtistInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\ArtistQuery The inner query object of the NOT IN statement
     */
    public function useNotInArtistQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\ArtistQuery */
        $q = $this->useInQuery('Artist', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Filter the query by a related \Chinook\Models\Track object
     *
     * @param \Chinook\Models\Track|ObjectCollection $track the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByTrack($track, ?string $comparison = null)
    {
        if ($track instanceof \Chinook\Models\Track) {
            $this
                ->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $track->getAlbumId(), $comparison);

            return $this;
        } elseif ($track instanceof ObjectCollection) {
            $this
                ->useTrackQuery()
                ->filterByPrimaryKeys($track->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByTrack() only accepts arguments of type \Chinook\Models\Track or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Track relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinTrack(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Track');

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
            $this->addJoinObject($join, 'Track');
        }

        return $this;
    }

    /**
     * Use the Track relation Track object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Chinook\Models\TrackQuery A secondary query class using the current class as primary query
     */
    public function useTrackQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTrack($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Track', '\Chinook\Models\TrackQuery');
    }

    /**
     * Use the Track relation Track object
     *
     * @param callable(\Chinook\Models\TrackQuery):\Chinook\Models\TrackQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withTrackQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useTrackQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Track table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Chinook\Models\TrackQuery The inner query object of the EXISTS statement
     */
    public function useTrackExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        /** @var $q \Chinook\Models\TrackQuery */
        $q = $this->useExistsQuery('Track', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Track table for a NOT EXISTS query.
     *
     * @see useTrackExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\TrackQuery The inner query object of the NOT EXISTS statement
     */
    public function useTrackNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\TrackQuery */
        $q = $this->useExistsQuery('Track', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Track table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Chinook\Models\TrackQuery The inner query object of the IN statement
     */
    public function useInTrackQuery($modelAlias = null, $queryClass = null, $typeOfIn = 'IN')
    {
        /** @var $q \Chinook\Models\TrackQuery */
        $q = $this->useInQuery('Track', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Track table for a NOT IN query.
     *
     * @see useTrackInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Chinook\Models\TrackQuery The inner query object of the NOT IN statement
     */
    public function useNotInTrackQuery($modelAlias = null, $queryClass = null)
    {
        /** @var $q \Chinook\Models\TrackQuery */
        $q = $this->useInQuery('Track', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildAlbum $album Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($album = null)
    {
        if ($album) {
            $this->addUsingAlias(AlbumTableMap::COL_ALBUM_ID, $album->getAlbumId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the album table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlbumTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AlbumTableMap::clearInstancePool();
            AlbumTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AlbumTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AlbumTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AlbumTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AlbumTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
