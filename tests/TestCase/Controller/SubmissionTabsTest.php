<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * The Configuration and Reproducibility tabs of a submission.
 */
class SubmissionTabsTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.Releases',
        'app.Types',
        'app.Listings',
        'app.Submissions',
        'app.ListingsSubmissions',
        'app.ReproducibilityScores',
        'app.Questionnaires',
    ];

    public function testConfigurationOfPublishedSubmission(): void
    {
        $this->get('/submissions/configuration/6');
        $this->assertResponseOk();
        $this->assertResponseContains('Shaheen-like');
    }

    public function testReproducibilityOfPublishedSubmission(): void
    {
        $this->get('/questionnaires/view/6');
        $this->assertResponseOk();
        $this->assertResponseContains('General academic research.');
    }

    /**
     * Like the summary, the other tabs do not show submissions that are only on lists
     * of an unreleased release.
     */
    public function testTabsRedirectUnreleasedSubmission(): void
    {
        $this->get('/submissions/configuration/10');
        $this->assertRedirect('/');
        $this->get('/questionnaires/view/10');
        $this->assertRedirect('/');
    }
}
