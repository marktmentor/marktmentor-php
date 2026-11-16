<?php

namespace MarktMentor\Niches\Types;

enum ProductsNichesRequestSort: string
{
    case SalesAsc = "sales";
    case SalesDesc = "-sales";
    case RevenueAsc = "revenue";
    case RevenueDesc = "-revenue";
    case PriceAsc = "price";
    case PriceDesc = "-price";
}
