<?php

namespace MarktMentor\Store\Types;

enum ProductsStoreRequestSort: string
{
    case RevenueAsc = "revenue";
    case RevenueDesc = "-revenue";
    case SalesAsc = "sales";
    case SalesDesc = "-sales";
    case CostsAsc = "costs";
    case CostsDesc = "-costs";
    case ProfitsAsc = "profits";
    case ProfitsDesc = "-profits";
}
