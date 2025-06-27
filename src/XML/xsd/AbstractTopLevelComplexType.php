<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XML\Type\{BooleanValue, IDValue, NCNameValue};
use SimpleSAML\XSD\Type\DerivationSetValue;

/**
 * Abstract class representing the topLevelComplexType-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractTopLevelComplexType extends AbstractComplexType
{
    /**
     * TopLevelComplexType constructor
     *
     * @param \SimpleSAML\XML\Type\NCNameValue $name
     * @param \SimpleSAML\XML\Type\BooleanValue|null $mixed
     * @param \SimpleSAML\XML\Type\BooleanValue|null $abstract
     * @param \SimpleSAML\XSD\Type\DerivationSetValue|null $final
     * @param \SimpleSAML\XSD\Type\DerivationSetValue|null $block
     * @param \SimpleSAML\XSD\XML\xsd\SimpleContent|\SimpleSAML\XSD\XML\xsd\ComplexContent|null $content
     * @param \SimpleSAML\XSD\XML\xsd\TypeDefParticleInterface|null $particle
     * @param array<\SimpleSAML\XSD\XML\xsd\LocalAttribute|\SimpleSAML\XSD\XML\xsd\ReferencedAttributeGroup> $attributes
     * @param \SimpleSAML\XSD\XML\xsd\AnyAttribute|null $anyAttribute
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        NCNameValue $name,
        ?BooleanValue $mixed = null,
        ?BooleanValue $abstract = null,
        ?DerivationSetValue $final = null,
        ?DerivationSetValue $block = null,
        SimpleContent|ComplexContent|null $content = null,
        ?TypeDefParticleInterface $particle = null,
        array $attributes = [],
        ?AnyAttribute $anyAttribute = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct(
            $name,
            $mixed,
            $abstract,
            $final,
            $block,
            $content,
            $particle,
            $attributes,
            $anyAttribute,
            $annotation,
            $id,
            $namespacedAttributes,
        );
    }
}
