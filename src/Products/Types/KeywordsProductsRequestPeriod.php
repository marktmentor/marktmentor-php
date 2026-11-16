<?php

namespace MarktMentor\Products\Types;

enum KeywordsProductsRequestPeriod: string
{
    case SevenD = "7d";
    case ThirtyD = "30d";
    case NinetyD = "90d";
}
