@extends('layouts.app')
@section('content')
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Dashboard Kesiswaan</h5>
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
                    <table id="hoverableTable" class="hover group" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Tempat Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $murid)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $murid->full_name }}</td>
                                    <td>{{ $murid->student_number }}</td>
                                    <td>{{ $murid->national_student_number }}</td>
                                    <td>{{ $murid->birth_place_date }}</td>
                                    <td>{{ $murid->gender }}</td>
                                    <td>

                                        <div class="flex flex-wrap gap-2">
                                            <button data-modal-target="defaultModal" type="button"
                                                class="flex rounded-full items-center justify-center size-[37.5px] p-0 text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                                    <path d="m9 18 6-6-6-6" />
                                                </svg>
                                            </button>
                                            <div id="defaultModal" modal-center=""
                                                class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                                                <div
                                                    class="w-screen md:w-[30rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                                                    <div
                                                        class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                                                        <h5 class="text-16">Modal Heading</h5>
                                                        <button data-modal-close="defaultModal"
                                                            class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i
                                                                data-lucide="x" class="size-5"></i></button>
                                                    </div>
                                                    <div
                                                        class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                                                        <h5 class="mb-3 text-16">Modal Content</h5>
                                                        <form id="violationsForm" method="POST" action="{{ route('violations.store') }}">
                                                            @csrf

                                                            <h5 class="mb-3 text-16 font-medium">Pilih Violations:</h5>

                                                            <!-- Container untuk checkbox violations -->
                                                            <div class="space-y-3">
                                                                @foreach ($violations as $index => $violation)
                                                                    <div class="flex items-center">
                                                                        <input type="checkbox"
                                                                            id="checkboxCircle{{ $index + 1 }}"
                                                                            name="violations[]" value="{{ $violation->id }}"
                                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 dark:bg-zink-700 dark:border-zink-600">
                                                                        <label for="checkboxCircle{{ $index + 1 }}"
                                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-zink-200 cursor-pointer">
                                                                            {{ $violation->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <!-- Hidden input untuk student_id jika diperlukan -->
                                                            <input type="hidden" name="student_id" id="student_id"
                                                                value="">

                                                        </form>
                                                    </div>
                                                    <div
                                                        class="flex items-center justify-between p-4 mt-auto border-t border-slate-200 dark:border-zink-500">
                                                        <button type="submit" form="violationsForm"
                                                            class="btn btn-primary bg-blue-600">
                                                            Submit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse

                    </table>
                </div>
            </div><!--end card-->
        </div>
        <!-- container-fluid -->
    </div>
@endsection
