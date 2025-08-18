@extends('layouts.app')
@section('content')
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Rekap & Konfirmasi Pelanggaran</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Dashboards</a>
                    </li>
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Super Admin</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                        Rekap & Verifikasi Pelanggaran
                    </li>
                </ul>
            </div>

            <!-- Filter Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="mb-4 text-15">Filter Data</h6>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <label for="classFilter"
                                class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">
                                Filter Kelas
                            </label>
                            <select id="classFilter"
                                class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zink-600 dark:border-zink-500 dark:text-zink-100">
                                <option value="">Semua Kelas</option>
                                @php
                                    $uniqueClasses = $students->pluck('user.class.name')->unique()->sort();
                                @endphp
                                @foreach ($uniqueClasses as $className)
                                    <option value="{{ $className }}">{{ $className }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <label for="genderFilter"
                                class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">
                                Filter Jenis Kelamin
                            </label>
                            <select id="genderFilter"
                                class="w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zink-600 dark:border-zink-500 dark:text-zink-100">
                                <option value="">Semua Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="button" id="resetMainFilter"
                                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-md hover:bg-slate-50 focus:ring-2 focus:ring-blue-500 dark:bg-zink-600 dark:border-zink-500 dark:text-zink-300 dark:hover:bg-zink-700 transition-colors duration-200">
                                Reset Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6 class="mb-4 text-15">Datatable Konfirmasi Pelanggaran (Status Pending)</h6>

                    <!-- Info hasil filter -->
                    <div id="filterInfo" class="mb-3 text-sm text-slate-600 dark:text-zink-300 hidden">
                        <span id="showingCount">0</span> dari <span id="totalCount">0</span> data ditampilkan
                    </div>

                    <table id="hoverableTable" style="width: 100%" class="hover group">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Jenis Kelamin</th>
                                <th>Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                @php
                                    $pendingCount = $student->recaps->count();
                                @endphp
                                @if ($pendingCount > 0)
                                    <tr class="student-row" data-class="{{ $student->user->class->name }}"
                                        data-gender="{{ $student->gender }}">
                                        <td>
                                            <div class="flex gap-2">

                                                <button data-modal-target="modal-detail-{{ $student->id }}" type="button"
                                                    class="flex rounded-full items-center justify-center size-[37.5px] p-0 bg-white text-slate-500 btn border-slate-500 hover:text-white hover:bg-slate-600 hover:border-slate-600 focus:text-white focus:bg-slate-600 focus:border-slate-600 focus:ring focus:ring-slate-100 active:text-white active:bg-slate-600 active:border-slate-600 active:ring active:ring-slate-100 dark:bg-zink-700 dark:hover:bg-slate-500 dark:ring-slate-400/20 dark:focus:bg-slate-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-eye-icon lucide-eye">
                                                        <path
                                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                                        <circle cx="12" cy="12" r="3" />
                                                    </svg>
                                                </button>
                                                <button data-modal-target="modal-{{ $student->id }}" type="button"
                                                    class="flex rounded-full items-center justify-center size-[37.5px] p-0 text-green-500 bg-white border-green-500 btn hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:bg-zink-700 dark:hover:bg-green-500 dark:ring-green-400/20 dark:focus:bg-green-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-check-check-icon lucide-check-check">
                                                        <path d="M18 6 7 17l-5-5" />
                                                        <path d="m22 10-7.5 7.5L13 16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="row-number">{{ $loop->iteration }}</td>
                                        <td>{{ $student->full_name }}</td>
                                        <td>{{ $student->student_number }}</td>
                                        <td>{{ $student->national_student_number }}</td>
                                        <td>{{ $student->gender }}</td>
                                        <td>{{ $student->user->class->name }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pesan jika tidak ada data -->
                    <div id="noMainData" class="hidden text-center py-8">
                        <div class="flex flex-col items-center text-slate-500 dark:text-zink-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="mb-2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                            <p class="text-sm">Tidak ada data yang sesuai dengan filter atau tidak ada pelanggaran pending
                            </p>
                        </div>
                    </div>
                </div>
            </div><!--end card-->

            <!-- Modal Detail untuk setiap siswa -->
            @foreach ($students as $student)
                @if ($student->recaps->count() > 0)
                    <div id="modal-detail-{{ $student->id }}" modal-center=""
                        class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 top-2/4 show ">
                        <!-- Modal dengan ukuran yang lebih besar -->
                        <div class="modal-container bg-white shadow rounded-md dark:bg-zink-600 flex flex-col">
                            <!-- Header Modal - Fixed -->
                            <div
                                class="modal-header flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500 flex-shrink-0">
                                <h5 class="text-16 font-semibold">Detail Rekap Pelanggaran - {{ $student->full_name }}
                                </h5>
                                <button data-modal-close="modal-detail-{{ $student->id }}"
                                    class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>

                            <!-- Content Modal dengan Filter dan Tabel - Scrollable -->
                            <div class="modal-content flex-1 overflow-hidden">
                                <div class="p-4 h-full flex flex-col">
                                    <!-- Filter Section - Fixed -->
                                    <div
                                        class="filter-section mb-4 p-3 bg-slate-50 dark:bg-zink-700 rounded-lg flex-shrink-0">
                                        <div class="flex flex-col sm:flex-row gap-4">
                                            <div class="flex-1">
                                                <label for="detailCategoryFilter-{{ $student->id }}"
                                                    class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">
                                                    Filter Kategori
                                                </label>
                                                <select id="detailCategoryFilter-{{ $student->id }}"
                                                    data-student-id="{{ $student->id }}"
                                                    class="detail-category-filter w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zink-600 dark:border-zink-500 dark:text-zink-100">
                                                    <option value="">Semua Kategori</option>
                                                    <option value="Ringan">Ringan</option>
                                                    <option value="Sedang">Sedang</option>
                                                    <option value="Berat">Berat</option>
                                                </select>
                                            </div>
                                            <div class="flex-1">
                                                <label for="detailStatusFilter-{{ $student->id }}"
                                                    class="block text-sm font-medium text-slate-700 dark:text-zink-300 mb-2">
                                                    Filter Status
                                                </label>
                                                <select id="detailStatusFilter-{{ $student->id }}"
                                                    data-student-id="{{ $student->id }}"
                                                    class="detail-status-filter w-full px-3 py-2 text-sm border border-slate-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zink-600 dark:border-zink-500 dark:text-zink-100">
                                                    <option value="">Semua Status</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="verified">Verifikasi</option>
                                                    <option value="not_verified">Tidak Terverifikasi</option>
                                                </select>
                                            </div>
                                            <div class="flex items-end">
                                                <button type="button" class="reset-detail-filter-btn"
                                                    data-student-id="{{ $student->id }}"
                                                    class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-md hover:bg-slate-50 focus:ring-2 focus:ring-blue-500 dark:bg-zink-600 dark:border-zink-500 dark:text-zink-300 dark:hover:bg-zink-700">
                                                    Reset Filter
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Table Container - Scrollable -->
                                    <div
                                        class="table-container flex-1 overflow-hidden border border-slate-200 rounded-lg dark:border-zink-500">
                                        <div class="table-scroll-wrapper h-full overflow-auto">
                                            <table class="table-detail-violations w-full text-sm text-left"
                                                id="detailViolationsTable-{{ $student->id }}">
                                                <thead
                                                    class="text-xs uppercase bg-slate-50 dark:bg-zink-700 sticky top-0 z-10">
                                                    <tr>
                                                        <th scope="col"
                                                            class="px-3 py-3 w-10 font-semibold text-slate-700 dark:text-zink-200">
                                                            No</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-24 font-semibold text-slate-700 dark:text-zink-200">
                                                            Tanggal</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 min-w-[200px] font-semibold text-slate-700 dark:text-zink-200">
                                                            Pelanggaran</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-20 font-semibold text-slate-700 dark:text-zink-200">
                                                            Kategori</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-16 font-semibold text-slate-700 dark:text-zink-200">
                                                            Poin</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-20 font-semibold text-slate-700 dark:text-zink-200">
                                                            Status</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-24 font-semibold text-slate-700 dark:text-zink-200">
                                                            Dibuat oleh</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-24 font-semibold text-slate-700 dark:text-zink-200">
                                                            Diverifikasi oleh</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-24 font-semibold text-slate-700 dark:text-zink-200">
                                                            Diupdate oleh</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $detailCounter = 1; @endphp
                                                    @forelse ($student->pRecaps as $pRecap)
                                                        <tr class="detail-violation-row bg-white border-b dark:bg-zink-800 dark:border-zink-700 hover:bg-slate-50 dark:hover:bg-zink-700"
                                                            data-category="{{ $pRecap->violation->category->name ?? '' }}"
                                                            data-status="{{ $pRecap->status }}">
                                                            <td class="px-3 py-3 font-medium detail-row-number">
                                                                {{ $detailCounter++ }}</td>
                                                            <td class="px-4 py-4 whitespace-nowrap">
                                                                {{ \Carbon\Carbon::parse($pRecap->created_at)->format('d/m/Y') }}
                                                            </td>
                                                            <td class="px-4 py-4">
                                                                <div class="violation-name">{{ $pRecap->violation->name }}
                                                                </div>
                                                            </td>
                                                            <td class="px-4 py-4">
                                                                <span
                                                                    class="px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap
                                                                @if (($pRecap->violation->category->name ?? '') === 'Berat') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                                                @elseif(($pRecap->violation->category->name ?? '') === 'Sedang') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300
                                                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 @endif">
                                                                    {{ $pRecap->violation->category->name ?? 'Tidak Diketahui' }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-4">
                                                                <span
                                                                    class="font-semibold text-red-600 dark:text-red-400 whitespace-nowrap">
                                                                    {{ $pRecap->violation->point ?? 0 }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-4">
                                                                @if ($pRecap->status === 'pending')
                                                                    <span
                                                                        class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300 rounded-full">
                                                                        Pending
                                                                    </span>
                                                                @elseif($pRecap->status === 'verified')
                                                                    <span
                                                                        class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 rounded-full">
                                                                        Terverifikasi
                                                                    </span>
                                                                @elseif($pRecap->status === 'not_verified')
                                                                    <span
                                                                        class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 rounded-full">
                                                                        Tidak Terverifikasi
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td class="px-4 py-4">
                                                                <span class="text-sm text-slate-600 dark:text-zink-300">
                                                                    {{ $pRecap->createdBy->name ?? '-' }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-4">
                                                                <span class="text-sm text-slate-600 dark:text-zink-300">
                                                                    {{ $pRecap->verifiedBy->name ?? '-' }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-4">
                                                                <span class="text-sm text-slate-600 dark:text-zink-300">
                                                                    {{ $pRecap->updatedBy->name ?? '-' }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr class="bg-white dark:bg-zink-800 no-detail-data-row">
                                                            <td colspan="10"
                                                                class="px-4 py-8 text-center text-slate-500 dark:text-zink-400">
                                                                <div class="flex flex-col items-center">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="48"
                                                                        height="48" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="mb-2">
                                                                        <circle cx="12" cy="12" r="10">
                                                                        </circle>
                                                                        <path d="M12 6v6l4 2"></path>
                                                                    </svg>
                                                                    <p class="text-sm">Tidak ada data pelanggaran untuk
                                                                        siswa ini</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- No data filtered message -->
                                    <div id="noDetailFilteredData-{{ $student->id }}" class="hidden text-center py-8">
                                        <div class="flex flex-col items-center text-slate-500 dark:text-zink-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="mb-2">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <path d="m21 21-4.35-4.35"></path>
                                            </svg>
                                            <p class="text-sm">Tidak ada data yang sesuai dengan filter</p>
                                        </div>
                                    </div>

                                    <!-- Summary - Fixed at bottom -->
                                    @if ($student->pRecaps->count() > 0)
                                        <div class="summary-section mt-4 p-3 bg-slate-50 dark:bg-zink-700 rounded-lg flex-shrink-0"
                                            id="detailSummary-{{ $student->id }}">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-medium text-slate-600 dark:text-zink-300">Total
                                                    Pelanggaran:</span>
                                                <span class="text-sm font-bold"
                                                    id="detailTotalCount-{{ $student->id }}">{{ $student->pRecaps->count() }}</span>
                                            </div>
                                            <div class="flex justify-between items-center mt-1">
                                                <span class="text-sm font-medium text-slate-600 dark:text-zink-300">Total
                                                    Poin:</span>
                                                <span class="text-sm font-bold text-red-600 dark:text-red-400"
                                                    id="detailTotalPoints-{{ $student->id }}">
                                                    {{ $student->pRecaps->sum(function ($pRecap) {return $pRecap->violation->point ?? 0;}) }}
                                                    Poin
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Modal untuk setiap siswa (Konfirmasi) -->
            @foreach ($students as $student)
                @if ($student->recaps->count() > 0)
                    <div id="modal-{{ $student->id }}" modal-center=""
                        class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 top-2/4 show ">
                        <!-- Modal dengan ukuran yang lebih besar -->
                        <div class="modal-container bg-white shadow rounded-md dark:bg-zink-600 flex flex-col">
                            <!-- Header Modal - Fixed -->
                            <div
                                class="modal-header flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500 flex-shrink-0">
                                <h5 class="text-16 font-semibold">Daftar Pelanggaran - {{ $student->full_name }}</h5>
                                <button data-modal-close="modal-{{ $student->id }}"
                                    class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>

                            <!-- Content Modal dengan Filter dan Tabel - Scrollable -->
                            <div class="modal-content flex-1 overflow-hidden">
                                <div class="p-4 h-full flex flex-col">
                                    <!-- Table Container - Scrollable -->
                                    <div
                                        class="table-container flex-1 overflow-hidden border border-slate-200 rounded-lg dark:border-zink-500">
                                        <div class="table-scroll-wrapper h-full overflow-auto">
                                            <table class="table-violations w-full text-sm text-left"
                                                id="violationsTable-{{ $student->id }}">
                                                <thead
                                                    class="text-xs uppercase bg-slate-50 dark:bg-zink-700 sticky top-0 z-10">
                                                    <tr>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-32 font-semibold text-slate-700 dark:text-zink-200">
                                                            Aksi</th>
                                                        <th scope="col"
                                                            class="px-3 py-3 w-10 font-semibold text-slate-700 dark:text-zink-200">
                                                            No</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-24 font-semibold text-slate-700 dark:text-zink-200">
                                                            Tanggal</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 min-w-[180px] font-semibold text-slate-700 dark:text-zink-200">
                                                            Pelanggaran</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-20 font-semibold text-slate-700 dark:text-zink-200">
                                                            Kategori</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-16 font-semibold text-slate-700 dark:text-zink-200">
                                                            Poin</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-20 font-semibold text-slate-700 dark:text-zink-200">
                                                            Status</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-24 font-semibold text-slate-700 dark:text-zink-200">
                                                            Dibuat oleh</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-24 font-semibold text-slate-700 dark:text-zink-200">
                                                            Diverifikasi oleh</th>
                                                        <th scope="col"
                                                            class="px-4 py-4 w-24 font-semibold text-slate-700 dark:text-zink-200">
                                                            Diupdate oleh</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $counter = 1; @endphp
                                                    @forelse ($student->recaps->where('status', 'pending' && 'verified') as $recap)
                                                        <tr class="violation-row bg-white border-b dark:bg-zink-800 dark:border-zink-700 hover:bg-slate-50 dark:hover:bg-zink-700"
                                                            data-category="{{ $recap->violation->category->name ?? '' }}">
                                                            <td class="px-4 py-4">
                                                                <div class="flex gap-2">

                                                                    <!-- Form untuk verifikasi -->
                                                                    <form method="POST"
                                                                        action="{{ route('superadmin.violation-status.update', $recap->id) }}"
                                                                        class="inline-block">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        @if ($recap->status == 'pending')
                                                                            <button type="submit" value="verified"
                                                                                name="status"
                                                                                onclick="return confirm('Apakah Anda yakin ingin memverifikasi pelanggaran ini?')"
                                                                                class="p-2 text-green-600 hover:text-green-700 hover:bg-green-50 rounded-full transition-colors duration-200"
                                                                                title="Verifikasi">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                    <polyline points="20,6 9,17 4,12">
                                                                                    </polyline>
                                                                                </svg>
                                                                            </button>
                                                                            <button type="submit" value="not_verified"
                                                                                name="status"
                                                                                onclick="return confirm('Apakah Anda yakin ingin menolak pelanggaran ini?')"
                                                                                class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-full transition-colors duration-200"
                                                                                title="Tolak">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                    <line x1="18" y1="6"
                                                                                        x2="6" y2="18">
                                                                                    </line>
                                                                                    <line x1="6" y1="6"
                                                                                        x2="18" y2="18">
                                                                                    </line>
                                                                                </svg>
                                                                            </button>
                                                                        @else
                                                                            <button type="submit" value="pending"
                                                                                name="status"
                                                                                onclick="return confirm('Apakah Anda yakin ingin memverifikasi ulang pelanggaran ini?')"
                                                                                class="p-2 text-orange-600 hover:text-orange-700 hover:bg-orange-50 rounded-full transition-colors duration-200"
                                                                                title="Verifikasi Ulang">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    class="lucide lucide-repeat-icon lucide-repeat">
                                                                                    <path d="m17 2 4 4-4 4" />
                                                                                    <path d="M3 11v-1a4 4 0 0 1 4-4h14" />
                                                                                    <path d="m7 22-4-4 4-4" />
                                                                                    <path d="M21 13v1a4 4 0 0 1-4 4H3" />
                                                                                </svg>
                                                                            </button>
                                                                        @endif

                                                                    </form>

                                                                </div>
                                                            </td>
                                                            <td class="px-3 py-3 font-medium row-number">
                                                                {{ $counter++ }}</td>
                                                            <td class="px-4 py-4 whitespace-nowrap">
                                                                {{ \Carbon\Carbon::parse($recap->created_at)->format('d/m/Y') }}
                                                            </td>
                                                            <td class="px-4 py-4">
                                                                <div class="violation-name">{{ $recap->violation->name }}
                                                                </div>
                                                            </td>
                                                            <td class="px-4 py-4">
                                                                <span
                                                                    class="px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap
                                                                @if (($recap->violation->category->name ?? '') === 'Berat') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                                                @elseif(($recap->violation->category->name ?? '') === 'Sedang') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300
                                                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 @endif">
                                                                    {{ $recap->violation->category->name ?? 'Tidak Diketahui' }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-4">
                                                                <span
                                                                    class="font-semibold text-red-600 dark:text-red-400 whitespace-nowrap">
                                                                    {{ $recap->violation->point ?? 0 }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-4">
                                                                @if ($recap->status == 'pending')
                                                                    <span
                                                                        class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300 rounded-full">
                                                                        Pending
                                                                    </span>
                                                                @endif
                                                                @if ($recap->status == 'verified')
                                                                    <span
                                                                        class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 rounded-full">
                                                                        Terverifikasi
                                                                    </span>
                                                                @endif

                                                            </td>
                                                            <td class="px-4 py-4">
                                                                <span class="text-sm text-slate-600 dark:text-zink-300">
                                                                    {{ $recap->createdBy->name ?? '-' }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-4">
                                                                <span class="text-sm text-slate-600 dark:text-zink-300">
                                                                    {{ $recap->verifiedBy->name ?? '-' }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-4">
                                                                <span class="text-sm text-slate-600 dark:text-zink-300">
                                                                    {{ $recap->updatedBy->name ?? '-' }}
                                                                </span>
                                                            </td>

                                                        </tr>
                                                    @empty
                                                        <tr class="bg-white dark:bg-zink-800 no-data-row">
                                                            <td colspan="11"
                                                                class="px-4 py-8 text-center text-slate-500 dark:text-zink-400">
                                                                <div class="flex flex-col items-center">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="48"
                                                                        height="48" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="mb-2">
                                                                        <circle cx="12" cy="12" r="10">
                                                                        </circle>
                                                                        <path d="M12 6v6l4 2"></path>
                                                                    </svg>
                                                                    <p class="text-sm">Tidak ada data pelanggaran pending
                                                                        untuk siswa ini</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- No data filtered message -->
                                    <div id="noFilteredData-{{ $student->id }}" class="hidden text-center py-8">
                                        <div class="flex flex-col items-center text-slate-500 dark:text-zink-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                class="mb-2">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <path d="m21 21-4.35-4.35"></path>
                                            </svg>
                                            <p class="text-sm">Tidak ada data yang sesuai dengan filter</p>
                                        </div>
                                    </div>

                                    <!-- Summary - Fixed at bottom -->
                                    @if ($student->recaps->count() > 0)
                                        <div class="summary-section mt-4 p-3 bg-slate-50 dark:bg-zink-700 rounded-lg flex-shrink-0"
                                            id="summary-{{ $student->id }}">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-medium text-slate-600 dark:text-zink-300">Total
                                                    Pelanggaran Pending:</span>
                                                <span class="text-sm font-bold"
                                                    id="totalCount-{{ $student->id }}">{{ $student->recaps->count() }}</span>
                                            </div>
                                            <div class="flex justify-between items-center mt-1">
                                                <span class="text-sm font-medium text-slate-600 dark:text-zink-300">Total
                                                    Poin Pending:</span>
                                                <span class="text-sm font-bold text-orange-600 dark:text-orange-400"
                                                    id="totalPoints-{{ $student->id }}">
                                                    {{ $student->recaps->sum(function ($recap) {return $recap->violation->point ?? 0;}) }}
                                                    Poin
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <!-- container-fluid -->
    </div>

    <style>
        /* Modal dengan ukuran tetap */
        .modal-container {
            width: 90vw;
            max-width: 1200px;
            height: 80vh;
            max-height: 700px;
            min-height: 400px;
        }

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            .modal-container {
                width: 95vw;
                height: 85vh;
                max-height: none;
                min-height: 300px;
            }
        }

        /* Modal backdrop */
        [modal-center] {
            backdrop-filter: blur(4px);
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Header tetap di atas */
        .modal-header {
            background-color: inherit;
            z-index: 20;
        }

        /* Content area yang bisa di-scroll */
        .modal-content {
            min-height: 0;
        }

        /* Filter section tetap di atas */
        .filter-section {
            background-color: inherit;
            z-index: 15;
        }

        /* Container table dengan scroll */
        .table-container {
            background-color: white;
        }

        /* Scroll wrapper untuk table */
        .table-scroll-wrapper {
            scrollbar-width: thin;
            scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
        }

        .table-scroll-wrapper::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .table-scroll-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }

        .table-scroll-wrapper::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 3px;
        }

        .table-scroll-wrapper::-webkit-scrollbar-thumb:hover {
            background-color: rgba(156, 163, 175, 0.7);
        }

        /* Table styling */
        .table-violations,
        .table-detail-violations {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-violations th,
        .table-detail-violations th {
            background-color: rgb(248, 250, 252);
            position: sticky;
            top: 0;
            z-index: 10;
            border-bottom: 1px solid rgb(226, 232, 240);
        }

        .dark .table-violations th,
        .dark .table-detail-violations th {
            background-color: rgb(39, 39, 42);
            border-bottom: 1px solid rgb(63, 63, 70);
        }

        /* Violation name dengan word wrap */
        .violation-name {
            word-wrap: break-word;
            word-break: break-word;
            hyphens: auto;
            max-width: 200px;
        }

        /* Summary section tetap di bawah */
        .summary-section {
            background-color: inherit;
            z-index: 15;
        }

        /* Filter dan reset button styling */
        .category-filter,
        .detail-category-filter,
        .detail-status-filter {
            transition: all 0.2s ease-in-out;
        }

        .category-filter:focus,
        .detail-category-filter:focus,
        .detail-status-filter:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Main table styling */
        .card-body select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .student-row {
            transition: all 0.2s ease-in-out;
        }

        .student-row:hover {
            background-color: rgba(248, 250, 252, 0.8);
        }

        .dark .student-row:hover {
            background-color: rgba(39, 39, 42, 0.8);
        }

        /* Action buttons styling */
        .action-button {
            transition: all 0.2s ease-in-out;
        }

        .action-button:hover {
            transform: scale(1.1);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Main table filter functionality
            const classFilter = document.getElementById('classFilter');
            const genderFilter = document.getElementById('genderFilter');
            const resetMainFilterBtn = document.getElementById('resetMainFilter');
            const filterInfo = document.getElementById('filterInfo');
            const noMainData = document.getElementById('noMainData');
            const mainTable = document.getElementById('hoverableTable');

            // Add event listeners for main table filters
            [classFilter, genderFilter].forEach(filter => {
                if (filter) {
                    filter.addEventListener('change', filterMainTable);
                }
            });

            if (resetMainFilterBtn) {
                resetMainFilterBtn.addEventListener('click', resetMainFilters);
            }

            // Initialize total count
            updateFilterInfo();

            function filterMainTable() {
                const classValue = classFilter ? classFilter.value : '';
                const genderValue = genderFilter ? genderFilter.value : '';

                const rows = mainTable.querySelectorAll('.student-row');
                let visibleRows = 0;

                rows.forEach(row => {
                    const rowClass = row.getAttribute('data-class');
                    const rowGender = row.getAttribute('data-gender');

                    let showRow = true;

                    // Filter by class
                    if (classValue && classValue !== rowClass) {
                        showRow = false;
                    }

                    // Filter by gender
                    if (genderValue && genderValue !== rowGender) {
                        showRow = false;
                    }

                    if (showRow) {
                        row.style.display = '';
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Update row numbers for visible rows
                updateRowNumbers();

                // Show/hide no data message
                const tbody = mainTable.querySelector('tbody');
                if (visibleRows === 0) {
                    noMainData.classList.remove('hidden');
                    tbody.style.display = 'none';
                } else {
                    noMainData.classList.add('hidden');
                    tbody.style.display = '';
                }

                // Update filter info
                updateFilterInfo(visibleRows);
            }

            function updateRowNumbers() {
                const visibleRows = mainTable.querySelectorAll('.student-row:not([style*="display: none"])');
                visibleRows.forEach((row, index) => {
                    const rowNumberElement = row.querySelector('.row-number');
                    if (rowNumberElement) {
                        rowNumberElement.textContent = index + 1;
                    }
                });
            }

            function updateFilterInfo(showing = null) {
                const totalRows = mainTable.querySelectorAll('.student-row').length;
                const showingRows = showing !== null ? showing : totalRows;

                const showingCount = document.getElementById('showingCount');
                const totalCount = document.getElementById('totalCount');

                if (showingCount && totalCount) {
                    showingCount.textContent = showingRows;
                    totalCount.textContent = totalRows;

                    if (showingRows < totalRows) {
                        filterInfo.classList.remove('hidden');
                    } else {
                        filterInfo.classList.add('hidden');
                    }
                }
            }

            function resetMainFilters() {
                // Reset all filter values
                if (classFilter) classFilter.value = '';
                if (genderFilter) genderFilter.value = '';

                // Show all rows
                const rows = mainTable.querySelectorAll('.student-row');
                rows.forEach(row => {
                    row.style.display = '';
                });

                // Update row numbers
                updateRowNumbers();

                // Hide no data message
                noMainData.classList.add('hidden');
                mainTable.querySelector('tbody').style.display = '';

                // Update filter info
                updateFilterInfo();
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle modal open
            document.querySelectorAll('[data-modal-target]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-modal-target');
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';

                        // Scroll table to top when modal opens
                        const tableWrapper = modal.querySelector('.table-scroll-wrapper');
                        if (tableWrapper) {
                            tableWrapper.scrollTop = 0;
                        }
                    }
                });
            });

            // Handle modal close
            document.querySelectorAll('[data-modal-close]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-modal-close');
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }
                });
            });

            // Close modal when clicking outside
            document.querySelectorAll('[modal-center]').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }
                });
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('[modal-center]:not(.hidden)').forEach(modal => {
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    });
                }
            });

            // Filter functionality for confirmation modal tables
            document.querySelectorAll('.category-filter').forEach(filter => {
                filter.addEventListener('change', function() {
                    const studentId = this.getAttribute('data-student-id');
                    filterTable(studentId);
                });
            });

            // Filter functionality for detail modal tables
            document.querySelectorAll('.detail-category-filter').forEach(filter => {
                filter.addEventListener('change', function() {
                    const studentId = this.getAttribute('data-student-id');
                    filterDetailTable(studentId);
                });
            });

            document.querySelectorAll('.detail-status-filter').forEach(filter => {
                filter.addEventListener('change', function() {
                    const studentId = this.getAttribute('data-student-id');
                    filterDetailTable(studentId);
                });
            });

            // Reset filter functionality for confirmation modals
            document.querySelectorAll('.reset-filter-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const studentId = this.getAttribute('data-student-id');
                    clearFilters(studentId);
                });
            });

            // Reset filter functionality for detail modals
            document.querySelectorAll('.reset-detail-filter-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const studentId = this.getAttribute('data-student-id');
                    clearDetailFilters(studentId);
                });
            });
        });

        // Filter function for confirmation modal (pending violations)
        function filterTable(studentId) {
            const categoryFilter = document.getElementById(`categoryFilter-${studentId}`);

            if (!categoryFilter) return;

            const categoryValue = categoryFilter.value;
            const table = document.getElementById(`violationsTable-${studentId}`);
            const rows = table.querySelectorAll('.violation-row');
            const noDataMsg = document.getElementById(`noFilteredData-${studentId}`);
            const tableContainer = table.closest('.table-container');

            let visibleRows = 0;
            let totalPoints = 0;

            rows.forEach(row => {
                const rowCategory = row.getAttribute('data-category');
                let showRow = true;

                // Filter by category
                if (categoryValue && categoryValue !== rowCategory) {
                    showRow = false;
                }

                if (showRow) {
                    row.style.display = '';
                    visibleRows++;
                    // Calculate points for visible rows
                    const pointsElement = row.querySelector('.font-semibold.text-red-600, .text-red-600');
                    if (pointsElement) {
                        const pointsText = pointsElement.textContent;
                        const pointsMatch = pointsText.match(/(\d+)/);
                        const points = pointsMatch ? parseInt(pointsMatch[1]) : 0;
                        totalPoints += points;
                    }
                } else {
                    row.style.display = 'none';
                }
            });

            // Update row numbers for visible rows
            let counter = 1;
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    const rowNumberElement = row.querySelector('.row-number');
                    if (rowNumberElement) {
                        rowNumberElement.textContent = counter++;
                    }
                }
            });

            // Show/hide no data message
            if (noDataMsg && tableContainer) {
                if (visibleRows === 0) {
                    noDataMsg.classList.remove('hidden');
                    tableContainer.style.display = 'none';
                } else {
                    noDataMsg.classList.add('hidden');
                    tableContainer.style.display = '';
                }
            }

            // Update summary
            const totalCountElement = document.getElementById(`totalCount-${studentId}`);
            const totalPointsElement = document.getElementById(`totalPoints-${studentId}`);

            if (totalCountElement) {
                totalCountElement.textContent = visibleRows;
            }
            if (totalPointsElement) {
                totalPointsElement.textContent = `${totalPoints} Poin`;
            }
        }

        // Filter function for detail modal (all violations)
        function filterDetailTable(studentId) {
            const categoryFilter = document.getElementById(`detailCategoryFilter-${studentId}`);
            const statusFilter = document.getElementById(`detailStatusFilter-${studentId}`);

            if (!categoryFilter || !statusFilter) return;

            const categoryValue = categoryFilter.value;
            const statusValue = statusFilter.value;
            const table = document.getElementById(`detailViolationsTable-${studentId}`);
            const rows = table.querySelectorAll('.detail-violation-row');
            const noDataMsg = document.getElementById(`noDetailFilteredData-${studentId}`);
            const tableContainer = table.closest('.table-container');

            let visibleRows = 0;
            let totalPoints = 0;

            rows.forEach(row => {
                const rowCategory = row.getAttribute('data-category');
                const rowStatus = row.getAttribute('data-status');
                let showRow = true;

                // Filter by category
                if (categoryValue && categoryValue !== rowCategory) {
                    showRow = false;
                }

                // Filter by status
                if (statusValue && statusValue !== rowStatus) {
                    showRow = false;
                }

                if (showRow) {
                    row.style.display = '';
                    visibleRows++;
                    // Calculate points for visible rows
                    const pointsElement = row.querySelector('.font-semibold.text-red-600, .text-red-600');
                    if (pointsElement) {
                        const pointsText = pointsElement.textContent;
                        const pointsMatch = pointsText.match(/(\d+)/);
                        const points = pointsMatch ? parseInt(pointsMatch[1]) : 0;
                        totalPoints += points;
                    }
                } else {
                    row.style.display = 'none';
                }
            });

            // Update row numbers for visible rows
            let counter = 1;
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    const rowNumberElement = row.querySelector('.detail-row-number');
                    if (rowNumberElement) {
                        rowNumberElement.textContent = counter++;
                    }
                }
            });

            // Show/hide no data message
            if (noDataMsg && tableContainer) {
                if (visibleRows === 0) {
                    noDataMsg.classList.remove('hidden');
                    tableContainer.style.display = 'none';
                } else {
                    noDataMsg.classList.add('hidden');
                    tableContainer.style.display = '';
                }
            }

            // Update summary
            const totalCountElement = document.getElementById(`detailTotalCount-${studentId}`);
            const totalPointsElement = document.getElementById(`detailTotalPoints-${studentId}`);

            if (totalCountElement) {
                totalCountElement.textContent = visibleRows;
            }
            if (totalPointsElement) {
                totalPointsElement.textContent = `${totalPoints} Poin`;
            }
        }

        // Clear filters for confirmation modal
        function clearFilters(studentId) {
            // Reset filter values
            const categoryFilter = document.getElementById('categoryFilter-' + studentId);

            if (categoryFilter) {
                categoryFilter.value = '';
            }

            // Call filterTable to apply the reset
            filterTable(studentId);
        }

        // Clear filters for detail modal
        function clearDetailFilters(studentId) {
            // Reset filter values
            const categoryFilter = document.getElementById('detailCategoryFilter-' + studentId);
            const statusFilter = document.getElementById('detailStatusFilter-' + studentId);

            if (categoryFilter) {
                categoryFilter.value = '';
            }
            if (statusFilter) {
                statusFilter.value = '';
            }

            // Call filterDetailTable to apply the reset
            filterDetailTable(studentId);
        }
    </script>
@endsection
