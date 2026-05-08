<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIBOKO - Sistem Booking Konsultasi Mahasiswa. Booking jadwal konsultasi dengan dosen secara mudah dan cepat.">
    <title>@yield('title', 'Beranda') — SIBOKO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg mhs-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('beranda') }}">
                <i class="bi bi-calendar2-check me-2"></i>SIBOKO
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMahasiswa" style="border-color: rgba(255,255,255,0.3);">
                <i class="bi bi-list" style="color:white; font-size:1.4rem;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navMahasiswa">
                <ul class="navbar-nav ms-auto me-3 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">
                            <i class="bi bi-house-fill me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mahasiswa.jadwal') ? 'active' : '' }}" href="{{ route('mahasiswa.jadwal') }}">
                            <i class="bi bi-clock me-1"></i> Lihat Jadwal
                        </a>
                    </li>
                    @auth
                        @if(auth()->user()->role == 'mahasiswa')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('mahasiswa.riwayat') ? 'active' : '' }}" href="{{ route('mahasiswa.riwayat') }}">
                                    <i class="bi bi-clock-history me-1"></i> Riwayat
                                </a>
                            </li>
                            <li class="nav-item dropdown ms-lg-3 mt-2 mt-lg-0">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('mahasiswa.profil') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @else
                        <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                            <a class="btn btn-outline-light btn-sm px-3 rounded-pill" href="{{ route('login') }}">Masuk</a>
                            <a class="btn btn-light btn-sm px-3 rounded-pill ms-2 text-primary fw-bold" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endauth
                </ul>
                
                @auth
                    @if(auth()->user()->role == 'admin')
                        <a href="{{ route('dashboard') }}" class="btn btn-admin ms-2">
                            <i class="bi bi-gear-fill me-1"></i> Admin Panel
                        </a>
                    @elseif(auth()->user()->role == 'dosen')
                        <a href="{{ route('dosen-panel.dashboard') }}" class="btn btn-admin ms-2" style="background:#0f766e;">
                            <i class="bi bi-person-badge-fill me-1"></i> Panel Dosen
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success') || session('error'))
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:10px; border: none; background: rgba(16,185,129,0.1); color: #047857;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:10px; border: none; background: rgba(239,68,68,0.1); color: #b91c1c;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
    @endif

    {{-- Content --}}
    @yield('content')

    {{-- Footer --}}
    <footer class="mhs-footer">
        <div class="container">
            <p class="mb-1"><strong>SIBOKO</strong> — Sistem Booking Konsultasi Mahasiswa</p>
            <p class="mb-0">&copy; {{ date('Y') }} Dibuat untuk Ujian Kompetensi.</p>
        </div>
    </footer>

    {{-- Modal Booking --}}
    <div class="modal fade" id="modalBooking" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border:none; border-radius:15px; overflow:hidden;">
                <div class="modal-header bg-primary text-white" style="border-bottom:none;">
                    <h5 class="modal-title"><i class="bi bi-journal-plus me-2"></i>Form Booking Konsultasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <div id="bookingErrorAlert" class="alert alert-danger d-none" style="border-radius:10px; border:none; background:rgba(239,68,68,0.1); color:#b91c1c;"></div>
                    
                    <form id="formBookingSubmit" action="{{ route('mahasiswa.booking.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Pilih Pembimbing <span class="text-danger">*</span></label>
                                <select name="dosen_id" id="bookingDosenId" class="form-select" required onchange="updateSubject()">
                                    <option value="">-- Pilih Pembimbing --</option>
                                    @auth
                                        @php $mhsData = auth()->user()->mahasiswa; @endphp
                                        @if($mhsData && $mhsData->pembimbing1_id)
                                            <option value="{{ $mhsData->pembimbing1_id }}"
                                                data-subject="{{ \App\Http\Controllers\MahasiswaController::getNextSubject($mhsData->id, $mhsData->pembimbing1_id) }}">
                                                Pembimbing I — {{ $mhsData->pembimbing1->nama_dosen ?? '-' }}
                                            </option>
                                        @endif
                                        @if($mhsData && $mhsData->pembimbing2_id)
                                            <option value="{{ $mhsData->pembimbing2_id }}"
                                                data-subject="{{ \App\Http\Controllers\MahasiswaController::getNextSubject($mhsData->id, $mhsData->pembimbing2_id) }}">
                                                Pembimbing II — {{ $mhsData->pembimbing2->nama_dosen ?? '-' }}
                                            </option>
                                        @endif
                                    @endauth
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Subject Bimbingan <span class="text-danger">*</span></label>
                                <input type="text" name="subject" id="bookingSubject" class="form-control" readonly required placeholder="Pilih pembimbing dulu">
                                <small class="text-muted">Subject ditentukan otomatis berdasarkan urutan bimbingan.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Konsultasi <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jam Konsultasi <span class="text-danger">*</span></label>
                                <select name="jam" class="form-select" required>
                                    <option value="">-- Pilih Jam --</option>
                                    @for($h = 6; $h <= 17; $h++)
                                        <option value="{{ sprintf('%02d:00', $h) }}">{{ sprintf('%02d:00', $h) }}</option>
                                        <option value="{{ sprintf('%02d:30', $h) }}">{{ sprintf('%02d:30', $h) }}</option>
                                    @endfor
                                    <option value="18:00">18:00</option>
                                </select>
                                <small class="text-muted">Rentang: 06:00 - 18:00</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Topik / Keterangan <span class="text-danger">*</span></label>
                                <textarea name="topik" class="form-control" rows="3" placeholder="Jelaskan topik yang ingin dikonsultasikan..." required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100" id="btnSubmitBooking">
                                    <i class="bi bi-send-fill me-2"></i>Kirim Booking
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Sukses Booking --}}
    <div class="modal fade" id="modalBookingSuccess" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center p-4" style="border:none; border-radius:15px;">
                <div class="mb-3">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                </div>
                <h5 class="fw-bold mb-2">Booking Terkirim!</h5>
                <p class="text-muted mb-4 text-sm">Status awal: Menunggu.<br>Silakan cek status secara berkala.</p>
                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Oke, Mengerti</button>
            </div>
        </div>
    </div>

    {{-- Modal Cek Status Result --}}
    <div class="modal fade" id="modalCekStatusResult" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border:none; border-radius:15px; overflow:hidden;">
                <div class="modal-header bg-dark text-white" style="border-bottom:none;">
                    <h5 class="modal-title"><i class="bi bi-search me-2"></i>Hasil Pencarian Status</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="statusResultLoading" class="text-center py-5 d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 mb-0 text-muted">Mencari data...</p>
                    </div>
                    <div id="statusResultMessage" class="text-center py-5 d-none">
                        <i class="bi bi-journal-x text-muted" style="font-size:3rem;"></i>
                        <p class="mt-3 mb-0 text-muted" id="statusResultText"></p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 d-none" id="statusResultTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Dosen</th>
                                    <th>Topik</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="statusResultBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Custom Modal Style for Backdrop Blur
        document.addEventListener('show.bs.modal', function () {
            setTimeout(() => {
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.style.backdropFilter = 'blur(5px)';
                    backdrop.style.backgroundColor = 'rgba(15, 23, 42, 0.6)';
                }
            }, 10);
        });

        // Trigger Booking Modal
        function openBookingModal(dosenId = '') {
            if(dosenId) {
                document.getElementById('bookingDosenId').value = dosenId;
            } else {
                document.getElementById('bookingDosenId').value = '';
            }
            new bootstrap.Modal(document.getElementById('modalBooking')).show();
        }

        // Handle AJAX Booking Submit
        document.getElementById('formBookingSubmit').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const btn = document.getElementById('btnSubmitBooking');
            const alertBox = document.getElementById('bookingErrorAlert');
            
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...';
            alertBox.classList.add('d-none');
            alertBox.innerHTML = '';

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('modalBooking')).hide();
                    form.reset();
                    new bootstrap.Modal(document.getElementById('modalBookingSuccess')).show();
                } else {
                    alertBox.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i> ' + data.message;
                    alertBox.classList.remove('d-none');
                }
            })
            .catch(error => {
                alertBox.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i> Terjadi kesalahan, pastikan semua data diisi dengan benar.';
                alertBox.classList.remove('d-none');
                error.response && error.response.json().then(d => {
                    if(d.message) {
                        alertBox.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i> ' + d.message;
                    }
                });
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-send-fill me-2"></i>Kirim Booking';
            });
        });

        // Update Subject berdasarkan pilihan pembimbing
        function updateSubject() {
            var select = document.getElementById('bookingDosenId');
            var subjectInput = document.getElementById('bookingSubject');
            var selected = select.options[select.selectedIndex];
            
            if (selected && selected.dataset.subject) {
                subjectInput.value = selected.dataset.subject;
            } else {
                subjectInput.value = '';
                subjectInput.placeholder = 'Pilih pembimbing dulu';
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
