@extends('layouts.dosen')

@section('title', 'Booking Masuk')
@section('page-title', 'Booking Masuk')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-1">Daftar Booking Mahasiswa</h4>
    <p class="text-muted mb-0">Kelola persetujuan konsultasi mahasiswa yang masuk ke Anda</p>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>Subject</th>
                    <th>Tanggal & Jam</th>
                    <th>Topik</th>
                    <th>Presensi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $i => $b)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @php $mhs = $b->mahasiswa; @endphp
                            @if($mhs && $mhs->foto_profil)
                                <img src="{{ asset('storage/' . $mhs->foto_profil) }}" alt="Foto" 
                                     class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover; cursor: pointer;"
                                     onclick="showImageModal(this.src, '{{ $b->nama_mahasiswa }}')">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-secondary text-white" style="width: 36px; height: 36px; font-size: 0.9rem;">
                                    <i class="bi bi-person"></i>
                                </div>
                            @endif
                            <div>
                                <strong>{{ $b->nama_mahasiswa }}</strong><br>
                                <small class="text-muted">{{ $b->nim }}</small>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-dark border">{{ $b->subject ?? '-' }}</span></td>
                    <td>
                        <i class="bi bi-calendar3 me-1 text-teal"></i>{{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}<br>
                        <i class="bi bi-clock me-1 text-muted"></i>{{ \Carbon\Carbon::parse($b->jam)->format('H:i') }}
                    </td>
                    <td>{{ Str::limit($b->topik, 25) }}</td>
                    <td>
                        @if($b->presensi === 'Hadir')
                            <span class="badge bg-success">Hadir</span>
                        @elseif($b->presensi === 'Tidak Hadir')
                            <span class="badge bg-danger">Tidak Hadir</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($b->status == 'Menunggu')
                            <span class="badge-menunggu">{{ $b->status }}</span>
                        @elseif($b->status == 'Disetujui')
                            <span class="badge-disetujui">{{ $b->status }}</span>
                        @elseif($b->status == 'Revisi')
                            <span class="badge bg-warning text-dark">{{ $b->status }}</span>
                        @elseif($b->status == 'Ditolak')
                            <span class="badge-ditolak">{{ $b->status }}</span>
                        @else
                            <span class="badge-selesai">{{ $b->status }}</span>
                        @endif
                        @if($b->uraian)
                            <br><small class="text-muted fst-italic" title="{{ $b->uraian }}">{{ Str::limit($b->uraian, 30) }}</small>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            @if($b->status == 'Menunggu')
                                <form action="{{ route('dosen-panel.booking.updateStatus', $b) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="Disetujui">
                                    <button type="submit" class="btn btn-sm btn-success" title="Setujui"><i class="bi bi-check-lg"></i></button>
                                </form>
                                <form action="{{ route('dosen-panel.booking.updateStatus', $b) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="Ditolak">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Tolak"><i class="bi bi-x-lg"></i></button>
                                </form>
                            @elseif($b->status == 'Disetujui')
                                <button type="button" class="btn btn-sm btn-info text-white" title="Selesai" data-bs-toggle="modal" data-bs-target="#modalSelesai{{ $b->id }}">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </button>
                                <button type="button" class="btn btn-sm btn-warning text-dark" title="Revisi" data-bs-toggle="modal" data-bs-target="#modalRevisi{{ $b->id }}">
                                    <i class="bi bi-arrow-repeat"></i> Revisi
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>

                {{-- Modal Selesai --}}
                @if($b->status == 'Disetujui')
                <div class="modal fade" id="modalSelesai{{ $b->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2"></i>Tandai Selesai</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('dosen-panel.booking.updateStatus', $b) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="Selesai">
                                <div class="modal-body">
                                    <p class="mb-3">Booking: <strong>{{ $b->nama_mahasiswa }}</strong> — {{ $b->subject }}</p>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Presensi <span class="text-danger">*</span></label>
                                        <select name="presensi" class="form-select" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Hadir">Hadir</option>
                                            <option value="Tidak Hadir">Tidak Hadir</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Uraian / Catatan <span class="text-danger">*</span></label>
                                        <textarea name="uraian" class="form-control" rows="3" placeholder="Tuliskan catatan hasil bimbingan..." required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-info text-white"><i class="bi bi-check-circle me-1"></i>Tandai Selesai</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Modal Revisi --}}
                <div class="modal fade" id="modalRevisi{{ $b->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title"><i class="bi bi-arrow-repeat me-2"></i>Tandai Revisi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('dosen-panel.booking.updateStatus', $b) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="Revisi">
                                <div class="modal-body">
                                    <p class="mb-3">Booking: <strong>{{ $b->nama_mahasiswa }}</strong> — {{ $b->subject }}</p>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Catatan Revisi <span class="text-danger">*</span></label>
                                        <textarea name="uraian" class="form-control" rows="3" placeholder="Tuliskan apa yang perlu direvisi..." required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-warning text-dark"><i class="bi bi-arrow-repeat me-1"></i>Tandai Revisi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                @empty
                <tr><td colspan="8" class="text-center text-muted py-5"><i class="bi bi-inbox fs-1 d-block mb-3"></i>Belum ada booking masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
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

<script>
function showImageModal(src, name) {
    document.getElementById('imagePreviewImg').src = src;
    document.getElementById('imagePreviewName').textContent = name;
    new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
}
</script>
@endsection
