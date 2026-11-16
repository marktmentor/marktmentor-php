<?php

namespace MarktMentor\Products\Types;

enum CategoryRankingsProductsRequestPeriod: string
{
    case ThreeM = "3M";
    case SixM = "6M";
    case OneY = "1Y";
    case TwoY = "2Y";
}
