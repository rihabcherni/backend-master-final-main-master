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
        $stock_poubelle->description = $request->input('description');
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
        $stock_poubelle->description = $request->input('description');
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
    public function destroy($id) {
        $stock_poubelle = Stock_poubelle::find($id);
        if (is_null($stock_poubelle)) {
            return $this->handleError('stock poubelle n\'existe pas!');
        }elseif($stock_poubelle->photo ==="default.jpeg" || $stock_poubelle->photo === NULL){
            $stock_poubelle->delete();
            return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle supprimé!');
        } else{
            if(File::exists(('storage\images\stock_poubelle\\').$stock_poubelle->photo)){
                File::copy(public_path('storage\images\stock_poubelle\\').$stock_poubelle->photo,
                public_path('storage\trashImages\stock_poubelle\\').$stock_poubelle->photo);
                unlink(public_path('storage\images\stock_poubelle\\').$stock_poubelle->photo );
            }
            $stock_poubelle->delete();
            return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle supprimé!');
        }
    }
    public function hdelete( $id) {
        $stock_poubelle = Stock_poubelle::withTrashed()->where('id' ,  $id )->first();
        if (is_null($stock_poubelle)) {
            return $this->handleError('stock poubelle n\'existe pas!');
        }elseif($stock_poubelle->photo ==="default.jpeg" || $stock_poubelle->photo === NULL){
            $stock_poubelle->forceDelete();
            return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle supprimé!');
        } else{
            if(File::exists(('storage\trashImages\stock_poubelle\\').$stock_poubelle->photo)){
                unlink(public_path('storage\trashImages\stock_poubelle\\').$stock_poubelle->photo );
            }
            $stock_poubelle->forceDelete();
            return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $stock_poubelles = Stock_poubelle::onlyTrashed()->get();
        foreach($stock_poubelles as $stock_poubelle){
            if($stock_poubelle->photo ==="default.jpeg" || $stock_poubelle->photo === NULL){
                $stock_poubelle->forceDelete();
            } else{
                if(File::exists(('storage\trashImages\stock_poubelle\\').$stock_poubelle->photo)){
                    unlink(public_path('storage\trashImages\stock_poubelle\\').$stock_poubelle->photo );
                }
                $stock_poubelle->forceDelete();
            }
        }
        return $this->handleResponse(Stock_poubelleResource::collection($stock_poubelles), 'tous stock poubelles  supprimés définitivement');
    }
    public function restore( $id) {
        $stock_poubelle = Stock_poubelle::withTrashed()->where('id' ,  $id )->first();
        if (is_null($stock_poubelle)) {
            return $this->handleError('stock poubelle n\'existe pas!');
        }elseif($stock_poubelle->photo ==="default.jpeg" || $stock_poubelle->photo === NULL){
            $stock_poubelle->restore();
            return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle supprimé!');
        } else{
            if(File::exists(('storage\trashImages\stock_poubelle\\').$stock_poubelle->photo)){
                File::copy(public_path('storage\trashImages\stock_poubelle\\').$stock_poubelle->photo,
                public_path('storage\images\stock_poubelle\\').$stock_poubelle->photo);
                unlink(public_path('storage\trashImages\stock_poubelle\\').$stock_poubelle->photo );
            }
            $stock_poubelle->restore();
            return $this->handleResponse(new Stock_poubelleResource($stock_poubelle), 'stock poubelle supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $stock_poubelles= Stock_poubelle::onlyTrashed()->get();
        foreach($stock_poubelles as $stock_poubelle){
            if($stock_poubelle->photo ==="default.jpeg" || $stock_poubelle->photo === NULL){
                $stock_poubelle->restore();
            } else{
                if(File::exists(('storage\trashImages\stock_poubelle\\').$stock_poubelle->photo)){
                    File::copy(public_path('storage\trashImages\stock_poubelle\\').$stock_poubelle->photo,
                    public_path('storage\images\stock_poubelle\\').$stock_poubelle->photo);
                    unlink(public_path('storage\trashImages\stock_poubelle\\').$stock_poubelle->photo );
                }
                $stock_poubelle->restore();
            }
        }
        return $this->handleResponse(Stock_poubelleResource::collection($stock_poubelles), 'tous stock poubelles  trashed');
    }
    public function listeSuppression(){
        $stock_poubelle = Stock_poubelle::onlyTrashed()->get();
        return $this->handleResponse(Stock_poubelleResource::collection($stock_poubelle), 'affichage des stock poubelles ');
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
    public function exportInfoExcel(){
        return Excel::download(new Stock_poubelleExport  , 'stock-poubelle-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new Stock_poubelleExport, 'stock-poubelle-liste.csv');
    }
    public function pdf($id){
        $stock_poubelle = Stock_poubelle::find($id);
        if (is_null($stock_poubelle)) {
            return $this->handleError('stock poubelle n\'existe pas!');
        }else{
            $data= collect(Stock_poubelle::getStockPoubelleById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "type_poubelle" => $data[0]['type_poubelle'],
                "quantite_disponible" => $data[0]['quantite_disponible'],
                "description" => $data[0]['description'],
                "photo" => $data[0]['photo'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/ProductionPoubelle/stockPoubelle', $liste);
            return $pdf->download('stock-poubelle.pdf');
        }
    }
    public function pdfAll(){
        $stock_poubelle = Stock_poubelle::all();
        if (is_null($stock_poubelle)) {
            return $this->handleError('stock poubelle n\'existe pas!');
        }else{
            $p= Stock_poubelleResource::collection( $stock_poubelle);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/ProductionPoubelle/stockPoubelle', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('stock-poubelle.pdf');
        }
    }
    public function pdfAllTrashed(){
        $stock_poubelle = Stock_poubelle::onlyTrashed()->get();
        if (is_null($stock_poubelle)) {
            return $this->handleError('stock poubelle n\'existe pas!');
        }else{
            $p= Stock_poubelleResource::collection( $stock_poubelle);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/ProductionPoubelle/stockPoubelle', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('stock-poubelle.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $stock_poubelle = Stock_poubelle::withTrashed()->where('id' ,  $id )->first();
        if (is_null($stock_poubelle)) {
            return $this->handleError('stock poubelle n\'existe pas!');
        }else{
                $data= collect(Stock_poubelle::getStockPoubelleByIdTrashed($id))->toArray();
                $liste = [
                    'id' => $data[0]['id'],
                    "type_poubelle" => $data[0]['type_poubelle'],
                    "quantite_disponible" => $data[0]['quantite_disponible'],
                    "description" => $data[0]['description'],
                    "photo" => $data[0]['photo'],
                    "created_at" => $data[0]['created_at'],
                    "updated_at" => $data[0]['updated_at'],
                    'deleted_at' => $data[0]['deleted_at'],
                ];
                $pdf = Pdf::loadView('pdf/Delete/unique/ProductionPoubelle/stockPoubelle', $liste);
                return $pdf->download('stock-poubelle.pdf');
            }
    }
}
