<?php
namespace App\Http\Controllers\Internaute;

use App\Exports\ContactExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\Contact as ContactResources;
use App\Models\Contact;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class ContactsController extends BaseController{
    public function index(){
        $contact = Contact::all();
        return $this->handleResponse(ContactResources::collection($contact), 'Affichage des contacts');
    }
    public function store(ContactRequest $request){
        $input = $request->all();
        $contact = Contact::create($input);
        return $this->handleResponse(new ContactResources($contact), 'contact crée!');
    }
    public function show($id){
        $contact = Contact::find($id);
        if (is_null($contact)) {
            return $this->handleError('contact n\'existe pas!');
        }else{
            return $this->handleResponse(new ContactResources($contact), 'contact existe.');
        }
    }
    public function update(ContactRequest $request, Contact $contact){
        $input = $request->all();
        $contact->update($input);
        return $this->handleResponse(new ContactResources($contact), ' contact modifié!');
    }
    public function destroy($id){
        $contact =Contact::find($id);
        if (is_null($contact)) {
            return $this->handleError('contact n\'existe pas!');
        }
        else{
            $contact->delete();
            return $this->handleResponse(new ContactResources($contact),'contact supprimé!');
        }
    }

    public function exportInfoContactExcel(){
        return Excel::download(new ContactExport  , 'contact-liste.xlsx');
    }

    public function exportInfoContactCSV(){
        return Excel::download(new ContactExport, 'contact-liste.csv');
    }
    public function pdfContact($id){
        $contact = Contact::find($id);
        if (is_null($contact)) {
            return $this->handleError('contact n\'existe pas!');
        }else{
            $data= collect(Contact::getContactById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "nom"=> $data[0]['nom'],
                "prenom"=> $data[0]['prenom'],
                "email"=> $data[0]['email'],
                "numero_telephone"=> $data[0]['numero_telephone'],
                "message"=> $data[0]['message'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/contact', $liste);
            return $pdf->download('contact.pdf');
        }
    }
    public function pdfAllContact(){
        $contact = Contact::all();
        if (is_null($contact)) {
            return $this->handleError('Contact n\'existe pas!');
        }else{
            $p= ContactResources::collection( $contact);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/Contact', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('contact.pdf');
        }
    }
}
