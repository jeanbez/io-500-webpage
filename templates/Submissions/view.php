<?php
$this->assign('title', h($submission->information_system) . ' - Submission');

$fmt = fn($v) => $this->Number->format($v, ['places' => 2, 'precision' => 2]);
$num = fn($v) => $this->Number->format($v);

$nodes = (int)$submission->information_client_nodes;
$procs = (int)$submission->information_client_total_procs;
$ppn = $submission->information_procs_per_node ?: ($nodes ? intdiv($procs, $nodes) : null);

// Group all easy variants first, then all hard; sort by value within each group.
$byEasyHard = function ($a, $b) {
    $ga = str_starts_with($a[0], 'Easy') ? 0 : 1;
    $gb = str_starts_with($b[0], 'Easy') ? 0 : 1;

    return $ga <=> $gb ?: $b[1] <=> $a[1];
};

$ior = [
    ['Easy read', $submission->ior_easy_read],
    ['Easy write', $submission->ior_easy_write],
    ['Hard read', $submission->ior_hard_read],
    ['Hard write', $submission->ior_hard_write],
];
usort($ior, $byEasyHard);

$mdtest = [
    ['Easy write', $submission->mdtest_easy_write],
    ['Easy stat', $submission->mdtest_easy_stat],
    ['Easy delete', $submission->mdtest_easy_delete],
    ['Hard write', $submission->mdtest_hard_write],
    ['Hard read', $submission->mdtest_hard_read],
    ['Hard stat', $submission->mdtest_hard_stat],
    ['Hard delete', $submission->mdtest_hard_delete],
];
usort($mdtest, $byEasyHard);

// [label, unit, easy, hard]
$consistency = [
    ['Bandwidth · read', 'GiB/s', $submission->ior_easy_read, $submission->ior_hard_read],
    ['Bandwidth · write', 'GiB/s', $submission->ior_easy_write, $submission->ior_hard_write],
    ['Metadata · stat', 'kIOP/s', $submission->mdtest_easy_stat, $submission->mdtest_hard_stat],
    ['Metadata · write', 'kIOP/s', $submission->mdtest_easy_write, $submission->mdtest_hard_write],
];

