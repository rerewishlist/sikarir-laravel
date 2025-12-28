<!-- Modal Tambah Siswa-->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Siswa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahSiswa" class="row g-3" action="{{ route('datasiswa.store') }}" method="POST">
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
                            <input class="form-control @error('nis') is-invalid @enderror" type="text"
                                id="floatingNis" name="nis" value="{{ old('nis') }}" placeholder="NIS" required>
                            <label for="floatingNis">NIS</label>
                            @error('nis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-select @error('level') is-invalid @enderror" id="floatingSelect"
                                aria-label="Level" name="level" placeholder="Level" required>
                                <option value="siswa" {{ old('level') == 'siswa' ? 'selected' : '' }} selected>
                                    Siswa</option>
                            </select>
                            <label for="floatingSelect">Level</label>
                            @error('level')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-12">
                        <div class="form-floating">
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                id="floatingPassword" name="password" value="{{ old('password') }}"
                                placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select @error('jurusan_id') is-invalid @enderror"
                                id="floatingSelectJurusan" aria-label="Jurusan" name="jurusan_id" placeholder="Jurusan"
                                required>
                                <option value="" disabled selected>Pilih Jurusan</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}"
                                        {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                        {{ $jurusan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="floatingSelectJurusan">Jurusan</label>
                            @error('jurusan_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select @error('kelas') is-invalid @enderror" id="floatingSelectKelas"
                                aria-label="Kelas" name="kelas" placeholder="Kelas" required>
                                <option value="kelas" disabled selected>Kelas</option>
                                <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>10</option>
                                <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>11</option>
                                <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>12</option>
                            </select>
                            <label for="floatingSelectKelas">Kelas</label>
                            @error('kelas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select @error('subkelas') is-invalid @enderror"
                                id="floatingSelectSubkelas" aria-label="Subkelas" name="subkelas" placeholder="Kelas"
                                required>
                                <option value="Subkelas" disabled selected>Subkelas</option>
                                <option value="A" {{ old('subkelas') == 'A' ? 'selected' : '' }}>A
                                </option>
                                <option value="B" {{ old('subkelas') == 'B' ? 'selected' : '' }}>B
                                </option>
                                <option value="C" {{ old('subkelas') == 'C' ? 'selected' : '' }}>C
                                </option>
                            </select>
                            <label for="floatingSelectSubkelas">Subkelas</label>
                            @error('subkelas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                id="floatingSelectJenisKelamin" aria-label="Jenis Kelamin" name="jenis_kelamin"
                                placeholder="Kelas" required>
                                <option value="Jenis Kelamin" disabled selected>Jenis Kelamin
                                </option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>L
                                </option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>P
                                </option>
                            </select>
                            <label for="floatingSelectJenisKelamin">Jenis Kelamin</label>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input class="form-control @error('tempat_lahir') is-invalid @enderror" type="text"
                                id="floatingTempatLahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                placeholder="Tempat Lahir" required>
                            <label for="floatingTempatLahir">Tempat Lahir</label>
                            @error('tempat_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input class="form-control @error('tanggal_lahir') is-invalid @enderror" type="date"
                                id="floatingTanggalLahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                placeholder="Tanggal Lahir" required>
                            <label for="floatingTanggalLahir">Tanggal Lahir</label>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="floatingAlamat" name="alamat"
                                placeholder="Alamat" required>{{ old('alamat') }}</textarea>
                            <label for="floatingAlamat">Alamat</label>
                            @error('alamat')
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
