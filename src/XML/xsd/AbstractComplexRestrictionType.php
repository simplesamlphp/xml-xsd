<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XML\Type\{IDValue, QNameValue};

/**
 * Abstract class representing the complexRestrictionType-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractComplexRestrictionType extends AbstractRestrictionType
{
    /**
     * AbstractRestrictionType constructor
     *
     * @param \SimpleSAML\XML\Type\QNameValue $base
     * @param \SimpleSAML\XSD\XML\xsd\TypeDefParticleInterface|null $particle
     * @param array<\SimpleSAML\XSD\XML\xsd\Attribute|\SimpleSAML\XSD\XML\xsd\ReferencedAttributeGroup> $attributes
     * @param \SimpleSAML\XSD\XML\xsd\AnyAttribute|null $anyAttribute
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        QNameValue $base,
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
        parent::__construct(
            base: $base,
            particle: $particle,
            attributes: $attributes,
            anyAttribute: $anyAttribute,
            annotation: $annotation,
            id: $id,
            namespacedAttributes: $namespacedAttributes,
        );
    }
}
