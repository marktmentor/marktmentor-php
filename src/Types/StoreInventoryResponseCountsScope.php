<?php

namespace MarktMentor\Types;

enum StoreInventoryResponseCountsScope: string
{
    case ResolvedPage = "resolved_page";
    case ResolvedCatalogue = "resolved_catalogue";
}
