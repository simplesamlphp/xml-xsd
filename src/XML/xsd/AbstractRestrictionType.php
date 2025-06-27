<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\{IDValue, QNameValue};

use function strval;

/**
 * Abstract class representing the restrictionType-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractRestrictionType extends AbstractAnnotated
{
    use AttrDeclsTrait;
    use SimpleRestrictionModelTrait;
    use TypeDefParticleTrait;

    /**
     * AbstractRestrictionType constructor
     *
     * @param \SimpleSAML\XML\Type\QNameValue $base
     * @param \SimpleSAML\XSD\XML\xsd\TypeDefParticleInterface|null $particle
     * @param \SimpleSAML\XSD\XML\xsd\LocalSimpleType|null $localSimpleType
     * @param array<\SimpleSAML\XSD\XML\xsd\FacetInterface> $facets
     * @param array<\SimpleSAML\XSD\XML\xsd\Attribute|\SimpleSAML\XSD\XML\xsd\ReferencedAttributeGroup> $attributes
     * @param \SimpleSAML\XSD\XML\xsd\AnyAttribute|null $anyAttribute
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected QNameValue $base,
        // xs:typeDefParticle
        ?TypeDefParticleInterface $particle = null,
        // xs:simpleRestrictionModel
        protected ?LocalSimpleType $localSimpleType = null,
        array $facets = [],
        // xs:attrDecls
        array $attributes = [],
        ?AnyAttribute $anyAttribute = null,
        // parent defined
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        // The xs:typeDefParticle and xs:simpleRestrictionModel groups are mutually exclusive
        if ($particle !== null) {
            Assert::null($localSimpleType, SchemaViolationException::class);
            Assert::isEmpty($facets, SchemaViolationException::class);
        } elseif ($localSimpleType !== null || $facets !== []) {
            $this->setSimpleType($localSimpleType);
            $this->setFacets($facets);
        }

        parent::__construct($annotation, $id, $namespacedAttributes);

        $this->setAttributes($attributes);
        $this->setAnyAttribute($anyAttribute);
        $this->setParticle($particle);
    }


    /**
     * Collect the value of the localSimpleType-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\LocalSimpleType|null
     */
    public function getLocalSimpleType(): ?LocalSimpleType
    {
        return $this->localSimpleType;
    }


    /**
     * Collect the value of the base-property
     *
     * @return \SimpleSAML\XML\Type\QNameValue
     */
    public function getBase(): ?QNameValue
    {
        return $this->base;
    }


    /**
     * Add this RestrictionType to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this RestrictionType to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getParticle() !== null) {
            $this->getParticle()->toXML($e);
        } elseif ($this->getLocalSimpleType() !== null || $this->getFacets() !== []) {
            $this->getLocalSimpleType()->toXML($e);

            foreach ($this->getFacets() as $facet) {
                $facet->toXML($e);
            }
        }

        foreach ($this->getAttributes() as $attr) {
            $attr->toXML($e);
        }

        $this->getAnyAttribute()?->toXML($e);

        if ($this->getBase() !== null) {
            $e->setAttribute('base', strval($this->getBase()));
        }

        return $e;
    }
}
