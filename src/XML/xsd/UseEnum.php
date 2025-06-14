<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

enum UseEnum: string
{
    case Optional = 'optional';
    case Prohibited = 'prohibited';
    case Required = 'required';
}
