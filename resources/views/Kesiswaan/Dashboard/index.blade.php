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
                    <table id="hoverableTable" style="width: 100%" class="hover group">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>NIS</th>
            <th>NISN</th>
            <th>Jenis Kelamin</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $murid)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $murid->full_name }}</td>
                <td>{{ $murid->student_number }}</td>
                <td>{{ $murid->national_identification_number }}</td>
                <td>{{ $murid->gender }}</td>
                <td>
                    <!-- Tombol buka modal -->
                    <button data-modal-target="defaultModal{{ $murid->id }}" type="button"
                        class="flex rounded-full items-center justify-center size-[37.5px] p-0 text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-chevron-right-icon lucide-chevron-right">
                                                    <path d="m9 18 6-6-6-6" />
                                                </svg>
                                            </button>

                </td>
            </tr>

            <!-- Modal untuk siswa ini -->
            <div id="defaultModal{{ $murid->id }}" modal-center=""
                                                class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                                                <div style="width: 700px; height: 500px; max-width: 100%;"
                                                    class="  bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                                                    <div
                                                        class=" flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500"><h5 class="text-16 font-semibold">Tambah Pelanggaran - {{ $murid->full_name }}</h5>
                        <button data-modal-close="modal-{{ $murid->id }}" class="hover:text-red-500">✕</button>
                    </div>

                    <div class="p-4 overflow-y-auto" style="height: 475px">
                        <form method="POST" action="{{ route('violations.store', $murid->id) }}">
                            @csrf

                            <div class="flex items-center justify-between mb-3">
                                <h5 class="text-16 font-medium">Pilih Violations:</h5>
                                <button type="submit"
                                    class="px-4 py-2 text-white bg-blue-600 rounded shadow hover:bg-blue-700 transition">
                                    Submit
                                </button>
                            </div>

                            <div class="space-y-4">
    @foreach ([1 => '(5-10 poin)', 2 => '(10-25 poin)', 3 => '(25+ poin)'] as $catId => $label)
        <div>
            <h4 class="font-medium mb-1">{{ $label }}</h4>
            <div class="ml-2">
                @foreach ($violations->where('p_category_id', $catId)->sortBy('id') as $violation)
                    <div class="flex items-center py-1">
                        <input
                            type="checkbox"
                            name="violations[]"
                            value="{{ $violation->id }}"
                            id="violation_{{ $violation->id }}"
                            class="border rounded-sm appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-red-500 checked:border-red-500 dark:checked:bg-red-500 dark:checked:border-red-500 checked:disabled:bg-red-400 checked:disabled:border-red-400"
                        >
                        <label for="violation_{{ $violation->id }}" class="ml-2 text-sm cursor-pointer select-none">
                            {{ $violation->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<script>
    // Script untuk memastikan klik label mencentang checkbox
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('label').forEach(label => {
            label.addEventListener('click', function(e) {
                const inputId = this.getAttribute('for');
                if (inputId) {
                    const checkbox = document.getElementById(inputId);
                    if (checkbox) {
                        checkbox.checked = !checkbox.checked;

                        // Trigger event change jika diperlukan
                        const event = new Event('change', { bubbles: true });
                        checkbox.dispatchEvent(event);
                    }
                }
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
    // Tangani semua tombol close modal
    document.querySelectorAll('[data-modal-close]').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-close');
            const modal = document.getElementById(modalId);

            if(modal) {
                modal.classList.add('hidden'); // Sembunyikan modal

                // Tambahkan jika menggunakan backdrop
                const backdrop = document.querySelector('.modal-backdrop');
                if(backdrop) backdrop.remove();
            }
        });
    });
});
</script>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>

<style>
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
</style>

                </div>
            </div><!--end card-->
        </div>
        <!-- container-fluid -->
    </div>
@endsection
