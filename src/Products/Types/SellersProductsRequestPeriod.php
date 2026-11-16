<?php

namespace MarktMentor\Products\Types;

enum SellersProductsRequestPeriod: string
{
    case NinetyD = "90d";
    case OneHundredEightyD = "180d";
    case ThreeHundredSixtyFiveD = "365d";
    case SevenHundredThirtyD = "730d";
}
