<?php

namespace MarktMentor\Niches\Types;

enum ReviewHistoryNichesRequestPeriod: string
{
    case ThreeM = "3M";
    case SixM = "6M";
    case OneY = "1Y";
    case TwoY = "2Y";
}
