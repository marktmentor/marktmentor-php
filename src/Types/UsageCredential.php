<?php

namespace MarktMentor\Types;

enum UsageCredential: string
{
    case Oauth = "oauth";
    case Key = "key";
}
