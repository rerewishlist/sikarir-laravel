<!-- Modal Edit Siswa-->
@foreach ($users as $item)
    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditSiswa{{ $item->id }}" class="row g-3"
                        action="{{ route('datasiswa.update', $item->id) }}" method="POST">
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
                                <input class="form-control @error('nisupdate') is-invalid @enderror" type="text"
                                    id="floatingNis" name="nisupdate" value="{{ $item->nis }}" placeholder="NIS"
                                    required>
                                <label for="floatingNis">NIS</label>
                                @error('nisupdate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select @error('levelupdate') is-invalid @enderror"
                                    id="floatingSelect" aria-label="Level" name="levelupdate" placeholder="Level"
                                    required>
                                    <option value="siswa" {{ $item->level == 'siswa' ? 'selected' : '' }} selected>
                                        Siswa</option>

                                </select>
                                <label for="floatingSelect">Level</label>
                                @error('levelupdate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelectJurusan" aria-label="Jurusan"
                                    name="jurusan_idupdate" required>
                                    @foreach ($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}"
                                            {{ $item->jurusan_id == $jurusan->id ? 'selected' : '' }}>
                                            {{ $jurusan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="floatingSelectJurusan">Jurusan</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelectKelas" aria-label="Kelas"
                                    name="kelasupdate" required>
                                    <option value="10" {{ $item->kelas == '10' ? 'selected' : '' }}>10
                                    </option>
                                    <option value="11" {{ $item->kelas == '11' ? 'selected' : '' }}>11
                                    </option>
                                    <option value="12" {{ $item->kelas == '12' ? 'selected' : '' }}>12
                                    </option>
                                </select>
                                <label for="floatingSelectKelas">Kelas</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelectSubkelas" aria-label="Subkelas"
                                    name="subkelasupdate" required>
                                    <option value="A" {{ $item->subkelas == 'A' ? 'selected' : '' }}>A
                                    </option>
                                    <option value="B" {{ $item->subkelas == 'B' ? 'selected' : '' }}>B
                                    </option>
                                    <option value="C" {{ $item->subkelas == 'C' ? 'selected' : '' }}>C
                                    </option>
                                </select>
                                <label for="floatingSelectSubkelas">Subkelas</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelectJenisKelamin" aria-label="Jenis Kelamin"
                                    name="jenis_kelaminupdate" required>
                                    <option value="L" {{ $item->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                        L
                                    </option>
                                    <option value="P" {{ $item->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                        P
                                    </option>
                                </select>
                                <label for="floatingSelectJenisKelamin">Jenis Kelamin</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input class="form-control @error('tempat_lahirupdate') is-invalid @enderror"
                                    type="text" id="floatingTempatLahir" name="tempat_lahirupdate"
                                    value="{{ $item->tempat_lahir }}" placeholder="Tempat Lahir" required>
                                <label for="floatingTempatLahir">Tempat Lahir</label>
                                @error('tempat_lahirupdate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input class="form-control @error('tanggal_lahirupdate') is-invalid @enderror"
                                    type="date" id="floatingTanggalLahir" name="tanggal_lahirupdate"
                                    value="{{ $item->tanggal_lahir }}" placeholder="Tanggal Lahir" required>
                                <label for="floatingTanggalLahir">Tanggal Lahir</label>
                                @error('tanggal_lahirupdate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <textarea class="form-control @error('alamatupdate') is-invalid @enderror" id="floatingAlamat" name="alamatupdate"
                                    placeholder="Alamat" required>{{ $item->alamat }}</textarea>
                                <label for="floatingAlamat">Alamat</label>
                                @error('alamatupdate')
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
