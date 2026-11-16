<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class ReviewTopic extends JsonSerializableType
{
    /**
     * @var string $topic
     */
    #[JsonProperty('topic')]
    public string $topic;

    /**
     * @var int $count
     */
    #[JsonProperty('count')]
    public int $count;

    /**
     * @param array{
     *   topic: string,
     *   count: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->topic = $values['topic'];
        $this->count = $values['count'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
