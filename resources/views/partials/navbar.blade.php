<nav class="bg-primary">
  <div class="flex items-center justify-between p-4">
    <!-- Logo / School Name -->
    <div class="text-lg font-semibold">
      Taboc Elementary School
    </div>

    <!-- Mobile Menu Button -->
    <button id="menu-btn" class="md:hidden" type="button" aria-controls="mobile-menu" aria-expanded="false">
      &#9776;
    </button>

    <!-- Desktop Menu -->
    <ul class="hidden md:flex space-x-6 text-sm">
      <li><a href="/" class="hover:underline">Home</a></li>
      <li><a href="/announcements" class="hover:underline">Announcements</a></li>
      <li><a href="/events" class="hover:underline">Events</a></li>
    </ul>
  </div>

  <!-- Mobile Menu -->
  <ul id="mobile-menu" class="hidden flex-col space-y-2 px-4 pb-4 text-sm md:hidden">
    <li><a href="/" class="hover:underline">Home</a></li>
    <li><a href="/announcements" class="hover:underline">Announcements</a></li>
    <li><a href="/events" class="hover:underline">Events</a></li>
  </ul>
</nav>
