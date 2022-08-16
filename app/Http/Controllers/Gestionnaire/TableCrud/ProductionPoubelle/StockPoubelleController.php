<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\ProductionPoubelle;

use App\Exports\ProductionPoubelle\Stock_poubelleExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\ProductionPoubelle\Stock_poubelle as Stock_poubelleResource;
use App\Models\Stock_poubelle;
use App\Http\Requests\ProductionPoubelle\StockPoubelleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class StockPoubelleController extends BaseController{
    public function index(){
        $stock_poubelle = Stock_poubelle::all();
        return $this->handleResponse(Stock_poubelleResource::collection($stock_poubelle), 'Affichage stock poubelle');
    }
    public function store(StockPoubelleRequest $request){
        $stock_poubelle = new Stock_poubelle;
        $stock_poubelle->type_poubelle = $request->input('type_poubelle');
        $stock_poubelle->quantite_disponible = $request->input('quantite_disponible');
        $stock_poubelle->pourcentage_remise = $request->input('pourcentage_remise');
        $stock_poubelle->prix_unitaire = $request->input('prix_unitaire');
        if($request->hasfile('photo'))
        {
            $file = $request->file('photo');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('storage/images/stock_poubelle/', $filename);
            $stock_poubelle->photo = $filename;
        }
        $stock_poubelle->save();
        return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle crée!');
    }
    public function show($id){
        $stock_poubelle = Stock_poubelle::find($id);
        if (is_null($stock_poubelle)) {
            return $this->handleError('stock poubelle n\'existe pas!');
        }else{
            return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle existe.');
        }
    }
    public function update(StockPoubelleRequest $request, $id){

        $stock_poubelle = Stock_poubelle::find($id);
        $stock_poubelle->type_poubelle = $request->input('type_poubelle');
        $stock_poubelle->quantite_disponible = $request->input('quantite_disponible');
        $stock_poubelle->pourcentage_remise = $request->input('pourcentage_remise');
        $stock_poubelle->prix_unitaire = $request->input('prix_unitaire');

        if($request->hasfile('photo'))
        {
            $destination = 'storage/images/stock_poubelle/'.$stock_poubelle->photo;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $file = $request->file('photo');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/stock_poubelles/', $filename);
            $stock_poubelle->photo = $filename;
        }

        $stock_poubelle->update();
        return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle modifié!');
    }
    public function destroy($id){
        $stock_poubelle =Stock_poubelle::find($id);
        if (is_null($stock_poubelle)) {
            return $this->handleError('stock poubelle n\'existe pas!');
        }
        else{
            $stock_poubelle->delete();
            return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle supprimé!');
        }
    }
    public function updateStockImage(Request $request,$id){
        $request->validate([
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
            $stock_poubelle = Stock_poubelle::find($id);
            if($request->hasFile('photo')){
                $image = $request->file('photo');
                $destinationPath = 'storage/images/stock_poubelle';
                $destination = 'storage/images/stock_poubelle/'.$stock_poubelle->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                }
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['photo'] = $profileImage;
                $stock_poubelle['photo'] =$input['photo'];
                $stock_poubelle->save();
                return response([
                    'status' => 200,
                    'stock_poubelle' =>$stock_poubelle,
                ]);
            }
            return response([
                'status' => 404,
                'photo' =>'error',
            ]);
    }
    public function exportInfoStockPoubelleExcel(){
        return Excel::download(new Stock_poubelleExport  , 'stock-poubelle-liste.xlsx');
    }

    public function exportInfoStockPoubelleCSV(){
        return Excel::download(new Stock_poubelleExport, 'stock-poubelle-liste.csv');
    }

    public function pdfStockPoubelle($id){
        $stock_poubelle = Stock_poubelle::find($id);
        if (is_null($stock_poubelle)) {
            return $this->handleError('stock poubelle n\'existe pas!');
        }else{
            $data= collect(Stock_poubelle::getStockPoubelleById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "type_poubelle" => $data[0]['type_poubelle'],
                "quantite_disponible" => $data[0]['quantite_disponible'],
                "pourcentage_remise" => $data[0]['pourcentage_remise'],
                "prix_unitaire" => $data[0]['prix_unitaire'],
                "photo" => $data[0]['photo'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/ProductionPoubelle/stockPoubelle', $liste);
            return $pdf->download('stock-poubelle.pdf');
        }
    }
    public function pdfAllStockPoubelle(){
        $stock_poubelle = Stock_poubelle::all();
        if (is_null($stock_poubelle)) {
            return $this->handleError('stock poubelle n\'existe pas!');
        }else{
            $p= Stock_poubelleResource::collection( $stock_poubelle);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/ProductionPoubelle/stockPoubelle', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('stock-poubelle.pdf');
        }
    }
}
