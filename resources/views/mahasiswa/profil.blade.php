@extends('layouts.mahasiswa')

@section('title', 'Profil Mahasiswa')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">

<div class="container py-5" style="min-height: 70vh;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="fw-bold mb-4"><i class="bi bi-person-vcard me-2 text-primary"></i>Data Diri Mahasiswa</h3>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    {{-- Foto Profil Section --}}
                    <div class="text-center mb-4">
                        @if($mahasiswa->foto_profil)
                            <img src="{{ asset('storage/' . $mahasiswa->foto_profil) }}" alt="Foto Profil" 
                                 class="rounded-circle mb-3 profil-clickable" 
                                 style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #dee2e6; cursor: pointer;"
                                 onclick="showImageModal(this.src, '{{ $mahasiswa->nama_mahasiswa }}')">
                        @else
                            <div class="rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center bg-secondary text-white" style="width: 120px; height: 120px; font-size: 3rem;">
                                <i class="bi bi-person"></i>
                            </div>
                        @endif
                        
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="document.getElementById('selectFoto').click();">
                                <i class="bi bi-camera me-1"></i> Ganti Foto
                            </button>
                            <input type="file" id="selectFoto" class="d-none" accept=".jpeg,.jpg,.png" onchange="openCropper(event)">
                        </div>
                    </div>

                    {{-- Data --}}
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">Nama Lengkap</div>
                        <div class="col-sm-8 fw-bold fs-5">{{ $mahasiswa->nama_mahasiswa }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">NIM</div>
                        <div class="col-sm-8">{{ $mahasiswa->nim }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">Program Studi</div>
                        <div class="col-sm-8">{{ $mahasiswa->prodi }}</div>
                    </div>
                    <hr>
                    {{-- Pembimbing Info (read-only) --}}
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">Pembimbing I</div>
                        <div class="col-sm-8">
                            @if($mahasiswa->pembimbing1)
                                <span class="badge bg-primary">{{ $mahasiswa->pembimbing1->nama_dosen }}</span>
                            @else
                                <span class="text-danger fst-italic">Belum ditentukan (hubungi Admin)</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">Pembimbing II</div>
                        <div class="col-sm-8">
                            @if($mahasiswa->pembimbing2)
                                <span class="badge bg-primary">{{ $mahasiswa->pembimbing2->nama_dosen }}</span>
                            @else
                                <span class="text-danger fst-italic">Belum ditentukan (hubungi Admin)</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <form action="{{ route('mahasiswa.profil.update') }}" method="POST" enctype="multipart/form-data" id="profilForm">
                        @csrf
                        <input type="file" id="foto_profil" name="foto_profil" class="d-none" accept=".jpeg,.jpg,.png">
                        
                        <div class="row mb-3 align-items-center">
                            <div class="col-sm-4 text-muted fw-semibold">Judul Laporan Akhir <span class="text-danger">*</span></div>
                            <div class="col-sm-8">
                                <textarea name="judul_ta" class="form-control" rows="2" placeholder="Masukkan judul LA/TA Anda (wajib sebelum booking)">{{ $mahasiswa->judul_ta }}</textarea>
                                @if(empty($mahasiswa->judul_ta))
                                    <small class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Wajib diisi sebelum bisa melakukan booking bimbingan.</small>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3 align-items-center">
                            <div class="col-sm-4 text-muted fw-semibold">Nomor HP</div>
                            <div class="col-sm-8">
                                <input type="text" name="no_hp" class="form-control" value="{{ $mahasiswa->no_hp }}" placeholder="Contoh: 081234567890">
                            </div>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-save me-1"></i>Simpan Profil</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-outline-primary rounded-pill px-4">Lihat Riwayat Bimbingan <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

{{-- Image Preview Modal --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="background: transparent;">
            <div class="modal-body text-center p-0">
                <img id="imagePreviewImg" src="" alt="" style="max-width: 100%; max-height: 80vh; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
                <p class="text-white mt-3 fw-semibold" id="imagePreviewName"></p>
            </div>
        </div>
    </div>
</div>

{{-- Cropper Modal --}}
<div class="modal fade" id="cropperModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-crop me-2"></i>Atur Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center" style="min-height: 400px;">
                <div style="max-height: 400px; overflow: hidden;">
                    <img id="cropperImage" src="" style="max-width: 100%;">
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary" onclick="cropper.zoom(0.1)" title="Zoom In"><i class="bi bi-zoom-in"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="cropper.zoom(-0.1)" title="Zoom Out"><i class="bi bi-zoom-out"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="cropper.rotate(-90)" title="Rotate Left"><i class="bi bi-arrow-counterclockwise"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="cropper.rotate(90)" title="Rotate Right"><i class="bi bi-arrow-clockwise"></i></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="cropper.reset()" title="Reset"><i class="bi bi-arrow-repeat"></i></button>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveCrop()"><i class="bi bi-check-lg me-1"></i>Simpan Foto</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
    let cropper;

    function showImageModal(src, name) {
        document.getElementById('imagePreviewImg').src = src;
        document.getElementById('imagePreviewName').textContent = name;
        new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
    }

    function openCropper(event) {
        const file = event.target.files[0];
        if (!file) return;

        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file harus JPEG, JPG, atau PNG!');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('cropperImage');
            img.src = e.target.result;

            const modal = new bootstrap.Modal(document.getElementById('cropperModal'));
            modal.show();

            document.getElementById('cropperModal').addEventListener('shown.bs.modal', function() {
                if (cropper) cropper.destroy();
                cropper = new Cropper(img, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.8,
                    responsive: true,
                    restore: false,
                });
            }, { once: true });
        };
        reader.readAsDataURL(file);
    }

    function saveCrop() {
        if (!cropper) return;
        
        cropper.getCroppedCanvas({
            width: 400,
            height: 400,
            imageSmoothingQuality: 'high'
        }).toBlob(function(blob) {
            const file = new File([blob], 'profil.jpg', { type: 'image/jpeg' });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById('foto_profil').files = dataTransfer.files;
            
            bootstrap.Modal.getInstance(document.getElementById('cropperModal')).hide();
            document.getElementById('profilForm').submit();
        }, 'image/jpeg', 0.9);
    }
</script>
@endsection
