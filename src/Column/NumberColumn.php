<?php

/*
 * Symfony DataTables Bundle
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Omines\DataTablesBundle\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * NumberColumn.
 *
 * @author Niels Keurentjes <niels.keurentjes@omines.com>
 */
class NumberColumn extends AbstractColumn
{
    /**
     * {@inheritdoc}
     */
    public function normalize($value): string
    {
        $value = (string) $value;
        if (is_numeric($value)) return $value;

        return $this->isRaw() ? $value : (string) floatval($value);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefault('raw', false)
            ->setAllowedTypes('raw', 'bool')
        ;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRaw(): bool
    {
        return $this->options['raw'];
    }
}
