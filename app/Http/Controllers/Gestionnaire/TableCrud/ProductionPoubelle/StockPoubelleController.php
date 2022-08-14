<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\ProductionPoubelle;
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
    public function exportInfoClientDechetExcel(){
        return Excel::download(new ClientDechetExport  , 'client-dechet-liste.xlsx');
    }

    public function exportInfoClientDechetCSV(){
        return Excel::download(new ClientDechetExport, 'client-dechet-liste.csv');
    }

    public function pdfClientDechet($id){
        $client = Client_dechet::find($id);
        if (is_null($client)) {
            return $this->handleError('client n\'existe pas!');
        }else{
            $data= collect(Client_dechet::getClientDechetById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                'poubelle_id_resp' =>   $data[0]['poubelle_id_resp'],

                "etablissement" => $data[0]['etablissement'],
                "etablissement_id" =>  $data[0]['etablissement_id'],
                "nom" => $data[0]['nom'],
                "nom_poubelle_responsable" => $data[0]['nom_poubelle_responsable'],
                "type" => $data[0]['type'],
                "Etat" => $data[0]['Etat'],
                "quantite" => $data[0]['quantite'],
                "bloc_poubelle_id" => $data[0]['bloc_poubelle_id'],
                "bloc_poubelle_id_resp" => $data[0]['bloc_poubelle_id_resp'],
                "bloc_etablissement" => $data[0]['bloc_etablissement'],
                "bloc_etablissement_id" => $data[0]['bloc_etablissement_id'],

                "etage" => $data[0]['etage'],
                "etage_id" => $data[0]['etage_id'],
                "qrcode" => $data[0]['qrcode'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/GestionCompte/clientDechet', $liste);
            return $pdf->download('client-dechet.pdf');
        }
    }
    public function pdfAllClientDechet(){
        $client = Client_dechet::all();
        if (is_null($client)) {
            return $this->handleError('client dechet n\'existe pas!');
        }else{
            $p= Client_dechetResource::collection( $client);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionCompte/clientDechet', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('client-dechet.pdf');
        }
    }
}
