<div class="col-lg-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambah Kategori Baru</h5>

            <!-- Form Tambah Kategori -->
            <form class="row g-3 needs-validation" method="post" action="{{ route('datakategori.store') }}">
                @csrf
                <div class="col-md-12">
                    <label for="Name" class="form-label">Nama</label>
                    <div class="input-group has-validation">
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                            placeholder="Masukan nama kategori" id="Name" required>
                        @error('nama')
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
            </form><!-- End Form Tambah Kategori -->

        </div>
    </div>
</div>
