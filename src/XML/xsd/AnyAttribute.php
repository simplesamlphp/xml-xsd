<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\XsNamespace as NS;
use SimpleSAML\XML\XsProcess;

use function array_column;
use function array_pop;
use function in_array;

/**
 * Class representing the anyAttribute element
 *
 * @package simplesamlphp/xml-xsd
 */
final class AnyAttribute extends AbstractWildcard implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'anyAttribute';


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

        $namespace = self::getOptionalAttribute($xml, 'namespace', null);
        if (in_array($namespace, array_column(NS::cases(), 'value'), true)) {
            $namespace = NS::from($namespace);
        }

        $processContents = self::getOptionalAttribute($xml, 'processContents', null);
        if ($processContents !== null) {
            $processContents = XsProcess::from($processContents);
        }

        $annotation = Annotation::getChildrenOfClass($xml);

        return new static(
            $namespace,
            $processContents,
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
