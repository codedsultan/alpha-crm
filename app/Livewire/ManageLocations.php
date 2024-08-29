<?php

namespace App\Livewire;

use App\Models\Location;
use Livewire\Component;
use Livewire\Attributes\Validate;

class ManageLocations extends Component
{

    private $locations;

    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public Location $location;
    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public $address = '';

    #[Validate('required')]
    public $telephone_number = '';

    #[Validate('required')]
    public $status = '';


    public $confirmingLocationAdd;
    // public $confirmLocationAdd = true;

    // public $confirmLocationDeletion  = false;
    public $confirmingLocationDeletion = false;

    // protected $rules = [
    //     "location.name" => "required|string|max:255",
    //     "location.address" => "required|string|max:255",
    //     "location.telephone_number" => "required|string|min_digits:10|max_digits:10",
    //     "location.status" => "required|boolean",
    // ];
    // protected $rules = [
    //     "name" => "required|string|max:255",
    //     "address" => "required|string|max:255",
    //     "telephone_number" => "required|string|min_digits:10|max_digits:10",
    //     "status" => "required|boolean",
    // ];
    public function mount(): void
    {
        $this->location = new Location();
    }
    public function render()
    {
        $this->locations = Location::when($this->search, function ($query) {
            $query->where('name', 'like', '%'.$this->search.'%');
        })->paginate(10);

        return view('livewire.manage-locations', [
            'locations' => $this->locations,
        ]);
    }

    public function confirmLocationEdit(Location $location) {
        $this->location = $location;
        $this->confirmingLocationAdd= true;
    }
    public function confirmLocationDeletion() {
        $this->confirmingLocationDeletion = true;
    }

    public function saveLocation() {
        $this->validate();

        if (isset($this->location->id)) {
            $this->location->save();
        } else {
            Location::create(
                [
                    'name' => $this->location['name'],
                    'address' => $this->location['address'],
                    'telephone_number' => $this->location['telephone_number'],
                    'status' => $this->location['status'],
                ]
            );
        }

        $this->confirmingLocationAdd = false;
        $this->location = null;
    }

    public function deleteLocation(Location $locationId) {
        $this->location = $locationId;
        $this->location->delete();
        $this->confirmingLocationDeletion = false;
    }

    public function confirmLocationAdd() {
        // dd('here');
        $this->confirmingLocationAdd = true;
        // dd($this->confirmingLocationAdd);
    }

}
