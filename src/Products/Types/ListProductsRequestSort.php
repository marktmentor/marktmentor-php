<?php

namespace MarktMentor\Products\Types;

enum ListProductsRequestSort: string
{
    case SalesAsc = "sales";
    case SalesDesc = "-sales";
    case RevenueAsc = "revenue";
    case RevenueDesc = "-revenue";
    case PriceAsc = "price";
    case PriceDesc = "-price";
}
