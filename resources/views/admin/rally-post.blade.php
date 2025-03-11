@extends('admin.layout')

@section('style')
@endsection

@section('content')
    <div class="container mx-auto mt-5">
        <div class="mb-4">
            <label for="rallyDropdown" class="block mb-2 text-sm font-medium text-gray-700">Select Rally:</label>
            <select id="rallyDropdown"
                class="w-full px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:ring-blue-300">
                <option value="">-- Select a Rally --</option>
                @foreach ($rallies as $rally)
                    <option value="{{ $rally->id }}">{{ $rally->name }}</option>
                @endforeach
            </select>
        </div>

        <button id="openQrModal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Generate Rally QR Code
        </button>
    </div>

    <div id="qrCodeModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-[1036]">
        <div class="bg-white rounded-lg shadow-lg w-96">
            <div class="px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold">Rally QR Code</h2>
                <button id="closeQrModal" class="text-gray-400 hover:text-gray-600">
                    &times;
                </button>
            </div>
            <div class="p-4 text-center">
                <div id="loadingSpinner"
                    class="loader mx-auto my-4 border-t-4 border-blue-500 w-12 h-12 rounded-full animate-spin"></div>

                <div id="qrCodeContainer" class="hidden">
                    <img id="qrCodeImage" src="" alt="QR Code" class="mx-auto">
                </div>
            </div>
            <div class="px-4 py-2 border-t border-gray-200 text-right">
                <button id="closeModalButton" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Close
                </button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let rallyChannel = null;

            const rallyDropdown = document.getElementById("rallyDropdown");
            const openQrModalButton = document.getElementById("openQrModal");
            const qrCodeModal = document.getElementById("qrCodeModal");
            const qrCodeContainer = document.getElementById("qrCodeContainer");
            const qrCodeImage = document.getElementById("qrCodeImage");
            const loadingSpinner = document.getElementById("loadingSpinner");
            const closeQrModalButton = document.getElementById("closeQrModal");
            const closeModalButton = document.getElementById("closeModalButton");

            function subscribeToRallyChannel(rallyId) {
                const phaseId = localStorage.getItem("current_phase_id") || "default";
                
                if (rallyChannel) {
                    Echo.leave(rallyChannel.name);
                }
                console.log(`rally.${rallyId}.phase.${phaseId}`);
                
                rallyChannel = Echo.channel(`rally.${rallyId}.phase.${phaseId}`)
                    .listen(".rally.history.updated", (event) => {
                        console.log("Rally history updated:", event);
                        localStorage.setItem("current_phase_id", event.rallyHistory[0].pivot.phase_id);
                        alert("Rally data updated: " + JSON.stringify(event.rallyHistory));
                    });
            }

            rallyDropdown.addEventListener("change", (event) => {
                const rallyId = event.target.value;
                
                if (rallyId !== "") {
                    const firstOption = rallyDropdown.querySelector("option:first-child");
                    if (firstOption && firstOption.value === "") {
                        firstOption.remove();
                    }
                    subscribeToRallyChannel(rallyId);
                }
            });

            openQrModalButton.addEventListener("click", () => {
                const rallyId = rallyDropdown.value;

                if (rallyId === "") {
                    Swal.fire({
                        title: "No Rally Selected",
                        text: "Please choose a rally first.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                qrCodeModal.classList.remove("hidden");
                qrCodeContainer.classList.add("hidden");
                loadingSpinner.classList.remove("hidden");

                fetch(`{{ route('admin.generateQR', ':rallyId') }}`.replace(':rallyId', rallyId))
                    .then(response => response.text())
                    .then(data => {
                        qrCodeImage.src = `data:image/svg+xml;base64,${btoa(data)}`;
                        qrCodeContainer.classList.remove("hidden");
                        loadingSpinner.classList.add("hidden");
                    })
                    .catch(error => {
                        console.error("Error fetching QR code:", error);
                        alert("Failed to generate QR code.");
                        qrCodeModal.classList.add("hidden");
                    });
            });

            const closeModal = () => qrCodeModal.classList.add("hidden");
            closeQrModalButton.addEventListener("click", closeModal);
            closeModalButton.addEventListener("click", closeModal);
        });
    </script>
@endsection
