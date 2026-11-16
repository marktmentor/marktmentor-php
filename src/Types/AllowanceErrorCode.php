<?php

namespace MarktMentor\Types;

enum AllowanceErrorCode: string
{
    case BundleExhausted = "bundle_exhausted";
    case OverageLimitReached = "overage_limit_reached";
    case FreeQuotaExhausted = "free_quota_exhausted";
}
