<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GoogleSearchTest extends DuskTestCase
{
    public function test_google_search_company()
    {
        $this->browse(function (Browser $browser) {

            $keyword = "Laravel PHP";

            $browser->visit('https://www.google.com')
                ->pause(3000);

            // Handle cookie popup (more stable selector)
            try {
                $browser->pause(1000)
                    ->click('button')
                    ->pause(1000);
            } catch (\Exception $e) {
                // ignore if no popup
            }

            // Wait for search box (Google uses textarea most of the time)
            $browser->waitFor('textarea[name="q"]', 10);

            // Type search query
            $browser->type('textarea[name="q"]', $keyword)
                ->keys('textarea[name="q"]', '{enter}')
                ->pause(4000);

            // Extract results
            $results = [];

            $titles = $browser->elements('h3');

            foreach ($titles as $title) {
                $text = $title->getText();

                if (!empty($text)) {
                    $results[] = $text;
                }
            }

            // PRINT results in terminal
            print_r($results);

            // OPTIONAL: save results for controller usage
            file_put_contents(
                storage_path('app/google_results.json'),
                json_encode($results, JSON_PRETTY_PRINT)
            );

            $this->assertTrue(true);
        });
    }
}