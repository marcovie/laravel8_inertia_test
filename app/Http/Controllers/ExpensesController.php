<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Resources\ExpenseIndexResource;
use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;
use mysql_xdevapi\Exception;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Expense::all();
//        dd(ExpenseIndexResource::collection($data));
        return Inertia::render('expenses/index', ['data' => ExpenseIndexResource::collection($data)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseStoreRequest $request)
    {
        try {
            Expense::create($request->only(['expense_name', 'amount', 'description', 'date_of_purchase', 'date_purchase_belongs']));
            return redirect()->back();
        }
        catch (Exception $e)
        {
            dd($e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseStoreRequest $request)
    {
        if ($request->has('id')) {
            Expense::find($request->input('id'))->update($request->only(['expense_name', 'amount', 'description', 'date_of_purchase', 'date_purchase_belongs']));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            Expense::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
