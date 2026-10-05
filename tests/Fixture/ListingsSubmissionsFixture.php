<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * List memberships. Listing 4 (ISC24 Production) holds seven entries: submission 6
 * is 6th, with its score stored as FLOAT (797.038025 becomes 797.0380249023438),
 * and submissions 8 and 9 tie on 500.
 */
class ListingsSubmissionsFixture extends TestFixture
{
    /**
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            // SC23 Production: 1, 2, 3, 6
            ['id' => 1, 'listing_id' => 1, 'submission_id' => 1, 'score' => 9000],
            ['id' => 2, 'listing_id' => 1, 'submission_id' => 2, 'score' => 5000],
            ['id' => 3, 'listing_id' => 1, 'submission_id' => 3, 'score' => 3000],
            ['id' => 4, 'listing_id' => 1, 'submission_id' => 6, 'score' => 797.038025],
            // ISC24 Production: carried-over 1, 2, 3, 6 plus new 4, 5, 7, 8, 9
            ['id' => 11, 'listing_id' => 4, 'submission_id' => 1, 'score' => 9000],
            ['id' => 12, 'listing_id' => 4, 'submission_id' => 2, 'score' => 5000],
            ['id' => 13, 'listing_id' => 4, 'submission_id' => 3, 'score' => 3000],
            ['id' => 14, 'listing_id' => 4, 'submission_id' => 4, 'score' => 1000],
            ['id' => 15, 'listing_id' => 4, 'submission_id' => 5, 'score' => 900],
            ['id' => 16, 'listing_id' => 4, 'submission_id' => 6, 'score' => 797.038025],
            ['id' => 17, 'listing_id' => 4, 'submission_id' => 7, 'score' => 600],
            ['id' => 19, 'listing_id' => 4, 'submission_id' => 9, 'score' => 500],
            ['id' => 18, 'listing_id' => 4, 'submission_id' => 8, 'score' => 500],
            // Full lists (unranked)
            ['id' => 21, 'listing_id' => 3, 'submission_id' => 6, 'score' => 797.038025],
            ['id' => 22, 'listing_id' => 6, 'submission_id' => 6, 'score' => 797.038025],
            // Future SC99 Production
            ['id' => 31, 'listing_id' => 7, 'submission_id' => 10, 'score' => 99999],
            ['id' => 32, 'listing_id' => 7, 'submission_id' => 6, 'score' => 797.038025],
        ];
        parent::init();
    }
}
