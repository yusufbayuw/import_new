
<div class="min-h-full">
    <nav class="bg-gray-800">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <a href="#" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Taruna Bakti x Mandiri InHealth</a>
              </div>
            </div>
          </div>
          
        </div>
      </div>
  
      <!-- Mobile menu, show/hide based on menu state. -->
      <div class="md:hidden" id="mobile-menu">
        <div class="border-t border-gray-700 pt-4 pb-3">
          <div class="flex items-center px-5">
            <a href="#" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Taruna Bakti x Mandiri InHealth</a>
          </div>
        </div>
      </div>
    </nav>
  
    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Form Mutasi Mandiri InHealth</h1>
      </div>
    </header>
    <main>
      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
@if ($aktif)
@livewire('mutasi-baru')
@else
<h1 class="text-2xl font-bold text-red-900">Form Inhealth Sedang Ditutup</h1>
<h2 class="text-xl text-gray-900">Silakan menghubungi administrator.</h2>
<script>
        setTimeout(function() {
            window.location.href = "https://tarunabakti.or.id";
        }, 5000);
    </script>
@endif
      </div>
    </main>
  </div>
  
