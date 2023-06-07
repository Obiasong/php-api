<?php declare(strict_types=1);

use JetBrains\PhpStorm\ArrayShape;

/**
 * @OA\Info(
 *     title="Events Test API",
 *     version="1.0"
 * )
 */
class EventsController
{
    public function __construct(public EventsGateway $gateway)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1",
     *     tags={"Events"},
     *     description="Endpoint to search for events in a specific city or country. At least one of the parameters (term or date or both) must be provided for the search",
     * @OA\Parameter(in="query", name="term", required=false,
     *     description="What we want to search for",
     *   @OA\Schema(
     *     type="string"
     *   )
     * ),
     * @OA\Parameter(
     *     in="query", name="date",
     *     required=false,
     *     description="Get any events that the date(yyyy-mm-dd) searched for is in the range between startDate and endDate",
     *   @OA\Schema(
     *     type="string"
     *   )
     * ),
     * @OA\Response(response="200", description="OK - List of Events",
     * @OA\JsonContent(ref="#/components/schemas/Event"),
     * ),
     * @OA\Response(response="422", description="Unprocessable Entity")
     * )
     */

    public function findEvents(): bool|string|null
    {
        $validatedInput = $this->validateInputData();
        if (!empty($validatedInput['errors'])) {
            http_response_code(422);
            return json_encode(["errors" => $validatedInput['errors']]);
        }

        $date = $validatedInput['date'];
        $term = $validatedInput['term'];

        $data = [];
        if ($term && $date) {
            $data = $this->gateway->getTermAndDateEvents($term, $date);
        } elseif ($term && !$date) {
            $data = $this->gateway->getTermEvents($term);
        } elseif (!$term && $date) {
            $data = $this->gateway->getDateEvents($date);
        }

        return json_encode($data);
    }

    /**
     * @return array
     */
    #[ArrayShape(['date' => "null|string", 'term' => "null|string", 'errors' => "array"])]
    private function validateInputData(): array
    {
        $termInput = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $dateInput = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $date = $dateInput ? trim($dateInput) : null;
        $term = $termInput ? trim($termInput) : null;

        $errors = [];
        if (!$term && !$date) {
            $errors[] = "You are required to provide at least a term, date or both";
        }

        if ($date && !$this->validateDate($date)) {
            $errors[] = "Please enter a valid date in the accepted format yyyy-mm-dd";
        }

        if ($date && empty($errors)) {
            $searchDate = DateTime::createFromFormat('Y-m-d', $date);
            $currentDate = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
            if ($searchDate < $currentDate) $errors[] = "You can not search events using a past date";
        }

        return array('date' => $date, 'term' => $term, 'errors' => $errors);
    }

    /**
     * @param $date
     * @param string $format
     * @return bool
     * Compare date depending on the format you want
     */
    private function validateDate($date, $format = 'Y-m-d'): bool
    {
        $d = DateTime::createFromFormat($format, $date);
        //Verify that the date $d is same as $date; Larger days are pushed to the
        //next month by php datetime e.g 2023-04-35 is wrong but will be 2023-05-05
        return $d && $d->format($format) === $date;
    }
}