@extends('layouts.app')
@extends('layouts.navadmin')
@section('content')

<div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Tambah Peminjam</h1>
            </div>
            <div class="bordered-section p-8">
                <div class="form-container">
                    <form onsubmit="return false;">
                        
                        <!-- Nama -->
                        <div class="form-row">
                            <label for="namaPeminjam">Nama:</label>
                            <input type="text" id="namaPeminjam" value="">
                        </div>

                        <!-- No. KP -->
                        <div class="form-row">
                            <label for="noKp">No. KP:</label>
                            <input type="text" id="noKp" value="">
                        </div>

                        <!-- No. Tel -->
                        <div class="form-row">
                            <label for="noTel">No. Tel:</label>
                            <input type="text" id="noTel" value="">
                        </div>

                        <!-- Pelajar/Guru (Dropdown/Select) -->
                        <div class="form-row">
                            <label for="jenisPengguna">Pelajar/Guru:</label>
                            <select id="jenisPengguna">
                                <option value="pelajar" selected>Pelajar</option>
                                <option value="guru">Guru</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-between mt-8">
                            <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-md shadow-md transition duration-150">
                                Import File
                            </button>
                            <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white font-semibold py-2 px-8 rounded-md shadow-md transition duration-150">
                                SUBMIT
                            </button>
                        </div>

                    </form>
                </div>
            </div>

@endsection