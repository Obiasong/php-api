<?php


class ErrorHandler
{
    public static function handleException(Throwable $exc): void
    {
        http_response_code(500);
        echo json_encode([
            "code" => $exc->getCode(),
            "message" => $exc->getMessage(),
            "file" => $exc->getFile(),
            "line" => $exc->getLine()
        ]);
    }

    public static function handleError(int $errNum, string $errStr, string $errFile, int $errLine): bool
    {
//        http_response_code(500);
        throw new ErrorException($errStr, 0, $errNum, $errFile, $errLine);
    }
}