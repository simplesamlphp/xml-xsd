<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\{IDValue, NCNameValue};
use SimpleSAML\XSD\Type\SimpleDerivationSetValue;

/**
 * Abstract class representing the abstract topLevelSimpleType.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractTopLevelSimpleType extends AbstractSimpleType
{
    /**
     * Annotated constructor
     *
     * @param (
     *   \SimpleSAML\XSD\XML\xsd\Union|
     *   \SimpleSAML\XSD\XML\xsd\XsList|
     *   \SimpleSAML\XSD\XML\xsd\Restriction
     * ) $derivation
     * @param \SimpleSAML\XML\Type\NCNameValue $name
     * @param \SimpleSAML\XSD\Type\SimpleDerivationSetValue $final
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        Union|XsList|Restriction $derivation,
        NCNameValue $name,
        ?SimpleDerivationSetValue $final = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        Assert::notNull($name, SchemaViolationException::class);

        parent::__construct($derivation, $name, $final, $annotation, $id, $namespacedAttributes);
    }
}
