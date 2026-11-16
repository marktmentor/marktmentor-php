<?php

namespace MarktMentor\Types;

enum StoreInventoryRowStockState: string
{
    case OutOfStock = "out_of_stock";
    case Low = "low";
    case Ok = "ok";
    case Unknown = "unknown";
}
