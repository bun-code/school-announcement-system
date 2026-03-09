<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;

#[Layout('layouts.admin')]
#[Title('Events & Calendar')]
class EventManager extends Component
{
    use WithPagination;

    // ── Filters ──────────────────────────────────────────────
    public string $search   = '';
    public string $category = '';

    // ── Calendar navigation ──────────────────────────────────
    public int $calYear;
    public int $calMonth;

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

    #[Validate('nullable|string')]
    public string $description = '';

    #[Validate('required|in:Academic,Sports,Cultural,Program,Community,Health')]
    public string $formCategory = '';

    #[Validate('required|date')]
    public string $eventDate = '';

    #[Validate('nullable|date')]
    public string $endDate = '';

    #[Validate('nullable|date_format:H:i')]
    public string $startTime = '';

    #[Validate('nullable|date_format:H:i')]
    public string $endTime = '';

    #[Validate('nullable|string|max:255')]
    public string $location = '';

    public string $formStatus = 'upcoming';

    // ─────────────────────────────────────────
    //  Mount
    // ─────────────────────────────────────────

    public function mount(): void
    {
        $this->calYear  = now()->year;
        $this->calMonth = now()->month;
    }

    // ─────────────────────────────────────────
    //  Reset pagination on filter change
    // ─────────────────────────────────────────

    public function updatingSearch():   void { $this->resetPage(); }
    public function updatingCategory(): void { $this->resetPage(); }

    // ─────────────────────────────────────────
    //  Calendar navigation
    // ─────────────────────────────────────────

    public function prevMonth(): void
    {
        if ($this->calMonth === 1) {
            $this->calMonth = 12;
            $this->calYear--;
        } else {
            $this->calMonth--;
        }
    }

    public function nextMonth(): void
    {
        if ($this->calMonth === 12) {
            $this->calMonth = 1;
            $this->calYear++;
        } else {
            $this->calMonth++;
        }
    }

    // ─────────────────────────────────────────
    //  Computed: events list (paginated)
    // ─────────────────────────────────────────

    #[Computed]
    public function events()
    {
        return Event::query()
            ->when($this->search, fn($q) =>
                $q->where(fn($q2) =>
                    $q2->where('title',    'like', "%{$this->search}%")
                       ->orWhere('location','like', "%{$this->search}%")
                )
            )
            ->when($this->category, fn($q) => $q->where('category', $this->category))
            ->orderBy('event_date')
            ->paginate(10);
    }

    // ─────────────────────────────────────────
    //  Computed: calendar events for current month
    // ─────────────────────────────────────────

    #[Computed]
    public function calendarEvents(): array
    {
        return Event::inMonth($this->calYear, $this->calMonth)
            ->get(['id', 'title', 'event_date', 'category'])
            ->groupBy(fn($e) => $e->event_date->day)
            ->toArray();
    }

    // ─────────────────────────────────────────
    //  Computed: calendar grid days
    // ─────────────────────────────────────────

    #[Computed]
    public function calendarGrid(): array
    {
        $firstDay   = mktime(0, 0, 0, $this->calMonth, 1, $this->calYear);
        $startBlank = (int) date('w', $firstDay); // 0=Sun
        $daysInMonth = (int) date('t', $firstDay);

        return [
            'blanks'      => $startBlank,
            'days'        => $daysInMonth,
            'monthName'   => date('F Y', $firstDay),
            'today'       => (now()->month === $this->calMonth && now()->year === $this->calYear)
                                ? now()->day : null,
        ];
    }

    // ─────────────────────────────────────────
    //  Computed: category summary
    // ─────────────────────────────────────────

    #[Computed]
    public function categorySummary()
    {
        return Event::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');
    }

    // ═════════════════════════════════════════
    //  CREATE
    // ═════════════════════════════════════════

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->eventDate  = now()->format('Y-m-d');
        $this->formStatus = 'upcoming';
        $this->showCreateModal = true;
    }

    public function save(): void
    {
        $this->validate();

        Event::create([
            'title'       => $this->title,
            'description' => $this->description ?: null,
            'category'    => $this->formCategory,
            'event_date'  => $this->eventDate,
            'end_date'    => $this->endDate    ?: null,
            'start_time'  => $this->startTime  ?: null,
            'end_time'    => $this->endTime    ?: null,
            'location'    => $this->location   ?: null,
            'status'      => $this->formStatus,
        ]);

        $this->showCreateModal = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Event added to the calendar.']);
    }

    // ═════════════════════════════════════════
    //  EDIT
    // ═════════════════════════════════════════

    public function openEditModal(int $id): void
    {
        $event = Event::findOrFail($id);

        $this->editingId     = $id;
        $this->title         = $event->title;
        $this->description   = $event->description ?? '';
        $this->formCategory  = $event->category;
        $this->eventDate     = $event->event_date->format('Y-m-d');
        $this->endDate       = $event->end_date?->format('Y-m-d') ?? '';
        $this->startTime     = $event->start_time ?? '';
        $this->endTime       = $event->end_time   ?? '';
        $this->location      = $event->location   ?? '';
        $this->formStatus    = $event->status;

        $this->showEditModal = true;
    }

    public function update(): void
    {
        $this->validate();

        Event::findOrFail($this->editingId)->update([
            'title'       => $this->title,
            'description' => $this->description ?: null,
            'category'    => $this->formCategory,
            'event_date'  => $this->eventDate,
            'end_date'    => $this->endDate    ?: null,
            'start_time'  => $this->startTime  ?: null,
            'end_time'    => $this->endTime    ?: null,
            'location'    => $this->location   ?: null,
            'status'      => $this->formStatus,
        ]);

        $this->showEditModal = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Event updated successfully.']);
    }

    // ═════════════════════════════════════════
    //  DELETE
    // ═════════════════════════════════════════

    public function openDeleteModal(int $id): void
    {
        $this->deletingId    = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        Event::findOrFail($this->deletingId)->delete();

        $this->showDeleteModal = false;
        $this->deletingId      = null;
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Event removed from calendar.']);
    }

    // ═════════════════════════════════════════
    //  HELPERS
    // ═════════════════════════════════════════

    private function resetForm(): void
    {
        $this->reset([
            'title', 'description', 'formCategory', 'formStatus',
            'eventDate', 'endDate', 'startTime', 'endTime',
            'location', 'editingId',
        ]);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.event-manager');
    }
}