<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XSD\Type\MinOccursValue;

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
     * @var \SimpleSAML\XSD\Type\MinOccursValue|null
     */
    protected ?MinOccursValue $minOccurs = null;


    /**
     * Collect the value of the minOccurs-property
     *
     * @return \SimpleSAML\XSD\Type\MinOccursValue|null
     */
    public function getMinOccurs(): ?MinOccursValue
    {
        return $this->minOccurs;
    }


    /**
     * Set the value of the minOccurs-property
     *
     * @param \SimpleSAML\XSD\Type\MinOccursValue|null $minOccurs
     */
    protected function setMinOccurs(?MinOccursValue $minOccurs): void
    {
        $this->minOccurs = $minOccurs;
    }
}
