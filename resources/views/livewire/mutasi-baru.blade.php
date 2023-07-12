 <div>
  @if (!$showTY)
  <form wire:submit.prevent="submit">
    {{ $this->form }}
    <button type="submit" class="w-full bg-blue-500 text-white rounded-md mt-3 py-2.5">Kirim</button>
</form>
  @else
    <div>
      <h3 class="border border-gray-300 rounded-lg shadow-sm p-4">Terima kasih telah mengisi formulir.</h3>
      {{-- <button wire:click="showTY" class="w-full bg-blue-500 text-white rounded-md mt-3 py-2.5">Isi Formulir Kembali</button> --}}
    </div>  
  @endif
  </div>