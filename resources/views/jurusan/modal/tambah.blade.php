<div class="col-lg-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambah Jurusan Baru</h5>

            <!-- Form Tambah jurusan -->
            <form class="row g-3 needs-validation" method="post" action="{{ route('datajurusan.store') }}">
                @csrf
                <div class="col-md-12">
                    <label for="Name" class="form-label">Nama</label>
                    <div class="input-group has-validation">
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                            placeholder="Masukan nama jurusan" id="Name" value="{{ old('deskripsi') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="Name" class="form-label">Deskripsi</label>
                    <div class="input-group has-validation">
                        <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                            placeholder="Masukan deskripsi" id="Name" value="{{ old('deskripsi') }}">
                        @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="text-left">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form><!-- End Form Tambah jurusan -->

        </div>
    </div>
</div>
