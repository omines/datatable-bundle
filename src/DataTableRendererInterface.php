<?php

/*
 * Symfony DataTables Bundle
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Omines\DataTablesBundle;

use Iterator;

/**
 * DataTableRendererInterface.
 *
 * @author Niels Keurentjes <niels.keurentjes@omines.com>
 */
interface DataTableRendererInterface
{
    /**
     * Provides the HTML layout of the configured datatable.
     */
    public function renderDataTable(DataTable $dataTable, string $template, array $parameters): string;

    public function renderResultSet(Iterator $resultSet, string $template, array $parameters): array;
}
