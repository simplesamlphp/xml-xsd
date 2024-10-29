<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

use is_int;

/**
 * Trait grouping common functionality for elements that can hold a maxOccurs attribute.
 *
 * @package simplesamlphp/xml-xsd
 */
trait MaxOccursTrait
{
    /**
     * The maxOccurs.
     *
     * @var string|non-negative-int
     */
    protected string|int $maxOccurs;


    /**
     * Collect the value of the maxOccurs-property
     *
     * @return string|non-negative-int
     */
    public function getMaxOccurs(): string|int
    {
        return $this->maxOccurs;
    }


    /**
     * Set the value of the maxOccurs-property
     *
     * @param string|non-negative-int $maxOccurs
     */
    protected function setMaxOccurs(string|int $maxOccurs): void
    {
        if (is_int($maxOccurs)) {
            Assert::positiveInteger($maxOccurs, SchemaViolationException::class);
        } else {
            Assert::same($maxOccurs, 'unbounded', SchemaViolationException::class);
        }

        $this->maxOccurs = $maxOccurs;
    }
}
