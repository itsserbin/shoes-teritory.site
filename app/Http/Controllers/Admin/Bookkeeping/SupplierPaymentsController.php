<?php

namespace App\Http\Controllers\Admin\Bookkeeping;

class SupplierPaymentsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.bookkeeping.supplier-payments.index');
    }
}
