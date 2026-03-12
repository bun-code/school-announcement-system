<?php

namespace App\Livewire\Admin;

use App\Models\Faculty;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Title('Faculty & Staff')]
class FacultyManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $type = '';
    public string $sort = 'latest';

    public bool $showCreateModal = false;
    public bool $showDeleteModal = false;
    public ?int $deleteId = null;

    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone = '';
    public string $position = '';
    public string $faculty_type = 'teaching';
    public string $subject = '';
    public string $grade_handled = '';
    public bool $show_on_site = true;

    protected $rules = [
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'email' => 'nullable|email|max:100',
        'phone' => 'nullable|string|max:20',
        'position' => 'required|string|max:100',
        'faculty_type' => 'required|in:teaching,non-teaching,administrative',
        'subject' => 'nullable|string|max:100',
        'grade_handled' => 'nullable|string|max:100',
    ];

    #[Computed]
    public function stats()
    {
        return [
            'total' => Faculty::count(),
            'teaching' => Faculty::where('type', 'teaching')->count(),
            'non_teaching' => Faculty::where('type', 'non-teaching')->count(),
            'active' => Faculty::where('status', 'active')->count(),
        ];
    }

    #[Computed]
    public function faculty()
    {
        $query = Faculty::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', "%{$this->search}%")
                  ->orWhere('last_name', 'like', "%{$this->search}%")
                  ->orWhere('position', 'like', "%{$this->search}%");
            });
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        if ($this->sort === 'latest') {
            $query->latest();
        } elseif ($this->sort === 'name') {
            $query->orderBy('last_name')->orderBy('first_name');
        }

        return $query->paginate(15);
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function openDeleteModal($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function saveFaculty()
    {
        $this->validate();

        Faculty::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'position' => $this->position,
            'type' => $this->faculty_type,
            'subject' => $this->subject,
            'grade_handled' => $this->grade_handled,
            'show_on_site' => $this->show_on_site,
            'status' => 'active',
        ]);

        $this->dispatch('notify', type: 'success', message: 'Faculty member added successfully!');
        $this->closeCreateModal();
        $this->resetPage();
    }

    public function deleteFaculty()
    {
        if ($this->deleteId) {
            Faculty::find($this->deleteId)?->delete();
            $this->dispatch('notify', type: 'success', message: 'Faculty member deleted successfully!');
        }
        $this->closeDeleteModal();
    }

    public function resetForm()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->phone = '';
        $this->position = '';
        $this->faculty_type = 'teaching';
        $this->subject = '';
        $this->grade_handled = '';
        $this->show_on_site = true;
    }

    public function render()
      {
          return view('livewire.admin.faculty-manager');
      }
}
