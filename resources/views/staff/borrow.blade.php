@extends('layouts.app')
@extends('layouts.staffheader')
@section('content')

    <h2 class="text-2xl font-extrabold text-center mb-8 tracking-widest">PEMINJAMAN BUKU</h2>
    <div class="mb-4">
            <button type="button" onclick="history.back()" class="inline-flex items-center px-3 py-2 bg-white/20 text-gray-700 rounded-md hover:bg-white/30 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </button>
    </div>
<!-- Bahagian Input (Your ID, Book ID, Submit) -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-2 mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white p-2 mb-3">
                {{ session('error') }}
            </div>
        @endif
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 mb-8 w-full max-w-xl mx-auto">
            <!-- Borang Input -->
            <form action="{{ route('borrow.store') }}" method="POST" id="borrow-form" class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 items-end">
                @csrf
                <div class="w-full sm:w-1/2">
                    <label for="your-id" class="sr-only">Your ID</label>
                    <input type="text" id="your-id" placeholder="Your ID (no_matrik)" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                </div>
                <div class="w-full sm:w-1/2">
                    <label for="book-id" class="sr-only">Book ID</label>
                    <input type="text" id="book-id" placeholder="Book ID or Barcode" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                </div>
                <button id="submit-btn" type="submit" disabled class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-150 shadow-md">
                    SUBMIT
                </button>
            </form>
        </div>


        <!-- Bahagian Maklumat Peminjam & Buku -->
        <div class="flex flex-col lg:flex-row gap-8 justify-center mt-12">
            
            <!-- Panel Kiri: Maklumat Peminjam -->
            <div class="bg-white p-6 rounded-xl shadow-xl border-4 border-gray-300 w-full lg:w-1/2">
                <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Maklumat Peminjam</h2>
                
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <!-- Avatar/Imej Peminjam -->
                    <div class="flex-shrink-0 text-center">
                        <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 mx-auto">
                            <!-- Placeholder Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-700 mt-2">Name</p>
                    </div>

                    <!-- Butiran Peminjam -->
                    <div class="flex-grow space-y-4 w-full">
                        <input type="text" id="p_id" readonly placeholder="Your ID" class="w-full p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                        <input type="text" id="p_nama" readonly placeholder="NAMA" class="w-full p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                        <input type="text" id="p_program" readonly placeholder="PROGRAM/JAWATAN" class="w-full p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                        <input type="text" id="p_telefon" readonly placeholder="No Telefon" class="w-full p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                    </div>
                </div>
            </div>

            <!-- Panel Kanan: Maklumat Buku -->
            <div class="bg-white p-6 rounded-xl shadow-xl border-4 border-gray-300 w-full lg:w-1/2">
                <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Maklumat Buku</h2>
                
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    <!-- Input Buku -->
                    <div class="flex-grow space-y-4 w-full sm:w-1/2">
                        <input type="text" id="b_id" readonly placeholder="Book ID" class="w-full p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                        <input type="text" id="b_tajuk" readonly placeholder="TAJUK BUKU" class="w-full p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                        <input type="text" id="b_pengarang" readonly placeholder="PENGARANG" class="w-full p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                        <input type="text" id="b_tahun" readonly placeholder="TAHUN" class="w-full p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                    </div>

                    <!-- Placeholder Imej Buku -->
                    <div class="w-24 h-32 flex-shrink-0 mx-auto sm:mx-0 bg-gray-100 border border-gray-400 flex items-center justify-center rounded-lg text-gray-500 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12 12.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12 18.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- rekod peminjaman buku sahaja -->
        <div class="mt-8 max-w-4xl mx-auto">
            <h3 class="text-lg font-semibold mb-4">Rekod Peminjaman</h3>
            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Borrower Name</th>
                            <th class="px-4 py-2">Book Title</th>
                            <th class="px-4 py-2">Borrowed Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records ?? [] as $i => $r)
                            <tr class="border-t">
                                <td class="px-4 py-2 align-top">{{ $i + 1 }}</td>
                                <td class="px-4 py-2 align-top font-medium">{{ $r['borrower'] }}</td>
                                <td class="px-4 py-2 align-top">{{ $r['book'] }}</td>
                                <td class="px-4 py-2 align-top">{{ $r['borrowed_date'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-500">Tiada rekod aktif.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    
    
    <!-- MODAL POPUP (Pengganti alert()) -->
    <div id="custom-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white p-6 rounded-xl shadow-2xl max-w-sm w-full transform transition-all duration-300 scale-95 opacity-0" id="modal-content-container">
            <h3 class="text-xl font-bold mb-3 text-gray-800" id="modal-title">Makluman</h3>
            <p class="text-gray-600 mb-6" id="modal-message">Ini adalah mesej.</p>
            <div class="flex justify-end">
                <button id="modal-close-btn" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-150">
                    OK
                </button>
            </div>
        </div>
    </div>


<script>
    const modal = document.getElementById('custom-modal');
    const modalContainer = document.getElementById('modal-content-container');
    const modalTitle = document.getElementById('modal-title');
    const modalMessage = document.getElementById('modal-message');
    const modalCloseBtn = document.getElementById('modal-close-btn');
    const borrowForm = document.getElementById('borrow-form');
    const submitBtn = document.getElementById('submit-btn');

    let borrowerData = null;
    let bookData = null;

    // helper to enable/disable submit button
    function updateSubmitState() {
        if (submitBtn) {
            submitBtn.disabled = !(borrowerData && bookData);
        }
    }

    // Show modal
    function showModal(title, message) {
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContainer.classList.remove('scale-95', 'opacity-0');
            modalContainer.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    // Hide modal
    function hideModal() {
        modalContainer.classList.remove('scale-100', 'opacity-100');
        modalContainer.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    // Fetch borrower info
    document.getElementById('your-id').addEventListener('blur', function() {
        const yourId = this.value.trim();
        if (!yourId) return;

        fetch(`/api/borrower-info?id=${encodeURIComponent(yourId)}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    showModal('Ralat', data.error);
                    borrowerData = null;
                    document.getElementById('p_id').value = '';
                    document.getElementById('p_nama').value = '';
                    document.getElementById('p_program').value = '';
                    document.getElementById('p_telefon').value = '';
                } else {
                    borrowerData = data;
                    document.getElementById('p_id').value = data.no_matrik;
                    document.getElementById('p_nama').value = data.name;
                    document.getElementById('p_program').value = data.program || '-';
                    document.getElementById('p_telefon').value = data.phone || '-';
                }
                updateSubmitState();
            })
            .catch(err => {
                showModal('Ralat', 'Gagal mengambil maklumat peminjam');
                console.error(err);
            });
    });

    // Fetch book info
    document.getElementById('book-id').addEventListener('blur', function() {
        const bookId = this.value.trim();
        if (!bookId) return;

        fetch(`/api/book-info?id=${encodeURIComponent(bookId)}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    showModal('Ralat', data.error);
                    bookData = null;
                    document.getElementById('b_id').value = '';
                    document.getElementById('b_tajuk').value = '';
                    document.getElementById('b_pengarang').value = '';
                    document.getElementById('b_tahun').value = '';
                } else {
                    bookData = data;
                    document.getElementById('b_id').value = data.barcode;
                    document.getElementById('b_tajuk').value = data.title;
                    document.getElementById('b_pengarang').value = data.author || '-';
                    document.getElementById('b_tahun').value = data.year || '-';
                }
                updateSubmitState();
            })
            .catch(err => {
                showModal('Ralat', 'Gagal mengambil maklumat buku');
                console.error(err);
            });
    });

    // clear cached data if user erases input manually
    document.getElementById('your-id').addEventListener('input', function() {
        if (!this.value.trim()) {
            borrowerData = null;
            updateSubmitState();
            document.getElementById('p_id').value = '';
            document.getElementById('p_nama').value = '';
            document.getElementById('p_program').value = '';
            document.getElementById('p_telefon').value = '';
        }
    });
    document.getElementById('book-id').addEventListener('input', function() {
        if (!this.value.trim()) {
            bookData = null;
            updateSubmitState();
            document.getElementById('b_id').value = '';
            document.getElementById('b_tajuk').value = '';
            document.getElementById('b_pengarang').value = '';
            document.getElementById('b_tahun').value = '';
        }
    });

    // initialize button state on load
    updateSubmitState();

    // prevent enter key anywhere in the form from submitting early
    borrowForm.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            // if focus is on book-id or your-id, trigger blur to fetch data
            if (e.target && (e.target.id === 'book-id' || e.target.id === 'your-id')) {
                e.target.blur();
            }
        }
    });

    // Handle form submission
    borrowForm.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!borrowerData) {
            showModal('Ralat', 'Sila masukkan ID peminjam yang sah');
            return;
        }

        if (!bookData) {
            showModal('Ralat', 'Sila masukkan ID buku yang sah');
            return;
        }

        fetch('/borrow', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: JSON.stringify({
                borrower_type: borrowerData.type,
                no_matrik: borrowerData.no_matrik,
                barcode: bookData.barcode,
                book_id: bookData.id,
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showModal('Berjaya', data.success);
                borrowForm.reset();
                borrowerData = null;
                bookData = null;
                document.getElementById('p_id').value = '';
                document.getElementById('p_nama').value = '';
                document.getElementById('p_program').value = '';
                document.getElementById('p_telefon').value = '';
                document.getElementById('b_id').value = '';
                document.getElementById('b_tajuk').value = '';
                document.getElementById('b_pengarang').value = '';
                document.getElementById('b_tahun').value = '';
                // Reload book list
                location.reload();
            } else {
                showModal('Ralat', data.error || 'Gagal mencatat peminjaman');
            }
        })
        .catch(err => {
            showModal('Ralat', 'Ralat rangkaian');
            console.error(err);
        });
    });

    // Filter table
    function filterTable() {
        const input = document.getElementById('search-input');
        const filter = input.value.toUpperCase();
        const rows = document.querySelectorAll('tr.book-row');

        rows.forEach(row => {
            const barcode = row.querySelector('.book-barcode')?.textContent || '';
            const title = row.querySelector('.book-title')?.textContent || '';

            if (barcode.toUpperCase().indexOf(filter) > -1 || title.toUpperCase().indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Modal close button
    modalCloseBtn.addEventListener('click', hideModal);
</script>


@endsection