?>
<div class="subview">

    <?php echo $this->element('submission_header', ['active' => 'summary']); ?>

    <div class="sv-grid sv-metrics">
        <div class="sv-card hero">
            <div class="lbl"><?php echo __('IO500 Score') ?></div>
            <div class="val"><?php echo $fmt($submission->io500_score) ?></div>
        </div>
        <div class="sv-card">
            <div class="lbl"><?php echo __('Bandwidth') ?></div>
            <div class="val"><?php echo $fmt($submission->io500_bw) ?><span class="u">GiB/s</span></div>
        </div>
        <div class="sv-card">
            <div class="lbl"><?php echo __('Metadata') ?></div>
            <div class="val"><?php echo $fmt($submission->io500_md) ?><span class="u">kIOP/s</span></div>
        </div>
        <div class="sv-card">
            <div class="lbl"><?php echo __('Scale') ?></div>
            <dl class="sv-scale">
                <dt>Client nodes</dt><dd><?php echo $num($nodes) ?></dd>
                <dt>Total procs</dt><dd><?php echo $num($procs) ?></dd>
                <?php if ($ppn) : ?><dt>Procs / node</dt><dd><?php echo $num($ppn) ?></dd><?php endif; ?>
                <?php if ($submission->information_ds_nodes) : ?><dt>Data nodes</dt><dd><?php echo $num($submission->information_ds_nodes) ?></dd><?php endif; ?>
            </dl>
        </div>
    </div>

    <div class="sv-panel">
        <div class="sv-shead">
            <div class="sv-nodetoggle" id="sv-nodeToggle">
                <button data-cls="full" class="on">Full list</button>
                <button data-cls="ten">10-Node</button>
            </div>
        </div>
        <svg class="sv-scatter" id="sv-scatter" viewBox="0 0 760 294" role="img"
             aria-label="Bandwidth versus metadata for all submissions"></svg>
        <p class="sv-caption" id="sv-caption"></p>
    </div>

    <div class="sv-grid sv-2col">
        <div class="sv-panel">
            <table class="sv-tbl">
                <caption><span class="sv-lead">IOR</span> <?php echo __('bandwidth') ?></caption>
                <tbody>
                    <?php foreach ($ior as $r) : list($q, $op) = explode(' ', $r[0], 2); ?>
                        <tr><td><span class="sv-eh <?php echo strtolower($q) ?>"><?php echo h($q) ?></span><?php echo h($op) ?></td><td class="num"><?php echo $fmt($r[1]) ?></td><td class="u">GiB/s</td></tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="sv-panel">
            <table class="sv-tbl">
                <caption><span class="sv-lead">MDtest</span> <?php echo __('metadata') ?></caption>
                <tbody>
                    <?php foreach ($mdtest as $r) : list($q, $op) = explode(' ', $r[0], 2); ?>
                        <tr><td><span class="sv-eh <?php echo strtolower($q) ?>"><?php echo h($q) ?></span><?php echo h($op) ?></td><td class="num"><?php echo $fmt($r[1]) ?></td><td class="u">kIOP/s</td></tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="sv-panel">
        <table class="sv-tbl">
            <caption><span class="sv-lead"><?php echo __('Easy vs hard') ?></span> <?php echo __('access patterns') ?></caption>
            <thead>
                <tr><th>Test</th><th class="num">Easy</th><th class="num">Hard</th><th class="num">Ratio hard/easy</th></tr>
            </thead>
            <tbody>
                <?php foreach ($consistency as $c) : $pct = $c[2] > 0 ? round($c[3] / $c[2] * 100) : 0; ?>
                    <tr>
                        <td><?php echo $c[0] ?> <span class="cu"><?php echo $c[1] ?></span></td>
                        <td class="num"><?php echo $fmt($c[2]) ?></td>
                        <td class="num"><?php echo $fmt($c[3]) ?></td>
                        <td class="num sv-ret"><div class="sv-retw"><span class="bar"><i style="width:<?php echo min($pct, 100) ?>%"></i></span><span class="p"><?php echo $pct ?>%</span></div></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="sv-grid sv-2col">
        <div class="sv-panel">
            <table class="sv-tbl">
                <caption><span class="sv-lead">Random</span> <?php echo __('4 KiB reads') ?></caption>
                <tbody>
                    <tr><td>Throughput</td><td class="num"><?php echo $fmt($submission->ior_easy_read_random) ?></td><td class="u">GiB/s</td></tr>
                    <tr><td>IOPs</td><td class="num"><?php echo $fmt($submission->ior_easy_read_random * 256) ?></td><td class="u">kIOP/s</td></tr>
                </tbody>
            </table>
        </div>
        <div class="sv-panel">
            <table class="sv-tbl">
                <caption><span class="sv-lead"><?php echo __('Find') ?></span></caption>
                <tbody>
                    <tr><td>Rate</td><td class="num"><?php echo $fmt($submission->find_mixed) ?></td><td class="u">kIOP/s</td></tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
