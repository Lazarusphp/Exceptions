<?php
namespace LazarusPhp\Exceptions;

final class ErrorCodes
{

    // Errro Code Ideas

    // Validation Error Code 1xxx
    public const  INVALID_INPUT = 1001;
    public const  INVALID_FIELD = 1002;
    public const  INPUT_MISMATCH = 1003;
    // Authentication Error Code 2xxx
    public const AUTHENTICATION_FAILED = 2001;
    // Database Error Code 3xxx
    public const INVALID_QUERY = 3001;
    public const QUERY_FAILED = 3002;
    public const CONNECTION_FAILED = 3003;
    public const INVALID_TABLE = 3004;
    // local services Error Code 4xxx
    public const DIRECTORY_NOT_FOUND = 4001;
    public const FILE_NOT_FOUND = 4002;

}