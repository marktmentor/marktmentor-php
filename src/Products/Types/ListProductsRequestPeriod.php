<?php

namespace MarktMentor\Products\Types;

enum ListProductsRequestPeriod: string
{
    case ThirtyD = "30d";
    case NinetyD = "90d";
    case ThreeHundredSixtyFiveD = "365d";
}
