<?php

namespace Tests\Fixtures\AppBundle\DataTable\Adapter;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\GroupBy;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\AdapterQuery;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\AbstractColumn;

class CustomORMAdapter extends ORMAdapter
{
    protected $hydrationMode;

    public function configure(array $options)
    {
        parent::configure($options);

        $this->hydrationMode = isset($options['hydrate']) ? $options['hydrate'] : Query::HYDRATE_OBJECT;
    }

    protected function prepareQuery(AdapterQuery $query)
    {
        parent::prepareQuery($query);
        $query->setIdentifierPropertyPath(null);
    }

    /**
     * @param AdapterQuery $query
     * @return \Traversable
     */
    protected function getResults(AdapterQuery $query): \Traversable
    {
        /** @var QueryBuilder $builder */
        $builder = $query->get('qb');
        $state = $query->getState();

        // Apply definitive view state for current 'page' of the table
        foreach ($state->getOrderBy() as list($column, $direction)) {
            /** @var AbstractColumn $column */
            if ($column->isOrderable()) {
                $builder->addOrderBy($column->getOrderField(), $direction);
            }
        }
        if ($state->getLength() > 0) {
            $builder
                ->setFirstResult($state->getStart())
                ->setMaxResults($state->getLength());
        }

        /**
         * Use foreach instead of iterate to prevent group by from crashing
         */
        foreach ($builder->getQuery()->getResult($this->hydrationMode) as $result) {
            /**
             * Return everything instead of first element
             */
            yield $result;
        }
    }
}