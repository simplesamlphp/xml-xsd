<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XSD\Type\MaxOccursValue;

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
     * @var \SimpleSAML\XSD\Type\MaxOccursValue|null
     */
    protected ?MaxOccursValue $maxOccurs = null;


    /**
     * Collect the value of the maxOccurs-property
     *
     * @return \SimpleSAML\XSD\Type\MaxOccursValue|null
     */
    public function getMaxOccurs(): ?MaxOccursValue
    {
        return $this->maxOccurs;
    }


    /**
     * Set the value of the maxOccurs-property
     *
     * @param \SimpleSAML\XSD\Type\MaxOccursValue|null $maxOccurs
     */
    protected function setMaxOccurs(?MaxOccursValue $maxOccurs): void
    {
        $this->maxOccurs = $maxOccurs;
    }
}
