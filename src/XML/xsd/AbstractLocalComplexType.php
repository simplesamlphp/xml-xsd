<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XML\Type\{BooleanValue, IDValue, NCNameValue};

/**
 * Abstract class representing the localComplexType-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractLocalComplexType extends AbstractComplexType
{
    /**
     * LocalComplexType constructor
     *
     * @param \SimpleSAML\XML\Type\BooleanValue|null $mixed
     * @param \SimpleSAML\XSD\XML\xsd\SimpleContent|\SimpleSAML\XSD\XML\xsd\ComplexContent|null $content
     * @param \SimpleSAML\XSD\XML\xsd\TypeDefParticleInterface|null $particle
     * @param array<\SimpleSAML\XSD\XML\xsd\Attribute|\SimpleSAML\XSD\XML\xsd\ReferencedAttributeGroup> $attributes
     * @param \SimpleSAML\XSD\XML\xsd\AnyAttribute|null $anyAttribute
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        ?BooleanValue $mixed = null,
        SimpleContent|ComplexContent|null $content = null,
        ?TypeDefParticleInterface $particle = null,
        array $attributes = [],
        ?AnyAttribute $anyAttribute = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct(
            mixed: $mixed,
            content: $content,
            particle: $particle,
            attributes: $attributes,
            anyAttribute: $anyAttribute,
            annotation: $annotation,
            id: $id,
            namespacedAttributes: $namespacedAttributes,
        );
    }
}
