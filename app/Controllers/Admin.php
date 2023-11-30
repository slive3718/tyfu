<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index(): string
    {
        return
            view('admin/common/header').
            view('admin/common/page-head').
            view('admin/index').
            view('admin/common/footer');
    }

    public function login(): string
    {
        return
            view('admin/common/header').
//            view('admin/common/page-head').
            view('admin/login').
            view('admin/common/footer');
    }
}
