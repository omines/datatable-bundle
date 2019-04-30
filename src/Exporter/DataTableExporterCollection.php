<?php

/*
 * Symfony DataTables Bundle
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Omines\DataTablesBundle\Exporter;

use Omines\DataTablesBundle\Exception\UnknownDataTableExporterException;

/**
 * Holds the available DataTable exporters.
 * Exporters must be tagged with 'datatables.exporter'.
 *
 * @author Maxime Pinot <contact@maximepinot.com>
 */
class DataTableExporterCollection
{
    /** @var iterable The available exporters */
    private $exporters;

    /**
     * DataTableExporterCollection constructor.
     *
     * @param iterable $exporters
     */
    public function __construct(iterable $exporters)
    {
        $this->exporters = $exporters;
    }

    /**
     * Finds a DataTable exporter that matches the given name.
     *
     * @param string $name
     *
     * @return DataTableExporterInterface
     *
     * @throws UnknownDataTableExporterException
     */
    public function getByName(string $name): DataTableExporterInterface
    {
        foreach ($this->exporters as $exporter) {
            if ($exporter->getName() === $name) {
                return $exporter;
            }
        }

        throw new UnknownDataTableExporterException($name, $this->exporters);
    }
}
