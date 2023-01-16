<button wire:click="edit({{$id}})" class="btn btn-xs btn-warning">Edit</button>
<button onclick="confirm('Konfirmasi! Apakah anda akan menghapus data?') || event.stopImmediatePropagation()"
        wire:click="delete({{$id}})" class="btn btn-xs btn-danger">Delete</button>