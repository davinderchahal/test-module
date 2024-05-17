<?php $this->load->view('common/header');
$test_title = $test_description = $is_published = $test_duration = '';
$current_date = date('Y-m-d H:i:s');
$test_date = $current_date;
$form_url = site_url('test/add_test');
$form_display = 'style="display: none;"';
$form_title = 'Add';
if (!empty($edit_test_data)) {
    $test_title = $edit_test_data[0]['test_title'];
    $test_description = $edit_test_data[0]['test_description'];
    $test_date =  $edit_test_data[0]['test_date'];
    $test_duration =  $edit_test_data[0]['test_duration'];
    $is_published = $edit_test_data[0]['is_published'];
    $form_url = site_url('test/edit_test/' . $this->uri->segment(4));
    $form_display = '';
    $form_title = 'Edit';
} ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <div class="row">
            <div class="col-12" id="test-add-block" <?php echo $form_display; ?>>
                <!-- Basic Forms -->
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title"><?php echo $form_title; ?> Test</h4>
                    </div>
                    <!-- /.box-header -->
                    <form action="<?php echo $form_url; ?>" method="post" class="common-form-submit">
                        <div class="box-body">
                            <h4 class="mt-0 mb-20">1. Test Info:</h4>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label class="form-label">Test Title</label>
                                    <input type="text" name="tst_tle" value="<?php echo $test_title; ?>" class="form-control" placeholder="Enter Test Title">
                                </div>
                                <div class="col-6 form-group">
                                    <label class="form-label">Test Description</label>
                                    <input type="text" name="tst_descpton" value="<?php echo $test_description; ?>" class="form-control" placeholder="Enter Test Description">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 form-group">
                                    <label class="form-label">Test Date</label>
                                    <input class="form-control" type="datetime-local" name="tst_date" value="<?php echo $test_date; ?>" id="example-datetime-local-input">
                                </div>
                                <div class="col-3 form-group">
                                    <label class="form-label">Test Duration (in minute)</label>
                                    <input type="text" name="tst_duration" value="<?php echo $test_duration; ?>" class="form-control" placeholder="Enter Test Duration">
                                </div>
                                <div class="col-3 form-group">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="c-inputs-stacked">
                                        <input type="checkbox" name="tst_pblsh" value="1" id="publish-test" <?php echo ((int)$is_published == 1) ? 'checked' : ''; ?>>
                                        <label for="publish-test" class="me-30">Publish Test</label>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <h4 class="mt-0 mb-20">2. Question Info:</h4>
                            <div id="qustion-block">
                                <?php $count = 0;
                                foreach ($edit_test_data as $value) {
                                    $count++;
                                    $question_option = json_decode($value['question_option'], true);
                                    $question_answer = json_decode($value['question_answer'], true); ?>
                                    <div class="row qus-row" id="qus-row-<?php echo $count; ?>" data-row-count="<?php echo $count; ?>">
                                        <div class="col-11 form-group">
                                            <label class="form-label">Question <?php echo $count; ?></label>
                                            <input type="text" name="qus[<?php echo $count; ?>]" value="<?php echo $value['question']; ?>" class="form-control" placeholder="Enter Question">
                                        </div>
                                        <div class="col-1 form-group position-relative">
                                            <?php if ($count > 1) { ?>
                                                <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger btn-xs position-absolute translate-middle delete-qus" style="left:50%; top:70%" data-id="<?php echo $count; ?>"><i class="ti-minus"></i></button>
                                            <?php } ?>
                                        </div>
                                        <div class="col-10 form-group">
                                            <label class="form-label">Options</label>
                                        </div>
                                        <div class="col-2 form-group">
                                            <label class="form-label">Is Answer</label>
                                        </div>
                                        <div class="col-10 form-group">
                                            <div class="input-group">
                                                <span class="input-group-text">A</span>
                                                <input type="text" name="option[<?php echo $count; ?>][A]" value="<?php echo (isset($question_option['A'])) ? $question_option['A'] : ''; ?>" class="form-control" placeholder="Enter Option Descrition">
                                            </div>
                                        </div>
                                        <div class="col-2 form-group">
                                            <input type="checkbox" name="qus_ans[<?php echo $count; ?>][]" value="A" id="question-answer-a<?php echo $count; ?>" <?php echo (in_array('A', $question_answer)) ? 'checked' : ''; ?>>
                                            <label for="question-answer-a<?php echo $count; ?>" class="me-30"></label>
                                        </div>
                                        <div class="col-10 form-group">
                                            <div class="input-group">
                                                <span class="input-group-text">B</span>
                                                <input type="text" name="option[<?php echo $count; ?>][B]" value="<?php echo (isset($question_option['B'])) ? $question_option['B'] : ''; ?>" class="form-control" placeholder="Enter Option Descrition">
                                            </div>
                                        </div>
                                        <div class="col-2 form-group">
                                            <input type="checkbox" name="qus_ans[<?php echo $count; ?>][]" value="B" id="question-answer-b<?php echo $count; ?>" <?php echo (in_array('B', $question_answer)) ? 'checked' : ''; ?>>
                                            <label for="question-answer-b<?php echo $count; ?>" class="me-30"></label>
                                        </div>
                                        <div class="col-10 form-group">
                                            <div class="input-group">
                                                <span class="input-group-text">C</span>
                                                <input type="text" name="option[<?php echo $count; ?>][C]" value="<?php echo (isset($question_option['C'])) ? $question_option['C'] : ''; ?>" class="form-control" placeholder="Enter Option Descrition">
                                            </div>
                                        </div>
                                        <div class="col-2 form-group">
                                            <input type="checkbox" name="qus_ans[<?php echo $count; ?>][]" value="C" id="question-answer-c<?php echo $count; ?>" <?php echo (in_array('C', $question_answer)) ? 'checked' : ''; ?>>
                                            <label for="question-answer-c<?php echo $count; ?>" class="me-30"></label>
                                        </div>
                                        <div class="col-10 form-group">
                                            <div class="input-group">
                                                <span class="input-group-text">D</span>
                                                <input type="text" name="option[<?php echo $count; ?>][D]" value="<?php echo (isset($question_option['D'])) ? $question_option['D'] : ''; ?>" class="form-control" placeholder="Enter Option Descrition">
                                            </div>
                                        </div>
                                        <div class="col-2 form-group">
                                            <input type="checkbox" name="qus_ans[<?php echo $count; ?>][]" value="D" id="question-answer-d<?php echo $count; ?>" <?php echo (in_array('D', $question_answer)) ? 'checked' : ''; ?>>
                                            <label for="question-answer-d<?php echo $count; ?>" class="me-30"></label>
                                        </div>
                                        <hr>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="waves-effect waves-circle btn btn-circle btn-success btn-xs pull-right" id="add-new-qus"><i class="ti-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-danger" id="close-test">Close</button>
                            <button type="submit" class="btn btn-success pull-right">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xl-12 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="row">
                                <div class="col-xl-6 col-6">
                                    <h4 class="box-title">Manage Test</h4>
                                </div>
                                <div class="col-xl-6 col-6">
                                    <button type="button" class="waves-effect waves-light btn btn-secondary btn-flat float-end" id="add-test-btn">Add Test</button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <?php if (!empty($all_test)) { ?>
                                <div class="table-responsive">
                                    <table class="table no-bordered no-margin table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Discription</th>
                                                <th>Date</th>
                                                <th>Is Published</th>
                                                <th>Is Completed</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($all_test as $val) { ?>
                                                <tr>
                                                    <td><?php echo $val['test_title']; ?></td>
                                                    <td><?php echo $val['test_description']; ?></td>
                                                    <td><?php echo date('d/m/Y H:i:s', strtotime($val['test_date'])); ?></td>
                                                    <td><?php echo ((int)$val['is_published'] == 1) ? '<span class="label label-success">Published</span>' : '<span class="label label-danger">Un-Published</span>'; ?></td>
                                                    <td><?php echo (strtotime($val['test_date']) <= strtotime($current_date)) ? '<span class="label label-success">Complete</span>' : '<span class="label label-danger">Pending</span>'; ?></td>
                                                    <td>
                                                        <?php if (strtotime($val['test_date']) > strtotime($current_date)) { ?>
                                                            <a href="<?php echo site_url('test/manage_test/' . (int)$uri3 . '/' . aes_encrypt($val['test_id'])); ?>" class="waves-effect waves-light btn btn-sm btn-outline btn-info"><i class="ti-pencil"></i></a>
                                                            <a href="<?php echo site_url('test/delete_test/' . aes_encrypt($val['test_id'])); ?>" class="waves-effect waves-light btn btn-sm btn-outline btn-danger delete-test"><i class="ti-trash"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-info">No Test Data Found.</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- /.content -->
<?php $this->load->view('common/footer'); ?>
<script>
    $(document).ready(function() {
        if (!$('.qus-row').length) {
            addNewQuestion();
        }
    });
    $(document).on('click', '#add-test-btn', function() {
        if ($('#test-add-block').is(':visible')) {
            $('#test-add-block').hide();
        } else {
            $('#test-add-block').show();
        }
    });

    $(document).on('click', '#close-test', function() {
        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, close it!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?php echo site_url('test/manage_test/' . $this->uri->segment(3)); ?>';
            }
        });
    });

    $(document).on('click', '#add-new-qus', function() {
        addNewQuestion();
    });

    $(document).on('click', '.delete-qus', function() {
        var rowId = $(this).attr('data-id');
        $('#qus-row-' + rowId).remove();
    });

    $(document).on('click', '.delete-test', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
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

    function addNewQuestion() {
        var html = '';
        var count = 0;
        if ($('.qus-row').length) {
            count = parseInt($('.qus-row').last().attr('data-row-count'));
        }
        count++;
        html += '<div class="row qus-row" id="qus-row-' + count + '" data-row-count="' + count + '">';
        html += '    <div class="col-11 form-group">';
        html += '        <label class="form-label">Question ' + count + '</label>';
        html += '        <input type="text" name="qus[' + count + ']" value="" class="form-control" placeholder="Enter Question">';
        html += '    </div>';
        html += '    <div class="col-1 form-group position-relative">';
        if (count > 1) {
            html += '        <button type="button" class="waves-effect waves-circle btn btn-circle btn-danger btn-xs position-absolute translate-middle delete-qus" style="left:50%; top:70%" data-id="' + count + '"><i class="ti-minus"></i></button>';
        }
        html += '    </div>';
        html += '    <div class="col-10 form-group">';
        html += '        <label class="form-label">Options</label>';
        html += '    </div>';
        html += '    <div class="col-2 form-group">';
        html += '        <label class="form-label">Is Answer</label>';
        html += '    </div>';
        html += '    <div class="col-10 form-group">';
        html += '        <div class="input-group">';
        html += '            <span class="input-group-text">A</span>';
        html += '            <input type="text" name="option[' + count + '][A]" value="" class="form-control" placeholder="Enter Option Descrition">';
        html += '        </div>';
        html += '    </div>';
        html += '    <div class="col-2 form-group">';
        html += '        <input type="checkbox" name="qus_ans[' + count + '][]" value="A" id="question-answer-a' + count + '">';
        html += '        <label for="question-answer-a' + count + '" class="me-30"></label>';
        html += '    </div>';
        html += '    <div class="col-10 form-group">';
        html += '        <div class="input-group">';
        html += '            <span class="input-group-text">B</span>';
        html += '            <input type="text" name="option[' + count + '][B]" value="" class="form-control" placeholder="Enter Option Descrition">';
        html += '        </div>';
        html += '    </div>';
        html += '    <div class="col-2 form-group">';
        html += '        <input type="checkbox" name="qus_ans[' + count + '][]" value="B" id="question-answer-b' + count + '">';
        html += '        <label for="question-answer-b' + count + '" class="me-30"></label>';
        html += '    </div>';
        html += '    <div class="col-10 form-group">';
        html += '        <div class="input-group">';
        html += '            <span class="input-group-text">C</span>';
        html += '            <input type="text" name="option[' + count + '][C]" value="" class="form-control" placeholder="Enter Option Descrition">';
        html += '        </div>';
        html += '    </div>';
        html += '    <div class="col-2 form-group">';
        html += '        <input type="checkbox" name="qus_ans[' + count + '][]" value="C" id="question-answer-c' + count + '">';
        html += '        <label for="question-answer-c' + count + '" class="me-30"></label>';
        html += '    </div>';
        html += '    <div class="col-10 form-group">';
        html += '        <div class="input-group">';
        html += '            <span class="input-group-text">D</span>';
        html += '            <input type="text" name="option[' + count + '][D]" value="" class="form-control" placeholder="Enter Option Descrition">';
        html += '        </div>';
        html += '    </div>';
        html += '    <div class="col-2 form-group">';
        html += '        <input type="checkbox" name="qus_ans[' + count + '][]" value="D" id="question-answer-d' + count + '">';
        html += '        <label for="question-answer-d' + count + '" class="me-30"></label>';
        html += '    </div>';
        html += '    <hr>';
        html += '</div>';

        $('#qustion-block').append(html);
    }
</script>