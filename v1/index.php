<?php
declare(strict_types=1);

spl_autoload_register(function ($class) {
    if (file_exists(__DIR__ . "/src/controllers/$class.php")) {
        require __DIR__ . "/src/controllers/$class.php";
    } else if (file_exists(__DIR__ . "/src/$class.php")) {
        require __DIR__ . "/src/$class.php";
    }
});
header("Content-type: application/json; charset=UTF-8");

//Load error handler for php error
set_error_handler("ErrorHandler::handleError");
//Load generic exception handler class. Hence no need for try-catch
set_exception_handler("ErrorHandler::handleException");
//Log the request including server superglobal
$logger = new Logger();
$logger->logRequest();


/**
 * Accept only GET Requests
 * In case of more routing options, it is better to implement a Routing class
 */
switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $database = new Database();
        $eventGateway = new EventsGateway($database);

        $eventsController = new EventsController($eventGateway);
        $events = $eventsController->findEvents();
        echo $events;
        break;
    default:
        http_response_code(405);
        header("Allow: GET");
        echo json_encode("Bad Request Method!");
        break;
}



