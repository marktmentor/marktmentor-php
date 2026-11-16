<?php

namespace MarktMentor\Products\Types;

enum ReviewsProductsRequestSort: string
{
    case DateAsc = "date";
    case DateDesc = "-date";
    case ScoreAsc = "score";
    case ScoreDesc = "-score";
}
