<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

/**
 * Trait grouping common functionality for elements that represent the occurs group.
 *
 * @package simplesamlphp/xml-xsd
 */
trait OccursTrait
{
    use MaxOccursTrait;
    use MinOccursTrait;
}
