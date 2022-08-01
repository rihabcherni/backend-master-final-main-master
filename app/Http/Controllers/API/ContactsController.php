<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\Contact as ContactResources;
use App\Models\Contact;
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
}
