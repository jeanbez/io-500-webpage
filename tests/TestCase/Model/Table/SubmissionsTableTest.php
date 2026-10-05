<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubmissionsTable;
use Cake\TestSuite\TestCase;

class SubmissionsTableTest extends TestCase
{
    protected array $fixtures = [
        'app.Releases',
        'app.Types',
        'app.Listings',
        'app.Submissions',
        'app.ListingsSubmissions',
    ];

    protected SubmissionsTable $Submissions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->Submissions = $this->getTableLocator()->get('Submissions');
    }

    /**
     * A FLOAT list score (797.038025 is stored as 797.0380249023438) must not count
     * itself as "higher" when PHP rounds it to 14 digits: five entries are above it.
     */
    public function testRankingHeaderDoesNotCountItselfForFloatScores(): void
    {
        $header = $this->Submissions->rankingHeader($this->Submissions->get(6));

        $this->assertSame('ISC24 Production', $header['listName']);
        $this->assertSame(6, $header['rank']);
        $this->assertSame(9, $header['listTotal']);
    }

    /**
     * Equal scores are ranked by list entry id, the same order the list page uses.
     */
    public function testRankingHeaderBreaksTiesByEntryId(): void
    {
        $this->assertSame(8, $this->Submissions->rankingHeader($this->Submissions->get(8))['rank']);
        $this->assertSame(9, $this->Submissions->rankingHeader($this->Submissions->get(9))['rank']);
    }

    /**
     * Lists of a release that is not out yet are ignored.
     */
    public function testRankingHeaderIgnoresUnreleasedLists(): void
    {
        $this->assertNull($this->Submissions->rankingHeader($this->Submissions->get(10)));
    }
}
