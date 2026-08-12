<div class="subview">

    <?php echo $this->element('submission_header', ['active' => 'configuration']); ?>

    <div class="sv-panel">
        <div id="dcl_wrap"></div>
    </div>
</div>

<?php
echo $this->Html->css([
    'https://www.submission.io500.org/css/dcl.min.css'
]);

echo $this->Html->script(
    [
        'https://www.submission.io500.org/js/js-yaml.min.js',
        'https://www.submission.io500.org/js/c3.min.js',
        'https://www.submission.io500.org/js/d3.min.js',
        'https://www.submission.io500.org/js/jquery.min.js',
        'https://www.submission.io500.org/js/math.min.js',
        'https://unpkg.com/@popperjs/core@2',
        'https://unpkg.com/tippy.js@6',
        'https://www.submission.io500.org/js/dcl.js',
        'https://www.submission.io500.org/js/dcl-load.js',
        'https://www.submission.io500.org/js/dcl-move.js',
        'https://www.submission.io500.org/js/dcl-vis.js'
    ],
    [
        'block' => 'script'
    ]
);

$url_site = 'https://www.submission.io500.org/files/submissions/' . $submission->id . '.json?timestamp=' . time();
$url_schema = 'https://www.submission.io500.org/model/schema-io500.json?timestamp=' . time();

$this->Html->scriptBlock(
    "
    $(document).ready(function() {
        dcl_draw_graph = false;
        dcl_draw_table = false;
        dcl_draw_toolbar = false;
        dcl_draw_aggregation = false;
        dcl_global_readonly = true;

        dcl_schema = '" . $url_schema . "';
        dcl_site =  '" . $url_site . "';

        dcl_startup();
    });
    ",
    [
        'block' => 'script'
    ]
);
?>
