<?php
$this->set_css($this->default_theme_path . '/datatables/css/datatables.css');

$this->set_js_lib($this->default_javascript_path . '/jquery_plugins/jquery.form.min.js');
$this->set_js_config($this->default_theme_path . '/datatables/js/datatables-edit.js');
$this->set_css($this->default_css_path . '/ui/simple/' . grocery_CRUD::JQUERY_UI_CSS);
$this->set_js_lib($this->default_javascript_path . '/jquery_plugins/ui/' . grocery_CRUD::JQUERY_UI_JS);

$this->set_js_lib($this->default_javascript_path . '/jquery_plugins/jquery.noty.js');
$this->set_js_lib($this->default_javascript_path . '/jquery_plugins/config/jquery.noty.config.js');
?>

<div class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $this->l('form_edit'); ?> <?php echo $subject ?></h3>
                </div>
                <div class='ui-widget-content ui-corner-all datatables'> <?php echo form_open($update_url, 'method="post" id="crudForm" enctype="multipart/form-data"'); ?>
                    <div class="panel panel-default">
                        <div class="list-group">
                            <?php
                            $counter = 0;
                            foreach ($fields as $field) {
                                $even_odd = $counter % 2 == 0 ? 'odd' : 'even';
                                $counter++;
                                ?>
                                <div class='list-group-item <?php //echo $even_odd;?>' id="<?php echo $field->field_name; ?>_field_box">
                                    <div class='form-display-as-box' id="<?php echo $field->field_name; ?>_display_as_box"> <?php echo $input_fields[$field->field_name]->display_as ?><?php echo ($input_fields[$field->field_name]->required) ? "<span class='required'>*</span> " : "" ?> : </div>
                                    <div class='col-sm-9' id="<?php echo $field->field_name; ?>_input_box"> <?php echo $input_fields[$field->field_name]->input ?> </div>
                                    <div class='clear'></div>
                                </div>
                            <?php } ?>
                            <!-- Start of hidden inputs -->
                            <?php
                            foreach ($hidden_fields as $hidden_field) {
                                echo $hidden_field->input;
                            }
                            ?>
                            <!-- End of hidden inputs -->
                            <?php if ($is_ajax) { ?>
                                <input type="hidden" name="is_ajax" value="true" />
                            <?php } ?>
                            <div id='report-error' class='report-div error'></div>

                            <div id='report-success' class='report-div success'></div>
                        </div>
                    </div>
                    <div class='buttons-box'>
                        <div class='form-button-box'>
                            <input  id="form-button-save" type='submit' value='<?php echo $this->l('form_update_changes'); ?>' class='btn btn-primary' />
                        </div>
                        <?php if (!$this->unset_back_to_list) { ?>
                            <div class='form-button-box'>
                                <input type='button' value='<?php echo $this->l('form_update_and_go_back'); ?>' class='btn btn-primary' id="save-and-go-back-button"/>
                            </div>
                            <div class='form-button-box'>
                                <input type='button' value='<?php echo $this->l('form_cancel'); ?>' class='btn btn-primary' id="cancel-button" />
                            </div>
                        <?php } ?>
                        <div class='form-button-box loading-box'>
                            <div class='small-loading' id='FormLoading'><?php echo $this->l('form_update_loading'); ?></div>
                        </div>
                        <div class='clear'></div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var validation_url = '<?php echo $validation_url ?>';
    var list_url = '<?php echo $list_url ?>';

    var message_alert_edit_form = "<?php echo $this->l('alert_edit_form') ?>";
    var message_update_error = "<?php echo $this->l('update_error') ?>";
</script>