<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

/**
 * Trait grouping common functionality for elements that can hold a MinOccurs attribute.
 *
 * @package simplesamlphp/xml-xsd
 */
trait MinOccursTrait
{
    /**
     * The minOccurs.
     *
     * @var non-negative-int
     */
    protected int $minOccurs;


    /**
     * Collect the value of the minOccurs-property
     *
     * @return non-negative-int
     */
    public function getMinOccurs(): int
    {
        return $this->minOccurs;
    }


    /**
     * Set the value of the minOccurs-property
     *
     * @param string|non-negative-int $minOccurs
     */
    protected function setMinOccurs(string|int $MinOccurs): void
    {
        Assert::positiveInteger($MinOccurs, SchemaViolationException::class);

        $this->MinOccurs = $minOccurs;
    }
}
