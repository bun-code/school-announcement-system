<?php

namespace App\Livewire\Admin;

use App\Models\SiteSettings;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Site Settings')]
class SiteSettingsManager extends Component
{
    public string $hero_pill          = '';
    public string $hero_title_line1   = '';
    public string $hero_title_line2   = '';
    public string $hero_title_line3   = '';
    public string $hero_description   = '';
    public string $hero_cta_primary   = '';
    public string $hero_cta_secondary = '';

    public string $stats_students = '';
    public string $stats_teachers = '';
    public string $stats_years    = '';
    public string $stats_admins   = '';

    public string $school_head       = '';
    public string $school_head_title = '';
    public string $class_hours       = '';
    public string $school_location   = '';

    public string $footer_link_1_label = '';
    public string $footer_link_1_url   = '';
    public string $footer_link_2_label = '';
    public string $footer_link_2_url   = '';
    public string $footer_link_3_label = '';
    public string $footer_link_3_url   = '';
    public string $footer_link_4_label = '';
    public string $footer_link_4_url   = '';
    public string $footer_link_5_label = '';
    public string $footer_link_5_url   = '';

    public string $enrollment_info       = '';
    public string $academic_calendar_info = '';
    public string $curriculum_info       = '';
    public string $school_policies_info  = '';

    public string $activeTab = 'hero';

    public function mount(): void
    {
        $settings = SiteSettings::allAsArray();
        foreach ($settings as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value ?? '';
            }
        }

        $defaults = [
            // Hero defaults
            'hero_pill'          => 'S.Y. 2025-2026 Enrollment Now Open',
            'hero_title_line1'   => 'Where Every Child',
            'hero_title_line2'   => 'Learns, Grows',
            'hero_title_line3'   => '& Thrives',
            'hero_description'   => "Taboc Elementary School is committed to nurturing every learner's potential through quality, inclusive education grounded in Filipino values and excellence.",
            'hero_cta_primary'   => 'Latest Updates',
            'hero_cta_secondary' => 'About Our School',

            // Stats defaults
            'stats_students' => '500+',
            'stats_teachers' => '30+',
            'stats_years'    => '20+',
            'stats_admins'   => '2',

            // School info defaults
            'school_head'       => 'Mrs. [Principal Name]',
            'school_head_title' => 'Principal I',
            'class_hours'       => '7:30 AM - 5:00 PM',
            'school_location'   => 'Taboc, Philippines',

            // Footer link defaults
            'footer_link_1_label' => 'Home',
            'footer_link_1_url'   => '/',
            'footer_link_2_label' => 'Announcements',
            'footer_link_2_url'   => '/#announcements',
            'footer_link_3_label' => 'Events',
            'footer_link_3_url'   => '/#events',
            'footer_link_4_label' => 'Achievements',
            'footer_link_4_url'   => '/#achievements',
            'footer_link_5_label' => 'About Us',
            'footer_link_5_url'   => '/about',

            // School info defaults
            'enrollment_info'        => 'Visit the enrollment office or call us for more information on how to enroll your child at Taboc Elementary School.',
            'academic_calendar_info' => 'The academic calendar outlines all important dates including class opening, holidays, exam schedules, and graduation dates.',
            'curriculum_info'        => 'Our curriculum is guided by the DepEd Framework, providing a comprehensive, culturally-relevant education for all learners.',
            'school_policies_info'   => 'Our school policies are designed to create a safe, inclusive, and conducive learning environment for all students.',
        ];

        foreach ($defaults as $key => $value) {
            if (property_exists($this, $key) && $this->$key === '') {
                $this->$key = $value;
            }
        }
    }

    public function saveHero(): void
    {
        $this->validate([
            'hero_pill'          => 'required|string|max:100',
            'hero_title_line1'   => 'required|string|max:80',
            'hero_title_line2'   => 'required|string|max:80',
            'hero_title_line3'   => 'required|string|max:80',
            'hero_description'   => 'required|string|max:400',
            'hero_cta_primary'   => 'required|string|max:40',
            'hero_cta_secondary' => 'required|string|max:40',
        ]);

        foreach ([
            'hero_pill', 'hero_title_line1', 'hero_title_line2',
            'hero_title_line3', 'hero_description',
            'hero_cta_primary', 'hero_cta_secondary',
        ] as $key) {
            SiteSettings::set($key, $this->$key);
        }

        $this->dispatch('notify', type: 'success', message: 'Hero section saved!');
    }

    public function saveStats(): void
    {
        $this->validate([
            'stats_students' => 'required|string|max:20',
            'stats_teachers' => 'required|string|max:20',
            'stats_years'    => 'required|string|max:20',
            'stats_admins'   => 'required|string|max:20',
        ]);

        foreach (['stats_students', 'stats_teachers', 'stats_years', 'stats_admins'] as $key) {
            SiteSettings::set($key, $this->$key);
        }

        $this->dispatch('notify', type: 'success', message: 'Stats saved!');
    }

    public function saveSchoolInfo(): void
    {
        $this->validate([
            'school_head'       => 'required|string|max:100',
            'school_head_title' => 'required|string|max:60',
            'class_hours'       => 'required|string|max:60',
            'school_location'   => 'required|string|max:100',
        ]);

        foreach ([
            'school_head', 'school_head_title',
            'class_hours', 'school_location',
        ] as $key) {
            SiteSettings::set($key, $this->$key);
        }

        $this->dispatch('notify', type: 'success', message: 'School info saved!');
    }

    public function saveFooterLinks(): void
    {
        $this->validate([
            'footer_link_1_label' => 'nullable|string|max:60',
            'footer_link_1_url'   => 'nullable|string|max:255',
            'footer_link_2_label' => 'nullable|string|max:60',
            'footer_link_2_url'   => 'nullable|string|max:255',
            'footer_link_3_label' => 'nullable|string|max:60',
            'footer_link_3_url'   => 'nullable|string|max:255',
            'footer_link_4_label' => 'nullable|string|max:60',
            'footer_link_4_url'   => 'nullable|string|max:255',
            'footer_link_5_label' => 'nullable|string|max:60',
            'footer_link_5_url'   => 'nullable|string|max:255',
        ]);

        foreach ([
            'footer_link_1_label', 'footer_link_1_url',
            'footer_link_2_label', 'footer_link_2_url',
            'footer_link_3_label', 'footer_link_3_url',
            'footer_link_4_label', 'footer_link_4_url',
            'footer_link_5_label', 'footer_link_5_url',
        ] as $key) {
            SiteSettings::set($key, $this->$key);
        }

        $this->dispatch('notify', type: 'success', message: 'Footer links saved!');
    }

    public function saveSchoolDirectory(): void
    {
        $this->validate([
            'enrollment_info'        => 'required|string|max:2000',
            'academic_calendar_info' => 'required|string|max:2000',
            'curriculum_info'        => 'required|string|max:2000',
            'school_policies_info'   => 'required|string|max:2000',
        ]);

        foreach ([
            'enrollment_info',
            'academic_calendar_info',
            'curriculum_info',
            'school_policies_info',
        ] as $key) {
            SiteSettings::set($key, $this->$key);
        }

        $this->dispatch('notify', type: 'success', message: 'School directory info saved!');
    }

    public function render()
    {
        return view('livewire.admin.site-settings')
            ->layoutData([
                'breadcrumb'   => 'Settings',
                'pageTitle'    => 'Settings',
                'pageSubtitle' => 'Manage homepage content, school info, and site links.',
            ]);
    }
}