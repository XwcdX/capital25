@extends('admin.layout')

@section('content')
<div class="flex flex-col w-full py-4 shadow-md items-center justify-center mb-5">
    <h1 class="text-center text-4xl uppercase font-bold mb-2">Import Data Panitia</h1>
</div>
<div class="flex flex-col w-full py-8 rounded-lg shadow-md items-center justify-center mb-10">
    <div class="mb-4">
        <label for="formFileMultiple" class="mb-2 inline-block text-neutral-700 dark:text-neutral-200">
        Pilih file excel
        </label>
            <form class="grid sm:grid-cols-5 sm:gap-4 grid-cols-3 gap-2" id="form-import-excel"
                action="{{route('admin.import.excel')}}" method="post"  enctype="multipart/form-data">
                @csrf
                <input
                    class="relative m-0 block sm:col-span-4 col-span-2 min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary disabled:opacity-60"
                    type="file" name="data-panitia-excel" 
                    accept=".xlsx" />
                <button type="submit" data-te-ripple-init data-te-ripple-color="light"
                    class="inline-block rounded bg-success sm:px-6 px-2.5 pb-1.5 pt-1.5 sm:text-sm text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out  hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(20,164,77,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)] disabled:opacity-70 disabled:pointer-events-none">
                    UPLOAD
                </button>
            </form>
    </div>
</div>
@endsection

@section('script')
<script>
    @if (Session::has('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ Session::get('success') }}',
            showConfirmButton: true,
            confirmButtonColor: "#56843a",
        });
    @endif

    @if (Session::has('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ Session::get('error') }}',
            showConfirmButton: true,
            confirmButtonColor: "#56843a",
        });
    @endif
    $(document).ready(function() {
        $('#form-import-excel').submit(function(e){
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "Seluruh Panitia akan direplace dengan data yang baru",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#56843a",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, update it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    $(this).unbind('submit').submit();
                }
                });
        })
    });
</script>
@endsection
