<section class="content">
    <div id="bonus-content"></div>
</section>

<!-- Start Modal Change Passsword -->
<div class="modal fade" id="modal-password">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_password">
                    <input type="hidden" id="user_id_account" value="">
                    <!-- Username -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username_pass" class="form-control" id="username_pass">
                        <div id="username_error_pass"></div>
                    </div>

                    <!-- User Password -->
                    <div class="form-group">
                        <label for="password">Password</label>

                        <div class="input-group mb-1" id="pass_change">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" name="password_change" class="form-control" placeholder="masukan password baru" id="password_change">
                            <div class="input-group-append" id="view_pass_change">
                                <span class="input-group-text" id="view_change"><i class="fas fa-eye-slash"></i></span>
                            </div>
                        </div>
                        <div id="password_error_change"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!-- loading edit password -->
                <div id="loading_password">
                    <img src="<?php echo ASSETS ?>images/icon/loading.gif"><span class="loading-text-pass"></span>
                </div>
                <!-- Button edit data password -->
                <button type="button" class="btn btn-primary" id="edit_data_pass" onclick="changePassword()">Ubah</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal Change Passsword -->
