<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class ReviewItem extends JsonSerializableType
{
    /**
     * @var string $reviewId Stable, opaque identifier of the review. It does not contain the name of the reviewer.
     */
    #[JsonProperty('reviewId')]
    public string $reviewId;

    /**
     * @var ?string $productCode
     */
    #[JsonProperty('productCode')]
    public ?string $productCode;

    /**
     * @var ?int $rating Stars of the review, from 1 to 5.
     */
    #[JsonProperty('rating')]
    public ?int $rating;

    /**
     * @var ?string $title
     */
    #[JsonProperty('title')]
    public ?string $title;

    /**
     * @var ?string $text
     */
    #[JsonProperty('text')]
    public ?string $text;

    /**
     * @var ?string $date
     */
    #[JsonProperty('date')]
    public ?string $date;

    /**
     * @var ?bool $verifiedPurchase
     */
    #[JsonProperty('verifiedPurchase')]
    public ?bool $verifiedPurchase;

    /**
     * @var ?int $helpfulVotes
     */
    #[JsonProperty('helpfulVotes')]
    public ?int $helpfulVotes;

    /**
     * @param array{
     *   reviewId: string,
     *   productCode?: ?string,
     *   rating?: ?int,
     *   title?: ?string,
     *   text?: ?string,
     *   date?: ?string,
     *   verifiedPurchase?: ?bool,
     *   helpfulVotes?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->reviewId = $values['reviewId'];
        $this->productCode = $values['productCode'] ?? null;
        $this->rating = $values['rating'] ?? null;
        $this->title = $values['title'] ?? null;
        $this->text = $values['text'] ?? null;
        $this->date = $values['date'] ?? null;
        $this->verifiedPurchase = $values['verifiedPurchase'] ?? null;
        $this->helpfulVotes = $values['helpfulVotes'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
