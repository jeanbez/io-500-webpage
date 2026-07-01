<footer>
    <div class="container">
        <div class="footer">
            <strong>IO500 Foundation</strong><br/>
            <em>io500.org</em><br/>
            <a href="mailto:committee@io500.org">committee@io500.org</a><br>
        </div>
        <div class="footer">
            <ul class="social-links">
                <li>
                    <?php
                    echo $this->Html->link(
                        '<i class="fa-brands fa-github"></i>',
                        'https://github.com/IO500/webpage/issues/new',
                        [
                            'escape' => false,
                            'target' => '_blank',
                            'title' => __('Report an issue'),
                            'aria-label' => __('Report an issue on GitHub')
                        ]
                    );
                    ?>
                </li>
                <li>
                    <?php
                    echo $this->Html->link(
                        '<i class="fa-solid fa-envelope"></i>',
                        'http://lists.io500.org/listinfo.cgi/io500-io500.org',
                        [
                            'escape' => false,
                            'target' => '_blank',
                            'title' => __('Mailing list'),
                            'aria-label' => __('IO500 mailing list')
                        ]
                    );
                    ?>
                </li>
                <li>
                    <?php
                    echo $this->Html->link(
                        '<i class="fa-brands fa-slack"></i>',
                        'https://join.slack.com/t/io500workspace/shared_invite/zt-hv1i5svr-Yj8HR_wRzEy1bK2s2JX20w',
                        [
                            'escape' => false,
                            'target' => '_blank',
                            'title' => __('Slack'),
                            'aria-label' => __('Join us on Slack')
                        ]
                    );
                    ?>
                </li>
            </ul>
        </div>
    </div>
</footer>
