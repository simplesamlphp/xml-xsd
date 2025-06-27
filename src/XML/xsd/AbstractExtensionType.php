<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\XML\Type\{IDValue, QNameValue};

use function strval;

/**
 * Abstract class representing the extensionType-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractExtensionType extends AbstractAnnotated
{
    use AttrDeclsTrait;
    use TypeDefParticleTrait;

    /**
     * AbstractExtensionType constructor
     *
     * @param \SimpleSAML\XML\Type\QNameValue $base
     * @param \SimpleSAML\XSD\XML\xsd\TypeDefParticleInterface|null $particle
     * @param array<\SimpleSAML\XSD\XML\xsd\LocalAttribute|\SimpleSAML\XSD\XML\xsd\ReferencedAttributeGroup> $attributes
     * @param \SimpleSAML\XSD\XML\xsd\AnyAttribute|null $anyAttribute
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected QNameValue $base,
        // xs:typeDefParticle
        ?TypeDefParticleInterface $particle = null,
        // xs:attrDecls
        array $attributes = [],
        ?AnyAttribute $anyAttribute = null,
        // parent defined
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($annotation, $id, $namespacedAttributes);

        $this->setAttributes($attributes);
        $this->setAnyAttribute($anyAttribute);
        $this->setParticle($particle);
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

        if ($this->getBase() !== null) {
            $e->setAttribute('base', strval($this->getBase()));
        }

        $this->getParticle()?->toXML($e);

        foreach ($this->getAttributes() as $attr) {
            $attr->toXML($e);
        }

        $this->getAnyAttribute()?->toXML($e);

        return $e;
    }
}
