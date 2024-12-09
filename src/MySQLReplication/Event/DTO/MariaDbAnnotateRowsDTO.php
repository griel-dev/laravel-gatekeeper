<?php

namespace MySQLReplication\Event\DTO;

use MySQLReplication\Definitions\ConstEventsNames;
use MySQLReplication\Event\EventInfo;

class MariaDbAnnotateRowsDTO extends EventDTO
{
    private ConstEventsNames $type = ConstEventsNames::MARIA_ANNOTATE_ROWS_EVENT;

    public function __construct(EventInfo $eventInfo, public readonly string $query)
    {
        parent::__construct($eventInfo);
    }

    public function __toString(): string
    {
        return PHP_EOL .
            '=== Event ' .
            $this->getType() .
            ' === ' .
            PHP_EOL .
            'Date: ' .
            $this->eventInfo->getDateTime() .
            PHP_EOL .
            'Log position: ' .
            $this->eventInfo->pos .
            PHP_EOL .
            'Event size: ' .
            $this->eventInfo->size .
            PHP_EOL .
            'Query: ' .
            $this->query .
            PHP_EOL;
    }

    public function getType(): string
    {
        return $this->type->value;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
