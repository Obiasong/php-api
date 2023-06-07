<?php


class Logger
{
    public function logRequest(): void
    {
        $message = "Request at " . date('Y-m-d H:i:s', time()) . "\n";
        $message .= "------------------------------------------------------------------------\n";
        $message .= "\n";
        $message .= json_encode($_REQUEST, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT) . "\n";
        $message .= "\n";
        $message .= json_encode($_SERVER, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT) . "\n";
        $message .= "\n";

        $filename = "loggedRequests.txt";

        file_put_contents($filename, $message, FILE_APPEND);
    }

    public function logData($data): void
    {
        $message = "Data at " . date('Y-m-d H:i:s', time()) . "\n";
        $message .= "------------------------------------------------------------------------\n";
        $message .= "\n";
        $message .= $data . "\n";
        $message .= "\n";
        $filename = "datalogs.txt";

        file_put_contents($filename, $message, FILE_APPEND);
    }
}