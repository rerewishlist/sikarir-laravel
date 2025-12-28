<!-- Modal Tambah Siswa-->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Admin Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahAdmin" class="row g-3" action="{{ route('dataadmin.store') }}" method="POST">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input class="form-control @error('nama') is-invalid @enderror" type="text"
                                id="floatingNama" name="nama" value="{{ old('nama') }}" placeholder="Nama"
                                required>
                            <label for="floatingNama">Nama</label>
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control @error('username') is-invalid @enderror" type="text"
                                id="floatingNis" name="username" value="{{ old('username') }}" placeholder="Username" required>
                            <label for="floatingNis">Username</label>
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control @error('nohp') is-invalid @enderror" type="text"
                                id="floatingNoHP" name="nohp" value="{{ old('nohp') }}" placeholder="No HP"
                                required>
                            <label for="floatingNoHP">No HP</label>
                            @error('nohp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Tambah Siswa-->
