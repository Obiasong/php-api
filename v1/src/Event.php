<?php
declare(strict_types=1);

/**
 * @OA\Schema()
 */
class Event
{
    /**
     * The product id
     * @var integer
     *
     * @OA\Property(
     *   property="id",
     *   type="integer",
     *   description="The event id"
     * )
     */
    public int $id;
    /**
     * The product name
     * @var string
     *
     * @OA\Property(
     *   property="string",
     *   type="name of event",
     *   description="The event name"
     * )
     */
    public string $name;
    /**
     * The event host city
     * @var string
     *
     * @OA\Property(
     *   property="city",
     *   type="string",
     *   description="The event host city"
     * )
     */
    public string $city;
    /**
     * The event host country
     * @var string
     *
     * @OA\Property(
     *   property="country",
     *   type="string",
     *   description="The event country"
     * )
     */
    public string $country;
    /**
     * The event start date
     * @var string
     *
     * @OA\Property(
     *   property="startDate",
     *   type="string",
     *   description="The event start date"
     * )
     */
    public string $startDate;
    /**
     * The event end date
     * @var string
     *
     * @OA\Property(
     *   property="endDate",
     *   type="string",
     *   description="The event end date"
     * )
     */
    public string $endDate;
}