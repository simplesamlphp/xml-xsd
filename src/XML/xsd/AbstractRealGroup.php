<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\{IDValue, NCNameValue, QNameValue};
//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;
use SimpleSAML\XML\XsNamespace;
use SimpleSAML\XSD\Type\{MinOccursValue, MaxOccursValue};

use function is_null;

/**
 * Abstract class representing the realGroup-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractRealGroup extends AbstractGroup
{
    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = XsNamespace::OTHER;
//    public const XS_ANY_ATTR_NAMESPACE = NamespaceEnum::Other;


    /**
     * Group constructor
     *
     * @param \SimpleSAML\XSD\XML\xsd\ParticleInterface|null $particle
     * @param \SimpleSAML\XML\Type\NCNameValue|null $name
     * @param \SimpleSAML\XML\Type\QNameValue|null $reference
     * @param \SimpleSAML\XSD\Type\MinOccursValue|null $minOccurs
     * @param \SimpleSAML\XSD\Type\MaxOccursValue|null $maxOccurs
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        ?ParticleInterface $particle = null,
        ?NCNameValue $name = null,
        ?QNameValue $reference = null,
        ?MinOccursValue $minOccurs = null,
        ?MaxOccursValue $maxOccurs = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        Assert::nullOrIsInstanceOf(
            $particle,
            ParticleInterface::class,
            SchemaViolationException::class,
        );

        parent::__construct(
            $name,
            $reference,
            $minOccurs,
            $maxOccurs,
            is_null($particle) ? [] : [$particle],
            $annotation,
            $id,
            $namespacedAttributes,
        );
    }
}
