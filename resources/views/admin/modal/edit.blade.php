<!-- Modal Edit Siswa-->
@foreach ($alladmins as $item)
    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditAdmin{{ $item->id }}" class="row g-3"
                        action="{{ route('dataadmin.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input class="form-control @error('namaupdate') is-invalid @enderror" type="text"
                                    id="floatingNama" name="namaupdate" value="{{ $item->nama }}" placeholder="Nama"
                                    required>
                                <label for="floatingNama">Nama</label>
                                @error('namaupdate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input class="form-control @error('usernameupdate') is-invalid @enderror" type="text"
                                    id="floatingNis" name="usernameupdate" value="{{ $item->username }}" placeholder="Username"
                                    required>
                                <label for="floatingNis">Username</label>
                                @error('usernameupdate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input class="form-control @error('nohpupdate') is-invalid @enderror" type="text"
                                    id="floatingNoHP" name="nohpupdate" value="{{ $item->nohp }}"
                                    placeholder="No HP" required>
                                <label for="floatingNoHP">No HP</label>
                                @error('nohpupdate')
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
<!-- End Modal Edit Siswa-->
