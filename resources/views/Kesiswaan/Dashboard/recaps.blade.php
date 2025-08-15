@extends('layouts.app')
@section('content')
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Recap Point</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Dashboards</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                        Kesiswaan
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-4 text-15">Hoverable</h6>
                    <table id="hoverableTable" style="width: 100%" class="hover group">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Jenis Kelamin</th>
                                <th>Kelas</th>
                                <th>Total Poin Pelanggaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recaps as $rec)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rec->full_name }}</td>
                                    <td>{{ $rec->student_number }}</td>
                                    <td>{{ $rec->national_student_number }}</td>
                                    <td>{{ $rec->gender }}</td>
                                    <td>{{ $rec->user->class->name }}</td>
                                    <td>
                                        <button data-modal-target="modal-{{ $rec->id }}" type="button"
                                            class="font-semibold text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 underline cursor-pointer transition-colors duration-200">
                                            {{ $rec->violations_sum_point ?? 0 }} Poin
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--end card-->

            <!-- Modal untuk setiap siswa -->
            @foreach ($recaps as $rec)
                <div id="modal-{{ $rec->id }}" modal-center=""
                    class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 top-2/4 show ">
                    <div
                        class="w-screen md:w-[50rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col max-h-[90vh]">
                        <!-- Header Modal -->
                        <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                            <h5 class="text-16 font-semibold">Daftar Pelanggaran - {{ $rec->full_name }}</h5>
                            <button data-modal-close="modal-{{ $rec->id }}"
                                class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>

                        <!-- Content Modal dengan Tabel -->
                        <div class="p-4 overflow-y-auto flex-1">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="text-xs uppercase bg-slate-50 dark:bg-zink-700">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">No</th>
                                            <th scope="col" class="px-4 py-3">Tanggal</th>
                                            <th scope="col" class="px-4 py-3">Jenis Pelanggaran</th>
                                            <th scope="col" class="px-4 py-3">Nama Pelanggaran</th>
                                            <th scope="col" class="px-4 py-3">Kategori</th>
                                            <th scope="col" class="px-4 py-3">Poin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $counter = 1;
                                            $currentStudentViolations = $rec->recaps->where('ref_student_id', $rec->id);
                                        @endphp

                                        @forelse ($currentStudentViolations as $recapsViol)
                                            <tr
                                                class="bg-white border-b dark:bg-zink-800 dark:border-zink-700 hover:bg-slate-50 dark:hover:bg-zink-700">
                                                <td class="px-4 py-3 font-medium">{{ $counter++ }}</td>
                                                <td class="px-4 py-3">
                                                    {{ \Carbon\Carbon::parse($recapsViol->created_at)->format('d/m/Y') }}
                                                </td>
                                                <td class="px-4 py-3">{{ $recapsViol->violation->category->name }}
                                                <td class="px-4 py-3">{{ $recapsViol->violation->name }}
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium rounded-full
                                                        @if (($recapsViol->violation->point ?? 0) >= 50) bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                                        @elseif(($recapsViol->violation->point ?? 0) >= 25) bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                        @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 @endif">
                                                        @if (($recapsViol->violation->point ?? 0) >= 50)
                                                            Berat
                                                        @elseif(($recapsViol->violation->point ?? 0) >= 25)
                                                            Sedang
                                                        @else
                                                            Ringan
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="font-semibold text-red-600 dark:text-red-400">
                                                        {{ $recapsViol->violation->point ?? 0 }} Poin
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="bg-white dark:bg-zink-800">
                                                <td colspan="6"
                                                    class="px-4 py-8 text-center text-slate-500 dark:text-zink-400">
                                                    <div class="flex flex-col items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="48"
                                                            height="48" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" class="mb-2">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <path d="M12 6v6l4 2"></path>
                                                        </svg>
                                                        <p class="text-sm">Tidak ada data pelanggaran untuk siswa ini</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if ($currentStudentViolations->count() > 0)
                                <div class="mt-4 p-3 bg-slate-50 dark:bg-zink-700 rounded-lg">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-slate-600 dark:text-zink-300">Total
                                            Pelanggaran:</span>
                                        <span class="text-sm font-bold">{{ $currentStudentViolations->count() }}</span>
                                    </div>
                                    <div class="flex justify-between items-center mt-1">
                                        <span class="text-sm font-medium text-slate-600 dark:text-zink-300">Total
                                            Poin:</span>
                                        <span class="text-sm font-bold text-red-600 dark:text-red-400">
                                            {{ $rec->violations_sum_point ?? 0 }} Poin
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- container-fluid -->
    </div>

    <style>
        /* Modal styling */
        .modal-custom {
            width: 700px;
            height: 500px;
            max-width: 100%;
        }

        @media (max-width: 768px) {
            .modal-custom {
                width: 95%;
                height: auto;
                max-height: 90vh;
            }
        }

        /* Ensure modal content doesn't overflow */
        [modal-center] {
            backdrop-filter: blur(4px);
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Table styling dalam modal */
        .modal-table {
            min-width: 100%;
            border-collapse: collapse;
        }

        .modal-table th,
        .modal-table td {
            text-align: left;
            vertical-align: middle;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle modal open
            document.querySelectorAll('[data-modal-target]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-modal-target');
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden'; // Prevent background scroll
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
                        document.body.style.overflow = 'auto'; // Re-enable background scroll
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
        });
    </script>
@endsection
