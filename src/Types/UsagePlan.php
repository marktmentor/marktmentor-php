<?php

namespace MarktMentor\Types;

enum UsagePlan: string
{
    case Bundle = "bundle";
    case Unmetered = "unmetered";
    case Free = "free";
    case None = "none";
}
