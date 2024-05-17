<?php $this->load->view('common/header'); ?>
<style>
    .wizard-content .wizard.vertical>.steps {
        width: 17% !important;
        max-height: 310px;
        overflow-y: auto;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <?php if (!empty($test_data)) { ?>
                <div class="box">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="box-title"><?php echo $test_data[0]['test_title']; ?></h4>
                                <h6 class="box-subtitle"><?php echo $test_data[0]['test_description']; ?></h6>
                            </div>
                            <div class="col-6">
                                <?php if (!empty($test_started)) { ?>
                                    <div id="countdown" class="row justify-content-md-center"></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <?php if (!empty($test_started)) { ?>
                        <div class="box-body wizard-content">
                            <form action="#" class="tab-wizard vertical wizard-circle">
                                <?php $count = 0;
                                foreach ($test_data as $value) {
                                    $count++;
                                    $test_id = $value['test_id'];
                                    $question_id = $value['question_id'];
                                    $question = $value['question'];
                                    $question_option = json_decode($value['question_option'], true); ?>
                                    <h6>Question</h6>
                                    <section>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4><?php echo $question; ?></h4>
                                                <div class="form-group">
                                                    <?php foreach ($question_option as $option => $opt_val) {
                                                        $radio_bt_val = aes_encrypt($test_id . '~' . $question_id . '~' . $option); ?>
                                                        <div class="radio">
                                                            <input type="radio" name="option_<?php echo $question_id; ?>" value="<?php echo $radio_bt_val; ?>" class="qus-option" id="<?php echo $question_id; ?>_Option_<?php echo $option; ?>">
                                                            <label for="<?php echo $question_id; ?>_Option_<?php echo $option; ?>"><?php echo $option; ?> : <?php echo $opt_val; ?></label>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                <?php } ?>
                            </form>
                        </div>
                    <?php } elseif ($test_attemted == 1) { ?>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-warning">
                                        <h4>You have been attemted this test. Please wait for next test.</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-12">
                                    <h4><i class="icon fa fa-check"></i> Note to Partcipants Before Starting a Test!</h4>

                                    <p>Dear Partcipants,</p>

                                    <p>As you embark on this test, I want to share a few words of encouragement and advice. Remember, tests are not just about evaluating your knowledge, but they are also opportunities for growth and learning. Here are a few things to keep in mind:</p>
                                    <ul>
                                        <li>
                                            <b>Stay Calm and Confident:</b>
                                            <p>in your preparation and abilities. Take a deep breath before you begin, and believe in yourself. A calm mind performs better.</p>
                                        </li>
                                        <li>
                                            <b>Time Management:</b>
                                            <p>You have 1 hour to complete test. Keep an eye on the clock, but don't rush. Allocate time wisely to each section or question. If you get stuck on a difficult question, move on and come back to it later.</p>
                                        </li>
                                        <li>
                                            <b>Answer Every Question:</b>
                                            <p>Even if you're unsure about an answer, attempt it. You might earn partial credit, and you never know – your intuition might guide you in the right direction.</p>
                                        </li>
                                        <li>
                                            <b>Review Your Work:</b>
                                            <p>If time permits, review your answers. Check for any errors or omissions. Often, a quick review can catch simple mistakes.</p>
                                        </li>
                                        <li>
                                            <b>Celebrate Effort:</b>
                                            <p>Regardless of the outcome, be proud of the effort you've put in. Every test is a step towards your academic journey.</p>
                                        </li>
                                    </ul>

                                    <p>Believe in yourself, stay focused, and give it your best shot. You've got this! Good luck!</p>
                                    <button type="button" class="btn btn-success start-test">Start Test</button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- /.box-body -->
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <h4>There is no scheduled test for the current period.</h4>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>
    </div>
</div>
<!-- /.content -->
<?php $this->load->view('common/footer'); ?>
<script>
    $(".tab-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "none",
        titleTemplate: '<span class="step">#index#</span> #title#',
        saveState: true,
        labels: {
            finish: "Finish"
        },
        onFinished: function(event, currentIndex) {
            window.location.href = '<?php echo site_url('test/finish'); ?>';
        }
    });
    $(document).on('click', '.start-test', function() {
        Swal.fire({
            title: "Are you sure?",
            text: "If you start test, you have to complete test in given time frame.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, start it!",
        }).then((result) => {
            if (result.isConfirmed) {
                var url = '<?php echo site_url('test/start'); ?>';
                $.post(url, function(data) {
                    if (Math.floor(data) == data && $.isNumeric(data)) {
                        var redirectUrl = "<?php echo current_url(); ?>";
                        window.location.href = redirectUrl;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '',
                            html: data,
                        });
                    }
                });
            }
        });
    });

    $(document).on('click', '.qus-option', function() {
        var value = $(this).val();
        var url = '<?php echo site_url('test/save_option'); ?>';
        $.post(url, {
            val: value
        }, function(data) {
            if (Math.floor(data) == data && $.isNumeric(data)) {

            } else {
                if (data.includes("redirect#~@")) {
                    var newData = data.replace("redirect#~@", "");
                    window.location.href = $.trim(newData);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '',
                        html: data,
                    });
                }
            }
        });
    });
</script>