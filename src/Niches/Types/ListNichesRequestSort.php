<?php

namespace MarktMentor\Niches\Types;

enum ListNichesRequestSort: string
{
    case RevenueAsc = "revenue";
    case RevenueDesc = "-revenue";
    case VolumeAsc = "volume";
    case VolumeDesc = "-volume";
    case ProductsAsc = "products";
    case ProductsDesc = "-products";
}
