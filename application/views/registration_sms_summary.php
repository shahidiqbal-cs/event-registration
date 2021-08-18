<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"> SMS Summary</h3>
                <div class="box-tools pull-right">
                    <button data-original-title="Collapse" class="btn btn-box-tool" data-widget="collapse"
                            data-toggle="tooltip" title=""><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <form id="form_badges" action="" method="post" class="form-horizontal">
                <div class="box-body">
                    <br>
                    <div class="col-md-12">
                        <div class="form-group<?= (form_error('tanzeem')) ? ' has-error' : ''; ?>">
                            <label class="col-sm-2 control-label" for="tanzeem">Summary of: </label>
                            <div class="col-sm-10">
                                <div class="col-sm-3">
                                    <label class="control-label">
                                        <input type="radio" name="tanzeem" class="minimal"
                                               value="overall" <?= set_radio('tanzeem', 'overall', TRUE); ?> />
                                        Overall
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">
                                        <input type="radio" name="tanzeem" class="minimal"
                                               value="combine" <?= set_radio('tanzeem', 'combine'); ?> />
                                        Combine
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">
                                        <input type="radio" name="tanzeem" class="minimal"
                                               value="bwp_zone" <?= set_radio('tanzeem', 'bwp_zone'); ?> />
                                        BWP Zone
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">
                                        <input type="radio" name="tanzeem" class="minimal"
                                               value="iub" <?= set_radio('tanzeem', 'iub'); ?> /> IUB
                                    </label>
                                </div>

                                <div class="col-sm-3">
                                    <label class="control-label">
                                        <input type="radio" name="tanzeem" class="minimal"
                                               value="miscellaneous" <?= set_radio('tanzeem', 'miscellaneous'); ?> />
                                        Miscellaneous (Lodhran)
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">
                                        <input type="radio" name="tanzeem" class="minimal"
                                               value="hasilpur" <?= set_radio('tanzeem', 'hasilpur'); ?> /> Hasilpur
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">
                                        <input type="radio" name="tanzeem" class="minimal"
                                               value="wasti" <?= set_radio('tanzeem', 'wasti'); ?> /> Wasti
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">
                                        <input type="radio" name="tanzeem" class="minimal"
                                               value="sharqi" <?= set_radio('tanzeem', 'sharqi'); ?> /> Sharqi
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">
                                        <input type="radio" name="tanzeem" class="minimal"
                                               value="gharbi" <?= set_radio('tanzeem', 'gharbi'); ?> /> Gharbi
                                    </label>
                                </div>
                            </div>

                            <div class="col-sm-6 pull-right alert alert-info">
                                <i class="icon fa fa-info"></i> Choose tanzeem for summary
                            </div>
                            <label class="col-sm-12" for="name"> <?= form_error('tanzeem'); ?></label>
                        </div>
                        <hr>
                        <br>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group<?= (form_error('number')) ? ' has-error' : ''; ?>">
                            <label class="col-sm-6 control-label" for="number"> Send Message to: </label>
                            <div class="col-sm-6">
                                <select class="form-control" name="number">
                                    <?php foreach ($numbers as $number): ?>
                                        <option value="<?= $number->number ?>"><?= $number->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label class="col-sm-offset-2 col-sm-10 control-label"
                                   for="number"><?= form_error('number'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-sm-6 control-label" for="marge_jaizapass">Marge JaizaPass</label>
                            <div class="col-sm-6">
                                <div class="col-sm-6">
                                    <label class="control-label">
                                        <input type="radio" name="marge_jaizapass" class="minimal"
                                               value="1" <?= set_radio('marge_jaizapass', 1, TRUE); ?> /> Yes
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">
                                        <input type="radio" name="marge_jaizapass" class="minimal"
                                               value="0" <?= set_radio('marge_jaizapass', 0); ?> /> No
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12 alert alert-info">
                                <i class="icon fa fa-info"></i> Marge All JaizaPass with Mohzir(Sirkel, Forum)
                            </div>
                            <label class="col-sm-12"
                                   for="marge_jaizapass"> <?= form_error('marge_jaizapass'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php if ($this->session->flashdata('message')): ?>
                            <div class="alert alert-info">
                                <i class="icon fa fa-info"></i> <?= str_replace("\r\n","<br>",$this->session->flashdata('message')); ?>
                            </div>
                        <?php endif; ?>
                    </div>


                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-credit-card"></i> Send SMS
                    </button>
                </div><!-- /.box-footer -->
            </form>
        </div><!-- /. box -->
    </div><!-- /.col -->
</div>