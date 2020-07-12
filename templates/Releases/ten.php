<nav id="breadcrumb">
    <p>YOU ARE HERE</p>

    <?php
    $this->Breadcrumbs->add(_('LISTS'), ['controller' => 'releases', 'action' => 'index']);
    $this->Breadcrumbs->add(_('10 NODE LIST'), ['controller' => 'releases', 'action' => 'index']);
    $this->Breadcrumbs->add(strtoupper($this->request->getParam('pass')[0]), ['controller' => 'releases', 'action' => 'ten', $this->request->getParam('pass')[0]]);

    echo $this->Breadcrumbs->render([], ['separator' => ' / ']);
    ?>
</nav>

<div class="releases index content">
    <h2>10 Node Challenge <?php echo strtoupper($this->request->getParam('pass')[0]); ?> List</h2>

    <div class="releases-action">
        <?php
        echo $this->Html->link(_('Customize'), [
            'controller' => 'releases',
            'action' => 'customize'
        ], [
            'class' => 'button'
        ]);
        ?>
    </div>

    <div class="table-responsive">
        <table class="tb">
            <thead>
                <tr>
                    <th rowspan="3" class="tb-id"><?php echo $this->Paginator->sort('rank', '#') ?></th>
                    <th colspan="6" class="tb-center">Information</th>
                    <th colspan="3" class="tb-center">IO500</th>
                </tr>
                <tr>
                    <th rowspan="2"><?php echo $this->Paginator->sort('information_institution', _('Institution')) ?></th>
                    <th rowspan="2"><?php echo $this->Paginator->sort('information_system', _('System')) ?></th>
                    <th rowspan="2"><?php echo $this->Paginator->sort('information_storage_vendor', _('Storage Vendor')) ?></th>
                    <th rowspan="2"><?php echo $this->Paginator->sort('information_filesystem_type', _('File System Type')) ?></th>
                    <th rowspan="2" class="tb-number"><?php echo $this->Paginator->sort('information_client_nodes', _('Client Nodes')) ?></th>
                    <th rowspan="2" class="tb-number"><?php echo $this->Paginator->sort('information_client_total_procs', _('Total Client Proc.')) ?></th>

                    <th rowspan="2" class="tb-number"><?php echo $this->Paginator->sort('io500_score', _('Score')) ?></th>
                    <th class="tb-center"><?php echo $this->Paginator->sort('io500_bw', _('BW')) ?></th>
                    <th class="tb-center"><?php echo $this->Paginator->sort('io500_md', _('MD')) ?></th>
                </tr>
                <tr>
                    <th class="tb-center">(GiB/s)</th>
                    <th class="tb-center">(kIOP/s)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($releases as $i => $release) { ?>
                <tr>
                    <td class="tb-id">
                        <?php
                        echo $this->Html->link((($this->Paginator->current('Releases') - 1) * $limit) + ($i + 1), [
                            'controller' => 'releases',
                            'action' => 'view',
                            $release->id
                        ], [
                            'class' => 'rank'
                        ]);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $this->Html->link($release->information_institution, [
                            'controller' => 'releases',
                            'action' => 'view',
                            $release->id
                        ]);
                        ?>
                    </td>
                    <td><?php echo h($release->information_system) ?></td>
                    <td><?php echo h($release->information_storage_vendor) ?></td>
                    <td><?php echo h($release->information_filesystem_type) ?></td>
                    <td class="tb-number"><?php echo $this->Number->format($release->information_client_nodes) ?></td>
                    <td class="tb-number"><?php echo $this->Number->format($release->information_client_total_procs) ?></td>

                    <td class="tb-number"><?php echo $this->Number->format($release->io500_score, ['places' => 2, 'precision' => 2]) ?></td>
                    <td class="tb-number"><?php echo $this->Number->format($release->io500_bw, ['places' => 2, 'precision' => 2]) ?></td>
                    <td class="tb-number"><?php echo $this->Number->format($release->io500_md, ['places' => 2, 'precision' => 2]) ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="paginator">
        <ul class="pagination">
            <?php
            if ($this->Paginator->total() > 1) {
                echo $this->Paginator->first('<<');
                echo $this->Paginator->prev('<');
                echo $this->Paginator->numbers();
                echo $this->Paginator->next('>');
                echo $this->Paginator->last('>>');
            }
            ?>
        </ul>
    </div>

    <div class="plot-box">
        <canvas id="radio-chart" width="960" height="350"></canvas>
    </div>

    <div id="disqus_thread"></div>
</div>

<script>
var disqus_config = function () {
    this.page.url = "<?php echo $this->Url->build($this->request->getRequestTarget(), ['fullBase' => true]); ?>";
    this.page.identifier = "<?php echo $this->Url->build($this->request->getRequestTarget()); ?>";
};

(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://io500.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>

<?php
$LIMIT = 5;

$max_io500_score = 0;
$max_io500_bw = 0;
$max_io500_md = 0;
$max_nodes = 0;
$max_procs = 0;

foreach ($releases as $i => $release) {
    if ($i >= $LIMIT) {
       break;
    }

    $max_io500_score = max($max_io500_score, $release->io500_score);
    $max_io500_bw = max($max_io500_bw, $release->io500_bw);
    $max_io500_md = max($max_io500_md, $release->io500_md);
    $max_nodes = max($max_nodes, $release->information_client_nodes);
    $max_procs = max($max_procs, $release->information_client_total_procs);
}

$plot_border[0] = 'rgb(86, 166, 186)';
$plot_background[0] = 'rgba(86, 166, 186, 0.2)';

$plot_border[1] = 'rgb(209, 199, 76)';
$plot_background[1] = 'rgba(209, 199, 76, 0.2)';

$plot_border[2] = 'rgb(2256, 159, 43)';
$plot_background[2] = 'rgba(2256, 159, 43, 0.2)';

$plot_border[3] = 'rgb(243, 93, 36)';
$plot_background[3] = 'rgba(243, 93, 36, 0.2)';

$plot_border[4] = 'rgb(243, 68, 35)';
$plot_background[4] = 'rgba(243, 68, 35, 0.2)';
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script type="text/javascript">
var ctx = document.getElementById('radio-chart').getContext('2d');

var myRadarChart = new Chart(ctx, {
    type: 'radar',
    data: {
        labels: [
            'Score',
            'Bandwidth',
            'Metadata',
            'Clients',
            'Processes'
        ],
        datasets: [
            <?php
            foreach ($releases as $i => $release) {
                if ($i >= $LIMIT) {
                    break;
                }
            ?>
            {
                'label': '#<?php echo (($this->Paginator->current('Releases') - 1) * $limit) + ($i + 1) . " - " . $release->information_system . " from " . $release->information_institution; ?>',
                'data': [
                    <?php echo $release->io500_score / $max_io500_score * 100.0; ?>,
                    <?php echo $release->io500_bw / $max_io500_bw * 100.0; ?>,
                    <?php echo $release->io500_md / $max_io500_md * 100.0; ?>,
                    <?php echo $release->information_client_nodes / $max_nodes * 100.0; ?>,
                    <?php echo $release->information_client_total_procs / $max_procs * 100.0; ?>
                ],
                'fill': true,
                'borderColor': '<?php echo $plot_border[$i]; ?>',
                'backgroundColor': '<?php echo $plot_background[$i]; ?>',
            },
            <?php
            }
            ?>
        ]
    },
    options: {
        'legend': {
            'position': 'right'
        }
    }
    
});

</script>
