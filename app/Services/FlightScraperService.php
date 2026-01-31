<?php

namespace App\Services;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Symfony\Component\Panther\Client;

class FlightScraperService
{
    private const TIKET_BASE_URL = 'https://www.tiket.com/pesawat/search';
    private const DEPARTURE_CITY = 'JKTC';
    private const ARRIVAL_CITY = 'DPS';
    private const CABIN_CLASS = 'economy';
    private const MAX_DEPARTURE_HOUR = 17;

    /**
     * Fetch flights from tiket.com using Symfony Panther
     *
     * @return array{success: bool, data: array, message: string, note?: string}
     */
    public function fetchFlights(): array
    {
        $client = null;

        // Extend execution time for scraping
        set_time_limit(120);

        try {
            $departureDate = now()->addDay()->format('Y-m-d');
            $url = $this->buildSearchUrl($departureDate);

            $chromedriverPath = base_path('drivers/chromedriver');

            $client = Client::createChromeClient($chromedriverPath, [
                '--headless=new',
                '--disable-gpu',
                '--no-sandbox',
                '--disable-dev-shm-usage',
                '--disable-blink-features=AutomationControlled',
                '--window-size=1920,1080',
                '--user-agent=Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            ]);

            $client->request('GET', $url);

            $this->waitForFlightResults($client);

            $flights = $this->parseFlightResults($client);

            $filteredFlights = $this->filterFlightsByDepartureTime($flights);

            $client->quit();

            if (empty($filteredFlights)) {
                return [
                    'success' => true,
                    'data' => [],
                    'message' => 'No flights found departing before 5:00 PM',
                    'note' => 'Try adjusting your search criteria or check back later.',
                ];
            }

            return [
                'success' => true,
                'data' => $filteredFlights,
                'message' => 'Successfully fetched ' . count($filteredFlights) . ' flights',
            ];
        } catch (\Exception $e) {
            if ($client) {
                $client->quit();
            }

            return [
                'success' => false,
                'data' => [],
                'message' => 'Failed to fetch flights: ' . $e->getMessage(),
                'note' => 'The scraping service encountered an error. This may be due to website changes or anti-bot protection.',
            ];
        }
    }

    /**
     * Build the tiket.com search URL
     */
    private function buildSearchUrl(string $departureDate): string
    {
        $params = [
            'd' => self::DEPARTURE_CITY,
            'a' => self::ARRIVAL_CITY,
            'date' => $departureDate,
            'adult' => 1,
            'child' => 0,
            'infant' => 0,
            'class' => self::CABIN_CLASS,
        ];

        return self::TIKET_BASE_URL . '?' . http_build_query($params);
    }

    /**
     * Wait for flight results to load
     */
    private function waitForFlightResults(Client $client): void
    {
        $webDriver = $client->getWebDriver();

        // Wait for page to stabilize
        sleep(5);

        // Try multiple selectors that tiket.com might use
        $selectors = [
            '[data-testid="desktop-product-list"]',
            '[data-testid="flight-card"]',
            '.flight-card',
            '.flight-item',
            '[class*="FlightCard"]',
            '[class*="ProductList"]',
            '[class*="search-result"]',
        ];

        $found = false;
        foreach ($selectors as $selector) {
            try {
                $webDriver->wait(10, 500)->until(
                    WebDriverExpectedCondition::presenceOfElementLocated(
                        WebDriverBy::cssSelector($selector)
                    )
                );
                $found = true;
                break;
            } catch (\Exception $e) {
                continue;
            }
        }

        // Give additional time for JavaScript to render
        sleep(3);
    }

    /**
     * Parse flight results from the page
     *
     * @return array<int, array{airline: string, flight_number: string, departure_time: string, price: string, departure_airport: string, arrival_airport: string}>
     */
    private function parseFlightResults(Client $client): array
    {
        $flights = [];
        $crawler = $client->getCrawler();

        $flightCards = $crawler->filter('[data-testid="flight-card"], .flight-card, .search-result-card, [class*="FlightCard"], [class*="flight-result"]');

        if ($flightCards->count() === 0) {
            $flightCards = $crawler->filter('div[class*="SearchResult"] > div, div[class*="flight"] > div');
        }

        $flightCards->each(function ($card) use (&$flights) {
            try {
                $flight = $this->extractFlightData($card);
                if ($flight) {
                    $flights[] = $flight;
                }
            } catch (\Exception $e) {
                // Skip malformed flight cards
            }
        });

        return $flights;
    }

    /**
     * Extract flight data from a card element
     *
     * @return array{airline: string, flight_number: string, departure_time: string, price: string, departure_airport: string, arrival_airport: string}|null
     */
    private function extractFlightData($card): ?array
    {
        $airlineSelectors = [
            '[data-testid="airline-name"]',
            '.airline-name',
            '[class*="airline"]',
            '[class*="Airline"]',
            '.carrier-name',
        ];

        $flightNumberSelectors = [
            '[data-testid="flight-number"]',
            '.flight-number',
            '[class*="flightNumber"]',
            '[class*="FlightNumber"]',
        ];

        $departureTimeSelectors = [
            '[data-testid="departure-time"]',
            '.departure-time',
            '[class*="departureTime"]',
            '[class*="DepartureTime"]',
            'time[class*="departure"]',
        ];

        $priceSelectors = [
            '[data-testid="price"]',
            '.price',
            '[class*="price"]',
            '[class*="Price"]',
            '.fare-price',
        ];

        $airline = $this->findElementText($card, $airlineSelectors);
        $flightNumber = $this->findElementText($card, $flightNumberSelectors);
        $departureTime = $this->findElementText($card, $departureTimeSelectors);
        $price = $this->findElementText($card, $priceSelectors);

        if (! $airline && ! $flightNumber && ! $departureTime) {
            return null;
        }

        return [
            'airline' => $airline ?: 'Unknown Airline',
            'flight_number' => $flightNumber ?: 'N/A',
            'departure_time' => $departureTime ?: 'N/A',
            'price' => $price ?: 'N/A',
            'departure_airport' => 'CGK',
            'arrival_airport' => 'DPS',
        ];
    }

    /**
     * Find element text using multiple selectors
     */
    private function findElementText($card, array $selectors): ?string
    {
        foreach ($selectors as $selector) {
            try {
                $element = $card->filter($selector);
                if ($element->count() > 0) {
                    $text = trim($element->first()->text());
                    if ($text) {
                        return $text;
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return null;
    }

    /**
     * Filter flights by departure time (before 5:00 PM / 17:00)
     *
     * @param  array<int, array>  $flights
     * @return array<int, array>
     */
    private function filterFlightsByDepartureTime(array $flights): array
    {
        return array_values(array_filter($flights, function ($flight) {
            $departureTime = $flight['departure_time'] ?? '';

            if (preg_match('/(\d{1,2}):(\d{2})/', $departureTime, $matches)) {
                $hour = (int) $matches[1];

                return $hour < self::MAX_DEPARTURE_HOUR;
            }

            return true;
        }));
    }
}
