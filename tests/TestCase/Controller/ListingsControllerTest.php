<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class ListingsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Releases',
        'app.Types',
        'app.Listings',
        'app.Submissions',
        'app.ListingsSubmissions',
    ];

    /**
     * Tied scores are listed by entry id, matching the rank on the submission page.
     */
    public function testListBreaksTiesByEntryId(): void
    {
        $this->get('/list/isc24/production');
        $this->assertResponseOk();

        $body = (string)$this->_response->getBody();
        $this->assertLessThan(strpos($body, 'Iota'), strpos($body, 'Theta'));
    }

    /**
     * Lists of a release that is not out yet are not served.
     */
    public function testHomeServesLatestPublishedRelease(): void
    {
        $this->get('/');
        $this->assertResponseOk();
        $this->assertResponseContains('ISC24');
        $this->assertResponseNotContains('Future');
        // The home URL names no list type; the Production tab is still marked active.
        $this->assertMatchesRegularExpression('#list/isc24/production" class="tab tab-active"#', (string)$this->_response->getBody());
    }
}
