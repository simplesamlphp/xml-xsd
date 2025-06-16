<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, MissingElementException, SchemaViolationException};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\{IDValue, QNameValue, StringValue};

use function array_fill;
use function array_map;
use function array_pop;
use function implode;
use function strval;

/**
 * Class representing the union-element.
 *
 * @package simplesamlphp/xml-xsd
 */
final class Union extends AbstractAnnotated implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'union';


    /**
     * Notation constructor
     *
     * @param \SimpleSAML\XSD\XML\xsd\LocalSimpleType[] $simpleType
     * @param array<\SimpleSAML\XML\Type\QNameValue> $memberTypes
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected array $simpleType,
        protected array $memberTypes = [],
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        Assert::allIsInstanceOf($simpleType, LocalSimpleType::class, SchemaViolationException::class);
        Assert::allIsInstanceOf($memberTypes, QNameValue::class, SchemaViolationException::class);

        if (empty($memberTypes)) {
            Assert::minCount($simpleType, 1, MissingElementException::class);
        }

        parent::__construct($annotation, $id, $namespacedAttributes);
    }


    /**
     * Collect the value of the simpleType-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\LocalSimpleType[]
     */
    public function getSimpleType(): array
    {
        return $this->simpleType;
    }


    /**
     * Collect the value of the memberTypes-property
     *
     * @return array<\SimpleSAML\XML\Type\QNameValue>
     */
    public function getMemberTypes(): array
    {
        return $this->memberTypes;
    }


    /**
     * Add this Notation to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this notation to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $memberTypes = implode(' ', array_map('strval', $this->getMemberTypes()));
        if ($memberTypes !== '') {
            $e->setAttribute('memberTypes', $memberTypes);
        }

        foreach ($this->getSimpleType() as $simpleType) {
            $simpleType->toXML($e);
        }

        return $e;
    }


    /**
     * Create an instance of this object from its XML representation.
     *
     * @param \DOMElement $xml
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $annotation = Annotation::getChildrenOfClass($xml);
        $simpleType = LocalSimpleType::getChildrenOfClass($xml);

        $memberTypes = [];
        $memberTypesValue = self::getOptionalAttribute($xml, 'memberTypes', StringValue::class, null);
        if ($memberTypesValue !== null) {
            $exploded = explode(' ', strval($memberTypesValue));
            /** @var \SimpleSAML\XML\Type\QNameValue[] $memberTypes */
            $memberTypes = array_map(
                [QNameValue::class, 'fromDocument'],
                $exploded,
                array_fill(0, count($exploded), $xml),
            );
        }

        return new static(
            $simpleType,
            $memberTypes,
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
