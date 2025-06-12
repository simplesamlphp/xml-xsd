<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

enum WhiteSpaceEnum: string
{
    case Collapse = 'collapse';
    case Preserve = 'preserve';
    case Replace = 'replace';
}
