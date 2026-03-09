<?php

namespace App\Livewire\Admin;

use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;

#[Layout('layouts.admin')]
#[Title('Announcements')]
class AnnouncementManager extends Component
{
    use WithPagination;

    // ── Search & filter ──────────────────────────────────────
    public string $search   = '';
    public string $category = '';
    public string $status   = '';

    // ── Sorting ──────────────────────────────────────────────
    public string $sortBy  = 'post_date';
    public string $sortDir = 'desc';

    // ── Bulk select ──────────────────────────────────────────
    public array $selected    = [];
    public bool  $selectAll   = false;

    // ── Modal state ──────────────────────────────────────────
    public bool $showCreateModal = false;
    public bool $showEditModal   = false;
    public bool $showDeleteModal = false;

    // ── Editing target ───────────────────────────────────────
    public ?int $editingId  = null;
    public ?int $deletingId = null;

    // ── Form fields ──────────────────────────────────────────
    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string')]
    public string $body = '';

    #[Validate('required|in:General,Academic,Notice,Health,Community')]
    public string $formCategory = '';

    #[Validate('required|in:published,draft')]
    public string $formStatus = 'draft';

    #[Validate('required|date')]
    public string $postDate = '';

    #[Validate('nullable|date')]
    public string $expiryDate = '';

    public bool $isPinned = false;

    // ── Reset pagination when filters change ─────────────────
    public function updatingSearch():   void { $this->resetPage(); }
    public function updatingCategory(): void { $this->resetPage(); }
    public function updatingStatus():   void { $this->resetPage(); }

    // ── Reset selected when page changes ─────────────────────
    public function updatedPage(): void
    {
        $this->selected  = [];
        $this->selectAll = false;
    }

    // ── Sorting ──────────────────────────────────────────────
    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy  = $column;
            $this->sortDir = 'asc';
        }
    }

    // ── Select all on current page ───────────────────────────
    public function updatedSelectAll(bool $value): void
    {
        $this->selected = $value
            ? $this->announcements->pluck('id')->map(fn($id) => (string) $id)->toArray()
            : [];
    }

    // ── Stats (computed, cached per render) ──────────────────
    #[Computed]
    public function stats(): array
    {
        return [
            'total'     => Announcement::count(),
            'published' => Announcement::published()->count(),
            'draft'     => Announcement::draft()->count(),
            'pinned'    => Announcement::pinned()->count(),
        ];
    }

    // ── Paginated announcements ───────────────────────────────
    #[Computed]
    public function announcements()
    {
        return Announcement::with('author')
            ->when($this->search, fn($q) =>
                $q->where(fn($q2) =>
                    $q2->where('title', 'like', "%{$this->search}%")
                       ->orWhere('body',  'like', "%{$this->search}%")
                )
            )
            ->when($this->category, fn($q) => $q->where('category', $this->category))
            ->when($this->status,   fn($q) => $q->where('status',   $this->status))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(10);
    }

    // ════════════════════════════════════════
    //  CREATE
    // ════════════════════════════════════════

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->postDate    = now()->format('Y-m-d');
        $this->formStatus  = 'draft';
        $this->showCreateModal = true;
    }

    public function save(string $action = 'draft'): void
    {
        $this->validate();

        Announcement::create([
            'title'       => $this->title,
            'body'        => $this->body,
            'category'    => $this->formCategory,
            'status'      => $action === 'publish' ? 'published' : 'draft',
            'is_pinned'   => $this->isPinned,
            'post_date'   => $this->postDate,
            'expiry_date' => $this->expiryDate ?: null,
            'author_id'   => Auth::id(),
        ]);

        $this->showCreateModal = false;
        $this->resetForm();
        $this->dispatch('notify', [
            'type'    => 'success',
            'message' => 'Announcement ' . ($action === 'publish' ? 'published' : 'saved as draft') . ' successfully.',
        ]);
    }

    // ════════════════════════════════════════
    //  EDIT
    // ════════════════════════════════════════

    public function openEditModal(int $id): void
    {
        $ann = Announcement::findOrFail($id);

        $this->editingId    = $id;
        $this->title        = $ann->title;
        $this->body         = $ann->body;
        $this->formCategory = $ann->category;
        $this->formStatus   = $ann->status;
        $this->isPinned     = $ann->is_pinned;
        $this->postDate     = $ann->post_date->format('Y-m-d');
        $this->expiryDate   = $ann->expiry_date?->format('Y-m-d') ?? '';

        $this->showEditModal = true;
    }

    public function update(): void
    {
        $this->validate();

        Announcement::findOrFail($this->editingId)->update([
            'title'       => $this->title,
            'body'        => $this->body,
            'category'    => $this->formCategory,
            'status'      => $this->formStatus,
            'is_pinned'   => $this->isPinned,
            'post_date'   => $this->postDate,
            'expiry_date' => $this->expiryDate ?: null,
        ]);

        $this->showEditModal = false;
        $this->resetForm();
        $this->dispatch('notify', [
            'type'    => 'success',
            'message' => 'Announcement updated successfully.',
        ]);
    }

    // ════════════════════════════════════════
    //  DELETE
    // ════════════════════════════════════════

    public function openDeleteModal(int $id): void
    {
        $this->deletingId    = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        Announcement::findOrFail($this->deletingId)->delete();

        $this->showDeleteModal = false;
        $this->deletingId      = null;
        $this->selected        = array_filter($this->selected, fn($id) => (int)$id !== $this->deletingId);

        $this->dispatch('notify', [
            'type'    => 'success',
            'message' => 'Announcement deleted.',
        ]);
    }

    // ════════════════════════════════════════
    //  BULK DELETE
    // ════════════════════════════════════════

    public function bulkDelete(): void
    {
        if (empty($this->selected)) return;

        $count = count($this->selected);
        Announcement::whereIn('id', $this->selected)->delete();

        $this->selected  = [];
        $this->selectAll = false;

        $this->dispatch('notify', [
            'type'    => 'success',
            'message' => "{$count} announcement" . ($count > 1 ? 's' : '') . ' deleted.',
        ]);
    }

    // ════════════════════════════════════════
    //  HELPERS
    // ════════════════════════════════════════

    private function resetForm(): void
    {
        $this->reset([
            'title', 'body', 'formCategory', 'formStatus',
            'isPinned', 'postDate', 'expiryDate', 'editingId',
        ]);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.announcement-manager');
    }
}