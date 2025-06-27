<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\IDValue;
use SimpleSAML\XSD\Type\{MinOccursValue, MaxOccursValue};
//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;
use SimpleSAML\XML\XsNamespace;

/**
 * Abstract class representing the explicitGroup-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractAll extends AbstractExplicitGroup
{
    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = XsNamespace::OTHER;
//    public const XS_ANY_ATTR_NAMESPACE = NamespaceEnum::Other;


    /**
     * All constructor
     *
     * @param \SimpleSAML\XSD\Type\MinOccursValue|null $minOccurs
     * @param \SimpleSAML\XSD\Type\MaxOccursValue|null $maxOccurs
     * @param \SimpleSAML\XSD\XML\xsd\NarrowMaxMinElement[] $particles
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        ?MinOccursValue $minOccurs = null,
        ?MaxOccursValue $maxOccurs = null,
        array $particles = [],
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        if ($minOccurs !== null) {
            Assert::oneOf($minOccurs->toInteger(), [0, 1], SchemaViolationException::class);
        }

        if ($maxOccurs !== null) {
            Assert::same($maxOccurs->toInteger(), 1, SchemaViolationException::class);
        }

        Assert::allIsInstanceOf(
            $particles,
            NarrowMaxMinElement::class,
            SchemaViolationException::class,
        );

        parent::__construct(
            nestedParticles: $particles,
            minOccurs: $minOccurs,
            maxOccurs: $maxOccurs,
            annotation: $annotation,
            id: $id,
            namespacedAttributes: $namespacedAttributes,
        );
    }
}
