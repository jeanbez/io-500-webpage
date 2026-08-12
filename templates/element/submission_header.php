<?php
/**
 * Shared submission header: reproducibility medal, system name, rank pill,
 * institution/vendor/filesystem strip and the Summary/Configuration/Reproducibility tabs.
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Submission $submission
 * @var \App\Model\Entity\Questionnaire|null $questionnaire
 * @var string $active One of 'summary', 'configuration', 'reproducibility'.
 * @var int|null $rank Rank within the submission's best list (optional).
 * @var string|null $listName Name of that list (optional).
 */
$num = fn($v) => $this->Number->format($v);
$repro = ($questionnaire && $questionnaire->reproducibility_score)
    ? $questionnaire->reproducibility_score->name : null;
$hasRank = isset($rank, $listName);
?>
<header class="sv-head">
    <div class="sv-head-l">
        <?php if ($questionnaire && $questionnaire->reproducibility_score_id) : ?>
            <span class="badge badge-<?php echo $questionnaire->reproducibility_score_id ?>"<?php echo $repro ? ' title="' . h($repro) . '"' : '' ?>></span>
        <?php endif; ?>
        <h1><?php echo h($submission->information_system) ?></h1>
        <?php if ($hasRank) : ?>
            <div class="sv-badges">
                <span class="sv-badge sv-rank">#<?php echo $num($rank) ?> · <?php echo h($listName) ?></span>
            </div>
        <?php endif; ?>
    </div>
    <div class="sv-actions">
        <?php
        if ($submission->repository_url) {
            echo $this->Html->link(__('Files'), $submission->repository_url, ['class' => 'button-navigation', 'target' => '_blank']);
        }
        if ($submission->cdcl_url) {
            echo $this->Html->link(__('Data Center'), $submission->cdcl_url, ['class' => 'button-navigation', 'target' => '_blank']);
        }
        ?>
    </div>
</header>

<div class="sv-strip">
    <b><?php echo h($submission->information_institution) ?></b><span class="sep">|</span>
    <?php echo h($submission->information_storage_vendor) ?><span class="sep">|</span>
    <?php echo h(trim($submission->information_filesystem_type . ' ' . $submission->information_filesystem_version)) ?>
</div>

<nav class="sv-tabs">
    <a class="sv-tab<?php echo $active === 'summary' ? ' active' : '' ?>" href="<?php echo $this->Url->build(['controller' => 'submissions', 'action' => 'view', $submission->id]) ?>"><?php echo __('Summary') ?></a>
    <a class="sv-tab<?php echo $active === 'configuration' ? ' active' : '' ?>" href="<?php echo $this->Url->build(['controller' => 'submissions', 'action' => 'configuration', $submission->id]) ?>"><?php echo __('Configuration') ?></a>
    <?php if ($questionnaire) : ?>
        <a class="sv-tab<?php echo $active === 'reproducibility' ? ' active' : '' ?>" href="<?php echo $this->Url->build(['controller' => 'questionnaires', 'action' => 'view', $submission->id]) ?>"><?php echo __('Reproducibility') ?></a>
    <?php endif; ?>
</nav>
