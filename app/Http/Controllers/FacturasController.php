<?php namespace App\Http\Controllers;

use App\Factura;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\FacturaRequest;
use App\Oferta;
use App\Procedimiento;
use Illuminate\Http\Request;

class FacturasController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($oferta_id)
	{
		$oferta = Oferta::findOrFail($oferta_id);
		return view('facturas.index', compact('oferta'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($oferta_id)
	{
		$oferta = Oferta::findOrFail($oferta_id);
		return view('facturas.create', compact('oferta'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(FacturaRequest $request, $oferta_id)
	{
		$oferta = Oferta::findOrFail($oferta_id);
		$oferta->facturas()->create($request->all());
		$procedimiento = Procedimiento::findOrFail($oferta->procedimiento_id);
		$procedimiento->status = 7;
		$procedimiento->save();
		return redirect('facturas/' . $oferta_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$factura = Factura::findOrFail($id);
		return view('facturas.edit', compact('factura'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(FacturaRequest $request, $id)
	{
		$factura = Factura::findOrFail($id);
		$factura->update($request->all());
		return redirect("facturas/" . $factura->oferta->id);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$factura = Factura::findOrFail($id);
		$factura->delete();
		return "true";
	}

}
