<?php

namespace MarktMentor\Niches\Types;

enum ReviewsNichesRequestSort: string
{
    case DateAsc = "date";
    case DateDesc = "-date";
    case ScoreAsc = "score";
    case ScoreDesc = "-score";
}
