<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
    .input-group-addon:first-child {
        border-right: 0;
    }

    .input-group .form-control:first-child,
    .input-group-addon:first-child,
    .input-group-btn:first-child>.btn,
    .input-group-btn:first-child>.btn-group>.btn,
    .input-group-btn:first-child>.dropdown-toggle,
    .input-group-btn:last-child>.btn:not(:last-child):not(.dropdown-toggle),
    .input-group-btn:last-child>.btn-group:not(:last-child)>.btn {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .input-group-addon {
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1;
        color: #555;
        text-align: center;
        background-color: #eee;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .input-group-addon .input-group-btn {
        width: 1%;
        white-space: nowrap;
        vertical-align: middle;
    }

    .input-group-addon,
    .input-group-btn,
    .input-group .form-control {
        display: table-cell;
    }
</style>

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-md-7" style="margin-top:200px;">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class=" col-lg-12">
                            <div class="p-5">
                                <div class=" text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Form Login</h1>
                                </div>

                                <?php if ($flash_message) : ?>
                                    <p class="text-danger text-center"><?= $flash_message ?></p>
                                <?php endif; ?>
                                <form class="user" action="<?= site_url('auth/do_login') ?>" method="post">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="exampleInputEmail" name="email" aria-describedby="emailHelp" placeholder="Masukan Email Anda" <?php if ($old_username) {
                                                                                                                                                                                        echo 'value="' . $old_username . '"';
                                                                                                                                                                                    } ?>>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        <input type="password" class="form-control" name="password" id="exampleInputPassword" placeholder="Masukan Password">
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>

                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>