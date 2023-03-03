<?php $this->assign('title', 'Submission'); ?>

<div class="submissions index content">

<div class="content">
    <p class="call">
        Submissions are not yet open for ISC23.
    </p>

    <h2>Call for Submissions</h2>

    <p>
        The IO500 is <b>no longer</b> accepting submissions for the
        upcoming 11th semi-annual IO500 list in conjunction with SC'22.
        Submissions for the 10 Node Challenge are encouraged to share
        small scale storage system results.
    </p>

    <h2>How to Submit?</h2>

    <p>
        This page contains the information about the submission procedure.
        First, you need to
        <?php echo $this->Html->link(_('run the benchmark'),
            [ 'controller' => 'Pages', 'action' => 'display',
              'running'
            ], [ 'class' => 'link' ]);
         ?>
        .
    </p>

    <p>
        The IO500 list is released during ISC and SC. See our
        <?php echo $this->Html->link(_('call for submissions'),
            [ 'controller' => 'Pages', 'action' => 'display',
              'cfs'
            ], [ 'class' => 'link' ]);
         ?>
        page for details.
        Submissions to the upcoming list can be made all year. However,
        <strong>to be included in the next submission</strong>, we must receive
        the submission before the deadline listed in our call for submissions.
    </p>

    <h3>Submission Instructions</h3>

    <p>
        There are two options to submit to the IO500, we prefer the online form:
    </p>

    <ol>
        <li>
            Use our <a href="https://www.vi4io.org/io500-submission/" target="_blank" class="link">online form</a>. You have to receive a one-time token (please check your SPAM folder if you did not receive the initial response 5 minutes later).
        </li>
        <li>
            If you experience any problems with the online form; send an <a href="mailto:submit@io500.org" class="link">email</a> with attachments:

            <ul>
                <li>The (potentially) adapted <span class="code">io500.sh</span></li>
                <li>The output directory of the benchmark (variable <span class="code">io500_result_dir</span> in <span class="code">io500.sh</span>)</li>
                <li>If possible, please mention which system is covered of the <a href="https://www.vi4io.org/hpsl/start" class="link">CDCL</a> or provide system information such that we can add the system to the CDCL!</li>
            </ul>
        </li>
    </ol>

    <p>
        We will reply to you, to confirm reception and any question that may arise.
    </p>

    <h3>Handling of the Submitted Data</h3>

    <p>
        Until the next release of the list, the submission committee will
        handle all submitted data confidentially. That means that we will not
        disclose any submitted data to individuals/companies, or institutions.
    </p>

    <h4>Privacy</h4>

    <p>
        We will publish all data submitted, so by submitting the information you <strong>give us the right to publish the uploaded data</strong>.
    </p>

    <h5>Submitter Name</h5>

    <p>
        Submissions will be visible immediately to the members of the
        <?php echo $this->Html->link(_('IO500 Steering Committee'),
            [ 'controller' => 'Pages', 'action' => 'display',
              'steering'
            ], [ 'class' => 'link' ]);
         ?>.
        If there is sensitivity about early visibility to your results
        being seen by any of the committee, please feel free to email
        results privately to a subset of the committee (i.e. do not use
        the official submission tools if you have privacy concerns).
    </p>

    <p>
        Starting with the SC'18 list, submissions include the name of the submitter (or team) to give them the credit they deserve to execute the benchmark; this can be opted out.
    </p>

    <h4>Annonymity</h4>

    <p>
        With the online form, the submitter is able to individually opt-out the submission the name of the submitter/team (this will be then an anonymous submission)
    </p>

    <h3>Previous Call for Submissions</h3>

    <ul class="cfs-list">
        <li>
            <?php echo $this->Html->link("SC'22 CFS",
                [ 'controller' => 'pages', 'action' => 'display', 'cfs-sc22' ],
                [ 'class' => 'button' ]);
             ?>
        </li>
        <li>
            <?php echo $this->Html->link("ISC'22 CFS",
                [ 'controller' => 'pages', 'action' => 'display', 'cfs-isc22' ],
                [ 'class' => 'button' ]);
             ?>
        </li>
        <li>
            <?php echo $this->Html->link("SC'21 CFS",
                [ 'controller' => 'pages', 'action' => 'display', 'cfs-sc21' ],
                [ 'class' => 'button' ]);
             ?>
        </li>
        <li>
            <?php echo $this->Html->link("ISC'21 CFS",
                [ 'controller' => 'pages', 'action' => 'display', 'cfs-isc21' ],
                [ 'class' => 'button' ]);
             ?>
        </li>
    </ul>
</div>
