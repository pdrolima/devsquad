<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductImportRequest;
use App\Imports\ProductsImport;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Excel as MaatwebsiteExcel;
use Maatwebsite\Excel\Facades\Excel;

class ProductImportController extends Controller
{
    public function import(ProductImportRequest $request)
    {         
        Excel::import(new ProductsImport(request()->user()), $request->file('productsFile'), null, MaatwebsiteExcel::CSV);

        return response()->json(['message' => 'The file has been uploaded! We\'ll notify you once the import is completed.'], Response::HTTP_OK);
   }
}
