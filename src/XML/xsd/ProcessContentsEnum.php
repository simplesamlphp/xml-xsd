<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

enum ProcessContentsEnum: string
{
    case Lax = 'lax';
    case Skip = 'skip';
    case Strict = 'strict';
}
