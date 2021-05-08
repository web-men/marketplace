<?php

namespace App\Utils;

use ArrayIterator;
use Doctrine\ORM\QueryBuilder;

/**
 * Class Paginator
 * @package App\Utils
 */
class Paginator
{
    private const PAGE_SIZE = 2;
    private ArrayIterator $result;
    private int $numResult;
    private int $currentPage;

    /**
     * Paginator constructor.
     * @param QueryBuilder $queryBuilder
     * @param int $pageSize
     */
    public function __construct(
        private QueryBuilder $queryBuilder,
        private int $pageSize = self::PAGE_SIZE,
    ) {}

    /**
     * @param int $page
     * @return $this
     */
    final public function pagination(int $page = 1): self
    {
        $this->currentPage = (int) max(1, $page);
        $firstResult = ($this->currentPage - 1) * $this->pageSize;

        $query = $this->queryBuilder
            ->setFirstResult($firstResult)
            ->setMaxResults($this->pageSize)
            ->getQuery();

        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query, true);

        $this->result = $paginator->getIterator();
        $this->numResult = $paginator->count();

        return $this;
    }

    /**
     * @return ArrayIterator
     */
    final public function getResult(): ArrayIterator
    {
        return $this->result;
    }

    /**
     * @return int
     */
    final  public function getNumResult(): int
    {
        return $this->numResult;
    }

    /**
     * @return int
     */
    final public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    final public function getLastPage(): int
    {
        return (int) ceil($this->numResult / $this->pageSize);
    }

    /**
     * @return int
     */
    final public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @return bool
     */
    final public function hasPreviousPage(): bool
    {
        return $this->currentPage > 1;
    }

    /**
     * @return int
     */
    final public function getPreviousPage(): int
    {
        return max(1, $this->currentPage - 1);
    }

    /**
     * @return bool
     */
    final public function hasNextPage(): bool
    {
        return $this->currentPage < $this->getLastPage();
    }

    /**
     * @return bool
     */
    final public function hasToPaginate(): bool
    {
        return $this->numResult > $this->pageSize;
    }

    /**
     * @return int
     */
    final public function getNextPage(): int
    {
        return min($this->getLastPage(), $this->currentPage + 1);
    }
}