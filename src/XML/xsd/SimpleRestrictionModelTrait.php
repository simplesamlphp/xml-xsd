<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

/**
 * Trait grouping common functionality for elements that are part of the xs:facets group.
 *
 * @package simplesamlphp/xml-xsd
 */
trait SimpleRestrictionModelTrait
{
    use FacetsTrait;

    /**
     * The simpleType.
     *
     * @var \SimpleSAML\XSD\XML\xsd\LocalSimpleType|null
     */
    protected ?LocalSimpleType $simpleType = null;


    /**
     * Collect the value of the simpleType-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\LocalSimpleType|null
     */
    public function getSimpleType(): ?LocalSimpleType
    {
        return $this->simpleType;
    }


    /**
     * Set the value of the simpleType-property
     *
     * @param \SimpleSAML\XSD\XML\xsd\LocalSimpleType|null $simpleType
     */
    protected function setSimpleType(?LocalSimpleType $simpleType = null): void
    {
        $this->simpleType = $simpleType;
    }
}
