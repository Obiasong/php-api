<?php declare(strict_types=1);
define('__ROOT__', dirname(dirname(__FILE__)) . "/src");

require_once(__ROOT__ . '/Database.php');
require_once(__ROOT__ . '/EventsGateway.php');
require_once(__ROOT__ . '/controllers/EventsController.php');
require_once(__ROOT__ . '/Logger.php');
require_once(__ROOT__ . '/Event.php');

use PHPUnit\Framework\TestCase;

class EventsControllerTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass(); // TODO: Change the autogenerated stub
    }

    /**
     * @Assert Events gateway is injected in controller
     * @covers EventsController
     */
    public function testEventsControllerConstructor(): void
    {
        $db = new Database();
        $gateway = new EventsGateway($db);

        $eventsController = new EventsController($gateway);

        self::assertSame($gateway, $eventsController->gateway);
    }

    /**
     * Provide arguments for {term} and {date} parameters to the endpoint
     * @covers EventsController::validateInputData
     * @covers EventsController::validateDate
     * @covers EventsController::findEvents
     * @Assert Response Code is 200
     * @Assert JSON string
     * @Assert data is a List
     * @Assert response data is correct using expected event from test database
     * Assert list length = 1. //Test DB contains one matching event for term=c&date=2024-04-17.
     */
    public function testEndpointReturnsJsonForTermAndDate(): void
    {
        $events = [
            [
                "id" => 4,
                "name" => "Ex elit consequat laborum non ad ad commodo est ad fugiat eiusmod occaecat nulla magna",
                "city" => "Rose",
                "country" => "Cambodia",
                "startDate" => "2024-04-17",
                "endDate" => "2024-05-30"
            ]
        ];
        $data = file_get_contents("http://localhost/api/v1?term=c&date=2024-04-17", false,
            stream_context_create(['http' => ['ignore_errors' => true]]));
        $this->assertJson($data, "Response is a Json string");
        $res = json_decode($data, true);
        $this->assertIsList($res, "List of events with '2024-04-17' between startDate and endDate, having city or country like 'c' ");
        $this->assertCount(1, $res);
        $this->assertSame($res, $events);
        $response_code = substr($http_response_header[7], 9, 3);
        $this->assertEquals(200, $response_code, "OK");
    }

    /**
     * Provide argument for {term} parameter to the endpoint
     * Assert Response Code is 200
     * Assert JSON string
     * Assert data is a List
     */
    public function testEndpointReturnsJsonListForSearchTerm(): void
    {
        $data = file_get_contents("http://localhost/api/v1?term=c", false,
            stream_context_create(['http' => ['ignore_errors' => true]]));
        $this->assertJson($data, "Response is a Json string");
        $res = json_decode($data, true);
        $this->assertIsList($res, "List of events having city or country like 'c' ");
        $response_code = substr($http_response_header[7], 9, 3);
        $this->assertEquals(200, $response_code, "OK");
    }

    /**
     * Provide argument for {date} parameter to the endpoint
     * Assert Response Code is 200
     * Assert JSON string
     * Assert data is a List
     */
    public function testEndpointReturnsJsonListForSearchDate(): void
    {
        $data = file_get_contents("http://localhost/api/v1?date=2024-04-17", false,
            stream_context_create(['http' => ['ignore_errors' => true]]));
        $this->assertJson($data, "Response is a Json string");
        $res = json_decode($data, true);
        $this->assertIsList($res, "List of events with '2024-04-17' between startDate and endDate ");
        $response_code = substr($http_response_header[7], 9, 3);
        $this->assertEquals(200, $response_code, "OK");
    }

    /**
     * Provide invalid for {date} parameter to the endpoint
     * @covers EventsController::validateDate
     * @Assert Response Code is 422
     * @Assert JSON string
     * @Assert Error contains "Please enter a valid date in the accepted format yyyy-mm-dd"
     */
    public function testEndpointAcceptsOnlyValidDate(): void
    {
        $data = file_get_contents("http://localhost/api/v1?term=c&date=2024-04-47", false,
            stream_context_create(['http' => ['ignore_errors' => true]]));
        $this->assertJson($data, "Response is a Json string");
        $res = json_decode($data, true);
        $this->assertStringContainsString("Please enter a valid date in the accepted format yyyy-mm-dd",
            $res['errors'][0]);
        $response_code = substr($http_response_header[7], 9, 3);
        $this->assertEquals(422, $response_code);
    }

    /**
     * Provide a {date} in the past to the endpoint
     * @Assert Response Code is 422
     * @Assert JSON string
     * @Assert Error contains "You can not search events using a past date"
     */
    public function testEndpointRejectsPastDate(): void
    {
        $data = file_get_contents("http://localhost/api/v1?term=c&date=2023-06-04", false,
            stream_context_create(['http' => ['ignore_errors' => true]]));
        $this->assertJson($data, "Response is a Json string");
        $res = json_decode($data, true);
        $this->assertStringContainsString("You can not search events using a past date",
            $res['errors'][0]);
        $response_code = substr($http_response_header[7], 9, 3);
        $this->assertEquals(422, $response_code);
    }

    /**
     * Access end point with no search parameter
     * @covers EventsController::validateInputData
     * @Assert Response Code is 422
     * @Assert JSON string
     * @Assert Error contains "You are required to provide at least a term, date or both"
     */
    public function testEndpointNeedsAParameter(): void
    {
        $data = file_get_contents("http://localhost/api/v1", false,
            stream_context_create(['http' => ['ignore_errors' => true]]));
        $this->assertJson($data, "Response is a Json string");
        $res = json_decode($data, true);
        $this->assertStringContainsString("You are required to provide at least a term, date or both",
            $res['errors'][0]);
        $response_code = substr($http_response_header[7], 9, 3);
        $this->assertEquals(422, $response_code);
    }
}