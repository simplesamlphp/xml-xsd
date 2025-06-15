<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XSD\XML\xsd\FacetInterface;

/**
 * Trait grouping common functionality for elements that are part of the xs:facets group.
 *
 * @package simplesamlphp/xml-xsd
 */
trait FacetsTrait
{
    /**
     * The facets.
     *
     * @var \SimpleSAML\XSD\XML\xsd\FacetInterface[]
     */
    protected array $facets;


    /**
     * Collect the value of the facets-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\FacetInterface[]
     */
    public function getFacets(): array
    {
        return $this->facets;
    }


    /**
     * Set the value of the facets-property
     *
     * @param \SimpleSAML\XSD\XML\xsd\FacetInterface[] $facets
     */
    protected function setFacets(array $facets): void
    {
        Assert::maxCount($facets, C::UNBOUNDED_LIMIT);
        Assert::isInstanceOf($facets, FacetInterface::class, SchemaViolationException::class);
        $this->facets = $facets;
    }
}
