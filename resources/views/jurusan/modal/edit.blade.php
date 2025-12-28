<!-- Modal Edit jurusan-->
@foreach ($jurusans as $item)
    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Jurusan "{{ $item->nama }}"</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditJurusan{{ $item->id }}" class="row g-3" action="{{ route('datajurusan.update', $item->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input class="form-control @error('namaupdate') is-invalid @enderror" type="text" id="floatingNama"
                                    name="namaupdate" value="{{ $item->nama }}" placeholder="Nama" required>
                                <label for="floatingNama">Nama</label>
                                @error('namaupdate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input class="form-control @error('deskripsiupdate') is-invalid @enderror" type="text" id="floatingNama"
                                    name="deskripsiupdate" value="{{ $item->deskripsi }}" placeholder="Deskripsi">
                                <label for="floatingNama">Deskripsi</label>
                                @error('deskripsiupdate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
<!-- End Modal Edit jurusan-->
