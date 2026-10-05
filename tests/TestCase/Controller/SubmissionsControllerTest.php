<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class SubmissionsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Releases',
        'app.Types',
        'app.Listings',
        'app.Submissions',
        'app.ListingsSubmissions',
    ];

    public function testViewRendersPublishedSubmission(): void
    {
        $this->get('/submissions/view/6');
        $this->assertResponseOk();
        $this->assertResponseContains('Shaheen-like');
    }

    /**
     * A submission that is only on lists of an unreleased release is not shown.
     */
    public function testViewRedirectsUnreleasedSubmission(): void
    {
        $this->get('/submissions/view/10');
        $this->assertRedirect('/');
    }

    public function testCompareReturnsListEntriesAndHistory(): void
    {
        $this->get('/submissions/compare/6/4');
        $this->assertResponseOk();
        $this->assertContentType('application/json');
        $this->assertHeaderContains('Cache-Control', 'max-age');

        $data = json_decode((string)$this->_response->getBody(), true);
        $this->assertSame(4, $data['listing_id']);
        $this->assertCount(9, $data['entries']);
        $this->assertSame(['SC23', 'ISC24'], $data['history']['releases']);
        $this->assertStringNotContainsString('information_submitter', (string)$this->_response->getBody());
        $this->assertStringNotContainsString('user_id', (string)$this->_response->getBody());
    }

    /**
     * Only released, ranked lists the submission is on can be compared against.
     */
    public function testCompareRejectsOtherListings(): void
    {
        $this->get('/submissions/compare/6/7'); // unreleased SC99 Production
        $this->assertResponseCode(404);
        $this->get('/submissions/compare/6/3'); // unranked Full list
        $this->assertResponseCode(404);
        $this->get('/submissions/compare/6/2'); // SC23 Research: submission 6 is not on it
        $this->assertResponseCode(404);
        $this->get('/submissions/compare/999/4'); // unknown submission
        $this->assertResponseCode(404);
    }
}
