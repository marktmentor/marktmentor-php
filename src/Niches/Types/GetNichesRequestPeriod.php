<?php

namespace MarktMentor\Niches\Types;

enum GetNichesRequestPeriod: string
{
    case ThirtyD = "30d";
    case NinetyD = "90d";
    case ThreeHundredSixtyFiveD = "365d";
}
