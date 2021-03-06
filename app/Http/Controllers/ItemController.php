<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jne;
use Excel;
use DB;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getItem()
    {
        return Jne::all();
    }

    public function getItemByDate(Request $request)
    {
        
        $jne = DB::table('jne')->selectRaw('*, count(*) as total_jumlah')->groupBy('service')
        ->where('tanggal','LIKE','%'.$request->tanggal.'%')->get();
        $result[] = ['Service','Jumlah'];
        foreach($jne as $key => $value){
            $result[++$key] = [$value->service, (int)$value->total_jumlah];
        }

        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('import_file')){
            $path = $request->file('import_file')->getRealPath();
            $data = \Excel::load($path)->get();
            if($data->count()){
                foreach ($data as $key => $value) {
                    $arr[] = ['tanggal' => $value->tanggal, 'no_resi' => $value->no_resi,
                              'yes' => $value->yes, 'reg' => $value->reg,
                              'oke' => $value->oke, 'service' => $value->service,
                              'tujuan' => $value->tujuan, 'pengirim' => $value->pengirim,
                              'penerima' => $value->penerima];
                }
                if(!empty($arr)){
                    Jne::insert($arr);
                    return back()->with('success','Insert Record successfully.');
                }
            }
        }
        return back()->with('error','Please Check your file, Something is wrong there.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Jne::find($id);
        // return $item;
        // return $request->name;
        $item->tanggal = $request->tanggal;
        $item->service = $request->service;
        $item->save();
        return back()->with('success','Update Record successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Jne::find($id);
        $item->delete();
        return back()->with('success','Delete Record successfully.');
    }
}
