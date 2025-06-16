<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, MissingElementException};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\{IDValue, QNameValue, StringValue};

use function array_map;
use function array_pop;
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
     * @param \SimpleSAML\XML\Type\QNameValue|null $memberTypes
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected array $simpleType,
        protected ?QNameValue $memberTypes = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        Assert::allIsInstanceOf($simpleType, LocalSimpleType::class, SchemaViolationException::class);

        if ($memberTypes === null) {
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
     * @return \SimpleSAML\XML\Type\QNameValue|null
     */
    public function getMemberTypes(): ?QNameValue
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

        if ($this->getMemberTypes() !== null) {
            $e->setAttribute('memberTypes', strval($this->getMemberTypes()));
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

        $memberTypes = null;
        $memberTypesValue = self::getOptionalAttribute($xml, 'memberTypes', StringValue::class, null);
        if ($memberTypesValue !== null) {
            $exploded = explode(' ', strval($memberTypesValue));
            $memberTypes = array_map([QNameValue::class, 'fromDocument'], $exploded, $xml);
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
