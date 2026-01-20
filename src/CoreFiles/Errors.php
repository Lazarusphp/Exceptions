<?php

namespace LazarusPhp\Exceptions\CoreFiles;

enum Errors: int
{
    // Validation Error Code 1xxx
    case INVALID_INPUT = 1001;
    case INVALID_FIELD = 1002;
    case INPUT_MISMATCH = 1003;
        // Authentication Error Code 2xxx
    case AUTHENTICATION_FAILED = 2001;
        // Database Error Code 3xxx
    case INVALID_QUERY = 3001;
    case QUERY_FAILED = 3002;
    case CONNECTION_FAILED = 3003;
    case INVALID_TABLE = 3004;
        // local services Error Code 4xxx
    case DIRECTORY_NOT_FOUND = 4001;
    case FILE_NOT_FOUND = 4002;

    public function label(): string
    {
        return strtoupper($this->name);
    }
}