$this->Html->scriptBlock(
    'var SV_FEATURED={bw:' . (float)$submission->io500_bw . ',md:' . (float)$submission->io500_md . '};'
    . 'var SV_POP=' . json_encode($population) . ';'
    . <<<'JS'
    (function(){
      var svg=document.getElementById('sv-scatter'); if(!svg) return;
      var FULL=SV_POP.full||[],TEN=SV_POP.ten||[],ALL=FULL.concat(TEN);
      var W=760,H=294,ml=64,mr=18,mt=16,mb=42,pw=W-ml-mr,ph=H-mt-mb,lx=Math.log10;
      function lo(v){return Math.pow(10,Math.floor(lx(v)));}
      function hi(v){return Math.pow(10,Math.ceil(lx(v)));}
      var bws=ALL.map(function(p){return p[0];}).concat([SV_FEATURED.bw]);
      var mds=ALL.map(function(p){return p[1];}).concat([SV_FEATURED.md]);
      var xMin=lo(Math.min.apply(null,bws)),xMax=hi(Math.max.apply(null,bws));
      var yMin=lo(Math.min.apply(null,mds)),yMax=hi(Math.max.apply(null,mds));
      var gx0=lx(xMin),gx1=lx(xMax),gy0=lx(yMin),gy1=lx(yMax);
      function X(v){return ml+(lx(v)-gx0)/(gx1-gx0)*pw;}
      function Y(v){return mt+ph-(lx(v)-gy0)/(gy1-gy0)*ph;}
      var NS='http://www.w3.org/2000/svg';
      function el(n,a){var e=document.createElementNS(NS,n);for(var k in a)e.setAttribute(k,a[k]);return e;}
      function dl(v){var e=Math.round(lx(v));if(e<0)return(''+v);var n=['1','10','100','1k','10k','100k','1M','10M','100M'];return n[e]||('1e'+e);}
      var frag=document.createDocumentFragment();
      var defs=el('defs'),cp=el('clipPath',{id:'sv-plot'});cp.appendChild(el('rect',{x:ml,y:mt,width:pw,height:ph}));defs.appendChild(cp);frag.appendChild(defs);
      for(var e=Math.round(gx0);e<=Math.round(gx1);e++){var v=Math.pow(10,e),x=X(v);
        frag.appendChild(el('line',{class:'grid-line',x1:x,y1:mt,x2:x,y2:mt+ph}));
        var t=el('text',{class:'tick','text-anchor':'middle',x:x,y:mt+ph+16});t.textContent=dl(v);frag.appendChild(t);}
      for(var e2=Math.round(gy0);e2<=Math.round(gy1);e2++){var v2=Math.pow(10,e2),y=Y(v2);
        frag.appendChild(el('line',{class:'grid-line',x1:ml,y1:y,x2:ml+pw,y2:y}));
        var t2=el('text',{class:'tick','text-anchor':'end',x:ml-8,y:y+3});t2.textContent=dl(v2);frag.appendChild(t2);}
      frag.appendChild(el('line',{class:'axis-line',x1:ml,y1:mt+ph,x2:ml+pw,y2:mt+ph}));
      frag.appendChild(el('line',{class:'axis-line',x1:ml,y1:mt,x2:ml,y2:mt+ph}));
      var ax=el('text',{class:'axis-title','text-anchor':'middle',x:ml+pw/2,y:H-8});ax.textContent='Bandwidth (GiB/s)';frag.appendChild(ax);
      var ay=el('text',{class:'axis-title','text-anchor':'middle',transform:'rotate(-90 16 '+(mt+ph/2)+')',x:16,y:mt+ph/2});ay.textContent='Metadata (kIOP/s)';frag.appendChild(ay);
      [100,1000,10000,100000].forEach(function(s){var s2=s*s;
        frag.appendChild(el('polyline',{class:'isoline','clip-path':'url(#sv-plot)',points:X(xMin)+','+Y(s2/xMin)+' '+X(xMax)+','+Y(s2/xMax)}));
        var b=Math.min(Math.max(s2/yMax,xMin),xMax);var t=el('text',{class:'iso-label',x:X(b)+4,y:Y(s2/b)-4});t.textContent='score '+s.toLocaleString('en-US');frag.appendChild(t);});
      var gPop=el('g',{'clip-path':'url(#sv-plot)'});frag.appendChild(gPop);
      var fx=X(SV_FEATURED.bw),fy=Y(SV_FEATURED.md),r=6.5;
      frag.appendChild(el('path',{class:'featured',d:'M'+fx+' '+(fy-r)+' L'+(fx+r)+' '+fy+' L'+fx+' '+(fy+r)+' L'+(fx-r)+' '+fy+' Z'}));
      svg.appendChild(frag);
      function draw(cls){
        while(gPop.firstChild)gPop.removeChild(gPop.firstChild);
        var pts=cls==='ten'?TEN:FULL,label=cls==='ten'?'10-Node Challenge':'Full',n=pts.length;
        pts.forEach(function(p){gPop.appendChild(el('circle',{class:'dot',cx:X(p[0]),cy:Y(p[1]),r:2.6}));});
        document.getElementById('sv-caption').innerHTML='Reference population: the <b>'+SV_POP.edition+' '+label+'</b> list (n&nbsp;=&nbsp;'+n+'). This submission is the red diamond; dashed diagonals are constant-score isolines.';
      }
      draw('full');
      document.getElementById('sv-nodeToggle').addEventListener('click',function(ev){var b=ev.target.closest('button');if(!b)return;[].forEach.call(this.children,function(c){c.classList.remove('on');});b.classList.add('on');draw(b.dataset.cls);});
    })();
    JS,
    ['block' => true]
);
?>
