<?php

namespace MarktMentor\Store\Types;

enum InventoryStoreRequestStockState: string
{
    case OutOfStock = "out_of_stock";
    case Low = "low";
    case Ok = "ok";
}
