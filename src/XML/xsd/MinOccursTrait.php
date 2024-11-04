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
     * @var non-negative-int|null
     */
    protected ?int $minOccurs;


    /**
     * Collect the value of the minOccurs-property
     *
     * @return non-negative-int|null
     */
    public function getMinOccurs(): ?int
    {
        return $this->minOccurs;
    }


    /**
     * Set the value of the minOccurs-property
     *
     * @param non-negative-int $minOccurs
     */
    protected function setMinOccurs(?int $minOccurs): void
    {
        Assert::nullOrPositiveInteger($minOccurs, SchemaViolationException::class);

        $this->minOccurs = $minOccurs;
    }
}
