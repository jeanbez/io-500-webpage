<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class NewsPageTest extends TestCase
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
     * Every hand-written entry is on the page: 20 announcements, 24 press items,
     * 10 talks and 5 other links (59 dated entries) plus 14 publications.
     */
    public function testAllContentIsShown(): void
    {
        $this->get('/news');
        $this->assertResponseOk();
        $body = (string)$this->_response->getBody();

        $this->assertSame(59, substr_count($body, '<span class="date">'));
        $this->assertSame(14, substr_count($body, 'class="bib"'));
        $this->assertStringContainsString('Matt Rásó-Barnett talk at LAD', $body);
        $this->assertStringContainsString('Rice O&amp;G', $body);
    }

    /**
     * The ISC'22 lists were published on 2022-05-30, not 2021-05-30.
     */
    public function testIsc22Date(): void
    {
        $this->get('/news');
        $this->assertResponseNotContains('2021-05-30');
    }
}
