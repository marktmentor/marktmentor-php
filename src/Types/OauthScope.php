<?php

namespace MarktMentor\Types;

enum OauthScope: string
{
    case StoreRead = "store:read";
    case ResearchRead = "research:read";
}
