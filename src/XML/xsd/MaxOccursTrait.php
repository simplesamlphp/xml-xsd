<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

use function is_int;
use function is_string;

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
     * @var string|non-negative-int|null
     */
    protected string|int|null $maxOccurs;


    /**
     * Collect the value of the maxOccurs-property
     *
     * @return string|non-negative-int|null
     */
    public function getMaxOccurs(): string|int|null
    {
        return $this->maxOccurs;
    }


    /**
     * Set the value of the maxOccurs-property
     *
     * @param string|non-negative-int|null $maxOccurs
     */
    protected function setMaxOccurs(string|int|null $maxOccurs): void
    {
        if (is_int($maxOccurs)) {
            Assert::positiveInteger($maxOccurs, SchemaViolationException::class);
        } elseif (is_string($maxOccurs)) {
            Assert::same($maxOccurs, 'unbounded', SchemaViolationException::class);
        }

        $this->maxOccurs = $maxOccurs;
    }
}
