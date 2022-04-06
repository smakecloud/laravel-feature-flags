<?php

namespace RyanChandler\LaravelFeatureFlags\Enums;

enum MiddlewareBehaviour
{
    case Abort;
    case Redirect;
}
