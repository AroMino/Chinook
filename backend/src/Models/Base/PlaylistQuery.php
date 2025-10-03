<?php

namespace Chinook\Models\Base;

use \Exception;
use \PDO;
use Chinook\Models\Playlist as ChildPlaylist;
use Chinook\Models\PlaylistQuery as ChildPlaylistQuery;
use Chinook\Models\Map\PlaylistTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `playlist` table.
 *
 * @method     ChildPlaylistQuery orderByPlaylistId($order = Criteria::ASC) Order by the playlist_id column
 * @method     ChildPlaylistQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildPlaylistQuery groupByPlaylistId() Group by the playlist_id column
 * @method     ChildPlaylistQuery groupByName() Group by the name column
 *
 * @method     ChildPlaylistQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPlaylistQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPlaylistQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPlaylistQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPlaylistQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPlaylistQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPlaylistQuery leftJoinPlaylistTrack($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlaylistTrack relation
 * @method     ChildPlaylistQuery rightJoinPlaylistTrack($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlaylistTrack relation
 * @method     ChildPlaylistQuery innerJoinPlaylistTrack($relationAlias = null) Adds a INNER JOIN clause to the query using the PlaylistTrack relation
 *
 * @method     ChildPlaylistQuery joinWithPlaylistTrack($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PlaylistTrack relation
 *
 * @method     ChildPlaylistQuery leftJoinWithPlaylistTrack() Adds a LEFT JOIN clause and with to the query using the PlaylistTrack relation
 * @method     ChildPlaylistQuery rightJoinWithPlaylistTrack() Adds a RIGHT JOIN clause and with to the query using the PlaylistTrack relation
 * @method     ChildPlaylistQuery innerJoinWithPlaylistTrack() Adds a INNER JOIN clause and with to the query using the PlaylistTrack relation
 *
 * @method     \Chinook\Models\PlaylistTrackQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPlaylist|null findOne(?ConnectionInterface $con = null) Return the first ChildPlaylist matching the query
 * @method     ChildPlaylist findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildPlaylist matching the query, or a new ChildPlaylist object populated from the query conditions when no match is found
 *
 * @method     ChildPlaylist|null findOneByPlaylistId(int $playlist_id) Return the first ChildPlaylist filtered by the playlist_id column
 * @method     ChildPlaylist|null findOneByName(string $name) Return the first ChildPlaylist filtered by the name column
 *
 * @method     ChildPlaylist requirePk($key, ?ConnectionInterface $con = null) Return the ChildPlaylist by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlaylist requireOne(?ConnectionInterface $con = null) Return the first ChildPlaylist matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlaylist requireOneByPlaylistId(int $playlist_id) Return the first ChildPlaylist filtered by the playlist_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlaylist requireOneByName(string $name) Return the first ChildPlaylist filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlaylist[]|Collection find(?ConnectionInterface $con = null) Return ChildPlaylist objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildPlaylist> find(?ConnectionInterface $con = null) Return ChildPlaylist objects based on current ModelCriteria
 *
 * @method     ChildPlaylist[]|Collection findByPlaylistId(int|array<int> $playlist_id) Return ChildPlaylist objects filtered by the playlist_id column
 * @psalm-method Collection&\Traversable<ChildPlaylist> findByPlaylistId(int|array<int> $playlist_id) Return ChildPlaylist objects filtered by the playlist_id column
 * @method     ChildPlaylist[]|Collection findByName(string|array<string> $name) Return ChildPlaylist objects filtered by the name column
 * @psalm-method Collection&\Traversable<ChildPlaylist> findByName(string|array<string> $name) Return ChildPlaylist objects filtered by the name column
 *
 * @method     ChildPlaylist[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildPlaylist> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class PlaylistQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Chinook\Models\Base\PlaylistQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Chinook\\Models\\Playlist', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPlaylistQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPlaylistQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildPlaylistQuery) {
            return $criteria;
        }
        $query = new ChildPlaylistQuery();
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
     * @return ChildPlaylist|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PlaylistTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PlaylistTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPlaylist A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT playlist_id, name FROM playlist WHERE playlist_id = :p0';
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
            /** @var ChildPlaylist $obj */
            $obj = new ChildPlaylist();
            $obj->hydrate($row);
            PlaylistTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPlaylist|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(PlaylistTableMap::COL_PLAYLIST_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(PlaylistTableMap::COL_PLAYLIST_ID, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the playlist_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPlaylistId(1234); // WHERE playlist_id = 1234
     * $query->filterByPlaylistId(array(12, 34)); // WHERE playlist_id IN (12, 34)
     * $query->filterByPlaylistId(array('min' => 12)); // WHERE playlist_id > 12
     * </code>
     *
     * @param mixed $playlistId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPlaylistId($playlistId = null, ?string $comparison = null)
    {
        if (is_array($playlistId)) {
            $useMinMax = false;
            if (isset($playlistId['min'])) {
                $this->addUsingAlias(PlaylistTableMap::COL_PLAYLIST_ID, $playlistId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($playlistId['max'])) {
                $this->addUsingAlias(PlaylistTableMap::COL_PLAYLIST_ID, $playlistId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(PlaylistTableMap::COL_PLAYLIST_ID, $playlistId, $comparison);

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

        $this->addUsingAlias(PlaylistTableMap::COL_NAME, $name, $comparison);

        return $this;
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
                ->addUsingAlias(PlaylistTableMap::COL_PLAYLIST_ID, $playlistTrack->getPlaylistId(), $comparison);

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
     * @param ChildPlaylist $playlist Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($playlist = null)
    {
        if ($playlist) {
            $this->addUsingAlias(PlaylistTableMap::COL_PLAYLIST_ID, $playlist->getPlaylistId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the playlist table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlaylistTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PlaylistTableMap::clearInstancePool();
            PlaylistTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PlaylistTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PlaylistTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PlaylistTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PlaylistTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
