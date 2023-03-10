<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Vendor;

use function PHPUnit\Framework\isNull;

class ContactService
{
    protected $errorNotifier;
    protected $settingService;

    public $paginatedList = true;

    public function __construct()
    {
        $this->errorNotifier = new ErrorNotifierService();
        $this->settingService = new SettingService();
    }

    public function lists($data = null)
    {
        $search_query = [];

        $order = $this->settingService->get("data_order", "desc") ?? "desc";

        $query = Contact::query();

        if (isset($data["search"])) {

            $search_query = [
                "search" => $data["search"]
            ];

            $query->where(function ($q) use ($data) {
                $q->orWhere("first_name", "LIKE", "%" . $data["search"] . "%");
                $q->orWhere("middle_name", "LIKE", "%" . $data["search"] . "%");
                $q->orWhere("last_name", "LIKE", "%" . $data["search"] . "%");
                $q->orWhere("code", "=", $data["search"] . "%");
            });
        }

        $query->orderBy('id', $order);

        if ($this->paginatedList === true) {

            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;

            $contacts = $query->paginate($item_per_page)->appends($search_query);
            $contacts->pagination_summary = get_pagination_summary($contacts);
        } else {
            $contacts = $query->get();
        }

        return $contacts;
    }

    public function updateOrCreate($data, $contact=null)
    {
        if(empty($data["id"])){
            //create, use all Models above that uses Contact:
            $contact = new Contact();
            if($data['contactable_type'] == 'Vendor'){
                $contactableModel = Vendor::findOrFail($data['contactable_id']);
            }
        }

        if (isset($data['contact_person'])) {
            $contact->contact_person = $data['contact_person'];
        }

        if (isset($data['contact_email'])) {
            $contact->contact_email = $data['contact_email'];
        }

        if (isset($data['contact_phone'])) {
            $contact->contact_phone = $data['contact_phone'];
        }

        if (isset($data['position'])) {
            $contact->position = $data['position'];
        }

        if (isset($data['is_default'])) {
            $contact->is_default = $data['is_default'];
        }
        // Save contact depending on create or update action:
        if(empty($data["id"])){
            return $contactableModel->contacts()->save($contact) ? $contact : null;
        } else {
            return $contact->save() ? $contact : null;
        }
    }

    public function getById($id)
    {
        return Contact::find($id);
    }

    public function delete($contact)
    {
        return $contact->delete();
    }
}
